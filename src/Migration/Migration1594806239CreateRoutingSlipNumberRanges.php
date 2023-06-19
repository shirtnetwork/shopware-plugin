<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;

class Migration1594806239CreateRoutingSlipNumberRanges extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1594806239;
    }

    public function update(Connection $connection): void
    {
        $exists = $connection->fetchOne('SELECT 1 FROM number_range_type WHERE technical_name = :technical_name', ['technical_name' => 'document_routing_slip']);
        if ($exists !== false) {
            return;
        }

        // number ranges
        $definitionNumberRangeTypes = [
            'document_routing_slip' => [
                'id' => Uuid::randomHex(),
                'global' => 0,
                'nameDe' => 'Laufzettel',
                'nameEn' => 'Routing Slip',
            ]
        ];

        $definitionNumberRanges = [
            'document_routing_slip' => [
                'id' => Uuid::randomHex(),
                'name' => 'Routing Slips',
                'nameDe' => 'Laufzettel',
                'global' => 1,
                'typeId' => $definitionNumberRangeTypes['document_routing_slip']['id'],
                'pattern' => '{n}',
                'start' => 1000,
            ]
        ];

        $languageEn = $this->getLanguageId($connection, 'en-GB');
        $languageDe = $this->getLanguageId($connection, 'de-DE');

        foreach ($definitionNumberRangeTypes as $typeName => $numberRangeType) {
            $connection->insert(
                'number_range_type',
                [
                    'id' => Uuid::fromHexToBytes($numberRangeType['id']),
                    'global' => $numberRangeType['global'],
                    'technical_name' => $typeName,
                    'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
                ]
            );
            $connection->insert(
                'number_range_type_translation',
                [
                    'number_range_type_id' => Uuid::fromHexToBytes($numberRangeType['id']),
                    'type_name' => $numberRangeType['nameEn'],
                    'language_id' => $languageEn,
                    'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
                ]
            );
            $connection->insert(
                'number_range_type_translation',
                [
                    'number_range_type_id' => Uuid::fromHexToBytes($numberRangeType['id']),
                    'type_name' => $numberRangeType['nameDe'],
                    'language_id' => $languageDe,
                    'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
                ]
            );
        }

        foreach ($definitionNumberRanges as $numberRange) {
            $connection->insert(
                'number_range',
                [
                    'id' => Uuid::fromHexToBytes($numberRange['id']),
                    'global' => $numberRange['global'],
                    'type_id' => Uuid::fromHexToBytes($numberRange['typeId']),
                    'pattern' => $numberRange['pattern'],
                    'start' => $numberRange['start'],
                    'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
                ]
            );
            $connection->insert(
                'number_range_translation',
                [
                    'number_range_id' => Uuid::fromHexToBytes($numberRange['id']),
                    'name' => $numberRange['name'],
                    'language_id' => $languageEn,
                    'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
                ]
            );
            $connection->insert(
                'number_range_translation',
                [
                    'number_range_id' => Uuid::fromHexToBytes($numberRange['id']),
                    'name' => $numberRange['nameDe'],
                    'language_id' => $languageDe,
                    'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
                ]
            );
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
}
