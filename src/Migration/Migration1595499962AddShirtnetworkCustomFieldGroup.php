<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;

class Migration1595499962AddShirtnetworkCustomFieldGroup extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1595499962;
    }

    public function update(Connection $connection): void
    {
        $exists = $connection->fetchOne('SELECT 1 FROM custom_field_set WHERE name = :name', ['name' => 'shirtnetwork']);
        if ($exists !== false) {
            return;
        }

        $id = Uuid::randomBytes();
        $connection->insert('custom_field_set', [
            'id' => $id,
            'name' => 'shirtnetwork',
            'config' => json_encode(['label' => ['en-GB' => 'Shirtnetwork']]),
            'active' => 1,
            'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)
        ]);

        $connection->insert('custom_field_set_relation', [
           'id' => Uuid::randomBytes(),
           'set_id' => $id,
           'entity_name' => 'product',
           'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)
        ]);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
