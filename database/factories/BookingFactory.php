<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Service;
use App\Models\Availability;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $service = Service::factory()->create();
        $availability = Availability::factory()->create(['service_id' => $service->id]);

        return [
            'user_id' => $customer->id,
            'service_id' => $service->id,
            'availability_id' => $availability->id,
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
