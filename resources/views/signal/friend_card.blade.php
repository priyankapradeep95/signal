<div class="col-md-6">
	  <div class="people-nearby">
	 <div class="nearby-user">
                <div class="row">
                  <div class="col-md-2 col-sm-2">
                    <img src="{{$friend['profile_image']}}" alt="user" class="profile-photo-lg">
                  </div>
                  <div class="col-md-7 col-sm-7">
                    <h5>{{$friend['name']}}</h5>
                    <p class="email-txt text-muted">{{$friend['email']}}</p>  
                   
                  </div>
                  <div class="col-md-3 col-sm-3">
                  	@if($friend['is_friend'] == "no")
                    <button class="btn btn-sm btn-primary pull-right" id="add{{$friend['id']}}" onclick="sendRequest({{$friend['id']}})">Add Friend</button>

                    @endif

                    @if($friend['is_friend'] == "yes")
                    <span >@if($friend['status'] == "confirmed") 
                    	<p class="green-color"><i class='fa fa-check'></i> Friends</p>
                    	 @endif</span>
                     @if($friend['status'] == "pending") 
                    	@if($friend['requester'] == "yes")<p class="blue-color">Request Sent</p>
                    	@else 
                    	<div id="approve{{$friend['id']}}">
                    	<button class="btn btn-sm btn-warning pull-right" onclick="approveRequest({{$friend['id']}})">Confirm</button> 
                    	<button class="btn btn-sm btn-secondary pull-right second-btn" onclick="deleteRequest({{$friend['id']}})">Not Now</button> </div>

                    	@endif 
                    @endif
                    @endif
                    <div id="msg{{$friend['id']}}" style="display: none;"></div>
                  </div>
                </div>
              </div>
          </div>
      </div>