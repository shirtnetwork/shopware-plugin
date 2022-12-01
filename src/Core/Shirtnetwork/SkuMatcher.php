<?php

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork;

use Aggrosoft\Shopware\ShirtnetworkPlugin\EntityExtension\Struct\ShirtnetworkStruct;
use Shopware\Core\Framework\Adapter\Twig\StringTemplateRenderer;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Struct\ArrayEntity;
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

    public function __construct (SystemConfigService $systemConfigService, StringTemplateRenderer $stringTemplateRenderer)
    {
        $this->systemConfigService = $systemConfigService;
        $this->stringTemplateRenderer = $stringTemplateRenderer;
    }

    public function match(string $productNumber, Context $context): ArrayEntity {
        $sizeMatcher = $this->systemConfigService->get('ShirtnetworkPlugin.config.sizeskumatcher', $context->getSource()->getSalesChannelId());
        $variantMatcher = $this->systemConfigService->get('ShirtnetworkPlugin.config.variantskumatcher', $context->getSource()->getSalesChannelId());
        $productMatcher = $this->systemConfigService->get('ShirtnetworkPlugin.config.productskumatcher', $context->getSource()->getSalesChannelId());

        $struct = new ArrayEntity([
            'sartnr' => $sizeMatcher ? $this->stringTemplateRenderer->render($sizeMatcher, ['sku' => $productNumber], $context) : '',
            'vartnr' => $variantMatcher ? $this->stringTemplateRenderer->render($variantMatcher, ['sku' => $productNumber], $context) : '',
            'artnr' => $productMatcher ? $this->stringTemplateRenderer->render($productMatcher, ['sku' => $productNumber], $context) : ''
        ]);
        return $struct;
    }

}