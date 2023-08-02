<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Get a random user to connect with
            $userToConnect = $users->except($user->id)->random();

            // Create connections between users
            $user->connections()->attach($userToConnect);
        }
    }
}
