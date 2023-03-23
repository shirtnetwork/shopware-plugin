<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Framework\Twig\Extension;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ConfigHelper;
use Shopware\Core\Framework\Adapter\Twig\TwigEnvironment;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DesignerConfigExtension extends AbstractExtension
{

    private ConfigHelper $configHelper;
    private TwigEnvironment $twig;

    public function __construct(ConfigHelper $configHelper)
    {
        $this->configHelper = $configHelper;
    }

    public function setTwig(TwigEnvironment $twig): void
    {
        $this->twig = $twig;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('designer_config', [$this, 'designer_config'], ['needs_context' => true]),
            new TwigFunction('render_designer_config', [$this, 'render_designer_config'], ['needs_context' => true, 'is_safe' => ['html']])
        ];
    }

    /**
     * @return string
     */
    public function designer_config(array $context, string $configId): ?array
    {
        return $this->configHelper->getShirtnetworkInfos($this->getSalesChannelId($context), $configId);
    }

    /**
     * @return string
     */
    public function render_designer_config(array $context, string $configId): ?string
    {
        $config = $this->configHelper->getShirtnetworkInfos($this->getSalesChannelId($context), $configId);
        if ($config) {
            return $this->twig->render('@ShirtnetworkPlugin/storefront/page/checkout/designer-config-objects-simple.html.twig', [
                'objects' => $config['objects']
            ]);
        }
    }

    private function getSalesChannelId(array $context): ?string
    {
        if (isset($context['context'])) {
            $salesChannelContext = $context['context'];
            if ($salesChannelContext instanceof SalesChannelContext) {
                return $salesChannelContext->getSalesChannelId();
            }
        }
        if (isset($context['salesChannel'])) {
            $salesChannel = $context['salesChannel'];
            if ($salesChannel instanceof SalesChannelEntity) {
                return $salesChannel->getId();
            }
        }

        return null;
    }

}