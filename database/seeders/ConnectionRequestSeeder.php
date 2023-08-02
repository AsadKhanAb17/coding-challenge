<?php

namespace Database\Seeders;

use App\Models\ConnectionRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            // Get a random user to send a connection request
            $userToRequest = $users->except($user->id)->random();

            // Create connection requests between users
            ConnectionRequest::create([
                'sender_id' => $user->id,
                'receiver_id' => $userToRequest->id,
            ]);
        }
    }
}
