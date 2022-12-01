<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\PageLoadedEvent;
use Symfony\Component\HttpFoundation\Request;

class ShirtnetworkDesignerPageLoadedEvent extends PageLoadedEvent
{
    /**
     * @var ShirtnetworkDesignerPage
     */
    protected $page;

    public function __construct(ShirtnetworkDesignerPage $page, SalesChannelContext $salesChannelContext, Request $request)
    {
        $this->page = $page;
        parent::__construct($salesChannelContext, $request);
    }

    public function getPage(): ShirtnetworkDesignerPage
    {
        return $this->page;
    }
}