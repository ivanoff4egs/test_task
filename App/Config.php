<?php declare(strict_types=1);

namespace App;

use App\Exceptions\AppException;

class Config
{
    public const string CONFIG_FILE = 'config.php';

    public function __construct(private array $configData)
    {}

    /**
     * @throws AppException
     */
    public function get(string $key)
    {
        if (!array_key_exists($key, $this->configData)) {
            throw new AppException("Config key '{$key}' not exists\n");
        }

        return $this->configData[$key];
    }


}