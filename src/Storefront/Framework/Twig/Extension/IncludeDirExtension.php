<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Framework\Twig\Extension;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Framework\Twig\IncludeDir\IncludeDirTokenParser;
use Shopware\Core\Framework\Adapter\Twig\TemplateFinderInterface;
use Twig\Extension\AbstractExtension;

class IncludeDirExtension extends AbstractExtension
{
    public function __construct(
        private readonly TemplateFinderInterface $finder,
    ) {
    }

    public function getTokenParsers()
    {
        return [
            new IncludeDirTokenParser($this->finder)
        ];
    }
}