<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Contributor;
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
        $organizations = Organization::factory()->count(10)->create();

        Contributor::factory()
            ->count(50)
            ->hasAttached($organizations, function () {
                return [
                    'sent' => rand(1, 30),
                    'payed_at' => Carbon::today()->subDays(rand(0, 365))
                ];
            })
            ->create();
    }
}
