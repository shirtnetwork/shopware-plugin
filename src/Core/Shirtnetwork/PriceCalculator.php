<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork;


class PriceCalculator {

    protected $client;
    protected $configHelper;

    public function __construct(ApiClient $client, ConfigHelper $configHelper)
    {
        $this->client = $client;
        $this->configHelper = $configHelper;
        // Use a precision of 15 for all further calculations
        bcscale(15);
    }

    public function getPrice ($salesChannelId, $config, $amount = 1) {

        $oShirtnetwork = $this->client;
        $oConfig = $oShirtnetwork->getConfig($salesChannelId, $config);

        $oProduct = $oShirtnetwork->getProductById($salesChannelId, $oConfig->product);

        // Capture rest of data from api
        $oVariant = $oShirtnetwork->getVariantById($salesChannelId, $oConfig->variant);
        $oSize = isset($oConfig->size) && $oConfig->size ? $oShirtnetwork->getSizeById($salesChannelId, $oConfig->size) : null;

        // Product base price, either scale or base
        $fScalePrice = $this->_getScalePrice($salesChannelId, $oConfig->product, $amount);
        $fPrice = $fScalePrice !== null ? $fScalePrice : $oProduct->price;

        // Variant price
        $fPrice += $oVariant->price;

        // Size price
        $fPrice += $oSize ? $oSize->price : 0;

        // Additional prices
        $fPrice += $this->_getAdditionalPrices($oProduct, $oConfig) / $amount;

        // Dodger if product is fix price we can return immediately
        if ($oProduct->fixPrice) return $fPrice;

        // Object prices
        $fPrice += $this->_getObjectsPrice($salesChannelId, $oConfig);

        // Printtype Scale price
        $fPrice += $this->_getPrinttypeScalePrice($salesChannelId, $oConfig, $amount);

        // View prices
        $fPrice += $this->_getViewPrices($salesChannelId, $oConfig);

        // Upload special price
        $fPrice += $this->_getUploadSpecialPrice($salesChannelId, $oConfig) / $amount;



        /*
        echo "Calculated Price is $fPrice <br/>";

        print_r($oProduct);
        print_r($oVariant);
        print_r($aViews);
        print_r($oSize);
        print_r($oConfig);

        echo '</pre>';
        exit();
        */

        return $fPrice;




    }

    protected function _getScalePrice (string $salesChannelId, $product, $amount) {
        $oShirtnetwork = $this->client;
        $aScalePrices = $oShirtnetwork->getProductPriceScales($salesChannelId, $product);

        //Sort scale prices by fromAmount first
        usort($aScalePrices,function($a,$b){
            return $a->fromAmount > $b->fromAmount;
        });

        $fScalePrice = null;
        foreach ($aScalePrices as $oScale) {
            if ($oScale->fromAmount <= $amount){
                $fScalePrice = $oScale->price;
            }else{
                break;
            }
        }
        return $fScalePrice;
    }

    protected function _getObjectsPrice (string $salesChannelId, $oConfig) {
        $aObjects = $oConfig->objects;

        // Dodge no objects, return 0
        if (count($oConfig->objects) == 0) return 0;

        $oShirtnetwork = $this->client;
        $oProduct = $oShirtnetwork->getProductById($salesChannelId, $oConfig->product);
        $oVariant = $oShirtnetwork->getVariantById($salesChannelId, $oConfig->variant);
        $aViews = $oShirtnetwork->getViewsByVariantId($salesChannelId, $oConfig->variant);

        $objectsPrice = 0;

        foreach ($aObjects as $object) {
            $oView = $this->_getViewById($aViews, $object->meta->view->id);
            // Calculate objects price, depending on pixel price or normal calculation
            if ($oProduct->usePixelPrice) {
                $price = $this->_getObjectPixelPrice($salesChannelId, $oView, $object);
                $price = $this->_constrainObjectPixelPrice($salesChannelId, $price, $oProduct, $object);
            } else {
                $price = $this->_getObjectPrice($salesChannelId, $object, $oProduct, $oVariant);
            }

            $price += $this->_getObjectColorPrice($salesChannelId, $object);

            $objectsPrice += $price;
        }

        return $objectsPrice;
    }

    protected function _getPrinttypeScalePrice (string $salesChannelId, $oConfig, $amount = 1) {
        $aObjects = $oConfig->objects;

        // Dodge no objects, return 0
        if (count($oConfig->objects) == 0) return 0;

        $map = $this->_generateColorMap($salesChannelId, $aObjects);
        $printtypeScalePrice = 0;

        foreach ($map as $printtypeId => $colors) {
            $printtype = $this->_getPrinttypeById($salesChannelId, $printtypeId);
            if ($printtype) {
                $printtypeScalePrice += $this->_getPrinttypeColorScalePriceByQuantity($printtype, count($colors), $amount);
            }
        }
        return $printtypeScalePrice;
    }

