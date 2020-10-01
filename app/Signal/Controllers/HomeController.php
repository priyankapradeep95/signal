<?php

namespace Signal\Controllers;

use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class HomeController extends Controller
{
    public function __construct(){
    	parent::__construct();
    }

    public function index(){

    	$this->data['seo']['title'] = "Signal";
    	return view('signal.home',$this->data);

    }


    public function getDashboard(){

    	$this->data['seo']['title'] = "Dashboard";
      $user = $this->current_user;
      $this->data['requested']=[];
      $this->data['friends'] =[];
      $this->data['non_friends']=[];
      $requested = $user->getRequestedUsers();
        foreach ($requested as $friend) {
         $this->data['requested'][] = \Signal\Models\DTO\UserDTO::process($friend);
      }
      $friends = $user->getFriends();
        foreach ($friends as $frnd) {
         $this->data['friends'][] = \Signal\Models\DTO\UserDTO::process($frnd);
      }

      $non_friends = $user->getNonFriends();
        foreach ($non_friends as $value) {
         $this->data['non_friends'][] = \Signal\Models\DTO\UserDTO::process($value);
      }


      $this->data['friends_count']= $user->getFriendCount();
    	return view('signal.dashboard',$this->data);

    }

    public function sendFriendRequest(Request $request){

        if(!empty($this->current_request->id)){
            $req_user = \Signal\Models\User::find($this->current_user->id);
            if(!empty($req_user)){

                $check_friend = \Signal\Models\Friend::where([
                    ['first_user' ,'=' ,$this->current_user->id],
                    ['second_user'  ,'=' , $request->id]])
                    ->orWhere([
                        ['first_user' ,'=' ,$request->id],
                        ['second_user' ,'=' ,$this->current_user->id]
                    ])->first();



                if(empty($check_friend)){
                    $create_request = \Signal\Models\Friend::createRequest($this->current_user->id,$request->id, "pending");

                    return response()->json([
                          'data'=>null,
                          'success' => 'true',
                          'message'=>"Request Sent"
                      ],200);

                }else{
                    return response()->json([
                          'data'=>null,
                          'success' => 'false',
                          'message'=>"Already Sent"
                      ],200);
                }

           
                
            }else{
                return response()->json([
                          'data'=>null,
                          'success' => 'false',
                          'message'=>"User Not Found"
                      ],200);
            }
            
        }else{
            return response()->json([
                      'data'=>null,
                      'success' => 'false',
                      'message'=>"Id Required"
                  ],200);
        }
    }

    public function acceptRequest(Request $request){

        if(!empty($this->current_request->id)){
            $req_user = \Signal\Models\User::find($this->current_user->id);
            if(!empty($req_user)){

                $check_friend = \Signal\Models\Friend::where([
                    ['first_user' ,'=' ,$this->current_user->id],
                    ['second_user'  ,'=' , $request->id]])
                    ->orWhere([
                        ['first_user' ,'=' ,$request->id],
                        ['second_user' ,'=' ,$this->current_user->id]
                    ])->first();



                if(!empty($check_friend)){
                  $check_friend->status = "confirmed";
                  $check_friend->save();

                  $this->current_user->friends_count = $this->current_user->getFriendCount();
                  $this->current_user->save();

                  return response()->json([
                      'data'=>null,
                      'success' => 'true',
                      'message'=>"Approved"
                  ],200);
                }else{
                   return response()->json([
                      'data'=>null,
                      'success' => 'false',
                      'message'=>"Not Found"
                  ],200);
                }
          }else{
            return response()->json([
                      'data'=>null,
                      'success' => 'false',
                      'message'=>"User Not Found"
                  ],200);
          }   
      }else{
        return response()->json([
                      'data'=>null,
                      'success' => 'false',
                      'message'=>"Id Required"
                  ],200);
      }
    }


    public function rejectRequest(Request $request){

        if(!empty($this->current_request->id)){
            $req_user = \Signal\Models\User::find($this->current_user->id);
            if(!empty($req_user)){

                $check_friend = \Signal\Models\Friend::where([
                    ['first_user' ,'=' ,$this->current_user->id],
                    ['second_user'  ,'=' , $request->id]])
                    ->orWhere([
                        ['first_user' ,'=' ,$request->id],
                        ['second_user' ,'=' ,$this->current_user->id]
                    ])->first();



                if(!empty($check_friend)){
                  $check_friend->status = "rejected";
                  $check_friend->save();

                  return response()->json([
                      'data'=>null,
                      'success' => 'true',
                      'message'=>"Rejected"
                  ],200);
                }else{
                   return response()->json([
                      'data'=>null,
                      'success' => 'false',
                      'message'=>"Not Found"
                  ],200);
                }
          }else{
            return response()->json([
                      'data'=>null,
                      'success' => 'false',
                      'message'=>"User Not Found"
                  ],200);
          }   
      }else{
        return response()->json([
                      'data'=>null,
                      'success' => 'false',
                      'message'=>"Id Required"
                  ],200);
      }
    }

    


}
