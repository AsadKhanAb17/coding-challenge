<?php

namespace Database\Seeders;

use App\Models\User;
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
            for ($i = 0; $i < 10; $i++) {
                // Get a random user to connect with
                $userToConnect = $users->except($user->id)->random();

                // Create connections between users
                // Here we're using syncWithoutDetaching to avoid attaching the same connection multiple times
                $user->connections()->syncWithoutDetaching($userToConnect);
            }
        }
    }
}
