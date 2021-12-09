<?php

namespace App\Http\Controllers\materi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use DB;

class subMateriController extends Controller
{
	public function show($materi_id)
    {
    	$title = 'Preview materi';

    	$this_materi = DB::table('coba_materi')
    	->where('id_materi',$materi_id)
    	->first();

    	$this_materi_lampiran = DB::table('coba_materi_lampiran')
    	->where([
    		['materi_id',$materi_id]
    	])
    	->get();

    	return view('muatan.materi.preview_materi',compact('this_materi','this_materi_lampiran','title'));
    }

    public function check_mapel(Request $request)
    {
    	$type = $request->type;

    	switch ($type) {
    		case 'edit':
	    		$this_materi = DB::table('coba_materi')
		        ->join('kelas','coba_materi.id_kelas','=','kelas.tingkat')
		        ->join('tblmapel','coba_materi.mapel','=','tblmapel.id_mapel')
		        ->select('coba_materi.*','tblmapel.nama','kelas.tingkat')
		    	->where('coba_materi.id_materi',$request->materi_id)
		    	->first();

    			$this_class_mapel = DB::table('mapel_kelas')
		    	->join('tblmapel','mapel_kelas.mapel','=','tblmapel.id_mapel')
		    	->select('mapel_kelas.*','tblmapel.nama')
		    	->where([
		    		['mapel_kelas.tingkat',$request->id_kelas],
		    	])
		    	->get();

		    	return view('muatan.materi.component.all_mapel_comp',compact('this_class_mapel','type','this_materi'));
		    	// echo $request->materi_id;
    			break;
    		case 'xhr':
    			$this_class_mapel = DB::table('mapel_kelas')
		    	->join('tblmapel','mapel_kelas.mapel','=','tblmapel.id_mapel')
		    	->select('mapel_kelas.*','tblmapel.nama')
		    	->where([
		    		['mapel_kelas.kelas',$request->id_kelas],
		    	])
		    	->get();
		    	return view('muatan.materi.component.all_mapel_comp',compact('this_class_mapel','type',));
    			break;
    		default:
    			return response('fail');
    			break;
    	}
    }

    public function delete_file(Request $request)
    {
    	$this_lampiran = DB::table('coba_materi_lampiran')
    	->where([
    		['id',$request->lampiran_id]
    	])
    	->first();

    	if (File::exists('materi/lampiran/'.$this_lampiran->attachment_name)) {
    		File::delete('materi/lampiran/'.$this_lampiran->attachment_name);
    	}

    	$delete_lampiran = DB::table('coba_materi_lampiran')
    	->where([
    		['id',$request->lampiran_id]
    	])
    	->delete();
    }
}
