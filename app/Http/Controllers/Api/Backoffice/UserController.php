<?php

namespace App\Http\Controllers\Api\Backoffice;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\AllUserRegistrationRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderByDesc('created_at')->get();
        
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AllUserRegistrationRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->username = Str::slug($request->name);
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->bio = $request->bio;
        $user->save();
        
        return response()->json($user);
        // return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = Str::slug($request->name);
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->update();
        
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json($user);
    }
}
