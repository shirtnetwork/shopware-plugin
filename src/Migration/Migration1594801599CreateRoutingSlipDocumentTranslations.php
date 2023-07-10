<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;

class Migration1594801599CreateRoutingSlipDocumentTranslations extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1594801599;
    }

    public function update(Connection $connection): void
    {
        $documentId = $this->getDocumentId($connection);
        $deLanguageId = $this->getLanguageId($connection, 'de-DE');
        $existsQuery = 'SELECT 1 FROM document_type_translation WHERE document_type_id = :document_type_id AND language_id = :language_id';

        $exists = $connection->fetchOne($existsQuery, ['document_type_id' => $documentId, 'language_id' => $deLanguageId]);
        if (!$exists) {
            $connection->insert('document_type_translation', ['document_type_id' => $documentId, 'language_id' => $deLanguageId, 'name' => 'Laufzettel', 'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)]);
        }

        $enLanguageId = $this->getLanguageId($connection, 'en-GB');
        $exists = $connection->fetchOne($existsQuery, ['document_type_id' => $documentId, 'language_id' => $enLanguageId]);
        if (!$exists) {
            $connection->insert('document_type_translation', ['document_type_id' => $documentId, 'language_id' => $enLanguageId, 'name' => 'Routing Slip', 'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)]);
        }
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }

    private function getLanguageId(Connection $connection, string $code): string
    {
        $sql = <<<SQL
            SELECT id
            FROM `language`
            WHERE translation_code_id = (
               SELECT id
               FROM locale
               WHERE locale.code = :code
            )
            ORDER BY created_at ASC
SQL;

        return (string) $connection->executeQuery($sql, ['code' => $code])->fetchOne();
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
}
