<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\DataResolver;

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
use Symfony\Component\HttpFoundation\RequestStack;

class DesignerCmsElementResolver extends AbstractCmsElementResolver
{
    /**
     * @var EntityRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var DesignerPluginOptionBuilder
     */
    protected $designerPluginOptionBuilder;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    public function __construct(EntityRepositoryInterface $productRepository, DesignerPluginOptionBuilder $designerPluginOptionBuilder, RequestStack $requestStack)
    {
        $this->productRepository = $productRepository;
        $this->designerPluginOptionBuilder = $designerPluginOptionBuilder;
        $this->requestStack = $requestStack;
    }

    public function getType(): string
    {
        return 'designer';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        return null;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $config = $slot->getFieldConfig();
        $productId = $config->get('product')->getValue();

        $request = $this->requestStack->getCurrentRequest();
        $initialData = array_filter([
            'logo' => $request->query->get('logo', ''),
            'text' => $request->query->get('text', ''),
            'font' => $request->query->get('font', ''),
            'amount' => $request->query->get('amount', ''),
            'printtype' => $request->query->get('sartnr', ''),
            'keep' => $request->query->get('keep', '')
        ]);

        if ($request->get('artnr') || $request->get('config')) {
            $initialData = array_merge([
                'product' => $request->get('artnr'),
                'variant' => $request->get('vartnr'),
                'size' => $request->get('sartnr'),
                'config' => $request->get('config')
            ], $initialData);
        }else{
            if ($productId) {
                $criteria = new Criteria([$productId]);
                $criteria->addAssociation('extensions');
                /** @var ProductEntity $product */
                $product = $this->productRepository->search($criteria, $resolverContext->getSalesChannelContext()->getContext())->first();

                if ($product) {
                    $initialData = array_merge([
                        'product' => $product->getExtension('shirtnetwork')->get('sku')->get('artnr'),
                        'variant' => $product->getExtension('shirtnetwork')->get('sku')->get('vartnr'),
                        'size' => $product->getExtension('shirtnetwork')->get('sku')->get('sartnr'),
                    ], $initialData);
                }
            }
        }



        $options = $this->designerPluginOptionBuilder->build($resolverContext->getSalesChannelContext(), $initialData);
        $slot->setData(new ArrayStruct($options));

    }
}