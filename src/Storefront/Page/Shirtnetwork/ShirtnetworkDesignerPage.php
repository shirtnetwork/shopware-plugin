<?php


namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork;
use Shopware\Storefront\Page\Page;

class ShirtnetworkDesignerPage extends Page
{
    /**
     * @var array
     */
    protected $shirtnetworkPluginOptions;

    public function getShirtnetworkPluginOptions(): array
    {
        return $this->shirtnetworkPluginOptions;
    }

    public function setShirtnetworkPluginOptions(array $shirtnetworkPluginOptions): void
    {
        $this->shirtnetworkPluginOptions = $shirtnetworkPluginOptions;
    }
}