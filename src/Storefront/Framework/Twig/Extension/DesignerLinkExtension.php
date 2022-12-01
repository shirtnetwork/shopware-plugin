<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Framework\Twig\Extension;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Content\Seo\SeoUrlPlaceholderHandlerInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DesignerLinkExtension extends AbstractExtension
{

    /**
     * @var SystemConfigService
     */
    protected $systemConfigService;

    /**
     * @var AbstractExtension
     */
    private $routingExtension;

    /**
     * @var SeoUrlPlaceholderHandlerInterface
     */
    private $seoUrlReplacer;

    /**
     * @param SystemConfigService $systemConfigService
     * @param AbstractExtension $routingExtension
     * @param SeoUrlPlaceholderHandlerInterface $seoUrlReplacer
     */
    public function __construct(SystemConfigService $systemConfigService, RoutingExtension $extension, SeoUrlPlaceholderHandlerInterface $seoUrlReplacer)
    {
        $this->systemConfigService = $systemConfigService;
        $this->routingExtension = $extension;
        $this->seoUrlReplacer = $seoUrlReplacer;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('designer_link', [$this, 'designer_link'], ['needs_context' => true, 'is_safe_callback' => [$this->routingExtension, 'isUrlGenerationSafe']]),
            new TwigFunction('designer_config_link', [$this, 'designer_config_link'], ['needs_context' => true, 'is_safe_callback' => [$this->routingExtension, 'isUrlGenerationSafe']])
        ];
    }

    /**
     * @return string
     */
    public function designer_link(array $context, ProductEntity $product = null)
    {
        $url = $this->getDesignerBaseUrl($context);

        if ($product) {
            $extension = $product->getExtension('shirtnetwork_sku');
            if ($extension) {
                $parameters = array_filter($extension->all(), 'strlen');
                if (count($parameters))
                    $url .= '?' . http_build_query($parameters);
            }
        }

        return $url;

    }

    /**
     * @return string
     */
    public function designer_config_link(array $context, string $config = null)
    {
        $url = $this->getDesignerBaseUrl($context);

        if ($config) {
            $url .= '?' . http_build_query(['config' => $config]);
        }

        return $url;
    }

    private function getDesignerBaseUrl(array $context)
    {
        $landingPageId = $this->systemConfigService->get('ShirtnetworkPlugin.config.landingpage', $this->getSalesChannelId($context));

        if ($landingPageId) {
            $url = $this->seoUrlReplacer->generate('frontend.landing.page', ['landingPageId' => $landingPageId]);
        }else{
            $url = $this->seoUrlReplacer->generate('frontend.shirtnetwork.designer');
        }

        return $url;
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