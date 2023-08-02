<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommonConnectionSeeder extends Seeder
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
            // Get a random user to create common connections with
            $userToConnect = $users->except($user->id)->random();

            // Create connections between users
            $user->connections()->attach($userToConnect);

            // Check for common connections and create connections with them
            $commonConnections = $user->connections()->whereIn('connected_user_id', $userToConnect->connections()->pluck('connected_user_id'))->get();

            foreach ($commonConnections as $commonConnection) {
                $user->connections()->attach($commonConnection->connected_user_id);
            }
        }
    }
}
