<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Cart\Checkout;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\PriceCalculator;
use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\CartBehavior;
use Shopware\Core\Checkout\Cart\CartDataCollectorInterface;
use Shopware\Core\Checkout\Cart\CartProcessorInterface;
use Shopware\Core\Checkout\Cart\LineItem\CartDataCollection;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\LineItem\LineItemCollection;
use Shopware\Core\Checkout\Cart\Price\QuantityPriceCalculator;
use Shopware\Core\Checkout\Cart\Price\Struct\QuantityPriceDefinition;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

class ShirtnetworkPriceCollector implements CartDataCollectorInterface, CartProcessorInterface
{

    /**
     * @var QuantityPriceCalculator
     */
    private $calculator;

    /**
     * @var PriceCalculator
     */
    private $priceCalculator;

    public function __construct(
        QuantityPriceCalculator $calculator,
        PriceCalculator $priceCalculator
    ) {
        $this->priceCalculator = $priceCalculator;
        $this->calculator = $calculator;
    }

    public function collect(CartDataCollection $data, Cart $original, SalesChannelContext $context, CartBehavior $behavior): void
    {
        // get all product ids of current cart
        $products = $original->getLineItems()->filterType(LineItem::PRODUCT_LINE_ITEM_TYPE);

        // remove all product ids which are already fetched from the database
        $filtered = $this->filterAlreadyFetchedPrices($products, $data);

        // Skip execution if there are no prices to be saved
        if (empty($filtered)) {
            return;
        }

        foreach ($filtered as $product) {
            if ($product->getPayloadValue('shirtnetwork')) {
                $key = $this->buildKey($product->getPayloadValue('shirtnetwork'));

                // Needs implementation, just an example
                $newPrice = $this->priceCalculator->getPrice($context->getSalesChannelId(), $product->getPayloadValue('shirtnetwork'), $product->getQuantity());

                // we have to set a value for each product id to prevent duplicate queries in next calculation
                $data->set($key, $newPrice);
            }
        }
    }

    public function process(CartDataCollection $data, Cart $original, Cart $toCalculate, SalesChannelContext $context, CartBehavior $behavior): void
    {
        // get all product line items
        $products = $toCalculate->getLineItems()->filterType(LineItem::PRODUCT_LINE_ITEM_TYPE);

        foreach ($products as $product) {

            if (!$product->getPayloadValue('shirtnetwork')) {
                continue;
            }

            $key = $this->buildKey($product->getPayloadValue('shirtnetwork'));

            // no overwritten price? continue with next product
            if (!$data->has($key) || $data->get($key) === null) {
                continue;
            }

            $newPrice = $data->get($key);

            // build new price definition
            $definition = new QuantityPriceDefinition(
                $newPrice,
                $product->getPrice()->getTaxRules(),
                $product->getQuantity(),
                true
            );

            // build CalculatedPrice over calculator class for overwritten price
            $calculated = $this->calculator->calculate($definition, $context);

            // set new price into line item
            $product->setPrice($calculated);
            $product->setPriceDefinition($definition);
        }
    }

    private function filterAlreadyFetchedPrices(LineItemCollection $products, CartDataCollection $data): array
    {
        $filtered = [];

        foreach ($products as $product) {

            if (!$product->getPayloadValue('shirtnetwork')) {
                continue;
            }

            $key = $this->buildKey($product->getPayloadValue('shirtnetwork'));

            // already fetched from database?
            if ($data->has($key)) {
                continue;
            }

            $filtered[] = $product;

        }

        return $filtered;
    }

    private function buildKey(string $id): string
    {
        return 'price-overwrite-'.$id;
    }


}
