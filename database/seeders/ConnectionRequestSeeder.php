<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ConnectionRequest;
use Illuminate\Database\Seeder;

class ConnectionRequestSeeder extends Seeder
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
                // Get a random user to send a connection request
                $userToRequest = $users->except($user->id)->random();

                // Create connection requests between users
                // Check if a request already exists before creating a new one
                $existingRequest = ConnectionRequest::where([
                    'sender_id' => $user->id,
                    'receiver_id' => $userToRequest->id,
                ])->first();

                if (!$existingRequest) {
                    ConnectionRequest::create([
                        'sender_id' => $user->id,
                        'receiver_id' => $userToRequest->id,
                    ]);
                }
            }
        }
    }
}
