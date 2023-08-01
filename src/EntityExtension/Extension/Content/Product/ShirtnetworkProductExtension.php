<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\EntityExtension\Extension\Content\Product;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Runtime;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ObjectField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class ShirtnetworkProductExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        /*$collection->add(
            (new StringField('shirtnetwork', 'shirtnetwork'))->addFlags(new Runtime())
        );
        $collection->add(
            (new StringField('custom_string', 'customString'))->addFlags(new Runtime())
        );*/
    }

    public function getDefinitionClass(): string
    {
        return ProductDefinition::class;
    }
}
