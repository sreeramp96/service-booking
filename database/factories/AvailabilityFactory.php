<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Availability>
 */
class AvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('en_US');
        $startTime = $faker->dateTimeBetween('8:00', '15:00');
        $endTime = clone $startTime;
        $endTime->modify('+1 hour');

        return [
            'service_id' => Service::factory(),
            'date' => $faker->dateTimeBetween('+1 days', '+10 days')->format('Y-m-d'),
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
        ];
    }
}
