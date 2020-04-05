<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return factory(User::Class, [
            "email" => "sanusisheriff16@gmail.com",
            "password" => "secret"
        ])->create();
    }
}
