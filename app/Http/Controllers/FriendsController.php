<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

class FriendsController extends Controller
{
    public function store(User $user)
    {
        if(auth()->user()->isFriend($user))
        {
            auth()->user()->unfriend($user);

        }
        else
        {
            auth()->user()->friend($user);
        }
        return back();
    }
}
