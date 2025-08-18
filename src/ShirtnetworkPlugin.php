<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\System\CustomField\Aggregate\CustomFieldSet\CustomFieldSetEntity;
use Shopware\Core\System\CustomField\CustomFieldTypes;

class ShirtnetworkPlugin extends Plugin
{
    public function install(Plugin\Context\InstallContext $installContext): void
    {

        if (!$this->getCustomFieldSet($installContext->getContext(), 'shirtnetwork_category')) {
            $customFieldSetRepository = $this->container->get('custom_field_set.repository');
            $customFieldSetRepository->create([
                [
                    'name' => 'shirtnetwork_category',
                    'config' => [
                        'label' => [
                            'de-DE' => 'Shirtnetwork Kategorien',
                            'en-GB' => 'Shirtnetwork Categories'
                        ]
                    ],
                    'customFields' => [
                        [
                            'name' => 'logo_category_id',
                            'type' => CustomFieldTypes::JSON,
                            'config' => [
                                'label' => [
                                    'de-DE' => 'Logo Kategorie',
                                    'en-GB' => 'Logo Category'
                                ],
                                'componentName' => 'shirtnetwork-logo-category-select',
                                'customFieldPosition' => 1,
                            ]
                        ]
                    ],
                    'relations' => [
                        [
                            'entityName' => 'category'
                        ]
                    ]
                ]
            ], $installContext->getContext());
        }


    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        if (!$uninstallContext->keepUserData()) {
            // This custom field set was created by a migration in an earlier version
            $customFieldSet = $this->getCustomFieldSet($uninstallContext->getContext(), 'shirtnetwork');
            if ($customFieldSet) {
                $customFieldSetRepository = $this->container->get('custom_field_set.repository');
                $customFieldSetRepository->delete([['id' => $customFieldSet->getId()]], $uninstallContext->getContext());
            }
            $customFieldSet = $this->getCustomFieldSet($uninstallContext->getContext(), 'shirtnetwork_category');
            if ($customFieldSet) {
                $customFieldSetRepository = $this->container->get('custom_field_set.repository');
                $customFieldSetRepository->delete([['id' => $customFieldSet->getId()]], $uninstallContext->getContext());
            }
        }
    }

    private function getCustomFieldSet (Context $context, string $name): ?CustomFieldSetEntity
    {
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');
        return $customFieldSetRepository->search(
            (new Criteria())->addFilter(new EqualsFilter('name', $name)),
            $context
        )->first();
    }
}
