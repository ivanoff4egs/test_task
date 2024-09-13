<?php

namespace Tests\Unit;

use App\Config;
use App\Exceptions\AppException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Config::class)]
class ConfigTest extends TestCase
{
    private Config $config;

    /**
     * @throws AppException
     */
    public function testGet(): void
    {
        $configData = require 'test_config.php';
        $this->config = new Config($configData);
        $comission = $this->config->get('eu_cards_comission');

        $this->assertEquals(0.01, $comission);
    }

    protected function tearDown(): void
    {
        unset($this->config);
    }
}
