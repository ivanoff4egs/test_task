<?php

namespace App\Config;

class AppConfig
{
    private array $configArray;

    protected function __construct() { }

    protected function __clone() { }

    private static AppConfig|null $instance = null;

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;

    }

    public function getConfigValue(string $key, $default = null)
    {
        return array_key_exists($key, $this->configArray) ? $this->configArray[$key] : $default;
    }

    public function setConfigValue(string $key, $value)
    {
        $this->configArray[$key] = $value;
    }

}