<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\Defaults;

class Migration1594800860CreateRoutingSlipDocument extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1594800860;
    }

    public function update(Connection $connection): void
    {
        $id = Uuid::randomBytes();
        $exists = $connection->fetchColumn('SELECT 1 FROM document_type WHERE technical_name = :technical_name', ['technical_name' => 'routing_slip']);
        if ($exists !== false) {
            return;
        }

        $connection->insert('document_type', ['id' => $id, 'technical_name' => 'routing_slip', 'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)]);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
