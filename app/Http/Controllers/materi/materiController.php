<?php

namespace App\Http\Controllers\materi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Session;

use DB;

class materiController extends Controller
{
    public function index($id_kelas, $id_mapel)
    {
    	$title = 'Admin - materi';
    	// semua mata pelajaran
    	$all_mapel = DB::table('tblmapel')->get();
    	// semua materi
    	$all_materi = DB::table('coba_materi')->get();
    	// semua kelas
    	$all_kelas = DB::table('kelas')->get();
    	$type = 'common';
    	return view('muatan.materi.index',compact('title','all_mapel','all_materi','all_kelas','type'));
    }

	public function check_video(Request $request)
    {
		$url = $request->id_url;
		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$id_url = $my_array_of_vars['v'];
		// echo $id_url;
        // $id_url=$request->id_url;
        return view('muatan.materi.check_video', compact('id_url'));
    }

    public function store(Request $request)
    {
		$mapel=$request->mapel;
    	$id_materi = Str::random(8);
    	$string_random = Str::random(32);
    	$directory = "public/muatan/materi/";
    	$lampiran_dir = "public/muatan/materi/lampiran/";
    	$file_array = array();

		$url = $request->video;
		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		// echo $my_array_of_vars['v'];
		$video_url = $my_array_of_vars['v'];

		// <iframe width="560" height="315" src="https://www.youtube.com/embed/$my_array_of_vars['v']" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

    	$store_materi = DB::table('coba_materi')
    	->insert([
    		'id_materi'=>$id_materi,
    		'id_kelas'=>$request->kelas,
    		'mapel'=>$mapel,
    		'judul'=>$request->judul,
			'video'=>$video_url,
    	]);

		$cekrow = DB::table('sub_bab')
			->where('bab_id',$request->bab_id)
			->orderBy('sub_id','desc')->first();
		// $id_sub_bab=1;
        if ($cekrow == null) {
           $id_sub_bab=1;
        } else {
            $id_sub_bab = DB::table('sub_bab')
			->where('bab_id',$request->bab_id)
			->orderBy('sub_id','desc')->first()->sub_id+1;
        }


		$store_sub_bab = DB::table('sub_bab')
    	->insert([
    		'room_id'=>$request->kelas,
    		'bab_id'=>$request->bab_id,
			'mapel'=>$mapel,
			'sub_id'=>$id_sub_bab,
    		'type'=>'materi',
    		'type_id'=>$id_materi,
    	]);

    	$json_content = array(
            'id_materi' => $id_materi,
            'judul'=>$request->judul,
            'konten' => $request->konten,
			'video' => $request->video,
        );

        $text = json_encode($json_content);

        $myfile = fopen($directory.$id_materi.'.json', "w");
        fwrite($myfile, $text);

        if ($request->attachment) {
        	for ($i=0; $i <count($request->attachment) ; $i++) { 
	    		$file_array[] = array(
	    			'materi_id'=>$id_materi,
	    			'attachment_name'=>$string_random.$request->attachment[$i]->getClientOriginalName(),
	    			'attachment_original_name'=>$request->attachment[$i]->getClientOriginalName(),
	    		);
	    		$request->attachment[$i]->move($lampiran_dir,$string_random.$request->attachment[$i]->getClientOriginalName());
	     	}

	     	$store_lampiran = DB::table('coba_materi_lampiran')
	        ->insert($file_array);
        }
		Session::flash('simpan_materi', 'Berhasil Menambahkan Materi');
		if ($mapel==null)
		return redirect('kelola_kursus/'.$request->kelas);
		else
		return redirect('kelola_mapelkelas/'.$request->kelas.'/'.$request->mapel);
     	// return back();
    }

