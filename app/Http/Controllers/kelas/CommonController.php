<?php

namespace App\Http\Controllers\kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CommonController extends Controller
{
    public function get_all_kelas(Request $request)
    {
    	$all_kelas = DB::table('kelas')
    	->where('room_name','like', '%' . $request->keyword . '%')
    	->get();

    	if ($request->keyword==null) {
    		return response('fail');
    	}else{
    		return view('muatan.common.all_kelas_list',compact('all_kelas'));
    	}
    } 
}
