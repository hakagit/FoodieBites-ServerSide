<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\Customer;
use App\Models\User; // Assuming you have a User model
use Faker\Factory as Faker;

class AddressSeeder extends Seeder
{
    public function run()
    {
        Address::factory(100)->create();
    }
}
