<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Contributor;
use App\Models\Lot;

class PaymentService
{
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
