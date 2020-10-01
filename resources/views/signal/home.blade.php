@extends('signal.layout')

@section('content')
    <div class="row" style="background: #5bc0de; min-height: 90vh;">
    <div class="banner col-md-6 side-content">
        <div class="container" >
            <h1>Speak Freely</h1>
            <p>Say "hello" to a different messaging experience. An unexepected focus on privacy, combined with all of the feature you expect </p>
            <!-- <a href="#content" class="button button-primary">Learn More</a> -->
        </div>
    </div>
    <div class="col-md-6 banner log-co">
    
         <div class="card">
             
                <form class="box" method="post">
                    {{ csrf_field() }}
                     @if(\Session::has('error_message'))
           <div class=" alert alert-danger">{{\Session::get('error_message')}}</div>
             @endif
             @if(\Session::has('success_message'))
                   <div class=" alert alert-success" >{{\Session::get('success_message')}}</div>
             @endif
                    <h1>Login</h1>
                    <p class="text-muted login-text"> Please enter your login and password!</p> 
                    <input type="text" name="email" placeholder="Email"> 
                    <input type="password" name="password" placeholder="Password">  
                    <button type="submit" class="btn btn-success"  href="#">Login</button>
                   
                </form>
            </div>


    </div>
</div>
@endsection
