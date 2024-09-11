<?php
declare(strict_types=1);

namespace App\Config;

class AppConfig
{
    private array $config = [];

    public function getConfigValue(string $key, $default = null)
    {
        return array_key_exists($key, $this->config) ? $this->config[$key] : $default;
    }

    public function setConfigValue(string $key, $value): void
    {
        $this->config[$key] = $value;
    }

}