<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.14  |
    |              on 2022-12-21 15:06:01              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Subscriber; use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient; use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity; use Shopware\Core\Checkout\Order\OrderEntity; use Shopware\Core\Checkout\Order\OrderEvents; use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface; use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent; use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria; use Symfony\Component\EventDispatcher\EventSubscriberInterface; class OrderSubscriber implements EventSubscriberInterface { private $apiClient; private $orderRepository; public function __construct(ApiClient $urHf7, EntityRepositoryInterface $hyk63) { $this->apiClient = $urHf7; $this->orderRepository = $hyk63; } public static function getSubscribedEvents() : array { return [OrderEvents::ORDER_WRITTEN_EVENT => "\x6f\x6e\x4f\x72\x64\x65\x72\x57\x72\151\164\164\x65\x6e"]; } public function onOrderWritten(EntityWrittenEvent $blzk_) { goto ycmrO; Y_oQY: ViwWd: goto Rit9m; yGjJA: foreach ($UL2xf as $yngz8) { goto rcjM7; v3i3T: $HW3Mz = $this->orderRepository->search($tMnFf, $blzk_->getContext())->first(); goto XInlh; kJwbs: PgAkj: goto kRZOW; zLOlj: $this->apiClient->manifestOrder($HW3Mz->getSalesChannelId(), $HW3Mz); goto dBkOx; tTxsj: $this->orderRepository->delete([["\x69\144" => $HW3Mz->getId()]]); goto U8vwV; kRZOW: if (!($O3A0P > 0 || $QWNX6 > 0)) { goto Ij5Af; } goto OhO1y; o4Hjk: c_x1d: goto X0Na3; dBkOx: goto c_x1d; goto SPsMo; SPsMo: j263h: goto tTxsj; U8vwV: throw new \Exception("\123\x48\x49\122\x54\x4e\x45\124\x57\117\x52\x4b\137\x43\x41\x4e\x4e\x4f\124\137\x4f\x52\104\105\122"); goto o4Hjk; Ks5sf: if (trim($CZHh5) != '' && trim($CZHh5) != "\117\113") { goto j263h; } goto zLOlj; iemmZ: $QWNX6 = 0; goto ZRiWU; S0gqF: $O3A0P = 0; goto iemmZ; X0Na3: Ij5Af: goto YquOv; XInlh: $oYkHO = $HW3Mz->getLineItems(); goto S0gqF; tk4Yj: $tMnFf->addAssociation("\x6c\x69\x6e\x65\111\164\x65\x6d\x73"); goto v3i3T; OhO1y: $CZHh5 = $this->apiClient->bookCoins($HW3Mz->getSalesChannelId(), $O3A0P, $HW3Mz->getOrderNumber(), 0, $QWNX6); goto Ks5sf; ZRiWU: foreach ($oYkHO as $Vdynu) { goto BRY_T; N_iC2: d_C87: goto ccKul; HtHQH: Z_Pbw: goto htZL5; ccKul: $O3A0P += $U6Sgy->getQuantity(); goto B1PEC; BRY_T: $JI9au = $Vdynu->getPayload(); goto MnRsE; fnaTX: $QWNX6 = $U6Sgy->getUnitPrice() / 10 * $U6Sgy->getQuantity(); goto KE9om; L74d1: if ($U6Sgy->getUnitPrice() >= 10) { goto d_C87; } goto fnaTX; KE9om: goto TySQm; goto N_iC2; B1PEC: TySQm: goto n6RVf; n6RVf: xSZNO: goto HtHQH; BOAtD: $U6Sgy = $Vdynu->getPrice(); goto L74d1; MnRsE: if (!isset($JI9au["\163\150\x69\x72\x74\156\145\164\167\157\x72\x6b"])) { goto xSZNO; } goto BOAtD; htZL5: } goto kJwbs; YquOv: aSt19: goto g9gjI; rcjM7: $tMnFf = new Criteria([$yngz8]); goto tk4Yj; g9gjI: } goto Y_oQY; ycmrO: $UL2xf = $blzk_->getIds(); goto yGjJA; Rit9m: } }