<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->name(),
            'quantity' => fake()->randomNumber(2),
            'expiry' => fake()->date(),
            'user_id' => User::query()->get()->random()->id,
        ];
    }
}
