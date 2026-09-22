<?php

namespace Database\Factories;

use App\Models\Courier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Courier>
 */
class CourierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                 => fake()->name(),
            'email'                => fake()->unique()->safeEmail(),
            'phone'                => fake()->phoneNumber(),
            'level'                => fake()->numberBetween(1, 5),
            'vehicle_type'         => fake()->randomElement(['motor', 'mobil', 'sepeda']),
            'vehicle_plate_number' => fake()->bothify('B #### ??'),
            'license_number'       => fake()->bothify('SIM-#######'),
            'address'              => fake()->address(),
            'status'               => 'active',
            'joined_at'            => fake()->dateTimeBetween('-2 years', 'now'),
        ];
    }
}
