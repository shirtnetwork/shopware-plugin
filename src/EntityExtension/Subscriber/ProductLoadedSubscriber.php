<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\EntityExtension\Subscriber;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\SkuMatcher;
use Aggrosoft\Shopware\ShirtnetworkPlugin\EntityExtension\Struct\ShirtnetworkStruct;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Api\Context\SalesChannelApiSource;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityLoadedEvent;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Content\Product\ProductEvents;

class ProductLoadedSubscriber implements EventSubscriberInterface
{

    /**
     * @var SkuMatcher $skuMatcher
     */
    private SkuMatcher $skuMatcher;

    public function __construct (SkuMatcher $skuMatcher)
    {
        $this->skuMatcher = $skuMatcher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductEvents::PRODUCT_LOADED_EVENT => 'onProductsLoaded'
        ];
    }

    public function onProductsLoaded(EntityLoadedEvent $event): void
    {
        if ($event->getContext()->getSource() instanceof SalesChannelApiSource) {
            /** @var ProductEntity $productEntity */
            foreach ($event->getEntities() as $productEntity) {
                $extension = $this->getShirtnetwork($productEntity, $event->getContext());
                $productEntity->addExtension('shirtnetwork_sku', $extension);
            }
        }
    }

    private function getShirtnetwork(ProductEntity $product, Context $context):ArrayEntity {
        return $this->skuMatcher->match($product->getProductNumber(), $context);
    }
}
