<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use App\Models\Photo;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Faker\Provider\Fakecar($faker));
        $faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($faker));

        $users = User::all();

        // each user got 1 to 3 cars
        foreach($users as $user){
            foreach(range(1, rand(1, 3)) as $c){
                $car = Car::create([
                    'make'                  => $faker->vehicleBrand(),
                    'model'                 => $faker->vehicleModel(),
                    'year'                  => $faker->year($max = 'now'),
                    'body_type'             => $faker->vehicleType(),
                    'fuel_type'             => $faker->vehicleFuelType(),
                    'engine_displ'          => $faker->numberBetween(1000, 10000),
                    'transmission_type'     => $faker->vehicleGearBoxType(),
                    'price'                 => $faker->numberBetween(10000, 9999999),
                    'description'           => $faker->text(),
                    'user_id'               => $user->id
                ]);
                
                // each car got 1 random(by make) photo
                Photo::create([
                    'img_path'              => $faker->imageUrl(1280, 720, [$car->make]),
                    'car_id'                => $car->id
                ]);
            }
        }
    }
}
