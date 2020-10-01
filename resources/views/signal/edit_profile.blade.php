@extends('signal.layout')

@section('content')

<div class="container" >

    <div class="registration-form col-md-12 " style=" margin-top: 10vh;">
      <div ><h4>Edit Profile</h4></div>
        <form method="post" class="reg-form"  enctype='multipart/form-data'>
            
            {{ csrf_field() }}
            <div class="row" style="justify-content: center; padding: 2vh;">
                <span>
                    <img class="mob-logo " src="/logo.png" width="180px"  alt="Logo">
      
            </div>
            @if(\Session::has('error_message'))
           <div class=" alert alert-danger">{{\Session::get('error_message')}}</div>
             @endif
             @if(\Session::has('success_message'))
                   <div class=" alert alert-success" >{{\Session::get('success_message')}}</div>
             @endif
             <div class="row col-md-12">
             <div class="col-md-6">
                  <div class="form-group">
                <input type="text" class="form-control item" id="fullname" name="fullname" placeholder="Full Name" value="{{$current_user->name}}" required="">
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" id="email" name="email" placeholder="Email" value="{{$current_user->email}}" required="">
            </div>
      
             </div>
             <div class="col-md-6">
                 <!-- <div class="form-group">
                <input type="password" class="form-control item" id="password" name="password" placeholder="Password" >
            </div> -->
           <!--  <div class="form-group">
                <input type="password" class="form-control item" id="confirm_password" name="confirm_password"placeholder="Confirm Password" >
            </div> -->
            
      <div class="custom-file item">
  <input type="file" class="custom-file-input" id="customFile" name="image">
  <label class="custom-file-label" for="customFile">Upload Profile Image</label>
</div>
        <div class="row col-md-12 form-group" >
       <div class="form-check">
  <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="0" @if($current_user->gender == \Signal\Models\User::GENDER_MALE) checked @endif >
  <label class="form-check-label" for="exampleRadios1" >
    Male
  </label>
</div>
<div class="form-check" style="margin-left: 2vh;">
  <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="1" @if($current_user->gender == \Signal\Models\User::GENDER_FEMALE) checked @endif>
  <label class="form-check-label" for="exampleRadios2">
    Female
  </label>
</div>
</div>
            <button type="submit" class="btn create-account" style="float: right;">Update Profile</button>
             </div>
            
        </div>
         </div>
           
            
            
         
            
        </form>
     
    </div>
</div>
@endsection
