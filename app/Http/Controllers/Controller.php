<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $data=[];
    public $current_user=[];
    public $current_request=[];

    function __construct()
    {
    	 
        $this->data = [];
        $this->data['y'] = date('Y');
    	$this->data['seo']['title'] = "Signal";
        $this->data['current_user'] = null;
        $this->middleware(function ($request, $next) {
            $this->data['current_user'] = \Auth::user();
            $this->current_user = \Auth::user();
            $this->current_request = $request;
            return $next($request);
        });
         
    }
}
