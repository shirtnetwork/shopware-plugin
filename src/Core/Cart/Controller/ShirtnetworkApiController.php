<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Cart\Controller;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Administration\Controller\Package;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ConfigHelper;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ProductSyncer;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\SyncSettings;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(defaults: ['_routeScope' => ['api']])]
#[Package('administration')]
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
     * @var EntityRepository
     */
    private $orderRepository;

    /**
     * @var ProductSyncer
     */
    private $productSyncer;

    public function __construct(ConfigHelper $configHelper, ApiClient $apiClient, EntityRepository $orderRepository, ProductSyncer $productSyncer)
    {
        $this->configHelper = $configHelper;
        $this->apiClient = $apiClient;
        $this->orderRepository = $orderRepository;
        $this->productSyncer = $productSyncer;

    }

    #[Route(path: '/api/shirtnetwork/orderconfigs/{order}', name: 'api.action.shirtnetwork.orderconfigs', methods: ['GET'])]
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

    #[Route(path: '/api/shirtnetwork/getsyncproducts/{start}/{num}/{salesChannelId}', name: 'api.action.shirtnetwork.getsyncproducts', methods: ['GET'])]
    public function getSyncProducts(Request $request, $start = 0, $num = 25, $salesChannelId = '')
    {
        $params = array("oUser" => $this->apiClient->getSOAPUserObject($salesChannelId), "iStart" => $start, "iNumProducts" => $num);
        $products = $this->apiClient->SOAPRequest($salesChannelId, "ProductService", "getUserProducts", $params, false, true);
        return new JsonResponse($products->source);

    }

    #[Route(path: '/api/shirtnetwork/countsyncproducts/{salesChannelId}', name: 'api.action.shirtnetwork.countsyncproducts', methods: ['GET'])]
    public function countSyncProducts(Request $request, $salesChannelId = '')
    {
        $params = array("oUser" => $this->apiClient->getSOAPUserObject($salesChannelId));
        $count = $this->apiClient->SOAPRequest($salesChannelId, "ProductService", "getUserProductsCount", $params, false, true);
        return new JsonResponse($count);
    }

    #[Route(path: '/api/shirtnetwork/syncproducts/{salesChannelId}', name: 'api.action.shirtnetwork.syncproducts', methods: ['POST'])]
    public function syncProducts(Context $context, Request $request, $salesChannelId = '')
    {
        $data = json_decode($request->getContent(), true);
        $log = $this->productSyncer->syncProducts(SyncSettings::fromArray($data),$salesChannelId, $context);
        return new JsonResponse($log);
    }

    #[Route(path: '/api/shirtnetwork/searchlogos/{salesChannelId}/{query}', name: 'api.action.shirtnetwork.searchlogos', methods: ['GET'])]
    public function searchLogos(Context $context, Request $request, string $salesChannelId = '', string $query = '')
    {
        $logos = $this->apiClient->getLogosBySearchTerm($salesChannelId, $query);
        return new JsonResponse($logos);
    }

    #[Route(path: '/api/shirtnetwork/getlogo/{logoId}', name: 'api.action.shirtnetwork.getlogo', methods: ['GET'])]
    public function getLogo(Context $context, Request $request, string $logoId)
    {
        $logo = $this->apiClient->getRest('logo/'.$logoId);
        return new JsonResponse($logo);
    }

    #[Route(path: '/api/shirtnetwork/getlogocategories/{salesChannelId}', name: 'api.action.shirtnetwork.getlogocategories', methods: ['GET'])]
    public function getLogoCategories(Context $context, Request $request, string $salesChannelId = '')
    {
        $categories = $this->apiClient->getLogoCategories($salesChannelId);
        return new JsonResponse($categories);
    }
}
