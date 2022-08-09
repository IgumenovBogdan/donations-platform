<?php

declare(strict_types=1);

namespace App\Services;

use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeService
{
    public const STRIPE_PRICE_FACTOR = 100;

    public function __construct(
        private readonly StripeClient $stripe,
        private readonly string $secretKey
    )
    {
        Stripe::setApiKey($this->secretKey);
    }

    public function createCustomerByCard(
        string $email,
        string $number,
        string $expMonth,
        int $expYear,
        string $cvc
    ): string {
        $tokenId = $this->createCardToken($number, $expMonth, $expYear, $cvc);
        try {
            $customer = $this->stripe->customers->create([
                'email' => $email,
                'source' => $tokenId
            ]);
        } catch (ApiErrorException $e) {
            throw new \DomainException($e->getMessage());
        }
        if (!$customer) {
            throw new \DomainException('Problem with customer data');
        }
        return $customer->id;
    }

    private function createCardToken(string $number, string $expMonth, int $expYear, string $cvc): string
    {
        try {
            $token = $this->stripe->tokens->create([
                'card[number]'  => $number,
                'card[exp_month]' => $expMonth,
                'card[exp_year]' => $expYear,
                'card[cvc]' => $cvc
            ]);
        } catch (ApiErrorException $e) {
            throw new \DomainException($e->getMessage());
        }

        if (!$token) {
            throw new \DomainException('Problem with payment method.');
        }
        return $token->id;
    }

    /**
     * @throws ApiErrorException
     */
    public function getCustomer(string $stripeId): \Stripe\Customer
    {
        return $this->stripe->customers->retrieve($stripeId);
    }

    /**
     * @throws ApiErrorException
     */
    public function createCharge(
        string $customerId,
        float $price,
        bool $capture = true,
        ?string $currency = null
    ): string {
        $customer = $this->getCustomer($customerId);
        try {
            $charge = $this->stripe->charges->create([
                'customer' => $customer->id,
                'amount'   => $price * self::STRIPE_PRICE_FACTOR,
                'currency' => $currency ?: 'usd',
                'capture' => $capture
            ]);
        } catch (ApiErrorException $e) {
            throw new \DomainException($e->getMessage());
        }

        if (!$charge) {
            throw new \DomainException(
                'Payment was not successful. Problem with charge. Maybe your credit card doesn\'t fit'
            );
        }
        return $charge->id;
    }
}
