<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;

class Migration1594802033CreateRoutingSlipDocumentBaseConfig extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1594802033;
    }

    public function update(Connection $connection): void
    {
        $documentId = $this->getDocumentId($connection);
        $id = Uuid::randomBytes();
        $config = $this->getBaseConfig();
        $existsQuery = 'SELECT 1 FROM document_base_config WHERE document_type_id = :document_type_id';
        $exists = $connection->fetchOne($existsQuery, ['document_type_id' => $documentId]);
        if (!$exists) {
            $connection->insert('document_base_config', ['id' => $id, 'document_type_id' => $documentId, 'name' => 'routing_slip', 'filename_prefix' => 'routing_slip_', 'global' => 1, 'config' => $config, 'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)]);
            $connection->insert('document_base_config_sales_channel', ['id' => Uuid::randomBytes(), 'document_base_config_id' => $id, 'document_type_id' => $documentId, 'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)]);
        }
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }

    private function getDocumentId(Connection $connection): string
    {
        $sql = <<<SQL
            SELECT id
            FROM `document_type`
            WHERE technical_name = :technical_name
SQL;

        return (string) $connection->executeQuery($sql, ['technical_name' => 'routing_slip'])->fetchOne();
    }

    private function getBaseConfig(): string
    {
        return json_encode([
            'displayPrices' => true,
            'displayFooter' => true,
            'displayHeader' => true,
            'displayLineItems' => true,
            'diplayLineItemPosition' => true,
            'displayPageCount' => true,
            'displayCompanyAddress' => true,
            'pageOrientation' => 'portrait',
            'pageSize' => 'a4',
            'itemsPerPage' => 10,
            'companyName' => 'Muster AG',
            'taxNumber' => '000111000',
            'vatId' => 'XX 111 222 333',
            'taxOffice' => 'Coesfeld',
            'bankName' => 'Kreissparkasse Münster',
            'bankIban' => 'DE11111222223333344444',
            'bankBic' => 'SWSKKEFF',
            'placeOfJurisdiction' => 'Coesfeld',
            'placeOfFulfillment' => 'Coesfeld',
            'executiveDirector' => 'Max Mustermann',
            'companyAddress' => 'Muster AG - Ebbinghoff 10 - 48624 Schöppingen',
        ]);
    }
}
