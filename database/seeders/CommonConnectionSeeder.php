<?php

namespace Database\Seeders;

use App\Models\User;
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
            $connectedUsers = collect();  // Collection to hold connected users IDs

            for ($i = 0; $i < 10; $i++) {
                // Get a random user to create common connections with
                $userToConnect = $users->except($user->id)->concat($connectedUsers)->random();

                // Create connections between users
                $user->connections()->attach($userToConnect);
                $connectedUsers->push($userToConnect->id);  // Add connected user ID to the collection

                // Check for common connections and create connections with them
                $commonConnections = $user->connections()->whereIn('connected_user_id', $userToConnect->connections()->pluck('connected_user_id'))->get();

                foreach ($commonConnections as $commonConnection) {
                    if (!$connectedUsers->contains($commonConnection->connected_user_id)) {  // Check if the common connection is not already connected
                        $user->connections()->attach($commonConnection->connected_user_id);
                        $connectedUsers->push($commonConnection->connected_user_id);  // Add common connection user ID to the collection
                    }
                }
            }
        }
    }
}
