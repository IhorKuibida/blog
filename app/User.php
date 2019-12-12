<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public  function posts(){
        return $this->hasMany(Post::class);
    }

    public  function comments(){
        return $this->hasMany(Comment::class);
    }

    public function add($fields){
        $user = new static;
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields){
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();
    }

    public function remove(){
        $this->delete();
    }

    public  function uploadAvatar($image){

        if($image == null){ return; }

        Storage::delete('uploads/'.$this->image);
        $filename = str_random(10).'.'.$image->extension();
        $image->saveAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    public function getAvatar(){
        if($this->image == null){
            return '/img/no-user.png';
        }
        return '/uploads/'.$this->image;
    }
}
