<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork\Config;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ConfigHelper;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class ShirtnetworkDesignerConfigPageLoader
{
    /**
     * @var GenericPageLoaderInterface
     */
    private $genericPageLoader;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ConfigHelper
     */
    private $configHelper;

    public function __construct(GenericPageLoaderInterface $genericPageLoader, EventDispatcherInterface $eventDispatcher, ConfigHelper $configHelper)
    {
        $this->genericPageLoader = $genericPageLoader;
        $this->eventDispatcher = $eventDispatcher;
        $this->configHelper = $configHelper;
    }

    public function load(string $config, Request $request, SalesChannelContext $context): ShirtnetworkDesignerConfigPage
    {
        $page = $this->genericPageLoader->load($request, $context);
        $page = ShirtnetworkDesignerConfigPage::createFrom($page);
        $infos = $this->configHelper->getShirtnetworkInfos($context->getSalesChannelId(), $config);
        $page->setConfig($infos);

        $this->eventDispatcher->dispatch(
            new ShirtnetworkDesignerConfigPageLoadedEvent($page, $context, $request)
        );

        return $page;
    }
}