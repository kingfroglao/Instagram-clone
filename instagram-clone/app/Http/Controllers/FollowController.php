<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FollowController extends Controller
{

    public function followUser(Request $request, $id)
    {
        $userToFollow = User::find($id);
        if (!$userToFollow) {
            return response()->json(['error' => 'User not found'], 404);
        }

        
        $existingFollow = Follow::where('follower_id', Auth::id())->where('followed_id', $id)->first();
        if ($existingFollow) {
            return response()->json(['error' => 'Already following'], 409); 
        }

        $follow = Follow::create([
            'follower_id' => Auth::id(),
            'followed_id' => $id,
        ]);

        return response()->json(['message' => 'Followed successfully']);
    }


    public function unfollowUser(Request $request, $id)
    {
        $follow = Follow::where('follower_id', Auth::id())->where('followed_id', $id)->first();
        if ($follow) {
            $follow->delete();
            return response()->json(['message' => 'Unfollowed successfully']);
        }

        return response()->json(['error' => 'Not following'], 404);
    }

}
