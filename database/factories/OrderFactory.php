<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class OrderFactory extends Factory
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
            'date' => fake()->date(),
            'user_id' => User::query()->get()->random()->id,
            'driver_id' => Driver::query()->get()->random()->id,
        ];
    }
}
