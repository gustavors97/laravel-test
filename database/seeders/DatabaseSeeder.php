<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{LevelModel, UserModel, UserLevelModel, CustomerModel, NumberModel, NumberPreferenceModel};

class DatabaseSeeder extends Seeder {

    // Create initial records
    public function run() {
        LevelModel::create(['type' => 'Admin']);
        LevelModel::create(['type' => 'Customer']);

        UserModel::create([
            'name'     => 'Administrator',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'image'    => 'admin.svg'
        ]);

        UserLevelModel::create([
            'user_id'  => 1,
            'level_id' => 1
        ]);

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $name = $faker->name;

            $user = UserModel::create([
                'name'     => $name,
                'email'    => $faker->email,
                'password' => bcrypt(Str::random(10))
            ]);

            UserLevelModel::create([
                'user_id'  => $user->id,
                'level_id' => 2
            ]);

            $customer = CustomerModel::create([
                'user_id'  => $user->id,
                'name'     => $name,
                'document' => $faker->numerify('############'),
                'status'   => 'new'
            ]);

            $number = NumberModel::create([
                'customer_id' => $customer->id,
                'number'      => $faker->numerify('##############'),
                'status'      => 'active'
            ]);

            NumberPreferenceModel::create([
                'number_id' => $number->id,
                'name'      => 'auto_attendant',
                'value'     => '1'
            ]);

            NumberPreferenceModel::create([
                'number_id' => $number->id,
                'name'      => 'voicemail_enabled',
                'value'     => '1'
            ]);
        }
    }
}
