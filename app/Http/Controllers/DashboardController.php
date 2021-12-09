<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
use \MacsiDigital\Zoom\Facades\Zoom;

class DashboardController extends Controller
{
    // CEK LOGIN
    function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
    	return view('dashboard');
    }

    // public function createZoom(Request $request)
    // {
    
    //   // $check = DB::table('users')
    //   //   ->where('email','fauzytamimkdr@gmail.com')
    //   //   ->first();
    //   //   $akun=$check->email;
    //   $url = $this->retrieveZoomUrl();
    //   //   $meetings = Zoom::user()->find('fauzytamimkdr@gmail.com')->meetings()->create([
    //   //   'topic' => 'Meeting 1',
    //   //   'duration' => 15, // In minutes, optional
    //   //   'start_time' => new Carbon('2021-03-01 03:00:00'),
    //   //   'timezone' => 'Asia/Jakarta',
    //   // ]);
    //   return [$url];
    // }

    
      

}