    protected function _getPrinttypeColorScalePriceByQuantity($printtype, $colors, $quantity) {
        $colorPriceScale = $this->_getPrinttypeColorPriceScales($printtype);
        if (!$colorPriceScale) {
            return 0;
        }

        $price = 0;
        foreach ($colorPriceScale as $item) {
            if ($colors >= $item['colors'] && $quantity >= $item['quantity']) {
                $price = $item['price'];
            } else {
                break;
            }
        }

        return $price;
    }

    protected function _getPrinttypeColorPriceScales($printtype) {
        if (empty($printtype->colorPriceScale)) {
            return null;
        }

        $scales = explode(';', $printtype->colorPriceScale);
        $result = array_map(function ($scale) {
            $item = explode(',', $scale);
            return [
                'colors' => (int) $item[0],
                'quantity' => (int) $item[1],
                'price' => (float) $item[2]
            ];
        }, $scales);

        usort($result, function ($a, $b) {
            return $a['colors'] <=> $b['colors'] ?: $a['quantity'] <=> $b['quantity'];
        });

        return $result;
    }

    protected function _getPrinttypeById($salesChannelId, $printtypeId) {
        $oShirtnetwork = $this->client;
        return $oShirtnetwork->getPrinttypeById($salesChannelId, $printtypeId);
    }

    protected function _generateColorMap($salesChannelId, $objects) {

        // all colors, with duplicates
        $objectColors = $this->_getAllObjectsColors($salesChannelId, $objects);

        // reduce to unique colors
        $uniqueColors = array_values(array_reduce($objectColors, function ($carry, $item) {
            $carry[$item->id] = $item;
            return $carry;
        }, []));

        // map them by printtype
        $colorMap = [];
        foreach ($uniqueColors as $color) {
            if (!isset($colorMap[$color->printtype])) {
                $colorMap[$color->printtype] = [];
            }
            $colorMap[$color->printtype][] = $color;
        }
        return $colorMap;
    }

    protected function _getAllObjectsColors($salesChannelId, $objects) {
        $objectColors = [];
        foreach ($objects as $object) {
            foreach ($object->meta->fills as $fill) {
                if ($fill) {
                    $color = $this->_getColorById($salesChannelId, $object->meta->printtype->id, $fill->id);
                    if ($color) {
                        $objectColors[] = $color;
                    }
                }
            }
        }
        return $objectColors;
    }

    protected function _getViewById ($aViews, $viewId) {
        foreach ($aViews as $oView) {
            if ($oView->id === $viewId) {
                return $oView;
            }
        }
        // View not found - maybe throw an exception here
    }

    protected function _getObjectPrice (string $salesChannelId, $object, $oProduct, $oVariant) {

        $objectPrice = 0;

        if ($object->type == 'text') {
            $objectPrice += $this->_getTextObjectPrice($object, $oProduct);
        } elseif ($object->type == 'logo' || $object->type == 'svg-logo') {
            $objectPrice += $this->_getLogoObjectPrice($salesChannelId, $object);
        } elseif ($object->type == 'user-logo') {
            $objectPrice += $this->_getUserUploadObjectPrice($salesChannelId, $object, $oProduct, $oVariant);
        }

        return $objectPrice;
    }

    protected function _getTextObjectPrice ($object, $oProduct) {
        $objectPrice = $oProduct->textBlockPrice;

        if ($oProduct->textPriceMode != 'PER_CHAR') {
            $aLines = preg_split('/\r\n|\r|\n/', $object->options->text);
            foreach ($aLines as $sLine) {
                if (strlen(trim($sLine)) > 0) {
                    $objectPrice += $oProduct->textPrice;
                }
            }
        } else {
            $str = preg_replace('/\s+/', '', $object->options->text);
            $objectPrice += strlen($str) * $oProduct->textPrice;
        }

        return $objectPrice;
    }

    protected function _getLogoObjectPrice (string $salesChannelId, $object) {
        $oShirtnetwork = $this->client;
        $logo = $oShirtnetwork->getLogoById($salesChannelId, $object->meta->logo->id);
        return $logo->price + $logo->provision;
    }

    protected function _getUserUploadObjectPrice (string $salesChannelId, $object, $oProduct, $oVariant) {
        $oShirtnetwork = $this->client;
        $oPrinttype = $oShirtnetwork->getPrinttypeById($salesChannelId, $object->meta->printtype->id);

        $objectPrice = $oProduct->uploadPrice; // + $oVariant->uploadPrice;
        $objectPrice += $oPrinttype->uploadPrice;
        return $objectPrice;
    }

    protected function _getObjectPixelPrice (string $salesChannelId, $oView, $object) {
        // Get cm2 of the object on this view
        $ocm = $this->_getObjectSize($oView, $object);

        // Get printtypes pixel price
        $ppx = $this->getPrinttypePixelPrice($salesChannelId, $object->meta->printtype->id, $ocm);

        $objectPrice = floatval(bcmul($ocm, strval($ppx)));

        return $objectPrice;
    }

