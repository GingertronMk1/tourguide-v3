<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ActivityLog;

class ActivityLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ActivityLog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'event_type' => $this->faker->word,
            'old_data' => '{}',
            'new_data' => '{}',
        ];
    }
}
