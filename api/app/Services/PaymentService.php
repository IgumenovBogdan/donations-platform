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
        $contributor = Contributor::find(auth()->user()->contributor->id);

        $lot->total_collected += $request->amount;
        $lot->save();

        if($contributor->lots()->get()->where('id', $id)->count() == 0) {
            $lot->contributors()->attach($contributor->id);
        }

        $contributor->lots()->updateExistingPivot($id, [
            'total_sent' => $contributor->lots()->where('lot_id', $id)->first()->pivot->total_sent + $request->amount
        ]);

        return ['message' => 'Payment success!'];
    }
}
