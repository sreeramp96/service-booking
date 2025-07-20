<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Availability;
use App\Models\Booking;
use Faker\Factory as Faker;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_US');
        $providers = User::factory(5)->create(['role' => 'provider']);
        foreach ($providers as $provider) {
            $services = Service::factory(3)->create(['user_id' => $provider->id]);
            foreach ($services as $service) {
                $availabilities = Availability::factory(3)->create(['service_id' => $service->id]);
                foreach ($availabilities as $availability) {
                    Booking::factory($faker->numberBetween(1, 2))->create([
                        'service_id' => $service->id,
                        'availability_id' => $availability->id,
                        'user_id' => User::factory()->create(['role' => 'customer'])->id,
                    ]);
                }
            }
        }
    }
}
