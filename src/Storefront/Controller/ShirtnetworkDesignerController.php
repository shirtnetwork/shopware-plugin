<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Controller;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork\ShirtnetworkDesignerPageLoader;
use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\Error\Error;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Content\Product\Exception\ProductNotFoundException;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Routing\Exception\MissingRequestParameterException;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\Framework\Uuid\Uuid;

#[Route(defaults: ['_routeScope' => ['storefront']])]
#[Package('storefront')]
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

    /**
     * @var EntityRepository
     */
    private $productRepository;

    public function __construct(ShirtnetworkDesignerPageLoader $designerPageLoader, CartService $cartService, EntityRepository $productRepository)
    {
        $this->designerPageLoader = $designerPageLoader;
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
    }

    #[Route(path: '/shirtnetwork/designer', name: 'frontend.shirtnetwork.designer', options: ['seo' => true], methods: ['GET'])]
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

    #[Route(path: '/shirtnetwork/add-to-cart', name: 'frontend.shirtnetwork.designer.cart', defaults: ['XmlHttpRequest' => true], methods: ['POST'])]
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
                $lineItem->setPayload($lineItemData->get('payload', [])->all());

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

    #[Route(path: '/shirtnetwork/designer-stock-infos/{productNumber}', name: 'frontend.shirtnetwork.designer.stock', defaults: ['XmlHttpRequest' => true], methods: ['GET'])]
    public function stockInfos(string $productNumber, Request $request, SalesChannelContext $context)
    {
        $stockInfo = [];
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('children.productNumber', $productNumber));
        $criteria->addAssociation('children');
        /** @var ProductEntity|null $product */
        $product = $this->productRepository->search($criteria, $context->getContext())->first();

        if ($product && $product->getChildren()->count() > 0) {
            $children = $product->getChildren();
            $stockInfo = $children->map(function(ProductEntity $child){
                $extension = $child->getExtension('shirtnetwork');
                return [
                    'size' => $extension['sku']['sartnr'],
                    'variant' => $extension['sku']['vartnr'],
                    'stock' => $child->getIsCloseout() ? $child->getAvailableStock() : 999999
                ];
            });
        }

        return new JsonResponse(array_values($stockInfo));
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
