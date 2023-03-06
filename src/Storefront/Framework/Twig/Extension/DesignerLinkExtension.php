<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Framework\Twig\Extension;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\Router;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Content\Seo\SeoUrlPlaceholderHandlerInterface;
use Shopware\Core\Framework\Struct\ArrayStruct;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DesignerLinkExtension extends AbstractExtension
{

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var RoutingExtension
     */
    protected $routingExtension;

    /**
     * @param Router $router
     */
    public function __construct(Router $router, RoutingExtension $routingExtension)
    {
        $this->router = $router;
        $this->routingExtension = $routingExtension;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('designer_link', [$this, 'designer_link'], ['needs_context' => true, 'is_safe_callback' => [$this->routingExtension, 'isUrlGenerationSafe']]),
            new TwigFunction('designer_config_link', [$this, 'designer_config_link'], ['needs_context' => true, 'is_safe_callback' => [$this->routingExtension, 'isUrlGenerationSafe']])
        ];
    }

    /**
     * @return string
     */
    public function designer_link(array $context, ProductEntity $product = null)
    {
        return $this->router->getDesignerLink($this->getSalesChannelId($context), $product);
    }

    /**
     * @return string
     */
    public function designer_config_link(array $context, string $configId = null)
    {
        return $this->router->getDesignerConfigLink($this->getSalesChannelId($context), $configId);
    }

    private function getSalesChannelId(array $context): ?string
    {
        if (isset($context['context'])) {
            $salesChannelContext = $context['context'];
            if ($salesChannelContext instanceof SalesChannelContext) {
                return $salesChannelContext->getSalesChannelId();
            }
        }
        if (isset($context['salesChannel'])) {
            $salesChannel = $context['salesChannel'];
            if ($salesChannel instanceof SalesChannelEntity) {
                return $salesChannel->getId();
            }
        }

        return null;
    }

}