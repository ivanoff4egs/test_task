<?php

namespace App\Config;

class ConfigFactory
{
    public static function createAppConfig(): AppConfig
    {
        return AppConfig::getInstance();
    }
}