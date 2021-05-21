<?php

namespace App\Http\Controllers;

use App\User;
use App\FollowedUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ChangePasswordRequest;
use Intervention\Image\ImageManagerStatic as Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     // $this->middleware('auth');
    //     $this->middleware('verified');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function get_all_user_followers(Request $request)
    {
        $follows = FollowedUser::where('user_id', '!=', $request->userId)->where('followed_userId', $request->userId)->orderByDesc('created_at')->get();

        foreach($follows as $follow){
            $followUsers = User::where('id', $follow->user_id)->get();

            foreach($followUsers as $followUser){

                $followers[] = $followUser; 
            }
        
        }

        return response()->json($followers);
    
    }

    public function get_all_user_followings(Request $request)
    {
    
        $follows = FollowedUser::where('user_id', $request->userId)->where('followed_userId', '!=', $request->userId)->orderByDesc('created_at')->get();

        foreach($follows as $follow){
            $followUsers = User::where('id', $follow->followed_userId)->get();

            foreach($followUsers as $followUser){

                $followings[] = $followUser; 
            }
        
        }

        return response()->json($followings);
    
    }


    public function get_user_profile(Request $request)
    {
        $user = User::where('id', $request->userId)->first();

        return response()->json($user);
    }


    public function updateMyProfileBio(Request $request)
    {
        $user = User::where('id', $request->userId)->first();
        $user->name = $request->name;
        $user->username = Str::slug($request->username);
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->update();
        
        return response()->json($request->bio);
    }


    public function updateMyProfilePhoto(Request $request)
    {
        $myFiles = $request->file('files');
        if(!empty($myFiles)){            
            $original_name = str_replace(' ', '', $myFiles->getClientOriginalName());
            $originalName = substr(str_replace(' ', '-', $original_name),0,20);
            $rand = rand(9,1000);
            $fileName   = $originalName . '_'. time(). date("Ymd") . '_'. $rand. '.'.'jpg';

            $img = Image::make($myFiles->getRealPath());
            $img->fit(100, 100, function ($constraint) {
                // $constraint->aspectRatio();
                $constraint->upsize();                  
            });
            $img->stream();

            Storage::disk('local')->put('/profile'.'/'.$fileName, $img, 'public');

            $user = User::find($request->userId);
            if(!empty($user->pic)){
            unlink(storage_path('/app/public/profile/'. $user->pic));
            }
            $user->pic = $fileName;
            $user->update();

            return response()->json([
                'userPhoto' => $fileName,
            ]);
        }
    }


    public function changeMyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = User::find($request->userId);
        $user->password = bcrypt($request->password);
        $user->update();

        return response()->json('Password changed successfully');
    }


    public function updateStatus(Request $request)
    {
        $user = User::find($request->userId);
        if($request->pvtStatus == 1){
           $user->pvt = 0;
        }else{
            $user->pvt = 1;
        }
        $user->update();

        return response()->json('Update was successful');
    }


}
