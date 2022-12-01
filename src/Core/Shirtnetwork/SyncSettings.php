<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork;

class SyncSettings {
    public $products;
    public $salesChannels;
    public $categories;
    public $tax;
    public $variantPropertyGroup;
    public $sizePropertyGroup;
    public $variantExpressionForListings;

    public static function fromArray($data){
        $instance = new SyncSettings();
        foreach($data as $key => $value){
            if (property_exists($instance, $key)){
                $instance->$key = $value;
            }
        }
        return $instance;
    }
}
