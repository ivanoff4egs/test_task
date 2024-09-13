<?php

namespace Tests\Unit;

use App\Config;
use App\Exceptions\AppException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Config::class)]
class ConfigTest extends TestCase
{
    private Config $config;

    public static function getDataProvider()
    {
        return [
            [require "test_config.php"],
            [[]]
        ];
    }

    #[dataProvider('getDataProvider')]
    public function testGet($configData): void
    {
        if (empty($configData)) {
            $this->expectException(AppException::class);
        }

        $this->config = new Config($configData);
        $comission = $this->config->get('eu_cards_comission');
        $this->assertEquals(0.01, $comission);
    }

    protected function tearDown(): void
    {
        unset($this->config);
    }
}
