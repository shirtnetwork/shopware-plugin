<?php

declare(strict_types = 1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Framework\Twig\IncludeDir;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use Shopware\Core\Framework\Adapter\Twig\TemplateFinderInterface;
use Shopware\Core\Framework\Adapter\Twig\Node\SwInclude;
use Twig\Compiler;
use Twig\Error\LoaderError;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Node;
use Twig\Node\NodeOutputInterface;
use Twig\Attribute\YieldReady;

/**
 * Class IncludeDirNode
 *
 * @package TwigIncludeDir
 */
#[YieldReady]
class IncludeDirNode extends Node implements NodeOutputInterface
{
    public function __construct(
        AbstractExpression $expr,
        private readonly TemplateFinderInterface $finder,
        private readonly ?string $namespace = null,
        ?AbstractExpression $variables = null,
        bool $recursive = false,
        bool $only = false,
        int $lineno = 0,
        string $tag = ''
    ) {
        $nodes = ['expr' => $expr];
        if (null !== $variables) {
            $nodes['variables'] = $variables;
        }

        parent::__construct(
            $nodes,
            [
                'recursive' => $recursive,
                'only' => $only
            ],
            $lineno,
            $tag
        );
    }

    /**
     * @param Compiler $compiler
     *
     * @throws LoaderError
     */
    public function compile(Compiler $compiler): void
    {
        $mainLoader = $compiler->getEnvironment()->getLoader();
        $loaders = $mainLoader instanceof ChainLoader ? $mainLoader->getLoaders() : [$mainLoader];
        $templateDirectory = trim(
            str_replace('\\', '/', $this->getNode('expr')->getAttribute('value')),
            '/'
        );
        $discoveredTemplates = [];

        foreach ($loaders as $loader) {
            if (!$loader instanceof FilesystemLoader) {
                continue;
            }

            foreach ($this->findTemplates($loader, $templateDirectory) as $template) {
                $discoveredTemplates[$template] = true;
            }
        }

        $templates = array_filter(
            array_keys($discoveredTemplates),
            $this->isAvailableInTemplateHierarchy(...)
        );
        sort($templates, SORT_STRING);

        foreach ($templates as $templateName) {
            if ($this->namespace !== null) {
                $templateName = $this->namespace . '/' . $templateName;
            }

            // A template may exist in multiple theme/plugin layers. Include the
            // logical name once and let SwInclude resolve the highest-priority
            // version through Shopware's template inheritance hierarchy.
            $template = new SwInclude(
                new ConstantExpression($templateName, $this->lineno),
                $this->hasNode('variables') ? $this->getNode('variables') : null,
                $this->getAttribute('only'),
                false,
                $this->lineno
            );

            $template->compile($compiler);
        }
    }

    /**
     * @return iterable<string>
     */
    private function findTemplates(FilesystemLoader $loader, string $templateDirectory): iterable
    {
        foreach ($loader->getPaths() as $loaderPath) {
            $loaderPath = rtrim($loaderPath, '/\\');
            $includePath = $loaderPath . DIRECTORY_SEPARATOR . str_replace(
                '/',
                DIRECTORY_SEPARATOR,
                $templateDirectory
            );

            if (!is_dir($includePath)) {
                continue;
            }

            if ($this->getAttribute('recursive')) {
                $directory = new RecursiveDirectoryIterator($includePath);
                $iterator = new RecursiveIteratorIterator($directory);
                $foundFiles = new RegexIterator($iterator, '/^.+\.twig$/i', RecursiveRegexIterator::GET_MATCH);

                foreach ($foundFiles as $file) {
                    yield $this->getRelativeTemplateName($loaderPath, $file[0]);
                }

                continue;
            }

            foreach (glob($includePath . '/*.twig') ?: [] as $file) {
                yield $this->getRelativeTemplateName($loaderPath, $file);
            }
        }
    }

    private function getRelativeTemplateName(string $loaderPath, string $file): string
    {
        return ltrim(
            str_replace(DIRECTORY_SEPARATOR, '/', substr($file, strlen($loaderPath))),
            '/'
        );
    }

    private function isAvailableInTemplateHierarchy(string $template): bool
    {
        if ($this->namespace === null) {
            return true;
        }

        return str_starts_with(
            $this->finder->find($this->namespace . '/' . $template, true),
            '@'
        );
    }
}
