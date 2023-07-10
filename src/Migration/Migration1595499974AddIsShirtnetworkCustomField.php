<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;

class Migration1595499974AddIsShirtnetworkCustomField extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1595499974;
    }

    public function update(Connection $connection): void
    {
        $exists = $connection->fetchColumn('SELECT 1 FROM custom_field WHERE name = :name', ['name' => 'is_shirtnetwork']);
        if ($exists !== false) {
            return;
        }

        $set = $connection->fetchColumn('SELECT id FROM custom_field_set WHERE name = :name', ['name' => 'shirtnetwork']);
        $connection->insert('custom_field', [
            'id' => Uuid::randomBytes(),
            'name' => 'is_shirtnetwork',
            'type' => 'bool',
            'config' => json_encode([
                'type' => 'checkbox',
                'label' => [
                    'en-GB' => 'Shirtnetwork active',
                    'de-DE' => 'Shirtnetwork aktiv'
                ],
                'componentName' => 'sw-field',
                'customFieldType' => 'checkbox',
                'customFieldPosition' => 1
            ]),
            'active' => 1,
            'set_id' => $set,
            'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)
        ]);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
