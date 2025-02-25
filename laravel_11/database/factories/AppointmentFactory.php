<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'created_at' => now(),
            'updated_at' => now(),
            // Diğer gerekli alanları modele göre ekleyin
        ];
    }
} 