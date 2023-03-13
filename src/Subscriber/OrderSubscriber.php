<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.14  |
    |              on 2023-03-13 11:55:29              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Subscriber; use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient; use Shopware\Core\Checkout\Cart\Event\CheckoutOrderPlacedEvent; use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity; use Shopware\Core\Checkout\Order\OrderEntity; use Shopware\Core\Checkout\Order\OrderEvents; use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface; use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent; use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria; use Symfony\Component\EventDispatcher\EventSubscriberInterface; class OrderSubscriber implements EventSubscriberInterface { private $apiClient; private $orderRepository; public function __construct(ApiClient $BPcGx, EntityRepositoryInterface $gJsAY) { $this->apiClient = $BPcGx; $this->orderRepository = $gJsAY; } public static function getSubscribedEvents() : array { return [CheckoutOrderPlacedEvent::class => "\x6f\156\117\x72\x64\145\x72\120\x6c\x61\143\x65\x64"]; } public function onOrderPlaced(CheckoutOrderPlacedEvent $de6b4) { goto L3KpS; G9eiR: $J9AYW = $d03Uo->getLineItems(); goto N3Hib; N3Hib: $COu4n = 0; goto C5sjH; C5sjH: $aMgzw = 0; goto UrT_S; pMHTE: if (!($COu4n > 0 || $aMgzw > 0)) { goto xClEa; } goto QTE1T; cxzJJ: $this->orderRepository->delete([["\x69\144" => $d03Uo->getId()]]); goto ny5j5; uHwIp: Cmqqu: goto cxzJJ; iRP6Q: pOoNc: goto k8JLR; lZ2yq: XCJ0g: goto pMHTE; QTE1T: $OoaYM = $this->apiClient->bookCoins($d03Uo->getSalesChannelId(), $COu4n, $d03Uo->getOrderNumber(), 0, $aMgzw); goto IFtxV; IFtxV: if (trim($OoaYM) != '' && trim($OoaYM) != "\117\x4b") { goto Cmqqu; } goto PiJtE; UrT_S: foreach ($J9AYW as $Sd7Bo) { goto vuety; T0QMy: u4f1d: goto DDCDK; m6Qci: $COu4n += $tu7XG->getQuantity(); goto MVVPK; vgXml: $aMgzw = $tu7XG->getUnitPrice() / 10 * $tu7XG->getQuantity(); goto iX8Nb; iX8Nb: goto Wr9nI; goto BsCoL; LqzMS: if ($tu7XG->getUnitPrice() >= 10) { goto KiZsK; } goto vgXml; vuety: $zHbFI = $Sd7Bo->getPayload(); goto KZkSy; wj8MO: IbpCB: goto T0QMy; KZkSy: if (!isset($zHbFI["\163\150\151\x72\164\156\145\164\167\x6f\x72\x6b"])) { goto IbpCB; } goto JF5EH; JF5EH: $tu7XG = $Sd7Bo->getPrice(); goto LqzMS; BsCoL: KiZsK: goto m6Qci; MVVPK: Wr9nI: goto wj8MO; DDCDK: } goto lZ2yq; PiJtE: $this->apiClient->manifestOrder($d03Uo->getSalesChannelId(), $d03Uo); goto tpYxp; L3KpS: $d03Uo = $de6b4->getOrder(); goto G9eiR; k8JLR: xClEa: goto WL1Gh; ny5j5: throw new \Exception("\x53\x48\111\x52\124\x4e\x45\x54\127\x4f\x52\x4b\137\x43\x41\116\116\117\124\x5f\117\x52\104\105\122"); goto iRP6Q; tpYxp: goto pOoNc; goto uHwIp; WL1Gh: } }