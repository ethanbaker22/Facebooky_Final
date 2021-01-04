<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Validation\Rule;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', [
            'user' => $user,
            'posts' => $user
                // ->posts()
                // ->withLikes()
                // ->paginate(50),
        ]);
    }

    public function edit(User $user)
    {
        if($user->isNot(auth()->user()))
        {
            abort(403);
        }
        else
        {
            return view ('profiles.edit', compact('user'));
        }

    }

    public function update(User $user)
    {
        $attributes = request()->validate([
            'username' => [
                'string',
                'required',
                'max:255',
                'alpha_dash',
                Rule::unique('users')->ignore($user),
            ],
            'name' => ['string', 'required', 'max:255'],
            'avatar' => ['file'],
            'email' => [
                'string',
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user),
            ],
            'password' => [
                'string',
                'required',
                'min:8',
                'max:255',
                'confirmed',
            ],
        ]);


        //Could not get profile picture to show up in the profile page. The image would get added to my project and to the database
        /**if (request('profile_pic')) {
            $attributes['profile_pic'] = request('profile_pic')->store('profile_pic');
        }

        $attributes['profile_picture'] = request('profile_picture')->store('profilepictures');*/

        $user->update($attributes);

        return redirect($user->path());
    }
}
