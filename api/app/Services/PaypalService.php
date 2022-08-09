<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class PaypalService
{
    private string $token;

    public function __construct(
        private readonly string $secret,
        private readonly string $clientId,
        private readonly string $redirectUrl,
        private readonly GuzzleHttpService $guzzleHttpService
    ) {
        $this->token = $this->getToken();
    }

    public function createPayment(
        float $price,
        ?string $currency = null
    ): array {
        try {
            $headers = [
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . $this->token
            ];
            $data = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'value' => $price,
                            'currency_code' => $currency ?: 'USD'
                        ]
                    ]
                ]
            ];
            return $this->guzzleHttpService->request(
                'POST',
                'https://api-m.sandbox.paypal.com/v2/checkout/orders',
                $headers,
                $data
            );
        } catch (\Throwable $e) {
            throw new \DomainException($e->getMessage());
        }
    }

    public function capturePayment(string $id): array
    {
        try {
            $data = [
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer " . $this->token
                ]
            ];
            return $this->guzzleHttpService->fetch('POST', 'https://api-m.sandbox.paypal.com/v2/checkout/orders/' . $id . '/capture', $data);
        } catch (\Throwable $e) {
            throw new \DomainException($e->getMessage());
        }
    }

    public function getRegisterCustomerLinks(): array
    {
        try {
            $headers = [
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . $this->token
            ];
            $data = [
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
            ];
            return $this->guzzleHttpService->request(
                'POST',
                'https://api-m.sandbox.paypal.com/v2/customer/partner-referrals',
                $headers,
                $data
            )['links'];
        } catch (\Throwable $e) {
            throw new \DomainException($e->getMessage());
        }
    }

    private function getToken(): string
    {
        try {
            $data = [
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
            ];
            $response = $this->guzzleHttpService->fetch('POST', 'https://api-m.sandbox.paypal.com/v1/oauth2/token', $data);
        } catch (\Throwable $e) {
            throw new \DomainException($e->getMessage());
        }

        return $response['access_token'];
    }
}
