<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Checkout\Document\DocumentGenerator;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ConfigHelper;
use Doctrine\DBAL\Connection;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Document\DocumentConfiguration;
use Shopware\Core\Checkout\Document\DocumentConfigurationFactory;
use Shopware\Core\Checkout\Document\Renderer\AbstractDocumentRenderer;
use Shopware\Core\Checkout\Document\Renderer\DocumentRendererConfig;
use Shopware\Core\Checkout\Document\Renderer\OrderDocumentCriteriaFactory;
use Shopware\Core\Checkout\Document\Renderer\RenderedDocument;
use Shopware\Core\Checkout\Document\Renderer\RendererResult;
use Shopware\Core\Checkout\Document\Service\DocumentConfigLoader;
use Shopware\Core\Checkout\Document\Struct\DocumentGenerateOperation;
use Shopware\Core\Checkout\Document\Twig\DocumentTemplateRenderer;
use Shopware\Core\Checkout\Order\OrderCollection;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\System\NumberRange\ValueGenerator\NumberRangeValueGeneratorInterface;
use Twig\Error\Error;

final class RoutingSlipGenerator extends AbstractDocumentRenderer
{
    public const TYPE = 'routing_slip';

    /**
     * @internal
     */
    public function __construct(
        private readonly EntityRepository $orderRepository,
        private readonly DocumentConfigLoader $documentConfigLoader,
        private readonly ConfigHelper $configHelper,
        private readonly DocumentTemplateRenderer $documentTemplateRenderer,
        private readonly NumberRangeValueGeneratorInterface $numberRangeValueGenerator,
        private readonly string $rootDir,
        private readonly Connection $connection
    ) {
    }

    public function supports(): string
    {
        return self::TYPE;
    }

    public function render(array $operations, Context $context, DocumentRendererConfig $rendererConfig): RendererResult
    {
        $result = new RendererResult();

        $template = '@ShirtnetworkPlugin/documents/routing_slip.html.twig';

        $ids = \array_map(fn (DocumentGenerateOperation $operation) => $operation->getOrderId(), $operations);

        if (empty($ids)) {
            return $result;
        }

        $chunk = $this->getOrdersLanguageId(array_values($ids), $context->getVersionId(), $this->connection);

        foreach ($chunk as ['language_id' => $languageId, 'ids' => $ids]) {
            $criteria = OrderDocumentCriteriaFactory::create(explode(',', (string) $ids), $rendererConfig->deepLinkCode);
            $context = $context->assign([
                'languageIdChain' => array_unique(array_filter([$languageId, $context->getLanguageId()])),
            ]);

            // TODO: future implementation (only fetch required data and associations)

            /** @var OrderCollection $orders */
            $orders = $this->orderRepository->search($criteria, $context)->getEntities();

            foreach ($orders as $order) {
                $orderId = $order->getId();

                try {
                    if (!\array_key_exists($order->getId(), $operations)) {
                        continue;
                    }

                    $configs = [];

                    $products = $order->getLineItems()->filterByType(LineItem::PRODUCT_LINE_ITEM_TYPE);;

                    foreach($products as $product) {
                        $payload = $product->getPayload();
                        $shirtnetwork = isset($payload['shirtnetwork']) ? $payload['shirtnetwork'] : null;
                        if (!$shirtnetwork){
                            continue;
                        }
                        $configs[$product->getId()] = $this->configHelper->getShirtnetworkInfos($order->getSalesChannelId(), $shirtnetwork);
                    }

                    /** @var DocumentGenerateOperation $operation */
                    $operation = $operations[$order->getId()];

                    $config = clone $this->documentConfigLoader->load(self::TYPE, $order->getSalesChannelId(), $context);

                    $config->merge($operation->getConfig());

                    $number = $config->getDocumentNumber() ?: $this->getNumber($context, $order, $operation);

                    $now = (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT);

                    $config->merge([
                        'documentNumber' => $number,
                        'documentDate' => $operation->getConfig()['documentDate'] ?? $now
                    ]);

                    if ($operation->isStatic()) {
                        $doc = new RenderedDocument('', $number, $config->buildName(), $operation->getFileType(), $config->jsonSerialize());
                        $result->addSuccess($orderId, $doc);

                        continue;
                    }

                    /** @var LocaleEntity $locale */
                    $locale = $order->getLanguage()->getLocale();

                    $html = $this->documentTemplateRenderer->render(
                        $template,
                        [
                            'order' => $order,
                            'orderConfigs' => $configs,
                            'config' => $config,
                            'rootDir' => $this->rootDir,
                            'context' => $context,
                        ],
                        $context,
                        $order->getSalesChannelId(),
                        $order->getLanguageId(),
                        $locale->getCode()
                    );

                    $doc = new RenderedDocument(
                        $html,
                        $number,
                        $config->buildName(),
                        $operation->getFileType(),
                        $config->jsonSerialize(),
                    );

                    $result->addSuccess($orderId, $doc);
                } catch (\Throwable $exception) {
                    $result->addError($orderId, $exception);
                }
            }
        }

        return $result;
    }

    /**
     * @throws Error
     */
    public function generate(
        OrderEntity $order,
        DocumentConfiguration $config,
        Context $context,
        ?string $templatePath = null
    ): string {
        $templatePath = $templatePath ?? self::DEFAULT_TEMPLATE;


        $configs = [];

        $products = $order->getLineItems()->filterByType(LineItem::PRODUCT_LINE_ITEM_TYPE);;

        foreach($products as $product) {
            $payload = $product->getPayload();
            $shirtnetwork = isset($payload['shirtnetwork']) ? $payload['shirtnetwork'] : null;
            if (!$shirtnetwork){
                continue;
            }
            $configs[$product->getId()] = $this->configHelper->getShirtnetworkInfos($context, $shirtnetwork);
        }

        $documentString = $this->documentTemplateRenderer->render(
            $templatePath,
            [
                'order' => $order,
                'orderConfigs' => $configs,
                'config' => DocumentConfigurationFactory::mergeConfiguration($config, new DocumentConfiguration())->jsonSerialize(),
                'rootDir' => $this->rootDir,
                'context' => $context,
            ],
            $context,
            $order->getSalesChannelId(),
            $order->getLanguageId(),
            $order->getLanguage()->getLocale()->getCode()
        );

        return $documentString;
    }

    public function getFileName(DocumentConfiguration $config): string
    {
        return $config->getFilenamePrefix() . $config->getDocumentNumber() . $config->getFilenameSuffix();
    }

    public function getDecorated(): AbstractDocumentRenderer
    {
        throw new DecorationPatternException(self::class);
    }

    private function getNumber(Context $context, OrderEntity $order, DocumentGenerateOperation $operation): string
    {
        return $this->numberRangeValueGenerator->getValue(
            'document_' . self::TYPE,
            $context,
            $order->getSalesChannelId(),
            $operation->isPreview()
        );
    }

}
