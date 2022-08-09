<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;

class GuzzleHttpService
{
    public function __construct(
        private readonly Client $client
    ) {}

    public function fetch(string $method, string $url, array $data): array
    {
        try {
            $response = $this->client->request($method, $url, $data);
            $data = json_decode((string)$response->getBody(), true);
        } catch (\Throwable $e) {
            throw new \DomainException('Data fetching problems.');
        }
        return $data;
    }

    public function request(string $method, string $url, array $headers, array $data): array
    {
        try {
            $response = $this->client->request($method, $url, [
                'headers' => $headers,
                'json' => $data,
            ]);
            if (!in_array($response->getStatusCode(), [200, 201])) {
                throw new \DomainException('Something gone wrong');
            }
            $data = json_decode((string)$response->getBody(), true);
        } catch (ConnectException $e) {
            throw new \DomainException('Connection Exception');
        } catch (BadResponseException $e) {
            $response = json_decode((string)($e->getResponse() ? $e->getResponse()->getBody() : '[]'));
            throw new \DomainException($response->title ?? ($e->getResponse()->getReasonPhrase() ?? $e->getMessage()));
        } catch (\Throwable $e) {
            throw new \DomainException($e->getMessage());
        }
        return $data;
    }
}
