<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Controller;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork\ShirtnetworkDesignerPageLoader;
use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\Error\Error;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Content\Product\Exception\ProductNotFoundException;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Routing\Exception\MissingRequestParameterException;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\Framework\Uuid\Uuid;

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
     * @var CartService
     */
    private $cartService;

    public function __construct(ShirtnetworkDesignerPageLoader $designerPageLoader, CartService $cartService)
    {
        $this->designerPageLoader = $designerPageLoader;
        $this->cartService = $cartService;
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

    /**
     * @Route("/shirtnetwork/add-to-cart", name="frontend.shirtnetwork.designer.cart", methods={"POST"}, defaults={"XmlHttpRequest"=true, "csrf_protected"=false})
     */
    public function addToCart(Cart $cart, RequestDataBag $requestDataBag, Request $request, SalesChannelContext $context): Response
    {
        /** @var RequestDataBag|null $lineItems */
        $lineItems = $requestDataBag->get('lineItems');

        if (!$lineItems) {
            throw new MissingRequestParameterException('lineItems');
        }

        $count = 0;

        try {
            $items = [];
            /** @var RequestDataBag $lineItemData */
            foreach ($lineItems as $lineItemData) {
                $lineItem = new LineItem(
                    Uuid::randomHex(),
                    $lineItemData->getAlnum('type'),
                    $lineItemData->get('referencedId'),
                    $lineItemData->getInt('quantity', 1)
                );

                $lineItem->setStackable($lineItemData->getBoolean('stackable', true));
                $lineItem->setRemovable($lineItemData->getBoolean('removable', true));
                $lineItem->setPayload((array) $lineItemData->get('payload', []));

                $count += $lineItem->getQuantity();

                $items[] = $lineItem;
            }

            $cart = $this->cartService->add($cart, $items, $context);

            if (!$this->traceErrors($cart)) {
                $this->addFlash(self::SUCCESS, $this->trans('checkout.addToCartSuccess', ['%count%' => $count]));
            }
        } catch (ProductNotFoundException $exception) {
            $this->addFlash(self::DANGER, $this->trans('error.addToCartError'));
        }

        return $this->createActionResponse($request);
    }

    private function traceErrors(Cart $cart): bool
    {
        if ($cart->getErrors()->count() <= 0) {
            return false;
        }

        $this->addCartErrors($cart, function (Error $error) {
            return $error->isPersistent();
        });

        return true;
    }

}
