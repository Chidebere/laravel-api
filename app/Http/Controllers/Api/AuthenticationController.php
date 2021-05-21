<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @group Auth endpoints
 */
class AuthenticationController extends Controller
{
    /**
     * Shows authenticated user information
     *
     * @authenticated
     */
    public function user()
    {
        return auth()->user();
    }
}
