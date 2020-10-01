<?php

namespace Signal\Models\DTO;
use Storage;

class UserDTO
{

	public static function process($user){

        $user_data_array=[];
        $current_user = \Auth::user();
        if(!empty($user)){
            $user_data_array['id'] = $user->id;
            $user_data_array['name'] = $user->name;
            $user_data_array['email'] = $user->email;
            $check_is_friend = \Signal\Models\Friend::where([
                    ['first_user' ,'=' ,$current_user->id],
                    ['second_user'  ,'=' , $user->id]])
                    ->orWhere([
                        ['first_user' ,'=' ,$user->id],
                        ['second_user' ,'=' ,$current_user->id]
                    ])->first();

            if(empty($check_is_friend)){
                $user_data_array['is_friend'] = "no";
            }else{
                $user_data_array['is_friend'] = "yes";
                $user_data_array['status'] = $check_is_friend->status; 
                if($check_is_friend->first_user == $current_user->id){
                   $user_data_array['requester'] = "yes" ;
                }else{
                    $user_data_array['requester'] = "no" ;
                }
                
                $user_data_array['status'] = $check_is_friend->status; 
            }     
            
            if(!empty($user->profile_image)){
                $user_data_array['profile_image'] = url(Storage::url('user-pic/'.$user->profile_image));
            }else{
                $user_data_array['profile_image'] = url('/default_user.png');
            }
            
        }
           
        return $user_data_array;


     
    }

	public static function processArray($users){

		if(empty($users)){
			return [];
		}

		$data = [];
		foreach($users as $user){
			$data[] = self::process($user);
		}

		return $data;
	}


}
