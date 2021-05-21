<?php

namespace App\Http\Controllers;

use App\User;
use App\FollowedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{

    //Get All Users Data
    public function index()
    {
        $users = User::orderByDesc('created_at')->get();
        
        return response()->json($users);
    }

     //Get specific User Records
    public function getUser(Request $request)
    {
        
        $user = User::where('username', $request->username)->first();
        $following = FollowedUser::where('user_id', $request->userId)->where('followed_userId', $user->id)->first();

        return response()->json([
            'user' => $user,
            'following' => $following
        ]);
    }


    public function followStatusUpdate(Request $request)
    {
        $follow = new FollowedUser();
        $follow->user_id = $request->userId;
        $follow->followed_userId = $request->followedUserId;
        $follow->save();

        return response()->json('Successfully updated');
    }
    
    public function updateUnfollowStatus(Request $request)
    {
        $unfollow = FollowedUser::where('user_id', $request->userId)
                ->where('followed_userId', $request->followedUserId)
                ->first();
        $unfollow->delete();

        return response()->json('Successully updated');
    }


}
