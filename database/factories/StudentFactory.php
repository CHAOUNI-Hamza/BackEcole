<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->name(),
            'prenom' => $this->faker->name(),
            'niveau_scolaire' => $this->faker->name(),
            'type_niveau' => $this->faker->name(),
            'photo' => $this->faker->imageUrl($width = 640, $height = 480),
            'num_matricule' => $this->faker->name(),
            'sex' => $this->faker->name(),
            'date_naissance' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ];
    }
}
