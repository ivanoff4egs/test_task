<?php
declare(strict_types=1);

namespace App;

class AppConfig
{
    public function __construct(array $runtimeValues = [])
    {
        $this->config = array_merge($this->config, $runtimeValues);
    }

    private array $config = [];

    public function getConfigValue(string $key, $default = null)
    {
        return array_key_exists($key, $this->config) ? $this->config[$key] : $default;
    }
}