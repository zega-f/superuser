<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use DB;


class PengajarController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }
     
    public function index()
    {
        $pengajar = DB::table('users')
        ->where('partner_type','1')
        ->get();
    	return view('pengajar.pengajar',compact('pengajar'));
    }

    public function pengajar_store(Request $request)
    {   
        $check = DB::table('users')
        ->where('email',$request->email)
        ->count();
        if ($check==0) {

            $id_pengajar = Str::random(8);
            $store = DB::table('users')
            ->insert([
                'name'=>$request->pengajar_name,
                'email'=>$request->email,
                'verify'=>1,
                'partner_type' => 1,
                'partner_id' => $id_pengajar,
                'password' => Hash::make('12345678'),
            ]);

            $store1 = DB::table('detail_pengajar')
            ->insert([
                'pengajar'=>$id_pengajar,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'tempat_lahir'=>$request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'pendidikan' => $request->pendidikan,
                'universitas' => $request->universitas,
                'tlp' => $request->tlp,
            ]);

            $cekrow = DB::table('mapel_pengajar')->count();
            $id_mapel_pengajar = 1;

            if ($cekrow == 0) {
                DB::table('mapel_pengajar')->truncate();
            } else {
                $id_mapel_pengajar = DB::table('mapel_pengajar')->orderBy('id', 'desc')->first()->id+1;
            }

    
            $store2 = DB::table('mapel_pengajar')
            ->insert([
                'id_pengajar'      =>  $id_pengajar,
                'id_mapel'  =>  $request->mapel,
                'id_mapel_pengajar' => $id_mapel_pengajar,
            ]);


            if ($store) {
                Session::flash('add_pengajar', 'Berhasil Menambahkan Pengajar');
                return redirect()->route('pengajar');
            }else{
                Session::flash('gagal_pengajar', 'Gagal Menambahkan Pengajar');
                return redirect()->route('pengajar');
            }
            
        } else {
            return back()->with('fail',"Data Gagal disimpan Email $request->email Sudah ada");
        }
    }


    public function jadwal_pengajar(Request $request)
    {
        $jadwal = DB::table('jadwal_kelas')
                    ->join('mapel_kelas', 'jadwal_kelas.mapel', '=', 'mapel_kelas.id_mapel_kelas')
                    ->join('kelas', 'jadwal_kelas.kelas', '=', 'kelas.id_kelas')
                    ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
                    ->join('users', 'jadwal_kelas.pengajar', '=', 'users.partner_id')
                    ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
                    ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.id')
                    ->select('jadwal_kelas.*', 'tblmapel.nama as mapel_nama', 'users.name as pengajar', 'users.partner_id as id_pengajar', 'tblhari.namahari as hari', 'tblhari.id as id_hari', 'atur_jam.start as mulai', 'atur_jam.end as akhir','kelas.room_name','kelas.tingkat','atur_jam.id as jam_ke')
                    // ->orderBy('jadwal_kelas.hari', 'asc')
                    ->get();
        return view('pengajar.all_jadwal',compact('jadwal'));
    }


    // public function reset_password(Request $request, $id)
    // {
        
	// DB::table('users')->where('id',$request->id)->update([
	// 	'password' => Hash::make('12345678'),
	// ]);
	// // alihkan halaman ke halaman pegawai
	// return back();
    // }


    public function delete_pengajar(Request $request)
    {
        $pengajar_id=$request->id_pengajar;
        $del_pengajar = \DB::table('users')
        ->where(
            'partner_id',$pengajar_id)->delete();

        $del_detail = \DB::table('detail_pengajar')
            ->where(
                'pengajar',$pengajar_id)->delete();
        
        $del_mapel_pengajar = \DB::table('mapel_pengajar')
            ->where(
                'id_pengajar',$pengajar_id)->delete();

        $pengajar = DB::table('users')
            ->where('partner_type','1')
            ->get();
            
        Session::flash('del_pengajar', 'Berhasil Menghapus Pengajar');
        return view('pengajar.tabel_pengajar',compact('pengajar'));  
    }


    public function detail_pengajar($id)
    {
       
        $nama_guru = DB::table('users')
                    ->where('partner_id',$id)
                    ->get();
        
        $jadwal = DB::table('jadwal_kelas')
                    ->join('kelas', 'jadwal_kelas.kelas', '=', 'kelas.id_kelas')
                    ->join('mapel_kelas', 'jadwal_kelas.mapel', '=', 'mapel_kelas.id_mapel_kelas')
                    ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
                    ->join('users', 'jadwal_kelas.pengajar', '=', 'users.partner_id')
                    ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
                    ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.id')
                    ->select('jadwal_kelas.*', 'tblmapel.nama as nama', 'users.name as pengajar', 'users.partner_id as id_pengajar', 'tblhari.namahari as hari', 'tblhari.id as id_hari', 'atur_jam.start as mulai', 'atur_jam.end as akhir','atur_jam.nama', 'kelas.room_name','tblmapel.nama as mapel_nama','kelas.tingkat')
                    ->where('users.partner_id',$id)
                    ->orderBy('jadwal_kelas.hari', 'asc')
                    ->get();
        
                    $pengajar_mapel = DB::table('mapel_pengajar')
                    ->join('tblmapel', 'mapel_pengajar.id_mapel', '=', 'tblmapel.id_mapel')
                    ->join('users', 'mapel_pengajar.id_pengajar', '=', 'users.partner_id')
                    ->select('mapel_pengajar.*', 'tblmapel.nama as mapel','users.name as pengajar')
                    ->where('users.partner_type','1')
                    ->where('mapel_pengajar.id_pengajar',$id)
                    ->get();

    	return view('pengajar.detail_pengajar',compact('nama_guru','jadwal','pengajar_mapel'));
    }

}
