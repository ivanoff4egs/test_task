<?php

namespace App\Config;

class AppConfigFactory
{
    public static function createAppConfig(): AppConfig
    {
        return new AppConfig();
    }
}