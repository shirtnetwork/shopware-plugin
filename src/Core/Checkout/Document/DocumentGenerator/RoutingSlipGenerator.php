<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Checkout\Document\DocumentGenerator;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ConfigHelper;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Document\DocumentConfiguration;
use Shopware\Core\Checkout\Document\DocumentConfigurationFactory;
use Shopware\Core\Checkout\Document\DocumentGenerator\DocumentGeneratorInterface;
use Shopware\Core\Checkout\Document\Twig\DocumentTemplateRenderer;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\Context;
use Twig\Error\Error;

class RoutingSlipGenerator implements DocumentGeneratorInterface
{
    public const DEFAULT_TEMPLATE = '@ShirtnetworkPlugin/documents/routing_slip.html.twig';
    public const ROUTING_SLIP = 'routing_slip';

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @var DocumentTemplateRenderer
     */
    private $documentTemplateRenderer;

    /**
     * @var ConfigHelper
     */
    private $configHelper;

    public function __construct(DocumentTemplateRenderer $documentTemplateRenderer, ConfigHelper $configHelper, string $rootDir)
    {
        $this->rootDir = $rootDir;
        $this->documentTemplateRenderer = $documentTemplateRenderer;
        $this->configHelper = $configHelper;
    }

    public function supports(): string
    {
        return self::ROUTING_SLIP;
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
}
