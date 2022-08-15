<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Lot;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class DonationsRepository
{
    public function getAllLotHistory(Lot $lot): LengthAwarePaginator
    {
        return $lot->contributors()->orderBy('contributor_lot.created_at', 'desc')->paginate(10);
    }

    public function getAllOrganizationTotalHistoryByPeriod(Request $request): array
    {
        $organization = $request->user()->organization;

        $report = [];

        foreach ($organization->lots as $lot) {
            foreach ($lot->contributors as $contributor) {
                $report[$contributor->user->email] = $this->getContributorTotalDonationsHistory($contributor);
            }
        }

        return $report;
    }

    public function getAllContributorHistory(User $user): LengthAwarePaginator
    {
        return $user->contributor->lots()->orderBy('contributor_lot.created_at', 'desc')->paginate(10);
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
