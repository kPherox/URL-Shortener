<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert(
            array(
                'id' => 0,
                'name' => env('ADMINISTRATOR_NAME', str_random(10)),
                'email' => env('ADMINISTRATOR_EMAIL', str_random(10).'@gmail.com'),
                'password' => bcrypt(env('ADMINISTRATOR_PASSWORD', 'secret')),
                'verified' => true
            )
        );
    }
}
