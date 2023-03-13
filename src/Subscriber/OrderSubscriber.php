<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.14  |
    |              on 2023-03-13 15:30:11              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Subscriber; use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient; use Shopware\Core\Checkout\Cart\Event\CheckoutOrderPlacedEvent; use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity; use Shopware\Core\Checkout\Order\OrderEntity; use Shopware\Core\Checkout\Order\OrderEvents; use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface; use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent; use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria; use Symfony\Component\EventDispatcher\EventSubscriberInterface; class OrderSubscriber implements EventSubscriberInterface { private $apiClient; private $orderRepository; public function __construct(ApiClient $uYkPk, EntityRepositoryInterface $uCijf) { $this->apiClient = $uYkPk; $this->orderRepository = $uCijf; } public static function getSubscribedEvents() : array { return [CheckoutOrderPlacedEvent::class => "\x6f\x6e\x4f\162\144\145\x72\x50\154\x61\x63\x65\x64"]; } public function onOrderPlaced(CheckoutOrderPlacedEvent $QQDlT) { goto yGNmF; AK63q: foreach ($Kt9fx as $rq3w_) { goto v5eIG; KSmoJ: $zuhf9 = $gPC4R->getUnitPrice() / 10 * $gPC4R->getQuantity(); goto FSCAR; tj85g: cirnw: goto iydma; BLZFl: FlITz: goto uFMFj; FSCAR: goto cirnw; goto Gv1DV; sIMvd: if (!isset($tpIfV["\163\x68\151\162\x74\156\x65\164\167\157\162\153"])) { goto rxkxF; } goto Fl3mW; v5eIG: $tpIfV = $rq3w_->getPayload(); goto sIMvd; iydma: rxkxF: goto BLZFl; Fl3mW: $gPC4R = $rq3w_->getPrice(); goto X0dU2; X0dU2: if ($gPC4R->getUnitPrice() >= 10) { goto Kkjz1; } goto KSmoJ; Gv1DV: Kkjz1: goto LGz7Z; LGz7Z: $hd0kf += $gPC4R->getQuantity(); goto tj85g; uFMFj: } goto d1yVw; utmHk: Tzu2t: goto qwyLg; XBLk4: $Rx1iS = $this->apiClient->bookCoins($CHVd_->getSalesChannelId(), $hd0kf, $CHVd_->getOrderNumber(), 0, $zuhf9); goto lmA1a; yGNmF: $CHVd_ = $QQDlT->getOrder(); goto YdzwR; qwyLg: FR0pb: goto Hea0A; zAjMy: $zuhf9 = 0; goto AK63q; lmA1a: if (trim($Rx1iS) != '' && trim($Rx1iS) != "\117\x4b") { goto Qse0o; } goto nfsUw; MZsS0: Qse0o: goto J3rTu; j2VZ5: goto Tzu2t; goto MZsS0; nfsUw: $this->apiClient->manifestOrder($CHVd_->getSalesChannelId(), $CHVd_); goto j2VZ5; d1yVw: SrtVx: goto gTqrK; YdzwR: $Kt9fx = $CHVd_->getLineItems(); goto btvXW; bbOaw: throw new \Exception("\x53\x48\111\122\x54\116\x45\124\x57\x4f\122\113\137\x43\101\x4e\116\x4f\124\137\x4f\122\x44\x45\122"); goto utmHk; J3rTu: $this->orderRepository->delete([["\x69\x64" => $CHVd_->getId()]]); goto bbOaw; gTqrK: if (!($hd0kf > 0 || $zuhf9 > 0)) { goto FR0pb; } goto XBLk4; btvXW: $hd0kf = 0; goto zAjMy; Hea0A: } }