<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Lot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function getLastWeekContributorsDonates(Request $request): Collection|array
    {
        return DB::table('contributor_organization')
            ->join('contributors', 'contributor_organization.contributor_id', '=', 'contributors.id')
            ->select(DB::raw('SUM(sent) as total_sent, contributors.first_name, contributors.last_name'))
            ->where('organization_id', $request->user()->organization->id)
            ->whereDate('payed_at', '>', Carbon::now()->subWeek())
            ->groupBy('contributors.first_name', 'contributors.last_name')
            ->orderBy('total_sent', 'desc')
            ->get();

//        $id = $request->user()->organization->id;
//        $carbon = Carbon::now()->subWeek();
//
//        return collect(
//            DB::select("SELECT SUM(sent) AS total_sent, contributors.first_name, contributors.last_name
//                           FROM contributor_organization
//                           INNER JOIN contributors ON contributor_organization.contributor_id = contributors.id
//                           WHERE organization_id = $id AND payed_at::DATE > '$carbon' GROUP BY contributors.last_name, contributors.first_name
//                           ORDER BY total_sent DESC")
//        );
    }

    public function getLastWeekContributorsTransactions(Request $request): array
    {

        $transactions = [];

        $contributors = DB::table('contributor_organization')
            ->join('contributors', 'contributor_organization.contributor_id', '=', 'contributors.id')
            ->where('organization_id', $request->user()->organization->id)
            ->whereDate('payed_at', '>', Carbon::now()->subWeek())
            ->select('contributors.first_name', 'contributors.last_name', 'sent', 'contributors.id', 'payed_at')
            ->get();


//        $id = $request->user()->organization->id;
//        $carbon = Carbon::now()->subWeek();
//        $contributors = collect(
//            DB::select("SELECT contributors.first_name, contributors.last_name, sent, contributors.id
//                                          FROM contributor_organization
//                                          INNER JOIN contributors ON contributor_organization.contributor_id = contributors.id
//                                          WHERE organization_id = $id AND payed_at::DATE > '$carbon'")
//        );

        foreach ($contributors as $contributor) {
            $transactions[$contributor->id]['transactions'][] = [
                'payed_at' => Carbon::createFromFormat('Y-m-d H:i:s', $contributor->payed_at)->toDateString(),
                'sent' => $contributor->sent,
            ];
            $transactions[$contributor->id]['user'] = $contributor->first_name . ' ' . $contributor->last_name;
        }

        return array_values($transactions);
    }

    public function getTopContributorsForTheYear(Request $request): array
    {
        $result = [];
        $organizationId = $request->user()->id;
        $carbon = Carbon::now()->subYear();
        $contributors = array_unique($request->user()->organization->contributors->pluck('id')->toArray());

        foreach ($contributors as $key => $id) {
            $query = collect(DB::select("SELECT DATE_TRUNC('month', payed_at) as payed_to_month, SUM(sent) as total_sent, AVG(sent) as avg_sent, contributors.first_name, contributors.last_name
                                               FROM contributor_organization
                                               INNER JOIN contributors ON contributor_organization.contributor_id = contributors.id
                                               WHERE organization_id = $organizationId
                                               AND payed_at::DATE > '$carbon'
                                               AND contributor_id = $id
                                               GROUP BY DATE_TRUNC('month',payed_at), contributors.first_name, contributors.last_name
                                               HAVING SUM(sent) >= 5"));

            if ($query->count() === 12) {
                $result[$key]['contributor'] = $query[0]->first_name . ' ' . $query[0]->last_name;

                foreach ($query as $month) {
                    $result[$key]['months'][] = [
                        'month' => $month->payed_to_month,
                        'total_sent' => $month->total_sent,
                        'avg_sent' => (int)$month->avg_sent
                    ];
                }
            }
        }

        return $result;

    }

    public function getAllContributorHistory(User $user): LengthAwarePaginator
    {
        return $user->contributor->lots()->orderBy('contributor_lot.payed_at', 'desc')->with('organization')->paginate(10);
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

    public function getLastMonthDonates(Request $request): Collection
    {
        return DB::table('contributor_organization')
            ->join('organizations', 'contributor_organization.organization_id', '=', 'organizations.id')
            ->where('contributor_id', $request->user()->contributor->id)
            ->where('sent', '>', 5)
            ->whereDate('payed_at', '>', Carbon::now()->subMonth())
            ->select('sent', 'organizations.name as company', 'payed_at')
            ->orderBy('sent', 'asc')
            ->get();

//        $id = $request->user()->contributor->id;
//        $carbon = Carbon::now()->subMonth();
//
//        return collect(
//            DB::select("SELECT sent, payed_at, organizations.name
//                                 FROM contributor_organization
//                                 INNER JOIN organizations ON contributor_organization.organization_id = organizations.id
//                                 WHERE contributor_id = '$id'
//                                 AND sent > 5
//                                 AND payed_at::DATE > '$carbon'
//                                 ORDER BY sent ASC")
//        );
    }

    public function getAveragePerMonth(Request $request): float|string
    {
        $average = DB::table('contributor_organization')
            ->where('contributor_id', $request->user()->contributor->id)
            ->whereDate('payed_at', '>', Carbon::now()->subMonth())
            ->avg('sent');

        return round((float)$average, 2);

//        $id = $request->user()->contributor->id;
//        $carbon = Carbon::now()->subMonth();
//        $average = DB::select("SELECT AVG(sent)
//                                     FROM contributor_organization
//                                     WHERE contributor_id = $id
//                                     AND payed_at::DATE > '$carbon'");
//
//        if (!$average) {
//            return 'You haven\'t donated in the last month';
//        }
//
//        return $average[0]->avg;
    }

    public function getTheMostImportantCompanies(Request $request): string|Collection
    {
        $organizations = DB::table('contributor_organization')
            ->join('organizations', 'contributor_organization.organization_id', '=', 'organizations.id')
            ->select(DB::raw('SUM(sent) as total_sent, organizations.name'))
            ->where('contributor_id', $request->user()->contributor->id)
            ->whereDate('payed_at', '>', Carbon::now()->subYear())
            ->groupBy('organizations.name')
            ->havingRaw('SUM(sent) > ?', [100])
            ->get();

//        $id = $request->user()->contributor->id;
//        $carbon = Carbon::now()->subYear();
//        $organizations = collect(
//            DB::select("SELECT SUM(sent) as total_sent, organizations.name
//                              FROM contributor_organization
//                              INNER JOIN organizations ON contributor_organization.organization_id = organizations.id
//                              WHERE contributor_id = $id
//                              AND payed_at > '$carbon'
//                              GROUP BY organizations.name
//                              HAVING SUM(sent) > 100")
//        );

        return $organizations;
    }
}
