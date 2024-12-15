<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tracking_number' => bin2hex(random_bytes(16)),
            'status' => $this->faker->randomElement(['new', 'in-transit', 'delivered', 'delayed']),
            'cost' => $this->faker->randomFloat(2, 5, 500),
        ];
    }
}
