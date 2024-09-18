<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PaymentFactory extends Factory
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
            'card_number' => fake()->randomNumber(5),
            'total' => fake()->randomNumber(5),
            'order_id' => Order::query()->get()->random()->id,
        ];
    }
}
