<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Country::factory(10)->create();
        \App\Models\City::factory(50)->create();
        \App\Models\User::factory(10)->create(); // change to 100

        $this->call([CarSeeder::class]);
    }
}
