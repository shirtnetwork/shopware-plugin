<?php

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DesignerPluginOptionBuilder
{

    public function __construct(
        private readonly SystemConfigService $systemConfigService,
        private readonly UrlGeneratorInterface $router,
        private readonly ApiClient $apiClient,
        private readonly TranslatorInterface $translator,
        private readonly RequestStack $requestStack
    )
    {
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
            'language' => $this->requestStack->getCurrentRequest()->attributes->get('_locale'),
            'translations' => $this->getTranslations(),
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

    private function getTranslations():array {
        $catalogue = $this->translator->getCatalogue();
        $messages = $catalogue->all()['messages'];
        $translations = [];

        foreach($messages as $key => $value) {
            if (str_starts_with($key, 'shirtnetwork.designer.')) {
                $translationKey = str_replace('shirtnetwork.designer.', '', $key);
                $translations[$translationKey] = $value;
            }
        }

        return $translations;
    }
}