<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'profile_picture', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getProfileAttribute()
    {
        // // return asset("storage/profile_pictures/{$value}" ?: '\images\pc.png');
        // return asset('/images/'.$value ?: '/images/pc.png');
        return "https://i.pravatar.cc/400?u=" . $this->email;
    }

    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function timeline()
    {
        // return Post::where('user_id', $this->id)->latest()->get();
        $friends = $this->friends->pluck('id');
        // $ids->push($this->id);

        return Post::whereIn('user_id', $friends)
            ->orWhere('user_id', $this->id)
            ->latest()->get();
    }

    public function toggleFollow(User $user)
    {
        $this->follows()->toggles($user);
    }

    public function friend(User $user)
    {
        return $this->friends()->save($user);
        // return $this->friends()->save($friend);
    }

    public function unfriend(User $user)
    {
        return $this->friends()->detach($user);
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_user_id');
    }

    public function isFriend(User $user)
    {
        return $this->friends()->where('friend_user_id', $user->id)->exists();
    }

    // public function friendOf()
    // {
    //     return $this->belongsToMany(User::class, 'friends', 'friend_user_id', 'user_id');
    // }

    // protected function mergeFriends()
    // {
    //     return $this->friendsOfMine->merge($this->friendOf);
    // }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function path($append = '')
    {
        $path = route('profile', $this->username);

        return $append ? "{$path}/{$append}" : $path;
    }
}
