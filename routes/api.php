<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('getAllUserData', 'BaseController@index');

Route::get('getSpecificUser', 'BaseController@getUser');

Route::get('updateFollowStatus', 'BaseController@followStatusUpdate');

Route::get('updateUnfollowStatus', 'BaseController@updateUnfollowStatus');

Route::get('getAllFollowings', 'HomeController@get_all_user_followings');

Route::get('getAllFollowers', 'HomeController@get_all_user_followers');

Route::get('getMyProfile', 'HomeController@get_user_profile');

Route::post('updateMyProfile', 'HomeController@updateMyProfileBio');

Route::post('updateMyProfilePhoto', 'HomeController@updateMyProfilePhoto');

Route::post('changeMyPassword', 'HomeController@changeMyPassword');

Route::get('updateStatus', 'HomeController@updateStatus');



Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {

    Route::post('login', 'LoginController@login')->name('login');

    Route::post('register', 'RegisterController@register')->name('register');

    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('/email/verify/{hash}', 'VerificationController@verify')->name('verification.verify');

        Route::get('/email/resend', 'VerificationController@resend')->name('verification.resend');

        Route::get('user', 'AuthenticationController@user')->name('user');

        Route::post('logout', 'LoginController@logout')->name('logout');

    });

        //Back Office 
        Route::post('/admin_login', 'Backoffice\AuthController@adminLogin');
        
        Route::apiResource('allusers', 'Backoffice\UserController');

        Route::group(['middleware' => ['auth:api']], function () {

            Route::get('admin_user', 'Backoffice\AuthController@admin_user')->name('user');

            Route::post('admin_logout', 'Backoffice\AuthController@logout')->name('logout');

        });
});


  