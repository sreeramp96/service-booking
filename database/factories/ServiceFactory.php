<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('en_US');
        // return [

        //     'name' => $faker->words(2, true),
        //     'description' => $faker->sentence,
        //     'price' => $faker->numberBetween(100, 1000),
        // ];
        $serviceTypes = [
            'Cleaning',
            'Repair',
            'Maintenance',
            'Installation',
            'Consultation',
            'Training',
            'Design',
            'Development',
            'Support',
            'Management'
        ];

        $serviceAreas = [
            'Home',
            'Garden',
            'Computer',
            'Car',
            'Kitchen',
            'Bathroom',
            'Office',
            'Electrical',
            'Plumbing',
            'HVAC',
            'Security',
            'Fitness'
        ];

        $serviceType = $faker->randomElement($serviceTypes);
        $serviceArea = $faker->randomElement($serviceAreas);
        $serviceName = $serviceArea . ' ' . $serviceType;

        return [
            'user_id' => User::factory()->create(['role' => 'provider'])->id,
            'name' => $serviceName,
            'description' => $faker->catchPhrase() . '. ' . $faker->bs() . ' with professional quality and reliable service.',
            'price' => $faker->numberBetween(500, 5000),
        ];
    }
}
