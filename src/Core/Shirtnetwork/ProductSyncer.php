<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork;

use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class ProductSyncer {

    protected $productRepository;
    protected $productMediaRepository;
    protected $visibilityRepository;
    protected $propertyGroupOptionRepository;
    protected $taxRepository;
    protected $apiClient;
    protected $mediaSyncer;
    protected $taxCache = [];
    protected $systemConfigService;
    protected Context $context;
    protected $salesChannelId;

    public function __construct(
        ApiClient $apiClient,
        MediaSyncer $mediaSyncer,
        EntityRepository $productRepository,
        EntityRepository $productMediaRepository,
        EntityRepository $visibilityRepository,
        EntityRepository $propertyGroupOptionRepository,
        EntityRepository $taxRepository,
        SystemConfigService $systemConfigService
    )    {
        $this->apiClient = $apiClient;
        $this->mediaSyncer = $mediaSyncer;
        $this->productRepository = $productRepository;
        $this->productMediaRepository = $productMediaRepository;
        $this->visibilityRepository = $visibilityRepository;
        $this->propertyGroupOptionRepository = $propertyGroupOptionRepository;
        $this->taxRepository = $taxRepository;
        $this->systemConfigService = $systemConfigService;
    }

    /**
     * @param SyncSettings $syncSettings
     */
    public function syncProducts(SyncSettings $syncSettings, string $salesChannelId, Context $context){
        $this->context = $context;
        $this->salesChannelId = $salesChannelId;
        foreach($syncSettings->products as $pid){
            $product = $this->apiClient->SOAPRequest($this->salesChannelId, "ProductService", "getById", array("id" => $pid));
            $combinations = $this->syncPropertyGroups($product, $syncSettings->variantPropertyGroup, $syncSettings->sizePropertyGroup);
            $productData = $this->syncProduct($product,$combinations,$syncSettings);
            $variantData = $this->syncVariants($product,$combinations,$syncSettings);
            if (!$syncSettings->variantExpressionForListings && count($variantData)){
                $this->assignMainVariant($productData[0],$variantData);
            }
        }

        return true;

    }

    protected function syncProduct($product,$combinations,SyncSettings $syncSettings){
        $safeID = "SNW_".$product->id;
        $configuratorSettings = $this->buildConfiguratorSettings($combinations);
        $firstMedias = isset($combinations[0]) ? $this->mediaSyncer->getMediaFiles($this->salesChannelId, $this->context, $combinations[0]['pictures']) : [];
        $sizes = $this->getProductSizes($product);

        $configuratorGroupConfig = [["id" => $syncSettings->variantPropertyGroup, "representation" => "box", "expressionForListings" => $syncSettings->variantExpressionForListings]];
        if (count($sizes)) {
            $configuratorGroupConfig[] = ["id" => $syncSettings->sizePropertyGroup, "representation" => "box", "expressionForListings" => true];
        }

        $productData = [
            [
                'id' => md5($safeID,false),
                'name' => $product->name,
                'configuratorGroupConfig' => $configuratorGroupConfig,
                'configuratorSettings' => $configuratorSettings,
                'productNumber' => $product->artNr.'-'.uniqid(),
                'description' => $product->description,
                'stock' => 99999,
                'customFields' => ['is_shirtnetwork' => true],
                'categories' => array_map(function($c){ return ['id' => $c];},$syncSettings->categories),
                'taxId' => $syncSettings->tax,
                'price' => [['currencyId' => Defaults::CURRENCY, 'gross' => $product->price, 'net' => $this->toNetPrice($product->price, $syncSettings->tax), 'linked' => true ]],
            ]
        ];

        if (count($firstMedias)){
            $productData[0]['coverId'] = $firstMedias[0]['id'];
            $productData[0]['media'] = $firstMedias;
        }

        $this->removeProductMedia(md5($safeID,false));

        try {
            $this->productRepository->upsert($productData, $this->context);
        } catch (\Exception $e) {
            print_r($combinations);
            print_r($productData);
            throw($e);
        }
        $visibilities = array_map(function($ch) use ($safeID) { return ['id' => md5($safeID.$ch,false), 'productId' => md5($safeID,false), 'salesChannelId' => $ch, 'visibility' => 30];}, $syncSettings->salesChannels);
        $this->visibilityRepository->upsert($visibilities, $this->context);
        return $productData;
    }

    protected function syncVariants($product, $combinations,SyncSettings $syncSettings){
        $safeID = "SNW_".$product->id;
        $variantsData = [];
        foreach($combinations as $combination){
            $safeOptionID = $safeID . md5(json_encode($combination['option']));
            $media = $this->mediaSyncer->getMediaFiles($this->salesChannelId, $this->context, $combination['pictures']);

            $data = [
                'id' => md5($safeOptionID,false),
                'name' => $product->name . ' ' . $combination['name'],
                'coverId' => $media[0]['id'],
                'productNumber' => $combination['sku'],
                'options' => $combination['option'],
                'parentId' => md5($safeID,false),
                'customFields' => ['is_shirtnetwork' => true],
                'stock' => 99999,
                'taxId' => $syncSettings->tax,
                'media' => $media
            ];

            if ($combination['price'] > 0){
                $data['price'] = [['currencyId' => Defaults::CURRENCY, 'gross' => $product->price + $combination['price'], 'net' => $this->toNetPrice($product->price + $combination['price'], $syncSettings->tax), 'linked' => false ]];
            }

            $this->removeProductMedia(md5($safeOptionID,false));

            $variantsData[] = $data;
        }

        try{
            $this->productRepository->upsert($variantsData,$this->context);
        }catch(\Exception $e){
            print_r($variantsData);
            throw($e);
        }

        return $variantsData;
    }

    protected function assignMainVariant($product,$variants){
        try{
            $this->productRepository->update([[
                'id' => $product['id'],
                'mainVariantId' => $variants[0]['id']
            ]],$this->context);
        } catch (\Exception $e) {
            print_r([[
                'id' => $product['id'],
                'mainVariantId' => $variants[0]['id']
            ]]);
            throw($e);
        }
    }

    protected function removeProductMedia($pid) {
        $ids = $this->productMediaRepository->searchIds(
            (new Criteria())->addFilter(new EqualsFilter('productId', $pid)),
            $this->context
        );
        if ($ids->getTotal()){
            $this->productMediaRepository->delete(array_map(function($id){ return ['id' => $id]; }, $ids->getIds()), $this->context);
        }
    }

    protected function buildConfiguratorSettings($combinations) {
        $settings = [];
        $usedOptions = [];
        foreach($combinations as $combination){
            foreach($combination['option'] as $option){
                if (!in_array($option['id'], $usedOptions)) {
                    $settings[] = ['optionId' => $option['id']];
                    $usedOptions[] = $option['id'];
                }
            }
        }
        return $settings;
    }

    protected function syncPropertyGroups($product, $variantPropertyGroup, $sizePropertyGroup){
        $variants = $this->getProductVariants($product);
        $variantMatches = $this->syncVariantPropertyGroup($variantPropertyGroup, $variants);
        $sizes = $this->getProductSizes($product);
        $sizeMatches = $this->syncSizePropertyGroup($sizePropertyGroup, $sizes);

        //build combinations
        $combinations = [];
        foreach($variantMatches as $vm){
            if (count($sizeMatches)) {
                foreach($sizeMatches as $sm){
                    $combinations[] = [
                        'option' => [['id' => $vm['entity']], ['id' => $sm['entity']]],
                        'sku' => $this->getProductNumber($product->artNr, $vm['entry']['sku'],  $sm['entry']['sku']),
                        'price' => $vm['entry']['price'] + $sm['entry']['price'],
                        'name' => $vm['entry']['name'],
                        'pictures' => $vm['entry']['pictures']
                    ];
                }
            }else{
                $combinations[] = [
                    'option' => [['id' => $vm['entity']]],
                    'sku' => $this->getProductNumber($product->artNr, $vm['entry']['sku']),
                    'price' => $vm['entry']['price'],
                    'name' => $vm['entry']['name'],
                    'pictures' => $vm['entry']['pictures']
                ];

            }

        }

        return $combinations;
    }

    protected function syncVariantPropertyGroup($groupId, $variants){
        $entries = array_map(function($variant) use ($groupId) {
            $views = $this->getVariantViews($variant);
            return [
                'data' => [
                    'name' => $variant->name,
                    'colorHexCode' => '#' . dechex(intval($variant->color)),
                    'groupId' => $groupId
                ],
                'sku' => $variant->artnr,
                'price' => $variant->price,
                'name' => $variant->name,
                'pictures' => array_column($views, 'picture')
            ];
        }, $variants);
        return $this->syncPropertyGroup($groupId, $entries);
    }

    protected function syncSizePropertyGroup($groupId, $sizes){
        $entries = array_map(function($size) use ($groupId) {
            return [
                'data' => [
                    'name' => $size->name,
                    'groupId' => $groupId
                ],
                'sku' => $size->artnr,
                'name' => $size->name,
                'price' => $size->price
            ];
        }, $sizes);
        return $this->syncPropertyGroup($groupId, $entries);
    }

    protected function syncPropertyGroup($groupId, $entries){
        // map existing entries
        $mapped = $this->findExistingPropertyGroupOptions($groupId, $entries);

        foreach($mapped as $key => $match){
            if (!$match['entity']){
                $id = $this->propertyGroupOptionRepository->create([$match['entry']['data']], $this->context)->getPrimaryKeys('property_group_option')[0];
                $mapped[$key]['entity'] = $id;
            }
        }
        return $mapped;
    }

    protected function findExistingPropertyGroupOptions($groupId, $entries) {
        $names = array_map(function($e){ return $e['data']['name']; }, $entries);
        $criteria = new Criteria();
        $criteria->addFilter(
            new EqualsFilter('groupId',$groupId)
        );
        $criteria->addFilter(
            new EqualsAnyFilter('name', $names)
        );

        $entities = $this->propertyGroupOptionRepository->search($criteria,$this->context);
        return array_map(function($entry) use ($entities){
            foreach($entities as $entity){
                if ($entity->getName() === $entry['data']['name']){
                    return [
                        'entry' => $entry,
                        'entity' => $entity->getId()
                    ];
                }
            }
            return [
                'entry' => $entry,
                'entity' => null
            ];
        }, $entries);
    }

    /**
     * @param $product
     * @return mixed|null
     */
    protected function getProductVariants($product)
    {
        $variants = $this->apiClient->SOAPRequest($this->salesChannelId, "VariantService", "getVariantsByProduct", array("oProduct" => array("id" => $product->id)), true);
        $variants = $variants->source;
        return $variants;
    }

    /**
     * @param $product
     * @return mixed|null
     */
    protected function getProductSizes($product)
    {
        $sizes = $this->apiClient->SOAPRequest($this->salesChannelId, "SizeService", "getProductSizes", array("oProduct" => array("id" => $product->id)), true);
        $sizes = $sizes->source;
        return $sizes;
    }

    /**
     * @param $variant
     * @return mixed|null
     */
    protected function getVariantViews($variant)
    {
        $args = new \stdClass();
        $args->id = $variant->id;
        $views = $this->apiClient->SOAPRequest($this->salesChannelId, "VariantViewService", "getViewsByVariant", array("oVariant" => array("id" => $variant->id)), true);
        $views = $views->source;
        return $views;
    }

    protected function toNetPrice($price, $taxId) {
        $tax = isset($taxCache[$taxId]) ? $taxCache[$taxId] : $this->taxRepository->search(new Criteria([$taxId]), $this->context)->first();
        $taxCache[$taxId] = $tax;

        return $price / 100 * $tax->getTaxRate();
    }

    protected function getProductNumber($product, $variant, $size = '') {
        $scheme = $this->systemConfigService->get('ShirtnetworkPlugin.config.skuscheme', $this->salesChannelId);
        return str_replace(
            ['{PRODUCT_SKU}', '{VARIANT_SKU}', '{SIZE_SKU}'],
            [$product, $variant, $size],
            $scheme
        );
    }

}
