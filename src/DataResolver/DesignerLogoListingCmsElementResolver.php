<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\DataResolver;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\DesignerPluginOptionBuilder;
use Shopware\Core\Content\Category\CategoryEntity;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\EntityResolverContext;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\LandingPage\LandingPageEntity;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
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
     * @var EntityRepository
     */
    private $categoryRepository;

    public function __construct(ApiClient $apiClient, EntityRepository $categoryRepository)
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
        $salesChannelId = $context->getSalesChannelId();

        $page = $request->get('p') ?? 1;
        $contextData = $this->getContextData($resolverContext);

        $logoCategoryId = $contextData['logoCategoryId'] ?? null;

        if(!$logoCategoryId){
            return;
        }

        $logos = $this->apiClient->getLogosByCategory($salesChannelId, $logoCategoryId, 15, $page - 1);
        $total = $this->apiClient->getLogoCountByCategory($salesChannelId, $logoCategoryId);


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
            'currentFilters' => $contextData
        ]));

    }

    private function getContextData(ResolverContext $resolverContext): ?array
    {
        $data = [];

        if ($resolverContext instanceof EntityResolverContext) {
            $entity = $resolverContext->getEntity();

            if ($entity instanceof CategoryEntity) {
                $customFields = $entity->getCustomFields();
                if (isset($customFields['logo_category_id'])) {
                    $field = json_decode($customFields['logo_category_id'], true);
                    $data['logoCategoryId'] = $field[$resolverContext->getSalesChannelContext()->getSalesChannelId()];
                    $data['navigationId'] = $entity->getId();
                }
            }
        }

        return $data;
    }

}