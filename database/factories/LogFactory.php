<?php

namespace Database\Factories;

use App\Models\Log;
use App\Enums\ActivityType;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition()
    {
        return [
            'activity_type' => $this->faker->randomElement(ActivityType::cases()),
            'description' => $this->faker->sentence,
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
