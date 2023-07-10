<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.14  |
    |              on 2023-07-10 12:52:47              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Subscriber; use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient; use Shopware\Core\Checkout\Cart\Event\CheckoutOrderPlacedEvent; use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity; use Shopware\Core\Checkout\Order\OrderEntity; use Shopware\Core\Checkout\Order\OrderEvents; use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository; use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent; use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria; use Symfony\Component\EventDispatcher\EventSubscriberInterface; class OrderSubscriber implements EventSubscriberInterface { private $apiClient; private $orderRepository; public function __construct(ApiClient $NzoHj, EntityRepository $b3Hhm) { $this->apiClient = $NzoHj; $this->orderRepository = $b3Hhm; } public static function getSubscribedEvents() : array { return [CheckoutOrderPlacedEvent::class => "\x6f\156\117\x72\144\x65\162\x50\154\141\143\145\144"]; } public function onOrderPlaced(CheckoutOrderPlacedEvent $iKZqE) { goto HnDlJ; ykURj: $this->apiClient->manifestOrder($IdeRW->getSalesChannelId(), $IdeRW); goto TG_LE; tygN3: if (trim($GTQv2) != '' && trim($GTQv2) != "\117\113") { goto zO3qN; } goto ykURj; agrSx: zO3qN: goto jLr2G; HnDlJ: $IdeRW = $iKZqE->getOrder(); goto WGutb; EojkK: FC73L: goto fojot; JQ0FP: throw new \Exception("\123\110\x49\122\x54\x4e\105\124\x57\x4f\122\113\137\x43\101\116\x4e\x4f\124\137\117\122\x44\105\122"); goto aXdbA; dqfnk: if (!($OuXdm > 0 || $DMXc7 > 0)) { goto FC73L; } goto RXnVf; jLr2G: $this->orderRepository->delete([["\x69\144" => $IdeRW->getId()]]); goto JQ0FP; TG_LE: goto hTDXs; goto agrSx; sGDJQ: $OuXdm = 0; goto qxLyJ; aXdbA: hTDXs: goto EojkK; FYSMp: foreach ($hUafW as $ED6Np) { goto Kx3B5; e785Y: if ($NWVwe->getUnitPrice() >= 10) { goto V061S; } goto Z7iVl; GVqxm: goto sazbO; goto QMob3; ZLkRe: Kp3j0: goto I2ViE; NJz1d: $NWVwe = $ED6Np->getPrice(); goto e785Y; Z7iVl: $DMXc7 = $NWVwe->getUnitPrice() / 10 * $NWVwe->getQuantity(); goto GVqxm; tR615: $OuXdm += $NWVwe->getQuantity(); goto JfuUX; SJUTw: if (!isset($FfZvm["\163\150\151\162\x74\156\145\x74\167\157\162\x6b"])) { goto giueP; } goto NJz1d; JfuUX: sazbO: goto XPypF; Kx3B5: $FfZvm = $ED6Np->getPayload(); goto SJUTw; XPypF: giueP: goto ZLkRe; QMob3: V061S: goto tR615; I2ViE: } goto cX2FG; qxLyJ: $DMXc7 = 0; goto FYSMp; cX2FG: T50cE: goto dqfnk; RXnVf: $GTQv2 = $this->apiClient->bookCoins($IdeRW->getSalesChannelId(), $OuXdm, $IdeRW->getOrderNumber(), 0, $DMXc7); goto tygN3; WGutb: $hUafW = $IdeRW->getLineItems(); goto sGDJQ; fojot: } }