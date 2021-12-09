<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use DB;

class MasterController extends Controller
{
    // CEK LOGIN
    function __construct()
    {
        $this->middleware('admin');
    }
    
    // DATA MASTER MAPEL
    // route:mapel
    public function index()
    {
        $mapel = DB::table('tblmapel')->get();
    	return view('mapel.mapel',compact('mapel'));
    }


    // EDIT MAPEL
    // route:
    public function edit_mapel(Request $request)
    {
        $mapel = DB::table('tblmapel')->get();
    	return view('mapel.mapel',compact('mapel'));
    }

    // TAMBAH MASTER MAPEL
    // route:mapel_store
    public function mapel_store(Request $request)
    {
        $cekrow = DB::table('tblmapel')->count();
        $id_mapel = 1;

        if ($cekrow == 0) {
            DB::table('tblmapel')->truncate();
        } else {
            $id_mapel = DB::table('tblmapel')->orderBy('id', 'desc')->first()->id+1;
        }

    
        $store = DB::table('tblmapel')
        ->insert([
            'nama'      =>  $request->mapel_name,
            'id_mapel'  =>  $id_mapel,
            'inisial'      =>  $request->inisial,
        ]);

        if ($store) {
            Session::flash('add_mapel', 'Berhasil Menambahkan Mapel');
            return redirect()->route('mapel');
        }else{
            return redirect()->route('mapel');
        }

    }

    

    // MAPEL NON AKTIF
    // route:mapel_non_aktif
    public function mapel_non_aktif(Request $request)
    {
        $non_aktif = DB::table('tblmapel')
        ->where(
            'id',$request->id_mapel,
        )
        ->update([
            'aktif'=>'0',
        ]);
    }


    //MAPEL AKTIF
     // route:mapel_aktif
    public function mapel_aktif(Request $request)
    {
        $aktif = DB::table('tblmapel')
        ->where(
            'id',$request->id_mapel,
        )
        ->update([
            'aktif'=>'1',
        ]);
    }
    

    //HAPUS MAPEL
    // route:del_mapel
    public function delete_mapel(Request $request)
    {
        $del_mapel = \DB::table('tblmapel')
        ->where(
            'id',$request->id_mapel)->delete();

        $mapel = DB::table('tblmapel')->get();
        Session::flash('del_mapel', 'Berhasil Menghapus Mapel');
        return view('mapel.tabel_mapel', compact('mapel'));
    }


    // EDIT MAPEL
    // route:update_mapel/{id}
    public function update_mapel(Request $request, $id)
    {
	    DB::table('tblmapel')->where('id',$request->id)->update([
		    'nama' => $request->nama,
		    'inisial' => $request->inisial,
	    ]);
        Session::flash('update_mapel', 'Berhasil MengUpdate Mapel');
	    return redirect('mapel');
    }


    //SETTING JAM BIMBEL (VIEW)
    //rote:set_jam
    public function set_jam()
    {
        return view('setting_jam');
    }


    //SIMPAN JAM
    //route:simpanjam2
    public function simpan_jam2(Request $request)
    {
        //MERESET JAM/ TRUNCATE DB 'atur_jam' dan 'a_jam'
        $reset_jam = DB::table('atur_jam')->truncate();
        $reset = DB::table('a_jam')->truncate();

        $jam_a = DB::table('a_jam')
        ->insert([
            'start'=>$request->mulai,
            'durasi'=>$request->durasi,
            'jam'=>$request->jam,
        ]);

        $mulai = $request->mulai;
        $durasi = $request->durasi;
        $jumlah = $request->jam;
        for ($i = 0; $i < $jumlah; $i++) {

            if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
            $date= date_create( (@$end == '' ? $mulai : @$end));
            date_add($date, date_interval_create_from_date_string("$durasi minutes"));
            $end = date_format($date, 'H:i:s');
        
            if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
            $date= date_create( (@$end == '' ? $mulai : @$end));
            date_add($date, date_interval_create_from_date_string("-$durasi minutes"));
            $end1 = date_format($date, 'H:i:s');  

        $jam = DB::table('atur_jam')
        ->insert([   
            'nama' => $i+1,
            'start' => (@$end1 == '' ? $mulai : @$end1),
            'end' => $end,
            ]);
        }
        
        Session::flash('success', 'Berhasil Setting Jam Pelajaran');
        return redirect('set_jam');
       
    }

}
