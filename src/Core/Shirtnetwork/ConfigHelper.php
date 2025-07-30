<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork;

use Shopware\Core\Framework\Context;

class ConfigHelper {

    protected $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
        // Use a precision of 15 for all further calculations
        bcscale(15);
    }

    public function getShirtnetworkInfos(string $salesChannelId, $sConfigId, $blIncludeEmptyViews = true) {
        $oShirtnetwork = $this->client;
        $oConfig = $oShirtnetwork->getConfig($salesChannelId, $sConfigId);

        $aObjects = array();
        foreach($oConfig->objects as $object){
            $oView = $oShirtnetwork->getViewById($salesChannelId, $object->meta->view->id);
            $aObject =  array(
                'type' => $object->type,
                'fills' => $object->meta->fills,
                'printtype' => $object->meta->printtype->name,
                'dimensions' => $this->getObjectDimensions($oView,$object),
                'view' => $object->meta->view->key
            );
            $aObject = array_merge($aObject, $this->getShirtnetworkTypeInfos($salesChannelId, $object));
            $aObjects[] = $aObject;
        }

        $views = $this->getViewPictures($salesChannelId, $oConfig->views, $sConfigId);

        if ($blIncludeEmptyViews === false) {
            $views = $this->filterEmptyViews($views,$aObjects);
        }

        return array(
            'objects' => $aObjects,
            'views' => $views
        );
    }

    public function getShirtnetworkTypeInfos($salesChannelId, $object){
        $aTypeInfos = array();
        switch($object->type){
            case 'text':
                $aTypeInfos = array(
                    'font' => $object->options->fontFamily,
                    'text' => $object->options->text
                );
                break;
            case 'logo':
                $aTypeInfos = array(
                    'logo' => $this->getLogoName($salesChannelId, $object->meta->logo->id),
                    'picture' => $this->getLogoUrl($salesChannelId, $object->meta->logo->picture),
                    'designer' => $object->meta->logo->designer,
                    'provision' => $object->meta->logo->provision
                );
                break;
            case 'user-logo':
                $aTypeInfos = array(
                    'picture' => $object->meta->url,
                    'original' => $object->meta->original,
                    'filters' => $object->options->filters
                );
                break;
        }
        return $aTypeInfos;
    }

    public function getObjectDimensions($oView, $object){
        //Calculate factors for real w/h to pixel w/h
        if (!$oView->realWidth || !$oView->realHeight) {
            return array(
                'width' => 0,
                'height' => 0
            );
        }
        $fw = bcdiv((string)$oView->width, (string)$oView->realWidth);
        $fh = bcdiv((string)$oView->height, (string)$oView->realHeight);
        $sfx = bcmul((string)$object->options->width, (string)$object->options->scaleX);
        $sfy = bcmul((string)$object->options->height, (string)$object->options->scaleY);

        //These are the real cm sizes of the object then
        $trw = bcdiv($sfx, $fw); //cm width
        $trh = bcdiv($sfy, $fh); //cm height
        return array('width' => $trw, 'height' => $trh);
    }

    public function getViewPictures($salesChannelId, $views, $cid){
        $aPictures = array();
        $sBaseUrl = $this->client->getConfigServerUrl($salesChannelId);

        foreach($views as $view){
            $sViewBaseUrl = $sBaseUrl . '/preview/' . $cid . '/'.$view->key;
            $aPictures[] = array(
                'view' => (array)$view,
                'icon' => $sViewBaseUrl.'/icon',
                'thumb' => $sViewBaseUrl.'/thumb',
                'picture' => $sViewBaseUrl,
            );
        }
        return $aPictures;
    }

    public function getPrinttypeName($salesChannelId, $iPrinttype){
        $oShirtnetwork = $this->client;
        $oPrinttype = $oShirtnetwork->getPrinttypeById($salesChannelId, $iPrinttype);
        return $oPrinttype->name;
    }

    public function getLogoName($salesChannelId, $iLogo){
        $oShirtnetwork = $this->client;
        $oLogo = $oShirtnetwork->getLogoById($salesChannelId, $iLogo);
        return $oLogo->name;
    }

    public function getLogoUrl($salesChannelId, $sPicture){
        $oShirtnetwork = $this->client;
        return $oShirtnetwork->getAssetUrl($salesChannelId, 'logos', $sPicture);
    }

    public function getColorNames($salesChannelId, $aFills, $iPrinttype){
        $aColors = array();
        if(is_array($aFills)){
            foreach($aFills as $fill){
                $aColors[] = $this->getColorName($salesChannelId, $fill, $iPrinttype);
            }
        }
        return $aColors;
    }

    public function getColorName($salesChannelId, $sHex, $iPrinttype){
        $oShirtnetwork = $this->client;
        $oColors = $oShirtnetwork->getPrinttypeColors($salesChannelId, $iPrinttype);

        foreach($oColors->source as $color){
            if(("#".substr("000000".dechex($color->hex),-6)) == $sHex){
                return $color->name;
            }
        }
    }

    protected function filterEmptyViews($views,$objects) {
        return array_filter($views, function ($view) use ($objects) {
            return count(array_filter($objects, function ($object) use ($view) {
                    return $object['view'] === $view['view']['key'];
                })) > 0;
        });
    }


}
