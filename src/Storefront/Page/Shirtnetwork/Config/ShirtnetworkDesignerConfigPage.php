<?php


namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork\Config;
use Shopware\Storefront\Page\Page;

class ShirtnetworkDesignerConfigPage extends Page
{
    /**
     * @var array
     */
    protected $config;

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}