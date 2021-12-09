<?php

namespace App\Http\Controllers\tugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use DB;

class subTugasController extends Controller
{
    public function preview_tugas($tugas_id)
    {
    	$this_tugas = DB::table('coba_tugas')
    	->where('id_tugas',$tugas_id)
    	->first();

    	$this_tugas_lampiran = DB::table('coba_tugas_lampiran')
    	->where([
    		['tugas_id',$tugas_id]
    	])
    	->get();

    	return view('muatan.tugas.preview_tugas',compact('this_tugas','this_tugas_lampiran'));
    }

    public function delete_file(Request $request)
    {
    	$this_lampiran = DB::table('coba_tugas_lampiran')
    	->where([
    		['id',$request->lampiran_id]
    	])
    	->first();

    	if (File::exists('public/muatan/tugas/lampiran/'.$this_lampiran->attachment_name)) {
    		File::delete('public/muatan/tugas/lampiran/'.$this_lampiran->attachment_name);
    	}

    	// $delete_lampiran = DB::table('coba_tugas_lampiran')
    	// ->where([
    	// 	['id',$request->lampiran_id]
    	// ])
    	// ->delete();
    }
}
