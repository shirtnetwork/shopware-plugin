<?php

declare(strict_types = 1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Storefront\Framework\Twig\IncludeDir;

use Shopware\Core\Framework\Adapter\AdapterException;
use Shopware\Core\Framework\Adapter\Twig\TemplateFinderInterface;
use Shopware\Core\Framework\Adapter\Twig\TemplateScopeDetector;
use Twig\Error\SyntaxError;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Expression\ArrayExpression;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;
use Twig\TokenStream;

/**
 * Class IncludeDirTokenParser
 *
 * @package TwigIncludeDir
 */
class IncludeDirTokenParser extends AbstractTokenParser
{

    public function __construct(
        private readonly TemplateFinderInterface $finder,
    ) {
    }


    /**
     * Parses a token and returns a node.
     *
     * @param Token $token
     *
     * @return Node
     *
     * @throws SyntaxError
     */
    public function parse(Token $token): Node
    {
        $stream = $this->parser->getStream();
        $source = $stream->getSourceContext()->getName();
        $expr = $this->parser->getExpressionParser()->parseExpression();
        $template = $expr->getAttribute('value');

        $parent = $this->finder->find($template, true, $source);
        $expr->setAttribute('value', $parent);

        list($recursive, $variables, $only) = $this->parseArguments();

        return new IncludeDirNode(
            $expr,
            $variables,
            $recursive,
            $only,
            $token->getLine(),
            $this->getTag()
        );
    }

    /**
     * @return array
     *
     * @throws SyntaxError
     */
    protected function parseArguments()
    {
        $stream = $this->parser->getStream();

        $recursive = false;
        if ($stream->nextIf(Token::NAME_TYPE, 'recursive')) {
            $recursive = true;
        }

        $variables = null;
        if ($stream->nextIf(Token::NAME_TYPE, 'with')) {
            $variables = $this->parser->getExpressionParser()->parseExpression();
        }

        $only = false;
        if ($stream->nextIf(Token::NAME_TYPE, 'only')) {
            $only = true;
        }

        $stream->expect(Token::BLOCK_END_TYPE);

        return array($recursive, $variables, $only);
    }

    private function getOptions(TokenStream $stream): array
    {
        if ($stream->test(Token::STRING_TYPE)) {
            return [
                'scopes' => [TemplateScopeDetector::DEFAULT_SCOPE],
                'template' => $stream->next()->getValue(),
            ];
        }

        $expression = $this->parser->getExpressionParser()->parseExpression();
        $options = $this->convertExpressionToArray($expression);

        if (!isset($options['template']) || !\is_string($options['template'])) {
            throw AdapterException::missingExtendsTemplate($stream->getSourceContext()->getName());
        }

        if (!isset($options['scopes'])) {
            $options['scopes'] = [TemplateScopeDetector::DEFAULT_SCOPE];
        }

        if (\is_string($options['scopes'])) {
            $options['scopes'] = [$options['scopes']];
        }

        return $options;
    }

    private function convertExpressionToArray(AbstractExpression $expression): mixed
    {
        if ($expression instanceof ArrayExpression) {
            $array = [];
            foreach ($expression->getKeyValuePairs() as $pair) {
                if (!$pair['key'] instanceof ConstantExpression) {
                    throw AdapterException::unexpectedTwigExpression($pair['key']);
                }

                $array[$pair['key']->getAttribute('value')] = $this->convertExpressionToArray($pair['value']);
            }

            return $array;
        }

        if ($expression instanceof ConstantExpression) {
            return $expression->getAttribute('value');
        }

        throw AdapterException::unexpectedTwigExpression($expression);
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag(): string
    {
        return 'includeDir';
    }
}