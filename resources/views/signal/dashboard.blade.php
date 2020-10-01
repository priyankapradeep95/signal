@extends('signal.layout')

@section('content')
<div class="container prod-co">
<div class="row col-md-12">
<div class="profile">
   <div class="profile-header">
     
      <div class="profile-header-cover"></div>
  
      <div class="profile-header-content">
      
         <div class="profile-header-img">

            <img class="user-img" @if($current_user->profile_image) src="{{ asset('storage/user-pic/'.$current_user->profile_image) }}" @else src="/default_user.png" @endif alt="">
         </div>
     
         <div class="profile-header-info">
            <h4 class="m-t-10 m-b-5">{{$current_user->name}}</h4>
            <p class="m-b-10">{{$current_user->email}}</p>
            
           @if($friends_count > 0) <p class="frndCnt">{{$friends_count}} Friends</p> @endif
           <a href="/edit-profile" class="btn btn-xs btn-yellow edit-pro"><i class="fa fa-edit"></i> Edit Profile</a>
         </div>
         
      </div>
     

   </div>
</div>
</div>
<div class="row col-md-12">


@if($requested)
@foreach($requested as $friend)
 @include('signal.friend_card', array('friend'=>$friend))
@endforeach
@endif
@if($friends)
@foreach($friends as $frnd)
 @include('signal.friend_card', array('friend'=>$frnd))
@endforeach
@endif

@if($non_friends)
@foreach($non_friends as $non)
 @include('signal.friend_card', array('friend'=>$non))
@endforeach
@endif





</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    
  });

  function sendRequest($id){
    console.log($id);
    var id = $id;
    var url = '/send-request';
     $.ajax({
        type: "POST",
        url: url,
        data: {'_token':"{{ csrf_token() }}",'id':id},
        dataType: 'JSON',
        success: function (data) { 

            if(data.success== 'false'){
                alert(data.message);
            }else{
                $("#add"+id).hide();
                $("#msg"+id).html("<p class='blue-color'>Request Sent</p>");
                $("#msg"+id).show();
            }
        },
        error:function(data){
    
        }
      });
  }

  function deleteRequest($id){
    console.log($id);
    var id = $id;
    var url = '/reject-request';
     $.ajax({
        type: "POST",
        url: url,
        data: {'_token':"{{ csrf_token() }}",'id':id},
        dataType: 'JSON',
        success: function (data) { 
            
            if(data.success== 'false'){
                alert(data.message);
            }else{
                $("#approve"+$id).hide();
                $("#msg"+id).html("<p class='green-color'>Rejected</p>");
                $("#msg"+id).show();
            }
        },
        error:function(data){
    
        }
      });
  }

  function approveRequest($id){
    console.log($id);
    var id = $id;
    var url = '/approve-request';
     $.ajax({
        type: "POST",
        url: url,
        data: {'_token':"{{ csrf_token() }}",'id':id},
        dataType: 'JSON',
        success: function (data) { 
            
            if(data.success== 'false'){
                alert(data.message);
            }else{
                $("#approve"+$id).hide();
                $("#msg"+id).html("<p class='green-color'><i class='fa fa-check'></i> Friends</p>");
                $("#msg"+id).show();
            }
        },
        error:function(data){
    
        }
      });
  }
</script>
@endsection