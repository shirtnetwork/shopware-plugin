<?php

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork;

use Aggrosoft\Shopware\ShirtnetworkPlugin\EntityExtension\Struct\ShirtnetworkStruct;
use Shopware\Core\Framework\Adapter\Twig\StringTemplateRenderer;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class SkuMatcher
{
    /**
     * @var SystemConfigService $systemConfigService
     */
    private SystemConfigService $systemConfigService;

    /**
     * @var StringTemplateRenderer $stringTemplateRenderer
     */
    private StringTemplateRenderer $stringTemplateRenderer;

    /**
     * @var ApiClient $apiClient
     */
    private ApiClient $apiClient;

    /**
     * @param SystemConfigService $systemConfigService
     * @param StringTemplateRenderer $stringTemplateRenderer
     */
    public function __construct (SystemConfigService $systemConfigService, StringTemplateRenderer $stringTemplateRenderer, ApiClient $apiClient)
    {
        $this->systemConfigService = $systemConfigService;
        $this->stringTemplateRenderer = $stringTemplateRenderer;
        $this->apiClient = $apiClient;
    }

    public function match(string $productNumber, string $parentProductNumber, SalesChannelContext $context): ArrayEntity {

        $salesChannelId = $context->getSalesChannelId();
        $sizes = $this->apiClient->getSizes($salesChannelId);

        $sizeSkus = array_map(function($size) {
            return $size->artnr;
        }, $sizes);

        $sizeMatcher = $this->systemConfigService->get('ShirtnetworkPlugin.config.sizeskumatcher', $salesChannelId);
        $variantMatcher = $this->systemConfigService->get('ShirtnetworkPlugin.config.variantskumatcher', $salesChannelId);
        $productMatcher = $this->systemConfigService->get('ShirtnetworkPlugin.config.productskumatcher', $salesChannelId);

        $struct = new ArrayEntity([
            'sartnr' => $sizeMatcher ? trim($this->stringTemplateRenderer->render($sizeMatcher, ['sku' => $productNumber, 'psku' => $parentProductNumber, 'sizeSkus' => $sizeSkus], $context->getContext())) : '',
            'vartnr' => $variantMatcher ? trim($this->stringTemplateRenderer->render($variantMatcher, ['sku' => $productNumber, 'psku' => $parentProductNumber, 'sizeSkus' => $sizeSkus], $context->getContext())) : '',
            'artnr' => $productMatcher ? trim($this->stringTemplateRenderer->render($productMatcher, ['sku' => $productNumber, 'psku' => $parentProductNumber, 'sizeSkus' => $sizeSkus], $context->getContext())) : ''
        ]);

        return $struct;
    }

    public function usesParentProductNumber(SalesChannelContext $context): bool {
        $salesChannelId = $context->getSalesChannelId();

        $sizeMatcher = $this->systemConfigService->get('ShirtnetworkPlugin.config.sizeskumatcher', $salesChannelId);
        $variantMatcher = $this->systemConfigService->get('ShirtnetworkPlugin.config.variantskumatcher', $salesChannelId);
        $productMatcher = $this->systemConfigService->get('ShirtnetworkPlugin.config.productskumatcher', $salesChannelId);
        // @TODO: very naive check, maybe we should use regex or something
        return strpos($sizeMatcher, 'psku') !== false || strpos($variantMatcher, 'psku') !== false || strpos($productMatcher, 'psku') !== false;
    }

}