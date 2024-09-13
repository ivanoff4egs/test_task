<?php

namespace App\Providers;

use App\Exceptions\AppException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class BinlistCardInfoProvider implements ProviderInterface
{
    public function __construct(
        protected Client $client,
        protected array $config
    ) {}

    /**
     * @throws AppException
     */
    public function retrieveData(string $path = ''): array
    {
        $url = $this->config['base_uri'] . '/' . $path;
        try {
            $response = $this->client->request($this->config['method'], $url);
        } catch (GuzzleException $e) {
            throw new AppException($e->getMessage());
        }

        $data = $response->getBody()->getContents();
        if (!json_validate($data)) {
            throw new AppException(json_last_error_msg());
        }

        return json_decode($data, true);
    }

    public function getFieldsMap(): array
    {
        return $this->config['fields_map'];
    }
}