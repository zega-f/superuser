<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use DB;

class MapelController extends Controller
{
    //akses
    function __construct()
    {
        $this->middleware('admin');
    }

    
    //all kelas di dalamnya ada mapel
    public function kelola_mapel()
    {
        $sd = DB::table('db_jenjang')
        ->where('jenjang','1')
        ->get();

        $smp = DB::table('db_jenjang')
        ->where('jenjang','2')
        ->get();

        $sma = DB::table('db_jenjang')
        ->where('jenjang','3')
        ->get();

    	return view('mapel.kelola_mapel',compact('sd','smp','sma'));
    }


    //data mapel in kelas
    public function mapel_kelas($jenjang,$tingkat)
    {
        $kelas = DB::table('db_jenjang')
        ->where('jenjang',$jenjang)
        ->where('tingkat',$tingkat)
        ->get();

        $regis = DB::table('db_jenjang')
        ->where('jenjang',$jenjang)
        ->where('tingkat',$tingkat)
        ->first();

        $mapel_kelas = DB::table('mapel_kelas')
        ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
        ->select('mapel_kelas.*', 'tblmapel.nama','tblmapel.id_mapel')
        ->where('mapel_kelas.jenjang',$jenjang)
        ->where('mapel_kelas.tingkat',$tingkat)
        ->get();

    	return view('mapel.mapel_kelas',compact('kelas','mapel_kelas','jenjang','tingkat','regis'));
    }


    public function registrasi_kelas(Request $request)
    {
        $registrasi = DB::table('db_jenjang')
        ->where(
            'id',$request->tingkat,
        )
        ->update([
            'registrasi'=>$request->registrasi,
        ]);
        
        Session::flash('registrasi', 'Berhasil Menambahkan Biaya Registrasi');
        return back();
    }


    public function mapel_tingkat_non_aktif(Request $request)
    {
        $non_aktif = DB::table('db_jenjang')
        ->where(
            'id',$request->tingkat,
        )
        ->update([
            'status'=>'0',
        ]);
    }
    

    public function mapel_tingkat_aktif(Request $request)
    {
        $aktif = DB::table('db_jenjang')
        ->where(
            'id',$request->tingkat,
        )
        ->update([
            'status'=>'1',
        ]);
    }


    //add mapel to kelas
    public function mapelkelas_store(Request $request)
    {
        $cek_mapel = DB::table('tblmapel')
        ->where('id_mapel',$request->mapel_name)
        ->first();

        $cekrow = DB::table('mapel_kelas')->count();
        $id_mkelas = 1;

        if ($cekrow == 0) {
            DB::table('mapel_kelas')->truncate();
        } else {
            $id_mkelas = DB::table('mapel_kelas')->orderBy('id', 'desc')->first()->id+1;
        }

        $id_mapel_kelas=$cek_mapel->inisial.'-'.$request->tingkat.'-'.$id_mkelas;
        echo $id_mapel_kelas;
        $check = DB::table('mapel_kelas')
        ->where([
            ['tingkat',$request->tingkat],
            ['mapel',$request->mapel_name],
        ])
        ->count();

        if ($check==0) {

            $store = DB::table('mapel_kelas')
            ->insert([
                'jenjang'=>$request->jenjang,
                'tingkat'=>$request->tingkat,
                'mapel'=>$request->mapel_name,
                'harga'=>$request->harga,
                'id_mapel_kelas' => $id_mapel_kelas,
                'deskripsi'=>$request->deskripsi,
            ]);
            
            if ($store != null) {
                Session::flash('add_mapel_kelas', 'Berhasil Menambahkan Mapel pada tingkat ini');
                // return back()->with('add_mapel_kelas', 'Berhasil Menambahkan Mapel pada tingkat ini');
                return redirect('mapel_kelas/'.$request->jenjang.'/'.$request->tingkat);
            }

        } else {
            return redirect('mapel_kelas/'.$request->jenjang.'/'.$request->tingkat)->with('gagal_mapel_kelas', "Gagal Menambahkan Mapel, ".$cek_mapel->nama." sudah ada");;
        }
    }


