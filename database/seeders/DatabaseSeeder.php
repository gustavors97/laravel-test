<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{Level, User, UserLevel, Customer, Number, NumberPreference};

class DatabaseSeeder extends Seeder {

    // Create initial records
    public function run() {
        Level::create(['type' => 'admin']);
        Level::create(['type' => 'customer']);

        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'image'    => 'admin.svg'
        ]);

        UserLevel::create([
            'user_id'  => 1,
            'level_id' => 1
        ]);

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $name = $faker->name;

            $user = User::create([
                'name'     => $name,
                'email'    => $faker->email,
                'password' => bcrypt(Str::random(10))
            ]);

            UserLevel::create([
                'user_id'  => $user->id,
                'level_id' => 2
            ]);

            $customer = Customer::create([
                'user_id'  => $user->id,
                'name'     => $name,
                'document' => $faker->numerify('############'),
                'status'   => 'active'
            ]);

            $number = Number::create([
                'customer_id' => $customer->id,
                'number'      => $faker->numerify('##############'),
                'status'      => 'active'
            ]);

            NumberPreference::create([
                'number_id' => $number->id,
                'name'      => 'auto_attendant',
                'value'     => '1'
            ]);

            NumberPreference::create([
                'number_id' => $number->id,
                'name'      => 'voicemail_enabled',
                'value'     => '1'
            ]);
        }
    }
}
