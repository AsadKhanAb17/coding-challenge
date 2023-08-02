<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\ConnectionRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function countuser()
    {
        $currentUser = Auth::user();

        $existingConnections = $currentUser->connections()->pluck('connections.connected_user_id')->toArray();

        $sentRequests = $currentUser->sentRequests()->pluck('receiver_id')->toArray();
        $receivedRequests = $currentUser->receivedRequests()->pluck('sender_id')->toArray();

        $excludedUserIds = array_merge($existingConnections, $sentRequests, $receivedRequests, [$currentUser->id]);

        $suggestions = User::whereNotIn('users.id', $excludedUserIds)->get()->count();

        $sentRequests = ConnectionRequest::with('receiver')
            ->where('sender_id', $currentUser->id)
            ->get()->count();
        $receivedRequests = ConnectionRequest::with('sender')
            ->where('receiver_id', $currentUser->id)
            ->get()->count();
        $connections = $currentUser->connections->count();
        return response()->json(['suggestions' => $suggestions, 'sentRequests' => $sentRequests, 'receivedRequests' => $receivedRequests, 'connections' => $connections]);
    }
    public function suggestions()
    {
        $currentUser = Auth::user();

        $existingConnections = $currentUser->connections()->pluck('connections.connected_user_id')->toArray();

        $sentRequests = $currentUser->sentRequests()->pluck('receiver_id')->toArray();
        $receivedRequests = $currentUser->receivedRequests()->pluck('sender_id')->toArray();

        $excludedUserIds = array_merge($existingConnections, $sentRequests, $receivedRequests, [$currentUser->id]);

        $suggestions = User::whereNotIn('users.id', $excludedUserIds)->paginate(10);

        return response()->json($suggestions);
    }

    public function connect(Request $request, $user_id)
    {
        $currentUser = Auth::user();
        // Check if the user with the specified user_id exists
        $userToConnect = User::find($user_id);
        if (!$userToConnect) {
            return response()->json(['error' => 'User not found'], 404);
        }
        // Check if the connection already exists
        $existingConnection = $currentUser->connections()->where('connected_user_id', $user_id)->first();
        if ($existingConnection) {
            return response()->json(['message' => 'Already connected with this user'], 400);
        }
        // Check if a connection request already exists
        $existingRequest = $currentUser->sentRequests()->where('receiver_id', $user_id)->first();
        if ($existingRequest) {
            return response()->json(['message' => 'Connection request already sent'], 400);
        }

        // Create a new connection request
        $currentUser->sentRequests()->create([
            'receiver_id' => $user_id,
        ]);

        return response()->json(['message' => 'Connection request sent']);
    }

    public function sentRequests(Request $request)
    {
        $sentRequests = ConnectionRequest::with('receiver')
            ->where('sender_id', $request->user()->id)
            ->paginate(10);

        return response()->json($sentRequests);
    }

    public function withdrawRequest($user_id)
    {
        // Find the connection request to withdraw
        $connectionRequest = ConnectionRequest::where('id', $user_id)->first();

        if (!$connectionRequest) {
            return response()->json(['error' => 'Connection request not found'], 404);
        }
        // Delete the connection request
        $connectionRequest->delete();

        return response()->json(['message' => 'Connection request withdrawn']);
    }

    public function receivedRequests(Request $request)
    {
        $currentUser = Auth::user();

        // Retrieve all connection requests that have been sent to the current user.
        $receivedRequests = ConnectionRequest::with('sender')
            ->where('receiver_id', $request->user()->id)
            ->paginate(10);



        return response()->json($receivedRequests);
    }

    public function acceptRequest(Request $request, $user_id)
    {
        $currentUser = Auth::user();

        // Find the connection request to accept
        $connectionRequest = $currentUser->receivedRequests()->where('sender_id', $user_id)->first();
        if (!$connectionRequest) {
            return response()->json(['error' => 'Connection request not found'], 404);
        }

        Connection::create([
            'user_id' => $currentUser->id,
            'connected_user_id' => $connectionRequest->sender_id,

        ]);
        // Create a new connection between the users
        // $currentUser->connections()->create([]);

        // Delete the connection request
        $connectionRequest->delete();

        return response()->json(['message' => 'Connection request accepted']);
    }

    public function connections(Request $request)
    {
        $currentUser = Auth::user();

        // Retrieve all current user's connections.
        $connections = $currentUser->connections()->paginate(10);

        // Add common connection count for each user in the connections list
        foreach ($connections as $connection) {
            $commonConnectionCount = $currentUser->connections()->whereHas('connections', function ($query) use ($connection) {
                $query->where('connected_user_id', $connection->id);
            })->count();

            // Add the common connection count to each user model in the connections list
            $connection->common_connection_count = $commonConnectionCount;
        }

        return response()->json($connections);
    }

    public function removeConnection(Request $request, $user_id)
    {
        $currentUser = Auth::user();

        // Find the connection to remove
        $connection = $currentUser->connections()->where('connected_user_id', $user_id)->first();

        if (!$connection) {
            return response()->json(['error' => 'Connection not found'], 404);
        }

        // Delete the connection
        $connection->delete();

        return response()->json(['message' => 'Connection removed']);
    }

    public function commonConnections(Request $request, $user_id)
    {
        $currentUser = auth()->user();
        $selectedUser = User::findOrFail($user_id);

        // Retrieve common connections using the 'connections' relationship defined in the User model
        $commonConnections = $currentUser->connections()->whereHas('connections', function ($query) use ($selectedUser) {
            $query->where('connected_user_id', $selectedUser->id);
        })->paginate(10);

        return response()->json($commonConnections);
    }
}
