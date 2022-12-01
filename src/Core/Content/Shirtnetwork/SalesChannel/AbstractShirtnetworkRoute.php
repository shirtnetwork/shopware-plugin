<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Content\Shirtnetwork\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

abstract class AbstractShirtnetworkRoute
{
    abstract public function getDecorated(): AbstractShirtnetworkRoute;

    abstract public function load(Criteria $criteria, SalesChannelContext $context): ShirtnetworkRouteResponse;
}