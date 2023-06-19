<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Controller;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork\Config\ShirtnetworkDesignerConfigPageLoader;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\Routing\Annotation\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
#[Package('storefront')]
class ShirtnetworkDesignerConfigController extends StorefrontController
{
    /**
     * @var ShirtnetworkDesignerConfigPageLoader
     */
    private $designerConfigPageLoader;

    public function __construct(ShirtnetworkDesignerConfigPageLoader $designerConfigPageLoader)
    {
        $this->designerConfigPageLoader = $designerConfigPageLoader;
    }
    #[Route(path: '/shirtnetwork/config/{config}', name: 'frontend.shirtnetwork.config', options: ['seo' => false], defaults: ['XmlHttpRequest' => true], methods: ['GET'])]
    public function index(Request $request, SalesChannelContext $context, string $config)
    {
        $page = $this->designerConfigPageLoader->load($config, $request, $context);

        return $this->renderStorefront(
            '@ShirtnetworkPlugin/storefront/page/checkout/designer-config.html.twig',
            [
                'page' => $page
            ]
        );
    }

}
