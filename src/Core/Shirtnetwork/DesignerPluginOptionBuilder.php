<?php

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DesignerPluginOptionBuilder
{
    /**
     * @var SystemConfigService
     */
    private $systemConfigService;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var ApiClient
     */
    private $apiClient;

    public function __construct(SystemConfigService $systemConfigService, UrlGeneratorInterface $router, ApiClient $apiClient)
    {
        $this->systemConfigService = $systemConfigService;
        $this->router = $router;
        $this->apiClient = $apiClient;
    }

    public function build(SalesChannelContext $context, array $initialData = [])
    {
        $salesChannelId = $context->getSalesChannelId();

        return [
            'version' => $this->systemConfigService->get('ShirtnetworkPlugin.config.designerversion', $salesChannelId),
            'skuScheme' => $this->systemConfigService->get('ShirtnetworkPlugin.config.skuscheme', $salesChannelId),
            'swToken' => $context->getToken(),
            'swAccessKey' => $context->getSalesChannel()->getAccessKey(),
            'pages' => [
                'delivery' => $this->router->generate('frontend.cms.page', ['id' => $this->systemConfigService->get('core.basicInformation.shippingPaymentInfoPage', $salesChannelId)])
            ],
            'settings' => [
                'debug' =>  boolval($this->systemConfigService->get('ShirtnetworkPlugin.config.debug', $salesChannelId)),
                'initial' => array_merge([
                    'user' => $this->apiClient->getUserId($salesChannelId),
                    'product' => $this->systemConfigService->get('ShirtnetworkPlugin.config.defaultsku', $salesChannelId),
                    'defaultProduct' => $this->systemConfigService->get('ShirtnetworkPlugin.config.defaultsku', $salesChannelId)
                ], $initialData),
                'backend' => [
                    'cacheKey' => 'X',
                    'fonts' => $this->systemConfigService->get('ShirtnetworkPlugin.config.configserver', $salesChannelId) . '/fontlist',
                    'config' => $this->systemConfigService->get('ShirtnetworkPlugin.config.configserver', $salesChannelId),
                    'upload' => $this->systemConfigService->get('ShirtnetworkPlugin.config.uploadserver', $salesChannelId),
                    'type' => $this->systemConfigService->get('ShirtnetworkPlugin.config.servertype', $salesChannelId),
                ],
                'interface' => [
                    'printtypeMode' => $this->systemConfigService->get('ShirtnetworkPlugin.config.printtypemode', $salesChannelId),
                    'constraints' => $this->systemConfigService->get('ShirtnetworkPlugin.config.constraints', $salesChannelId),
                    'loadCSS' => boolval($this->systemConfigService->get('ShirtnetworkPlugin.config.loadcss', $salesChannelId)),
                    'showRealSizes' => boolval($this->systemConfigService->get('ShirtnetworkPlugin.config.showrealsizes', $salesChannelId)),
                    'amountMode' => $this->systemConfigService->get('ShirtnetworkPlugin.config.amountmode', $salesChannelId),
                    'stock' => true
                ],
                'shop' => [
                    'infos' => [
                        'url' => '/shirtnetwork/designer/productinfos'
                    ],
                    'stock' => [
                        'url' => '/shirtnetwork/designer/stockinfos'
                    ],
                    'cart' => [
                        'url' => '/shirtnetwork/designer/checkoutdata',
                        'link' => '/checkout/cart'
                    ]
                ]
            ]
        ];
    }
}