<?php

namespace Database\Seeders;

use App\Models\Tweet;
use App\Models\User;
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
    	User::factory()->create(["name" => "Pelle", "email" => "pelle@hej.se"]);
    	User::factory(3)->create();
    	Tweet::factory(5)->create(["user_id" => 1]);
    }
}
