<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class PaypalService
{
    private Client $client;
    private string $secret;
    private string $clientId;
    private string $redirectUrl;
    private string $token;

    public function __construct(
        Client $client,
        string $secret,
        string $clientId,
        string $redirectUrl
    ) {
        $this->client = $client;
        $this->secret = $secret;
        $this->clientId = $clientId;
        $this->token = $this->getToken();
        $this->redirectUrl = $redirectUrl;
    }

    public function createPayment(
        float $price,
        ?string $currency = null
    )
    {
        $response = $this->client->request('POST', 'https://api-m.sandbox.paypal.com/v2/checkout/orders', [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . $this->token
            ],
            'json' => [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'value' => $price,
                            'currency_code' => $currency ?: 'USD'
                        ]
                    ]
                ]
            ]
        ]);

        return json_decode((string) $response->getBody());
    }

    public function capturePayment(string $id)
    {
        $response = $this->client->request('POST', 'https://api-m.sandbox.paypal.com/v2/checkout/orders/' . $id . '/capture', [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . $this->token
            ]
        ]);
        return json_decode((string) $response->getBody());
    }

    public function getRegisterCustomerLinks(): array
    {
        $response = $this->client->request('POST', 'https://api-m.sandbox.paypal.com/v2/customer/partner-referrals', [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . $this->token
            ],
            'json' => [
                'tracking_id' => Str::random(15),
                'partner_config_override' => [
                    'return_url' => $this->redirectUrl,
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
                $this->clientId,
                $this->secret
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        return json_decode((string) $response->getBody(), true)['access_token'];
    }
}
