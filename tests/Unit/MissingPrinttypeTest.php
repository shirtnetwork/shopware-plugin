<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Tests\Unit;

use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ApiClient;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\ConfigHelper;
use Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork\PriceCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Shopware\Core\System\SystemConfig\SystemConfigService;

final class MissingPrinttypeTest extends TestCase
{
    #[DataProvider('priceCases')]
    public function testPricesKeepBaseChargesAndOnlyApplyAvailablePrinttypeCharges(string $state, string $mode, float $expected): void
    {
        $object = $this->createObject($state);
        if ($mode === 'upload') {
            $object->type = 'user-logo';
        }
        $config = (object) ['product' => 1, 'variant' => 2, 'objects' => [$object], 'options' => (object) ['correctionView' => false, 'typeSample' => false]];
        $product = (object) [
            'price' => 20, 'fixPrice' => false, 'usePixelPrice' => $mode === 'pixel',
            'uploadPrice' => 6, 'textBlockPrice' => 2, 'textPriceMode' => 'PER_LINE', 'textPrice' => 3,
            'minTextPrice' => 0, 'maxTextPrice' => 0,
        ];
        $client = $this->createMock(ApiClient::class);
        $client->method('getConfig')->willReturn($config);
        $client->method('getProductById')->willReturn($product);
        $client->method('getProductPriceScales')->willReturn([]);
        $client->method('getVariantById')->willReturn((object) ['price' => 2]);
        $client->method('getViewsByVariantId')->willReturn([$this->createView()]);

        $hasId = in_array($state, ['valid', 'deleted'], true);
        $client->expects($state === 'valid' || ($hasId && $mode !== 'text') ? self::atLeastOnce() : self::never())
            ->method('getPrinttypeById')->with('channel', 7)
            ->willReturn($state === 'valid' ? (object) ['uploadPrice' => 5, 'uploadSpecialPrice' => 8, 'pixelPrice' => 0.5, 'pixelPriceScale' => ''] : null);
        $client->expects($hasId ? self::exactly(2) : self::never())
            ->method('getPrinttypeColors')->with('channel', 7)
            ->willReturn($state === 'valid' ? (object) ['source' => [(object) ['id' => 9, 'price' => 1.5, 'printtype' => 7]]] : null);

        $calculator = new PriceCalculator($client, $this->createHelper($client));
        self::assertEqualsWithDelta($expected, $calculator->getPrice('channel', 'config', 2), 0.00001);
    }

    public static function priceCases(): iterable
    {
        foreach (['missing', 'null', 'without id', 'null id', 'deleted', 'valid'] as $state) {
            yield $state . ' text' => [$state, 'text', $state === 'valid' ? 32.5 : 31.0];
            yield $state . ' upload' => [$state, 'upload', $state === 'valid' ? 42.5 : 32.0];
            yield $state . ' pixel' => [$state, 'pixel', $state === 'valid' ? 30.5 : 26.0];
        }
    }

    #[DataProvider('infoCases')]
    public function testConfigInfoPreservesObjectsWhenPrinttypeIsAbsent(string $state, string $expected): void
    {
        $object = $this->createObject($state);
        $client = $this->createMock(ApiClient::class);
        $client->method('getConfig')->willReturn((object) [
            'objects' => [$object], 'views' => [(object) ['key' => 'front']],
            'options' => (object) [], 'product' => 1, 'variant' => 2, 'supplier' => 3, 'user' => 4,
        ]);
        $client->method('getViewById')->willReturn($this->createView());
        $client->method('getConfigServerUrl')->willReturn('https://example.test');

        $helper = $this->createHelper($client);
        $infos = $helper->getShirtnetworkInfos('channel', 'config', false);
        self::assertCount(1, $infos['objects']);
        self::assertCount(1, $infos['views']);
        self::assertSame($expected, $infos['objects'][0]['printtype']);
        self::assertSame('Hello', $infos['objects'][0]['text']);
        self::assertEquals(2, $infos['objects'][0]['dimensions']['width']);
        self::assertEquals(3, $infos['objects'][0]['dimensions']['height']);
    }

    public static function infoCases(): iterable
    {
        foreach (['missing', 'null', 'without id', 'null id', 'deleted', 'valid'] as $state) {
            yield $state => [$state, $state === 'valid' ? 'Flex' : ''];
        }
    }

    public function testNameOfDeletedPrinttypeIsEmpty(): void
    {
        $client = $this->createMock(ApiClient::class);
        $client->expects(self::once())->method('getPrinttypeById')->with('channel', 7)->willReturn(null);
        self::assertSame('', $this->createHelper($client)->getPrinttypeName('channel', 7));
    }

    public function testMissingPrinttypeNameDoesNotRequestTheApi(): void
    {
        $client = $this->createMock(ApiClient::class);
        $client->expects(self::never())->method('getPrinttypeById');
        self::assertSame('', $this->createHelper($client)->getPrinttypeName('channel', null));
    }

    public function testExistingPrinttypeNameIsPreserved(): void
    {
        $client = $this->createMock(ApiClient::class);
        $client->expects(self::once())->method('getPrinttypeById')->with('channel', 7)->willReturn((object) ['name' => 'Flex']);
        self::assertSame('Flex', $this->createHelper($client)->getPrinttypeName('channel', 7));
    }

    private function createHelper(ApiClient $client): ConfigHelper
    {
        $config = $this->createMock(SystemConfigService::class);
        $config->method('get')->with('ShirtnetworkPlugin.config.showrealsizes', 'channel')->willReturn(true);
        return new ConfigHelper($client, $config);
    }

    private function createObject(string $state): \stdClass
    {
        $object = (object) [
            'type' => 'text',
            'meta' => (object) ['view' => (object) ['id' => 10, 'key' => 'front'], 'fills' => [(object) ['id' => 9]]],
            'options' => (object) ['width' => 20, 'height' => 30, 'scaleX' => 1, 'scaleY' => 1, 'text' => 'Hello', 'fontFamily' => 'Arial'],
        ];
        if ($state !== 'missing') {
            $object->meta->printtype = $state === 'null' ? null : (object) [];
            if ($state === 'null id') {
                $object->meta->printtype->id = null;
            } elseif (in_array($state, ['valid', 'deleted'], true)) {
                $object->meta->printtype->id = 7;
            }
            if ($state === 'valid') {
                $object->meta->printtype->name = 'Flex';
            }
        }
        return $object;
    }

    private function createView(): \stdClass
    {
        return (object) ['id' => 10, 'price' => 4, 'width' => 100, 'height' => 100, 'realWidth' => 10, 'realHeight' => 10];
    }
}
