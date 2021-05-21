<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable, HasApiTokens;


    protected $fillable = [
        'name', 'email', 'password'
    ];


      protected $hidden = [
        'password',
        'remember_token',
    ];
}
