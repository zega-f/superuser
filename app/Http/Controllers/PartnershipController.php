<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use DB;

class PartnershipController extends Controller
{
    public function index(Request $request)
    {
        $partnership = DB::table('partnership')
    	->get();

        return view('partnership.partnership',compact('partnership'));
    }

    
    public function delete_partnership(Request $request)
    {
        $delete_partnership = \DB::table('partnership')
        ->where(
            'id',$request->id)->delete();
      
        $partnership = DB::table('partnership')
        ->get();

        return view('partnership.table_partnership', compact('partnership'));

    }

}
