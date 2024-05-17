<?php

namespace Database\Seeders;

use Faker\Factory;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
//        $faker = Factory::create();
        $faker = Factory::create('uk_UA');


        User::factory()->create([
//            'name' => 'Иван',
//            'lastname' => 'Демидов',
            'name' => $faker->firstName,
            'lastname' => $faker->lastName,
            'middle_name' => $faker->lastName,
            'email' => 'admin@alphamovers.test',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
            'photo_path'=> 'img/photo_plug.png',


        ]);

        User::factory()->create([
//            'name' => 'Вадим',
//            'lastname' => 'Немченко',
            'name' => $faker->firstName,
            'lastname' => $faker->lastName,
            'middle_name' => $faker->lastName,
            'email' => 'manager@local.com',
            'password' => Hash::make('12345678'),
            'is_manager' => true,
            'photo_path'=> 'img/photo_plug.png',

        ]);

        User::factory()->create([
//            'name' => 'Миколо',
//            'lastname' => 'Пагубець',
            'name' => $faker->firstName,
            'lastname' => $faker->lastName,
            'middle_name' => $faker->lastName,
            'email' => 'hr@local.com',
            'password' => Hash::make('12345678'),
            'is_hr' => true,
            'photo_path'=> 'img/photo_plug.png',

        ]);

        User::factory()->create([
//            'name' => 'Илья',
//            'lastname' => 'Новиков',
            'name' => $faker->firstName,
            'lastname' => $faker->lastName,
            'middle_name' => $faker->lastName,
            'email' => 'logist@local.com',
            'password' => Hash::make('12345678'),
            'is_logist' => true,
            'photo_path'=> 'img/photo_plug.png',

        ]);

        User::factory()->create([
//            'name'=> 'Вадим',
//            'lastname'=>'Вдовиченко',
            'name' => $faker->firstName,
            'lastname' => $faker->lastName,
            'middle_name' => $faker->lastName,
            'email'=>'accountant@local.com',
            'password'=>Hash::make('12345678'),
            'is_accountant' =>true,
            'photo_path'=> 'img/photo_plug.png',

        ]);

        User::factory()->create([
//            'name'=> 'Виктор',
//            'lastname'=> 'Попов',
            'name' => $faker->firstName,
            'lastname' => $faker->lastName,
            'middle_name' => $faker->lastName,
            'email'=>'executive@local.com',
            'password'=>Hash::make('12345678'),
            'is_executive'=>true,
            'photo_path'=> 'img/photo_plug.png',

        ]);

        // for ($i = 0; $i < 15; $i++) {
        //     User::factory()->create([
        //         'name'=>$faker->userName,
        //     'lastName'=>$faker->lastName,
        //         'email' => $faker->email,
        //         'password' => Hash::make('secret'),
        //     ]);
        // }

        User::factory(14)->create();




    }
}
