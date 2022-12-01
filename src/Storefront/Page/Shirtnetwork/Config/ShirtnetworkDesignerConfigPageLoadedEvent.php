<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork\Config;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\PageLoadedEvent;
use Symfony\Component\HttpFoundation\Request;

class ShirtnetworkDesignerConfigPageLoadedEvent extends PageLoadedEvent
{
    /**
     * @var ShirtnetworkDesignerConfigPage
     */
    protected $page;

    public function __construct(ShirtnetworkDesignerConfigPage $page, SalesChannelContext $salesChannelContext, Request $request)
    {
        $this->page = $page;
        parent::__construct($salesChannelContext, $request);
    }

    public function getPage(): ShirtnetworkDesignerConfigPage
    {
        return $this->page;
    }
}