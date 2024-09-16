<?php

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Subscriber;

use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Storefront\Page\Checkout\Confirm\CheckoutConfirmPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CheckoutConfirmPageLoadedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly CartService $cartService
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CheckoutConfirmPageLoadedEvent::class => 'onCheckoutConfirmLoaded',
        ];
    }

    public function onCheckoutConfirmLoaded(CheckoutConfirmPageLoadedEvent $event): void
    {
        // PayPal Express Checkout does not correctly update the cart somehow
        $cart = $event->getPage()->getCart();
        $this->cartService->recalculate($cart, $event->getSalesChannelContext());
    }
}