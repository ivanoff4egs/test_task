<?php
declare(strict_types=1);

namespace App\Config;

class AppConfigFactory
{
    public static function createAppConfig(): AppConfig
    {
        return new AppConfig();
    }
}