    //edit mapel in kelas
    public function update_mapel_kelas(Request $request, $id)
    {
	    DB::table('mapel_kelas')->where('id',$request->id)
        ->update([
           
		    'mapel' => $request->nama,
            'harga' => $request->harga,
            'deskripsi'=>$request->deskripsi,
	    ]);
        Session::flash('update_mapel_kelas', 'Berhasil MengUpdate Mapel pada tingkat ini');
	    return back();
    }

    
    //hapus mapel in kelas
    public function delete_mapel_kelas(Request $request)
    {
        $del_kelolakelas = \DB::table('mapel_kelas')
        ->where(
            'id',$request->id_kelas)->delete();

        $mapel_kelas = DB::table('mapel_kelas')
                    ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
                    ->select('mapel_kelas.*', 'tblmapel.nama','tblmapel.id_mapel')
                    ->where('mapel_kelas.tingkat',$request->tingkat)
                    ->get();

        Session::flash('delete_mapel_kelas', 'Berhasil Menghapus Mapel pada tingkat ini');
        return view('mapel.tabel_kelola_mapel', compact('mapel_kelas'));
    }





///////////////////////////////////////////////////////////////////////////////////////////////

  
    public function delete_mapel_pengajar(Request $request)
    {
        $del_mapel_pengajar = \DB::table('mapel_pengajar')
        ->where(
            'id',$request->id_mapel)->delete();
            
            $pengajar_mapel = DB::table('mapel_pengajar')
            ->join('tblmapel', 'mapel_pengajar.id_mapel', '=', 'tblmapel.id_mapel')
            ->join('users', 'mapel_pengajar.id_pengajar', '=', 'users.partner_id')
            ->select('mapel_pengajar.*', 'tblmapel.nama as mapel','users.name as pengajar')
            ->where('users.partner_type','1')
            ->where('users.partner_id',$request->id_pengajar)
            ->get();
        return view('mapel.tabel_pengajar_mapel', compact('pengajar_mapel'));

    }