    protected function _constrainObjectPixelPrice (string $salesChannelId, $objectPrice, $oProduct, $object) {
        //check if this exceeds the limits
        if ($object->type == 'text') {
            $minPrice = $oProduct->minTextPrice;
            $maxPrice = $oProduct->maxTextPrice;
        } else if ($object->type == 'user-logo') {
            $minPrice = $oProduct->minUploadPrice;
            $maxPrice = $oProduct->maxUploadPrice;
        } else if ($object->type == 'logo') {
            $oShirtnetwork = $this->client;
            $logo = $oShirtnetwork->getLogoById($salesChannelId, $object->meta->logo->id);

            $minPrice = $logo->minPrice;
            $maxPrice = $logo->maxPrice;
        }

        $objectPrice = $minPrice > 0 && $objectPrice < $minPrice ? $minPrice : $objectPrice;
        $objectPrice = $maxPrice > 0 && $objectPrice > $maxPrice ? $maxPrice : $objectPrice;
        return $objectPrice;
    }

    /**
     * Calculate real cm2 size of an object on a certain view
     */
    protected function _getObjectSize ($oView, $object) {
        $sizes = $this->configHelper->getObjectDimensions($oView,$object);
        $ocm = bcmul($sizes['width'], $sizes['height']); //object cm2;
        return $ocm;
    }

    /**
     * Get either the default or the scale pixelPrice for a printtype
     */
    protected function getPrinttypePixelPrice(string $salesChannelId, $printtype, $size) {
        $oShirtnetwork = $this->client;
        $oPrinttype = $oShirtnetwork->getPrinttypeById($salesChannelId, $printtype);

        // Maybe throw an error here
        if (!$oPrinttype)
            return 0;

        $price = $oPrinttype->pixelPrice;

        if ($oPrinttype->pixelPriceScale && stristr($oPrinttype->pixelPriceScale, ';') !== FALSE && strlen(trim($oPrinttype->pixelPriceScale)) > 0) {

            $scales = explode(';', $oPrinttype->pixelPriceScale);
            $numScales = count($scales);

            for ($i = 0; $i < $numScales; $i++) {
                $scale = explode(',', $scales[$i]);
                $scaleSize = floatval($scale[0]);
                if ($scaleSize < $size) {
                    $price = $scale[1];
                }
            }
        }

        return floatval($price);
    }

    protected function _getViewPrices (string $salesChannelId, $oConfig) {
        $aObjects = $oConfig->objects;

        // Dodge no objects, return 0
        if (count($oConfig->objects) == 0) return 0;

        $oShirtnetwork = $this->client;
        $aViews = $oShirtnetwork->getViewsByVariantId($salesChannelId, $oConfig->variant);
        $aFilledViews = array();
        $viewsPrice = 0;

        foreach ($aObjects as $object) {
            if(!in_array($object->meta->view->id, $aFilledViews)){
                $aFilledViews[] = $object->meta->view->id;
                $oView = $this->_getViewById($aViews, $object->meta->view->id);
                $viewsPrice += $oView->price;
            }
        }

        return $viewsPrice;
    }

    protected function _getObjectColorPrice (string $salesChannelId, $object) {
        $colorPrice = 0;

        foreach ($object->meta->fills as $fill) {
            if ($fill) {
                $color = $this->_getColorById($salesChannelId, $object->meta->printtype->id, $fill->id);
                $colorPrice += $color ? $color->price : 0;
            }
        }

        return $colorPrice;
    }


    protected function _getUploadSpecialPrice (string $salesChannelId, $oConfig) {
        $aObjects = $oConfig->objects;

        // Dodge no objects, return 0
        if (count($oConfig->objects) == 0) return 0;

        $oShirtnetwork = $this->client;
        $uploadSpecialPrice = 0;

        foreach ($aObjects as $object) {
            if ($object->type === 'user-logo') {
                $oPrinttype = $oShirtnetwork->getPrinttypeById($salesChannelId, $object->meta->printtype->id);
                if ($oPrinttype) {
                    $uploadSpecialPrice += $oPrinttype->uploadSpecialPrice;
                }
            }
        }

        return $uploadSpecialPrice;
    }


    protected function _getColorById (string $salesChannelId, $iPrinttype, $cid) {
        $oShirtnetwork = $this->client;
        $colors = $oShirtnetwork->getPrinttypeColors($salesChannelId, $iPrinttype);
        foreach ($colors->source as $color) {
            if ($color->id === $cid)
                return $color;
        }
    }

    private function _getAdditionalPrices($oProduct, $oConfig): float
    {
        $additionalPrice = 0;

        if ($oConfig->options->correctionView) {
            $additionalPrice += $oProduct->correctionViewPrice;
        }

        if ($oConfig->options->typeSample) {
            $additionalPrice += $oProduct->typeSamplePrice;
        }

        return $additionalPrice;
    }

}
