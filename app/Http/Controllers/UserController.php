<?php

// namespace App\Http\Controllers;

// use App\Models\User;
// use App\Models\FriendModel;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;



// class UserController extends Controller
// {
//     public function index()
//     {
//         $users = User::all();

//         return view('users.index', compact('users'));
//     }
//     public function friendrequest()
//     {
//         $friendrequest = "test";
//         return view('users.friendrequest', compact('friendrequest'));
//     }
//     public function addFriend(Request $request)
//     {
//         $friendId = $request->input('friend_id');
//         $user = Auth::user();
//         $userModel = User::FindOrFail($user->id);

//         //zodat er geen rare bugs komen met friend_ids
//         if ($userModel->friends()->where('friend_id', $friendId)->exists()) {
//             return response()->json(['message' => 'Already friends.']);
//         }
//         if ($userModel->friends()->where('user_id', $friendId)->exists()) {
//             return response()->json(['message' => 'Friend already added you.']);
//         }

//         $friend = new FriendModel();
//         $friend->user_id = $user->id;
//         $friend->friend_id = $friendId;
//         $friend->save();

//         return response()->json(['message' => 'Friend added successfully.']);
//     }
// }
namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return view('users.index', compact('users'));
    }
    public function dashboard()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $friends = User::find(Auth::id())->friends()->get();

        // dd($friends);
        $friendRequests = FriendRequest::where('recipient_id', Auth::id())->get();
        // dd($friendRequests);

        return view('dashboard', compact('users', 'friendRequests', 'friends'));
    }

    public function addFriend(Request $request)
    {
        $friendId = $request->input('friend_id');
        $user = Auth::user();
        $usermodel = User::find($user->id);
        $friend = User::find($friendId);
        // Check if the user is already friends with the given friendId
        if ($usermodel->isFriendWith($friendId)) {
            return redirect()->back()->with('message', 'Already friends.');
        }

        // Create a new friend request or add friend relationship directly
        if ($friend->hasFriendRequestFrom($user->id)) {
            // Accept friend request
            $friend->acceptFriendRequest($user->id);
            return redirect()->back()->with('message', 'Friend request accepted.');
        } else {
            // Send friend request
            $usermodel->sendFriendRequest($friendId);
            return redirect()->back()->with('message', 'Friend request sent.');
        }
    }
    public function acceptFriendRequest(FriendRequest $friendRequest)
    {
        // Update the status of the friend request to "accepted"
        $friendRequest->update(['status' => 'accepted']);
        $auth = Auth::user();
        $user = User::find($auth->id);

        // Add the sender as a friend to the authenticated user
        $user->friends()->attach($friendRequest->sender_id);

        // Redirect back to the dashboard or any desired page
        return redirect()->route('dashboard')->with('success', 'Friend request accepted successfully.');
    }

    public function denyFriendRequest(FriendRequest $friendRequest)
    {
        // Delete the friend request
        $friendRequest->delete();

        // Redirect back to the dashboard or any desired page
        return redirect()->route('dashboard')->with('success', 'Friend request denied successfully.');
    }
}
