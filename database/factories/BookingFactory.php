<?php

namespace Database\Factories;

use App\Models\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'customer_name'   => $this->faker->name(),
            'phone_number'    => $this->faker->phoneNumber(),
            'booking_date'    => $this->faker->dateTimeBetween('now', '+30 days'),
            'service_type_id' => ServiceType::inRandomOrder()->first()->id,
            'notes'           => $this->faker->optional()->text(100),
            'status'          => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
