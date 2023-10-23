<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\EntityExtension\Subscriber;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\Router;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\SkuMatcher;
use Aggrosoft\Shopware\ShirtnetworkPlugin\EntityExtension\Struct\ShirtnetworkStruct;
use Shopware\Core\Content\Product\Events\ProductListingResultEvent;
use Shopware\Core\Content\Product\Events\ProductSearchResultEvent;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Api\Context\SalesChannelApiSource;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityLoadedEvent;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Shopware\Core\Framework\Struct\ArrayStruct;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelEntityLoadedEvent;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepository;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Content\Product\ProductEvents;

class ProductLoadedSubscriber implements EventSubscriberInterface
{

    public function __construct (
        private readonly SkuMatcher $skuMatcher,
        private readonly Router $router,
        private readonly SalesChannelRepository $productRepository,
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'sales_channel.product.loaded' => 'onSalesChannelProductLoaded',
            ProductListingResultEvent::class => 'onProductListingResult',
            ProductSearchResultEvent::class => 'onProductSearchResult'
        ];
    }

    public function onSalesChannelProductLoaded(SalesChannelEntityLoadedEvent $event)
    {
        foreach ($event->getEntities() as $productEntity) {
            $skuExtension = $this->getShirtnetwork($productEntity, $event->getSalesChannelContext());
            $productEntity->addArrayExtension('shirtnetwork', [
                'sku' => $skuExtension,
                'url' => $this->router->getDesignerLink($event->getSalesChannelContext()->getSalesChannelId(), $skuExtension)
            ]);
        }
    }

    public function onProductListingResult(ProductListingResultEvent $event): void
    {
        /** @var ProductEntity $productEntity */
        foreach ($event->getResult()->getEntities() as $productEntity) {
            $skuExtension = $this->getShirtnetwork($productEntity, $event->getSalesChannelContext());
            $productEntity->addArrayExtension('shirtnetwork', [
                'sku' => $skuExtension,
                'url' => $this->router->getDesignerLink($event->getSalesChannelContext()->getSalesChannelId(), $skuExtension)
            ]);
        }
    }

    public function onProductSearchResult(ProductSearchResultEvent $event): void
    {
        /** @var ProductEntity $productEntity */
        foreach ($event->getResult()->getEntities() as $productEntity) {
            $skuExtension = $this->getShirtnetwork($productEntity, $event->getSalesChannelContext());
            $productEntity->addArrayExtension('shirtnetwork', [
                'sku' => $skuExtension,
                'url' => $this->router->getDesignerLink($event->getSalesChannelContext()->getSalesChannelId(), $skuExtension)
            ]);
        }
    }

    private function getShirtnetwork(ProductEntity $product, SalesChannelContext $context):ArrayEntity {
        if ($product->getParentId()) {
            $parent = $this->productRepository->search(new Criteria([$product->getParentId()]), $context)->first();
            $parentSku = $parent->getProductNumber();
        }else{
            $parentSku = $product->getProductNumber();
        }
        return $this->skuMatcher->match($product->getProductNumber(), $parentSku, $context);
    }
}
