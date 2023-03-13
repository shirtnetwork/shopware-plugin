<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Page\Shirtnetwork;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\DesignerPluginOptionBuilder;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ShirtnetworkDesignerPageLoader
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
     * @var DesignerPluginOptionBuilder
     */
    private $pluginOptionBuilder;

    public function __construct(GenericPageLoaderInterface $genericPageLoader, EventDispatcherInterface $eventDispatcher, DesignerPluginOptionBuilder $pluginOptionBuilder)
    {
        $this->genericPageLoader = $genericPageLoader;
        $this->eventDispatcher = $eventDispatcher;
        $this->pluginOptionBuilder = $pluginOptionBuilder;
    }

    public function load(Request $request, SalesChannelContext $context): ShirtnetworkDesignerPage
    {
        $page = $this->genericPageLoader->load($request, $context);
        $page = ShirtnetworkDesignerPage::createFrom($page);

        $initialData = array_filter([
            'config' => $request->query->get('config', ''),
            'product' => $request->query->get('artnr', ''),
            'variant' => $request->query->get('vartnr', ''),
            'size' => $request->query->get('sartnr', ''),
            'logo' => $request->query->get('logo', ''),
            'text' => $request->query->get('text', ''),
            'font' => $request->query->get('font', ''),
            'amount' => $request->query->get('amount', ''),
            'printtype' => $request->query->get('sartnr', ''),
            'keep' => $request->query->get('keep', '')
        ]);

        $page->setShirtnetworkPluginOptions($this->pluginOptionBuilder->build($context, $initialData));

        $this->eventDispatcher->dispatch(
            new ShirtnetworkDesignerPageLoadedEvent($page, $context, $request)
        );

        return $page;
    }
}