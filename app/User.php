<?php

namespace App;
use \Storage;
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
        'name', 'email',
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

    public static function add($fields){
        $user = new static;
        $user->fill($fields);
        $user->save();

        return $user;
    }

    public function edit($fields){
        $this->fill($fields);
        $this->generateNewPassword($fields['password']);
        $this->save();
    }

    public function generateNewPassword($password){
        if($password != null){
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    public function remove(){
        $this->removeAvatar($this->avatar);
        $this->delete();
    }

    public  function uploadAvatar($image){

        if($image == null){ return; }

        $this->removeAvatar($this->avatar);

        $filename = str_random(10).'.'.$image->extension();
        $image->storeAs('uploads', $filename);
        $this->avatar = $filename;
        $this->save();
    }

    public function getAvatar(){
        if($this->avatar == null){
            return '/img/no-user.png';
        }
        return '/uploads/'.$this->avatar;
    }

    public function removeAvatar($avatar){
        if($avatar != null){
            Storage::delete('uploads/'.$avatar);
        }
    }
}
