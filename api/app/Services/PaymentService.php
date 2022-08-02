<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Contributor;
use App\Models\Lot;
use Stripe\StripeClient;

class PaymentService
{
    public function stripeTest()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));


        $account = 'acct_1LSGpj2HvraPijZr';

//        $response = $stripe->accounts->create([
//            'type' => 'custom',
//            'capabilities' => [
//                'card_payments' => ['requested' => true],
//                'transfers' => ['requested' => true],
//            ],
//            'business_type' => 'company',
//
//        ]);
//
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $transfer = \Stripe\Transfer::create([
            "amount" => 1000,
            "currency" => "brl",
            "destination" => $account,
        ]);
        dd($transfer);
    }

    public function donate($request, $id): array
    {
        $lot = Lot::findOrFail($id);
        $contributor = Contributor::findOrFail(auth()->user()->contributor->id);

        $lot->total_collected += $request->amount;
        $lot->save();

        $lot->contributors()->attach($contributor->id, [
            'total_sent' => $request->amount
        ]);

        return ['message' => 'Payment success!'];
    }
}
