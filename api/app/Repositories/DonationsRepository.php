<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Lot;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class DonationsRepository
{
    public function getAllContributorHistory(User $user): LengthAwarePaginator
    {
        return $user->contributor->lots()->orderBy('contributor_lot.created_at', 'desc')->paginate(10);
    }

    public function getAllLotHistory(string $id): LengthAwarePaginator
    {
        $lot = Lot::findOrFail($id);
        return $lot->contributors()->orderBy('contributor_lot.created_at', 'desc')->paginate(10);
    }

    public function getTotalDonationsHistory(object $contributor): array
    {
        $report = [];
        $lastId = 0;
        foreach ($contributor->lots as $lot) {
            if ($lot->id == $lastId) {
                $report[$lot->id]['total_sent'] += $lot->pivot->total_sent;
            } else {
                $report[$lot->id] = [
                    'lot' => $lot->name,
                    'organization' => $lot->organization->name,
                    'total_sent' => $lot->pivot->total_sent,
                    'status' => $lot->is_completed ? 'Completed' : 'Not completed'
                ];
            }
            $lastId = $lot->id;
        }

        return $report;
    }
}
