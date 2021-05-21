<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FollowedUser extends Model
{
    protected $table = 'followed_users';

    protected $fillable = ['user_id', 'followed_userId'];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
