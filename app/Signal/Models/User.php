<?php

namespace Signal\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public const STATUS_ACTIVE=1;
    public const STATUS_INACTIVE=0;

    public const GENDER_FEMALE=1;
    public const GENDER_MALE=0;

    public function friendsFromMe(){

        return $this->belongsToMany(\Signal\Models\User::class, 'friends', 'first_user', 'second_user')
        ->withPivot('status')
        ->wherePivot('status', 'confirmed');
    }

    public function friendsToMe(){

        return $this->belongsToMany(\Signal\Models\User::class, 'friends', 'second_user', 'first_user')
        ->withPivot('status')
        ->wherePivot('status', 'confirmed');
    }


    public function getNonFriends(){
        // return self::where('id','!=',$this->id)->get();
        $friends = \Signal\Models\Friend::where(function($query){
                                $query->where('first_user',$this->id);
                                $query->orWhere('second_user',$this->id);
                            })->get();

        $first_user = $friends->pluck('first_user')->toArray();
        $second_user = $friends->pluck('second_user')->toArray();
        $unique =  array_merge($first_user, $second_user);
        $users = self::whereNotIn('id',$unique)->where('id','!=',$this->id)->get();
        return $users;
    }

    public function getRequestedUsers(){

        $pending = \Signal\Models\Friend::where('status','pending')->where('second_user',$this->id)->pluck('first_user');
        $users = self::whereIn('id',$pending)->where('id','!=',$this->id)->get();
        return $users;
    }

    public function getFriends(){

        $friends = \Signal\Models\Friend::where('status','confirmed')
                            ->where(function($query){
                                $query->where('first_user',$this->id);
                                $query->orWhere('second_user',$this->id);
                            })->get();

        $first_user = $friends->pluck('first_user')->toArray();
        $second_user = $friends->pluck('second_user')->toArray();
        $unique =  array_merge($first_user, $second_user);
        $users = self::whereIn('id',$unique)->where('id','!=',$this->id)->get();
        return $users; 
    }

    public function getFriendCount(){

        $second_user = $this->friendsFromMe()->pluck('second_user')->toArray();
        $first_user = $this->friendsToMe()->pluck('first_user')->toArray();

        $friends = array_merge($second_user,$first_user);

        return self::whereIn('id',$friends)->count();
    }

    

    
}
