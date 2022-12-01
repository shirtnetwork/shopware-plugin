<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Subscriber;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ConfigHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Checkout\Cart\Event\BeforeLineItemAddedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class LineItemSubscriber implements EventSubscriberInterface
{

    protected $requestStack;
    protected $configHelper;

    public function __construct(RequestStack $requestStack, ConfigHelper $configHelper)
    {
        $this->requestStack = $requestStack;
        $this->configHelper = $configHelper;
    }

    public static function getSubscribedEvents(): array
    {
        // Return the events to listen to as array like this:  <event to listen to> => <method to execute>
        return [
            BeforeLineItemAddedEvent::class => 'onLineItemAdded',
            LineItemQuantityChangedEvent::class => 'onLineItemQuantityChanged'
        ];
    }

    public function onLineItemAdded(BeforeLineItemAddedEvent $event)
    {
        $lineItem = $event->getLineItem();

        $shirtnetwork = $lineItem->getPayloadValue('shirtnetwork');
        if ($shirtnetwork){
            $cart = $event->getCart();
            $cart->remove($lineItem->getId());
            $lineItem->setId(md5($lineItem->getId() . $shirtnetwork));
            $lineItem->setPayloadValue('shirtnetworkconfig', $this->configHelper->getShirtnetworkInfos($event->getSalesChannelContext()->getSalesChannelId(), $shirtnetwork));
            $cart->add($lineItem);
        }
    }

    public function onLineItemQuantityChanged(LineItemQuantityChangedEvent $event){
        return;
        $lineItem = $event->getLineItem();
        if ($lineItem->hasPayloadValue('shirtnetworkPrice')){
            $lineItem->removePayloadValue('shirtnetworkPrice');
        }
    }
}
