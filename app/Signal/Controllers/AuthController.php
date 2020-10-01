<?php

namespace Signal\Controllers;

use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class AuthController extends Controller
{
    public function __construct(){
    	parent::__construct();
    }

    public function getRegister(){

    	$this->data['seo']['title'] = "Register Here";
    	return view('signal.registration',$this->data);

    }

    public function postRegister(Request $request){

    	$validator = Validator::make($this->current_request->all(), [
		    'email' => 'required|email|string',
		    'fullname' => 'required|string',
		    'gender' => 'required',
		    'password' => 'required',
		    'confirm_password' => 'required',
		   ],

		   [
		    'email.required'=>'Email Required',
		    'fullname.required'=>'Full Name Required',
		    'gender.required'=>'Gender Required',
		    'password.required'=>'Password Required',
		    'confirm_password.required'=>'Confirm Password Required',
		    'email.email'=>"Email must be a valid Email"
		  ]);

	    if ($validator->fails()){
	      $messages = $validator->messages()->first();
	      Session::flash('error_message', $messages);
	      return \Redirect::back();

	    }

	    if($this->current_request->password != $this->current_request->confirm_password){
	      Session::flash('error_message', 'Password Mismatch');
	      return \Redirect::back();
	    }

    	$user = \Signal\Models\User::where('email',$this->current_request->email)->first();
    	if(!empty($user)){
    		Session::flash('error_message', 'Already have an account, Please login ');
	      	return \Redirect::back();
    	}

    	$user = new \Signal\Models\User();
	    $user->name = $this->current_request->fullname;
	    $user->email = $this->current_request->email;
	    $user->gender = $this->current_request->gender;
	    $user->status = \Signal\Models\User::STATUS_ACTIVE;
	    $user->password = \Hash::make($this->current_request->confirm_password);

	    if(!empty($this->current_request->image)){
           $pic_name = 'profile_pic'.time().".".$this->current_request->image->getClientOriginalExtension();
           $this->current_request->image->move(storage_path('app/public/user-pic/'), $pic_name);
           $user->profile_image = $pic_name;

        }
	    $user->save();
	    \Auth::login($user);
	    return redirect('/dashboard');



    }

    public function logout(Request $request){

        $user = \Auth::user();
        if(!empty($user)){
            \Auth::logout();
        }
        
        return redirect(url('/'));

    }

    public function login(Request $request){

        $validator = Validator::make($this->current_request->all(), [
		    'email' => 'required|email|string',
		    'password' => 'required',
		   ],

		   [
		    'email.required'=>'Email Required',
		    'password.required'=>'Password Required',
		    'email.email'=>"Email must be a valid Email"
		  ]);

	    if ($validator->fails()){
	      $messages = $validator->messages()->first();
	      Session::flash('error_message', $messages);
	      return \Redirect::back();

	    }

	    if(\Auth::attempt(['email'=>$this->current_request->email,'password'=>$this->current_request->password])){
            \Auth::login(\Auth::user(),true);
            return redirect('/dashboard');
    	} else {
    		Session::flash('error_message', 'Incorrect Credential');
	      	return \Redirect::back();
    	}
	    

    }

    public function getEditProfile(){

      $this->data['seo']['title'] = "Edit Profile";
      return view('signal.edit_profile',$this->data);

    }

    public function postEditProfile(Request $request){
      
       $validator = Validator::make($this->current_request->all(), [
		    'email' => 'required|email|string',
		    'fullname' => 'required',
		    'gender' => 'required',
		   ],

		   [
		    'email.required'=>'Email Required',
		    'gender.required'=>'Gender Required',
		    'fullname.required'=>'Full Name Required',
		    'email.email'=>"Email must be a valid Email"
		  ]);

	    if ($validator->fails()){
	      $messages = $validator->messages()->first();
	      Session::flash('error_message', $messages);
	      return \Redirect::back();

	    }

	    $user = \Signal\Models\User::where('email',$this->current_request->email)->where('id', '!=',$this->current_user->id)->first();

    	if(!empty($user)){
    		Session::flash('error_message', 'Email Registered with some other account ');
	      	return \Redirect::back();
    	}


	    $this->current_user->name = $this->current_request->fullname;
	    $this->current_user->email = $this->current_request->email;
	    $this->current_user->gender = $this->current_request->gender;

	    if(!empty($this->current_request->image)){
           $pic_name = 'profile_pic'.time().".".$this->current_request->image->getClientOriginalExtension();
           $this->current_request->image->move(storage_path('app/public/user-pic/'), $pic_name);
           $this->current_user->profile_image = $pic_name;

        }
	    $this->current_user->save();
	    Session::flash('success_message', 'Profile Details Updated');
	    return \Redirect::back();

    }


}
