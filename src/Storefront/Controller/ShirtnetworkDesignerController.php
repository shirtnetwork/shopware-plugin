<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Controller;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork\ShirtnetworkDesignerPageLoader;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Storefront\Page\Product\Review\ProductReviewLoader;
use Shopware\Storefront\Page\Product\Review\ProductReviewsWidgetLoadedHook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

/**
 * @RouteScope(scopes={"storefront"})
 */
class ShirtnetworkDesignerController extends StorefrontController
{
    /**
     * @var ShirtnetworkDesignerConfigPageLoader
     */
    private $designerPageLoader;

    /**
     * @var ProductReviewLoader
     */
    private $productReviewLoader;

    public function __construct(ShirtnetworkDesignerPageLoader $designerPageLoader, ProductReviewLoader $productReviewLoader)
    {
        $this->designerPageLoader = $designerPageLoader;
        $this->productReviewLoader = $productReviewLoader;
    }

    /**
     * @Route("/shirtnetwork/designer", name="frontend.shirtnetwork.designer", options={"seo"="true"}, methods={"GET"})
     */
    public function index(Request $request, SalesChannelContext $context)
    {
        $page = $this->designerPageLoader->load($request, $context);

        return $this->renderStorefront(
            '@ShirtnetworkPlugin/storefront/page/shirtnetwork/designer.html.twig',
            [
                'page' => $page
            ]
        );
    }

}
