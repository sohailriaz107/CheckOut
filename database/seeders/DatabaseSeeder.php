<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,200) as $index) {
            DB::table('merchants')->insert([
                'name' => $faker->name(),
                'email' => $faker->email,
                'address' => $faker->address,
                'merchant_code' => $faker->numerify('##########'),
                'secret_id' => $faker->bothify('?###??##'),
                'store_name' => $faker->text(5),
                'telephone' => $faker->phoneNumber,
            ]);
        }
    }
}
