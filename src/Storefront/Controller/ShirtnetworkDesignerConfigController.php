<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Controller;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork\Config\ShirtnetworkDesignerConfigPageLoader;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

/**
 * @RouteScope(scopes={"storefront"})
 */
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

    /**
     * @Route("/shirtnetwork/config/{config}", name="frontend.shirtnetwork.config", options={"seo"="false"}, methods={"GET"}, defaults={"XmlHttpRequest"=true})
     */
    public function index(string $config, Request $request, SalesChannelContext $context)
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
