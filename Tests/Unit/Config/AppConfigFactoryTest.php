<?php

namespace Tests\Unit\Config;

use App\Config\AppConfig;
use App\Config\AppConfigFactory;
use PHPUnit\Framework\TestCase;

class AppConfigFactoryTest extends TestCase
{
    public function testCreateAppConfig()
    {
        $config = AppConfigFactory::createAppConfig();

        $this->assertInstanceOf(AppConfig::class, $config);
    }
}
