<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DonateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 500; $i++) {
            DB::table('contributor_organization')->insert([
                'contributor_id' => rand(1, 50),
                'organization_id' => rand(1, 10),
                'sent' => rand(1, 20),
                'payed_at' => Carbon::today()->subDays(rand(0, 600))
            ]);
        }
    }
}