    public function pengajar_mapel()
    {
        $pengajar_mapel = DB::table('mapel_pengajar')
        ->join('tblmapel', 'mapel_pengajar.id_mapel', '=', 'tblmapel.id_mapel')
        ->join('users', 'mapel_pengajar.id_pengajar', '=', 'users.partner_id')
        ->select('mapel_pengajar.*', 'tblmapel.nama as mapel','users.name as pengajar')
        ->where('users.partner_type','1')
        ->get();
    	return view('mapel.pengajar_mapel',compact('pengajar_mapel'));
    }

    
    public function pengajar_mapel_store(Request $request)
    {
        $cekrow = DB::table('mapel_pengajar')->count();
        $id_mapel_pengajar = 1;

        if ($cekrow == 0) {
            DB::table('mapel_pengajar')->truncate();
        } else {
            $id_mapel_pengajar = DB::table('mapel_pengajar')->orderBy('id', 'desc')->first()->id+1;
        }

    
        $store = DB::table('mapel_pengajar')
        ->insert([
            'id_pengajar'      =>  $request->pengajar,
            'id_mapel'  =>  $request->mapel,
            'id_mapel_pengajar' => $id_mapel_pengajar,
        ]);

        if ($store) {
            Session::flash('add_mapel_pengajar', 'Berhasil Menambahkan Mapel Pengajar');
            return back();
        }else{
            return redirect()->route('pengajar')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }



    /////////////////////////////////////////////////////////////////
    public function kelola_mapel_kelas($tingkat,$mapel)
    {
        $bab_materi = DB::table('bab')
        ->where('bab.room_id',$tingkat)
        ->where('bab.mapel',$mapel)
        ->get();

        echo "string";

        // $sub_bab = DB::table('sub_bab')
        // ->join('bab','bab.id','=','sub_bab.bab_id')
        // ->where('bab.room_id',$tingkat)
        // ->where('bab.mapel',$mapel)
        // ->orderBy()
        // ->get();

        $nm_kelas = DB::table('db_jenjang')
            ->where('tingkat',$tingkat)
            ->first();

        $nm_mapel = DB::table('mapel_kelas')
            ->join('tblmapel','mapel_kelas.mapel','=','tblmapel.id_mapel')
              ->where('mapel_kelas.id_mapel_kelas',$mapel)
              ->select('tblmapel.*','mapel_kelas.id_mapel_kelas') 
              ->first();
      
    	// return view('kelola_mapel.index',compact('bab_materi','nm_kelas','nm_mapel','tingkat','mapel'));
    }



    public function bab_store(Request $request)
    {
        $cekrow = DB::table('bab')->count();
        $id_bab = 1;

        if ($cekrow == 0) {
            DB::table('bab')->truncate();
        } else {
            $id_bab = DB::table('bab')->orderBy('id', 'desc')->first()->id+1;
        }

        $store = DB::table('bab')
        ->insert([
            'room_id'      =>  $request->tingkat,
            'mapel'        =>  $request->mapel,
            'bab_name'     => $request->bab_name,
            'id_bab'     =>    $id_bab,
            'type'     => 'kelas',
        ]);

        if ($store) {
            Session::flash('tambah_bab', 'Berhasil Menambahkan Bab');
            return back();
        }else{
            Session::flash('gagal_bab', 'Gagal Menambahkan Bab');
            return back();
        }
    }



    public function delete_bab(Request $request)
    {
        $materi1 = \DB::table('sub_bab')
        ->where('bab_id',$request->id)
        ->where('type','materi')
        ->first();
        // $materi=$materi1->type_id;
        ($materi1==null ? @$materi==0 : @$materi=$materi1->type_id);

        $tugas1 = \DB::table('sub_bab')
        ->where('bab_id',$request->id)
        ->where('type','tugas')
        ->first();
        // $tugas=$tugas1->type_id;
        ($tugas1==null ? @$tugas==0 : @$tugas=$tugas1->type_id);

        $quiz1 = \DB::table('sub_bab')
        ->where('bab_id',$request->id)
        ->where('type','quiz')
        ->first();
        // $quiz=$quiz1->type_id;
        ($quiz1==null ? @$quiz==0 : @$quiz1=$quiz1->type_id);
    
        ///////////////

       

        $delete_bab = \DB::table('bab')
        ->where('id',$request->id)->delete();
        
        $delete_sub = \DB::table('sub_bab')
        ->where('bab_id',$request->id)->delete();
        ///

        $delete_materi = \DB::table('coba_materi')
        ->where('id_materi',@$materi)
        ->delete();

        $all_lampiran = DB::table('coba_materi_lampiran')
    	->where([
    		['materi_id',@$materi]
    	])
    	->get();

    	foreach ($all_lampiran as $lampiran) {
    		if (File::exists('public/muatan/materi/lampiran/'.$lampiran->attachment_name)) {
    			File::delete('public/muatan/materi/lampiran/'.$lampiran->attachment_name);
    		}
    	}

    	if (File::exists('public/muatan/materi/'.@$materi.'.json')) {
    		File::delete('public/muatan/materi/'.@$materi.'.json');
    	}

    	$delete_lampiran = DB::table('coba_materi_lampiran')
    	->where([
    		['materi_id',@$materi]
    	])
    	->delete();

        //////////////////


        $all_lampiran1 = DB::table('coba_tugas_lampiran')
        ->where([
            ['tugas_id',@$tugas]
        ])
        ->get();

        foreach ($all_lampiran1 as $lampiran1) {
            if (File::exists('public/muatan/tugas/lampiran/'.$lampiran1->attachment_name)) {
                File::delete('public/muatan/tugas/lampiran/'.$lampiran1->attachment_name);
            }
        }

        if (File::exists('public/muatan/tugas/'.@$tugas.'.json')) {
            File::delete('public/muatan/tugas/'.@$tugas.'.json');
        }

        $delete_lampiran1 = DB::table('coba_tugas_lampiran')
        ->where([
            ['tugas_id',@$tugas]
        ])
        ->delete();

        $delete_tugas = \DB::table('coba_tugas')
        ->where('id_tugas',@$tugas)->delete();

        ////////////////////////////

        $delete_quiz = \DB::table('quiz')
        ->where('quiz_id',@$quiz)->delete();

        $del_question = \DB::table('quiz_question')
        ->where(
            'quiz_id',@$quiz)->delete();

        $del_option = \DB::table('quiz_option')
        ->where(
            'quiz_id',@$quiz)->delete();
        
            $delete_sub = DB::table('sub_bab')
            ->where([
                ['type_id',@$quiz]
            ])
            ->delete();
            Session::flash('hapus_bab', 'Berhasil Menghapus Bab');
        return back();
    }


    public function update_bab(Request $request)
    {
	    DB::table('bab')->where('id',$request->id)
        ->update([
		    'bab_name' => $request->nama,
	    ]);
        Session::flash('update_bab', 'Berhasil MengUpdate Bab');
	    return back();
    }
   
}
