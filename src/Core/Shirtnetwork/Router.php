<?php

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Content\Seo\SeoUrlPlaceholderHandlerInterface;
use Shopware\Core\Framework\Struct\Struct;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Bridge\Twig\Extension\RoutingExtension;

class Router
{
    /**
     * @var SystemConfigService
     */
    protected $systemConfigService;

    /**
     * @var SeoUrlPlaceholderHandlerInterface
     */
    private $seoUrlReplacer;

    /**
     * @param SystemConfigService $systemConfigService
     * @param SeoUrlPlaceholderHandlerInterface $seoUrlReplacer
     */
    public function __construct(SystemConfigService $systemConfigService,SeoUrlPlaceholderHandlerInterface $seoUrlReplacer)
    {
        $this->systemConfigService = $systemConfigService;
        $this->seoUrlReplacer = $seoUrlReplacer;
    }

    /**
     * @return string
     */
    public function getDesignerLink(string $salesChannelId, Struct $skuExtension = null)
    {
        $url = $this->getDesignerBaseUrl($salesChannelId);

        if ($skuExtension) {
            $parameters = array_filter($skuExtension->all(), 'strlen');
            if (count($parameters))
                $url .= '?' . http_build_query($parameters);
        }

        return $url;

    }

    /**
     * @return string
     */
    public function getDesignerConfigLink(string $salesChannelId, string $configId = null)
    {
        $url = $this->getDesignerBaseUrl($salesChannelId);

        if ($configId) {
            $url .= '?' . http_build_query(['config' => $configId]);
        }

        return $url;
    }

    public function getDesignerLogoLink(string $salesChannelId, string $logoId = null)
    {
        $url = $this->getDesignerBaseUrl($salesChannelId);

        if ($logoId) {
            $url .= '?' . http_build_query(['logo' => $logoId, 'keep' => 1]);
        }

        return $url;
    }

    private function getDesignerBaseUrl(string $salesChannelId)
    {
        $landingPageId = $this->systemConfigService->get('ShirtnetworkPlugin.config.landingpage', $salesChannelId);

        if ($landingPageId) {
            $url = $this->seoUrlReplacer->generate('frontend.landing.page', ['landingPageId' => $landingPageId]);
        }else{
            $url = $this->seoUrlReplacer->generate('frontend.shirtnetwork.designer');
        }

        return $url;
    }
}