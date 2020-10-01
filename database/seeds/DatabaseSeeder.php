<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
        $faker = \Faker\Factory::create();
        for($i=0;$i<10;$i++){
        	$gender = $faker->randomElement(['male', 'female']);
        	$user = new \Signal\Models\User();
            $user->name = $faker->name;
            $user->email = $faker->email;
            $user->gender = $gender;
            $user->password = \Hash::make('password');
            $user->save();
        }
    }
}
