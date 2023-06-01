<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Venue;

class VenueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venue::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'notes' => $this->faker->text,
            'street_address' => $this->faker->text,
            'city' => $this->faker->city,
            'maximum_stage_width' => $this->faker->randomNumber(),
            'maximum_stage_depth' => $this->faker->randomNumber(),
            'maximum_stage_height' => $this->faker->randomNumber(),
            'maximum_seats' => $this->faker->randomNumber(),
            'maximum_wheelchair_seats' => $this->faker->randomNumber(),
            'number_of_dressing_rooms' => $this->faker->randomNumber(),
            'backstage_wheelchair_access' => $this->faker->boolean,
        ];
    }
}
