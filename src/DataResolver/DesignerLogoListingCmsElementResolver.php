<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\DataResolver;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\DesignerPluginOptionBuilder;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Struct\ArrayStruct;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DesignerLogoListingCmsElementResolver extends AbstractCmsElementResolver
{
    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var EntityRepositoryInterface
     */
    private $categoryRepository;

    public function __construct(ApiClient $apiClient, EntityRepositoryInterface $categoryRepository)
    {
        $this->apiClient = $apiClient;
        $this->categoryRepository = $categoryRepository;
    }
    public function getType(): string
    {
        return 'designer-logo-listing';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        return null;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $request = $resolverContext->getRequest();
        $context = $resolverContext->getSalesChannelContext();

        $navigationId = $this->getNavigationId($request, $context);
        $salesChannelId = $context->getSalesChannelId();

        $page = $request->get('p') ?? 1;
        $logoCategoryId = $this->getLogoCategoryId($navigationId, $context);

        if ($logoCategoryId) {
            $logos = $this->apiClient->getLogosByCategory($salesChannelId, $logoCategoryId, 15, $page - 1);
            $total = $this->apiClient->getLogoCountByCategory($salesChannelId, $logoCategoryId);
        }else {
            $logos = [];
            $total = 0;
        }

        $slot->setData(new ArrayStruct([
            'logos' => $logos,
            'supplier' => $this->apiClient->getUserId($salesChannelId),
            'total' => $total,
            'criteria' => [
                'offset' => ($page - 1) * 15,
                'limit' => 15,
                'total' => $total,
                'page' => $page
            ],
            'currentFilters' => [
                'navigationId' => $navigationId,
                'logoCategoryId' => $logoCategoryId,
            ]
        ]));

    }

    private function getNavigationId(Request $request, SalesChannelContext $salesChannelContext): string
    {
        if ($navigationId = $request->get('navigationId')) {
            return $navigationId;
        }

        $params = $request->attributes->get('_route_params');

        if ($params && isset($params['navigationId'])) {
            return $params['navigationId'];
        }

        return $salesChannelContext->getSalesChannel()->getNavigationCategoryId();
    }

    /**
     * @param string $navigationId
     * @param SalesChannelContext $context
     * @return ?string
     */
    public function getLogoCategoryId(string $navigationId, SalesChannelContext $context): ?int
    {
        $salesChannelId = $context->getSalesChannelId();
        $category = $this->categoryRepository->search(new Criteria([$navigationId]), $context->getContext())->first();
        $customFields = $category->getCustomFields();
        $categoryField = $customFields['logo_category_id'];
        $logoCategories = $categoryField ? json_decode($categoryField) : [];
        return $logoCategories && isset($logoCategories->$salesChannelId) ? $logoCategories->$salesChannelId : null;
    }
}