    public function edit($materi_id)
    {
        $this_materi = DB::table('coba_materi')
        ->join('db_jenjang','coba_materi.id_kelas','=','db_jenjang.tingkat')
		// ->join('mapel_kelas', 'coba_materi.mapel_id', '=', 'mapel_kelas.id_mapel_kelas')
        // ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')

        ->join('tblmapel','coba_materi.mapel','=','tblmapel.id_mapel')
        ->select('coba_materi.*','tblmapel.nama','db_jenjang.tingkat')
    	->where('coba_materi.id_materi',$materi_id)
    	->first();

    	$this_materi_lampiran = DB::table('coba_materi_lampiran')
    	->where([
    		['materi_id',$materi_id]
    	])
    	->get();

    	$this_class_mapel = DB::table('mapel_kelas')
    	->join('tblmapel','mapel_kelas.mapel','=','tblmapel.id_mapel')
    	->select('mapel_kelas.*','tblmapel.nama')
    	->where([
    		['mapel_kelas.tingkat',$this_materi->tingkat],
    		['mapel_kelas.mapel','!=',$this_materi->mapel]
    	])
    	->get();

    	// $all_kelas = DB::table('kelas')///
    	// ->where('tingkat','!=',$this_materi->tingkat)
    	// ->get();

    	$type = 'edit';


		// return view('kelola_mapel.materi.edit_form_materi');

    	return view('muatan.materi.edit_materi',compact('this_materi','this_class_mapel','this_materi_lampiran','type'));
    }

    public function update(Request $request, $id_materi,$tingkat,$mapel)
    {
        $string_random = Str::random(32);
        $directory = "public/muatan/materi/";
        $lampiran_dir = "public/muatan/materi/lampiran/";
        $file_array = array();

		$url = $request->video;
		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		// echo $my_array_of_vars['v'];
		$video_url = $my_array_of_vars['v'];

        $store_materi = DB::table('coba_materi')
        ->where('id_materi',$id_materi)
        ->update([
            // 'id_kelas'=>$request->kelas,
            'video'=>$video_url,
            'judul'=>$request->judul,
        ]);

        $json_content = array(
            'id_materi' => $id_materi,
            'judul'=>$request->judul,
            'konten' => $request->konten,
			'video'=>$video_url,
        );

        $text = json_encode($json_content);

        $myfile = fopen($directory.$id_materi.'.json', "w");
        fwrite($myfile, $text);

        if ($request->attachment) {
            for ($i=0; $i <count($request->attachment) ; $i++) { 
                $file_array[] = array(
                    'materi_id'=>$id_materi,
                    'attachment_name'=>$string_random.$request->attachment[$i]->getClientOriginalName(),
                    'attachment_original_name'=>$request->attachment[$i]->getClientOriginalName(),
                );
                $request->attachment[$i]->move($lampiran_dir,$string_random.$request->attachment[$i]->getClientOriginalName());
            }

            $store_lampiran = DB::table('coba_materi_lampiran')
            ->insert($file_array);
        }

        $save_to_history = DB::table('coba_materi_history')
        ->insert([
            'updated_by'=>'user',
            'materi_id'=>$id_materi,
        ]);
			Session::flash('update_materi', 'Berhasil MengUpdate Materi');
			return redirect('kelola_mapelkelas/'.$tingkat.'/'.$mapel);
        // return back();
    }

    public function delete_materi(Request $request)
    {
    	$this_materi = DB::table('coba_materi')
    	->where([
    		['id_materi',$request->id_materi]
    	])
    	->first();

		
    	$all_lampiran = DB::table('coba_materi_lampiran')
    	->where([
    		['materi_id',$request->id_materi]
    	])
    	->get();

    	foreach ($all_lampiran as $lampiran) {
    		if (File::exists('public/muatan/materi/lampiran/'.$lampiran->attachment_name)) {
    			File::delete('public/muatan/materi/lampiran/'.$lampiran->attachment_name);
    		}
    	}

    	if (File::exists('public/muatan/materi/'.$request->id_materi.'.json')) {
    		File::delete('public/muatan/materi/'.$request->id_materi.'.json');
    	}

    	$delete_lampiran = DB::table('coba_materi_lampiran')
    	->where([
    		['materi_id',$request->id_materi]
    	])
    	->delete();

        $delete_materi = DB::table('coba_materi')
        ->where([
            ['id_materi',$request->id_materi]
        ])
        ->delete();

		$delete_sub = DB::table('sub_bab')
        ->where([
            ['type_id',$request->id_materi]
        ])
        ->delete();

        
		$idbab = $request->bab;
		Session::flash('delete_materi', 'Berhasil Menghapus Materi');
		return view('kelola_mapel.index',compact('idbab'));
        // return view('muatan.materi.component.all_materi_comp');
		// if ($request->mapel==null)
		// return redirect('kursus.kelola_kursus',compact('idbab'));
		// else
		// return view('kelola_mapel.index',compact('idbab'));
    }
}
