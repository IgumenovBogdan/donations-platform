<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Contributor;
use App\Models\Lot;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ContributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lots = Lot::factory()->count(25)->create();

        $organizations = Organization::all();

        Contributor::factory()
            ->count(200)
            ->hasAttached($organizations->slice(rand(1, 24)), function () {
                return [
                    'sent' => rand(1, 30),
                    'payed_at' => Carbon::today()->subDays(rand(0, 365))
                ];
            })
            ->hasAttached($lots->slice(rand(1, 24)), function () {
                return [
                    'total_sent' => rand(1, 30),
                    'payed_at' => Carbon::today()->subDays(rand(0, 100))
                ];
            })
            ->create();
    }
}
