<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Administration\Controller;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ProductSyncer;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\SyncSettings;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ConfigHelper;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @RouteScope(scopes={"api"})
 */
class ShirtnetworkApiController extends AbstractController
{
    /**
     * @var ConfigHelper
     */
    private $configHelper;

    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var EntityRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var ProductSyncer
     */
    private $productSyncer;

    public function __construct(ConfigHelper $configHelper, ApiClient $apiClient, EntityRepositoryInterface $orderRepository, ProductSyncer $productSyncer)
    {
        $this->configHelper = $configHelper;
        $this->apiClient = $apiClient;
        $this->orderRepository = $orderRepository;
        $this->productSyncer = $productSyncer;

    }

    /**
     * @Route("/api/shirtnetwork/orderconfigs/{order}", name="api.action.shirtnetwork.orderconfigs", methods={"GET"})
     */
    public function getConfigs($order, Context $context, Request $request)
    {
        $criteria = new Criteria([$order]);
        $criteria->addAssociation('lineItems');
        $entities = $this->orderRepository->search($criteria,$context)->getEntities();
        /** @var OrderEntity $order */
        $order = $entities->first();
        $lineItems = $order->getLineItems();
        $items = [];

        foreach($lineItems as $item) {
            $payload = $item->getPayload();
            $configId = isset($payload['shirtnetwork']) ? $payload['shirtnetwork'] : null;
            $items[] = [
                'lineItem' => $item,
                'infos' => $configId ? $this->configHelper->getShirtnetworkInfos($order->getSalesChannelId(), $configId) : null
            ];
        }

        return new JsonResponse($items);

    }

    /**
     * @Route("/api/shirtnetwork/getsyncproducts/{start}/{num}/{salesChannelId}", name="api.action.shirtnetwork.getsyncproducts", methods={"GET"})
     */
    public function getSyncProducts($start = 0, $num = 25, $salesChannelId = '', Request $request = null)
    {
        $params = array("oUser" => $this->apiClient->getSOAPUserObject($salesChannelId), "iStart" => $start, "iNumProducts" => $num);
        $products = $this->apiClient->SOAPRequest($salesChannelId, "ProductService", "getUserProducts", $params, false, true);
        return new JsonResponse($products->source);

    }

    /**
     * @Route("/api/shirtnetwork/countsyncproducts/{salesChannelId}", name="api.action.shirtnetwork.countsyncproducts", methods={"GET"})
     */
    public function countSyncProducts($salesChannelId = '', Request $request = null)
    {
        $params = array("oUser" => $this->apiClient->getSOAPUserObject($salesChannelId));
        $count = $this->apiClient->SOAPRequest($salesChannelId, "ProductService", "getUserProductsCount", $params, false, true);
        return new JsonResponse($count);
    }


    /**
     * @Route("/api/shirtnetwork/syncproducts/{salesChannelId}", name="api.action.shirtnetwork.syncproducts", methods={"POST"})
     */
    public function syncProducts($salesChannelId = '', Context $context, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $log = $this->productSyncer->syncProducts(SyncSettings::fromArray($data),$salesChannelId, $context);
        return new JsonResponse($log);
    }
}
