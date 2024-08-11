<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password default
            'remember_token' => Str::random(10),
            'role' => 'user', // default role
        ];
    }

    // State untuk admin
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
            ];
        });
    }

    // State untuk user    
    public function user()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'user',
            ];
        });
    }
}
