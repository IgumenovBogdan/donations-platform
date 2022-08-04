<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class PaypalService
{
    private Client $client;
    private string $token;

    public function __construct()
    {
        $this->client = new Client();
        $this->token = $this->getToken();
    }

    public function getRegisterCustomerLinks(string $uri): array
    {
        $response = $this->client->request('POST', $uri, [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . $this->token
            ],
            'json' => [
                'tracking_id' => Str::random(15),
                'partner_config_override' => [
                    'return_url' => 'http://localhost:85/'
                ],
                'operations' => [
                    [
                        'operation' => 'API_INTEGRATION',
                        'api_integration_preference' => [
                            'rest_api_integration' => [
                                'integration_method' => 'PAYPAL',
                                'integration_type' => 'THIRD_PARTY',
                                'third_party_details' => [
                                    'features' => [
                                        'PAYMENT',
                                        'REFUND'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'products' => [
                    'EXPRESS_CHECKOUT'
                ],
                'legal_consents' => [
                    [
                        'type' => 'SHARE_DATA_CONSENT',
                        'granted' => true
                    ]
                ]
            ],
        ]);

        return json_decode((string)$response->getBody(), true)['links'];
    }

    public function getSelfLinkData(string $uri)
    {
        $response = $this->client->request('GET', $uri, [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . $this->token
            ],
        ]);

        return json_decode((string) $response->getBody());
    }

    private function getToken(): string
    {
        $response = $this->client->request('POST', 'https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US'
            ],
            'auth' => [
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_SECRET')
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        return json_decode((string) $response->getBody(), true)['access_token'];
    }
}
