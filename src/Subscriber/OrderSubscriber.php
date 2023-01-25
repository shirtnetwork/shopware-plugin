<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.14  |
    |              on 2023-01-25 10:40:43              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Subscriber; use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient; use Shopware\Core\Checkout\Cart\Event\CheckoutOrderPlacedEvent; use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity; use Shopware\Core\Checkout\Order\OrderEntity; use Shopware\Core\Checkout\Order\OrderEvents; use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface; use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent; use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria; use Symfony\Component\EventDispatcher\EventSubscriberInterface; class OrderSubscriber implements EventSubscriberInterface { private $apiClient; private $orderRepository; public function __construct(ApiClient $xJkFL, EntityRepositoryInterface $QZNRb) { $this->apiClient = $xJkFL; $this->orderRepository = $QZNRb; } public static function getSubscribedEvents() : array { return [CheckoutOrderPlacedEvent::class => "\x6f\x6e\117\162\144\145\162\120\x6c\141\143\x65\144"]; } public function onOrderPlaced(CheckoutOrderPlacedEvent $cMRo_) { goto Nkxcs; e03k3: $HkBf0 = 0; goto CAasp; vwZSb: throw new \Exception("\x53\110\111\122\124\116\x45\x54\127\117\x52\113\137\103\101\116\x4e\117\124\137\x4f\x52\104\x45\x52"); goto ACICf; gxzKc: if (trim($leJ3M) != '' && trim($leJ3M) != "\x4f\x4b") { goto NEDGS; } goto sqhvC; sqhvC: $this->apiClient->manifestOrder($f3LpH->getSalesChannelId(), $f3LpH); goto pQuiT; CAasp: foreach ($UZeR3 as $bffhT) { goto Zg_vY; AazgK: $Epn4B += $GXsdy->getQuantity(); goto caQne; r6NvX: $GXsdy = $bffhT->getPrice(); goto TD4Zi; caQne: kgINP: goto RGsCg; aKiap: gp3mP: goto AazgK; AJtgp: goto kgINP; goto aKiap; FcoJx: if (!isset($Ni_tM["\x73\x68\151\162\x74\156\x65\164\x77\157\162\x6b"])) { goto rb_La; } goto r6NvX; WCZda: $HkBf0 = $GXsdy->getUnitPrice() / 10 * $GXsdy->getQuantity(); goto AJtgp; Zg_vY: $Ni_tM = $bffhT->getPayload(); goto FcoJx; TD4Zi: if ($GXsdy->getUnitPrice() >= 10) { goto gp3mP; } goto WCZda; ggh9T: QdPFt: goto oAlwY; RGsCg: rb_La: goto ggh9T; oAlwY: } goto ECPK2; pQuiT: goto ZvsRb; goto vnlvW; i8ZNx: $this->orderRepository->delete([["\x69\x64" => $f3LpH->getId()]]); goto vwZSb; iE7Y1: C5_aV: goto Qm8LI; ACICf: ZvsRb: goto iE7Y1; ECPK2: R0YcG: goto M8xga; M8xga: if (!($Epn4B > 0 || $HkBf0 > 0)) { goto C5_aV; } goto jNDFi; d7TVK: $Epn4B = 0; goto e03k3; jNDFi: $leJ3M = $this->apiClient->bookCoins($f3LpH->getSalesChannelId(), $Epn4B, $f3LpH->getOrderNumber(), 0, $HkBf0); goto gxzKc; Nkxcs: $f3LpH = $cMRo_->getOrder(); goto zOBFk; vnlvW: NEDGS: goto i8ZNx; zOBFk: $UZeR3 = $f3LpH->getLineItems(); goto d7TVK; Qm8LI: } }