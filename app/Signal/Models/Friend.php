<?php

namespace Signal\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Friend extends Authenticatable
{
    public static function createRequest($first_user,$second_user,$status){

    	$friend = new Friend();
    	$friend->first_user = $first_user;
    	$friend->second_user = $second_user;
    	$friend->status = $status;
    	$friend->save();

    	return $friend;
    }

   
}
