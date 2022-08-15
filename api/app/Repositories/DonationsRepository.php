<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Lot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DonationsRepository
{
    public function getAllLotHistory(Lot $lot): LengthAwarePaginator
    {
        return $lot->contributors()->orderBy('contributor_lot.payed_at', 'desc')->paginate(10);
    }

    public function getAllOrganizationTotalHistoryByPeriod(Request $request): array
    {
        $lots = Lot::where('organization_id', $request->user()->organization->id)->with('contributors.lots.organization', 'contributors.user')->get();

        $report = [];

        foreach ($lots as $lot) {
            foreach ($lot->contributors as $contributor) {
                $report[$contributor->user->email] = $this->getContributorTotalDonationsHistory($contributor);
            }
        }

        return $report;
    }

    public function getAllContributorHistory(User $user): LengthAwarePaginator
    {
        return $user->contributor->lots()->orderBy('contributor_lot.payed_at', 'desc')->paginate(10);
    }

    public function getContributorTotalDonationsHistory(object $contributor): array
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
