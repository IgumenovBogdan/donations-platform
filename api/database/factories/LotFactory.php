<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lot>
 */
class LotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $price = rand(1000, 30000);

        return [
            'name' => fake()->text(20),
            'description' => fake()->text(),
            'price' => $price,
            'total_collected' => round(((0.01 * rand(1, 50)) * $price)),
            'organization_id' => Organization::factory()->create()->id
        ];
    }
}
