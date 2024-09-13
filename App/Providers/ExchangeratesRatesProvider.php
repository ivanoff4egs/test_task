<?php declare(strict_types = 1);

namespace App\Providers;

use App\Exceptions\AppException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ExchangeratesRatesProvider implements ProviderInterface
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
        try {
            $response = $this->client->request(
                method: $this->config['method'],
                uri: $this->config['base_uri'],
                options: ['query' => ['access_key' => $this->config['access_key']]]
            );
        } catch (GuzzleException $e) {
            throw new AppException($e->getMessage());
        }

        $data = $response->getBody()->getContents();
        if (!json_validate($data)) {
            throw new AppException(json_last_error_msg());
        }

        $data = json_decode($data, true);

        if (isset($data['error'])) {
            throw new AppException($data['error']['info']);
        }

        return $data;
    }
}
