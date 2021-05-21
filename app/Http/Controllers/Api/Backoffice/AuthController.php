<?php

namespace App\Http\Controllers\Api\Backoffice;

use App\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * Handle a login request to the application.
     * @param  \Illuminate\Http\Request  $request
     * @throws \Illuminate\Validation\ValidationException
     * Validate the input before login
     */
    public function adminLogin(AdminLoginRequest $request)
    {

        $user = Admin::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
        
                $token = $user->createToken('TVZCorpAdmin')->accessToken;
                $response = [
                    'token' => $token,
                    'user'  => $user
                ];
                // return response($response, 200);
                return response()->json($response, 200);
            } else {
                $response = ["errors" => "Password mismatch"];
                // return response($response, 422);
                return response()->json($response, 422);
            }
        } else {
            $response = ["errors" =>'User does not exist'];
            // return response($response, 422);
            return response()->json($response, 422);
        }

    }


     /**
     * Log the user out of the application.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/');
    }


    public function admin_user()
    {
        return auth()->user();
    }



}
