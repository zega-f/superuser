<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use DB;
use DataTables;

class SiswaController extends Controller
{
    // CEK LOGIN
    function __construct()
    {
        $this->middleware('admin');
    }
    
    // DATA SISWA REGULER
    // route:data_siswa
    public function index()
    {
        $siswa = DB::table('room_user')
        ->join('users', 'users.partner_id', '=', 'room_user.user_id')
        ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
        ->leftjoin('kelas', 'room_user.room_id', '=', 'kelas.id_kelas')
        ->where('room_user.status','1')
        ->where('room_user.type','0')
        ->select('room_user.*', 'users.name','users.email','users.partner_id','user_detail.address as alamat','user_detail.phone','kelas.room_name')
        ->paginate(10);
        $nm_tingkat = 0;
    	return view('siswa.siswa',compact('siswa','nm_tingkat'));
    }

    // Dropdown FILTER DATA SISWA REGULER
    // route:filter_siswa_reguler
    public function filter_siswaReg(Request $request)
    {
        $siswa = DB::table('room_user')
        ->join('users', 'users.partner_id', '=', 'room_user.user_id')
        ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
        ->leftjoin('kelas', 'room_user.room_id', '=', 'kelas.id_kelas')
        ->where('room_user.status','1')
        ->where('room_user.type','0')
        ->where('room_user.tingkat',$request->tingkat)
        ->select('room_user.*', 'users.name','users.email','users.partner_id','user_detail.address as alamat','user_detail.phone','kelas.room_name')
        ->paginate(10);

        $nm_tingkat = DB::table('db_jenjang')
            ->where('id',$request->tingkat)
            ->first();

    	return view('siswa.siswa',compact('siswa','nm_tingkat'));
    }


     // Dropdown FILTER DATA SISWA REGULER
    // route:cetak_siswa_reguler
    public function cetak_siswaReg(Request $request)
    {
        $siswa = DB::table('room_user')
        ->join('users', 'users.partner_id', '=', 'room_user.user_id')
        ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
        ->leftjoin('kelas', 'room_user.room_id', '=', 'kelas.id_kelas')
        ->where('room_user.status','1')
        ->where('room_user.type','0')
        ->where('room_user.tingkat',$request->id_tingkat)
        ->select('room_user.*', 'users.name','users.email','users.partner_id','user_detail.address as alamat','user_detail.phone','kelas.room_name','user_detail.jenis_kelamin')
        ->paginate(10);

        $nm_tingkat = DB::table('db_jenjang')
            ->where('id',$request->id_tingkat)
            ->first();

    	return view('siswa.cetak_siswa',compact('siswa','nm_tingkat'));
    }



    // DATA SISWA KURSUS
    // route:siswa_kursus
    public function siswa_kursus()
    {
        $siswa_kursus = DB::table('room_user')
        ->join('users', 'users.partner_id', '=', 'room_user.user_id')
        ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
        ->join('room', 'room_user.room_id', '=', 'room.room_id')
        ->where('room_user.status','1')
        ->where('room_user.type','1')
        ->select('room_user.*', 'users.name','users.email','users.partner_id','user_detail.address as alamat','user_detail.phone','room.room_name')
        ->paginate(10);
        $nm_kursus = 0;
    	return view('siswa.siswa_kursus',compact('siswa_kursus','nm_kursus'));
    }


     // Dropdown FILTER DATA SISWA KURSUS
    // route:filter_siswa_kursus
    public function filter_siswaKursus(Request $request)
    {
        $siswa_kursus = DB::table('room_user')
        ->join('users', 'users.partner_id', '=', 'room_user.user_id')
        ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
        ->join('room', 'room_user.room_id', '=', 'room.room_id')
        ->where('room_user.status','1')
        ->where('room_user.type','1')
        ->where('room_user.room_id',$request->room)
        ->select('room_user.*', 'users.name','users.email','users.partner_id','user_detail.address as alamat','user_detail.phone','room.room_name')
        ->paginate(10);

        $nm_kursus = DB::table('room')
        ->where('room.room_id',$request->room)
        ->first();
       
        return view('siswa.siswa_kursus',compact('siswa_kursus','nm_kursus'));
    }


     // Dropdown cetak DATA SISWA KURSUS
    // route:cetak_siswa_kursus
    public function cetak_siswaKursus(Request $request)
    {
        $siswa_kursus = DB::table('room_user')
        ->join('users', 'users.partner_id', '=', 'room_user.user_id')
        ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
        ->join('room', 'room_user.room_id', '=', 'room.room_id')
        ->where('room_user.status','1')
        ->where('room_user.type','1')
        ->where('room_user.room_id',$request->room)
        ->select('room_user.*', 'users.name','users.email','users.partner_id','user_detail.address as alamat','user_detail.phone','room.room_name')
        ->paginate(10);

        $nm_kursus = DB::table('room')
        ->where('room.room_id',$request->room)
        ->first();
       
        return view('siswa.cetak_siswa_kursus',compact('siswa_kursus','nm_kursus'));
    }



    //FILTER JADWAL KELAS
    // route:filter_jadwal_kelas
    public function filter_jadwal_kelas(Request $request)
    {
        $jadwal = DB::table('jadwal_kelas')
            ->join('mapel_kelas', 'jadwal_kelas.mapel', '=', 'mapel_kelas.id_mapel_kelas')
            ->join('kelas', 'jadwal_kelas.kelas', '=', 'kelas.id_kelas')
            ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
            ->join('users', 'jadwal_kelas.pengajar', '=', 'users.partner_id')
            ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
            ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.id')
            ->select('jadwal_kelas.*', 'tblmapel.nama as mapel_nama', 'users.name as pengajar', 'users.partner_id as id_pengajar', 'tblhari.namahari as hari', 'tblhari.id as id_hari', 'atur_jam.start as mulai', 'atur_jam.end as akhir','kelas.room_name','kelas.tingkat','atur_jam.id as jam_ke')
            ->where('jadwal_kelas.tingkat',$request->tingkat)
            ->orderBy('jadwal_kelas.hari', 'asc')
            ->get();

        $nm_tingkat = DB::table('db_jenjang')
            ->where('id',$request->tingkat)
            ->first();

    	return view('pengajar.all_jadwal',compact('jadwal','nm_tingkat'));
    }

     //FILTER JADWAL KELAS
    // route:filter_jadwal_kelas
    public function cetak_jadwal_kelas(Request $request)
    {
        $jadwal = DB::table('jadwal_kelas')
            ->join('mapel_kelas', 'jadwal_kelas.mapel', '=', 'mapel_kelas.id_mapel_kelas')
            ->join('kelas', 'jadwal_kelas.kelas', '=', 'kelas.id_kelas')
            ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
            ->join('users', 'jadwal_kelas.pengajar', '=', 'users.partner_id')
            ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
            ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.id')
            ->select('jadwal_kelas.*', 'tblmapel.nama as mapel_nama', 'users.name as pengajar', 'users.partner_id as id_pengajar', 'tblhari.namahari as hari', 'tblhari.id as id_hari', 'atur_jam.start as mulai', 'atur_jam.end as akhir','kelas.room_name','kelas.tingkat','atur_jam.id as jam_ke')
            ->where('jadwal_kelas.tingkat',$request->tingkat)
            ->orderBy('jadwal_kelas.hari', 'asc')
            ->get();

        $nm_tingkat = DB::table('db_jenjang')
            ->where('id',$request->tingkat)
            ->first();

    	return view('pengajar.cetak_all_jadwal',compact('jadwal','nm_tingkat'));
    }




    // DETAIL SISWA REGULER
    // route:detail_siswaReguler/{id}
    public function detail_siswa($id)
    {
        $item = DB::table('room_user')
        ->join('users', 'users.partner_id', '=', 'room_user.user_id')
        ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
        ->leftjoin('kelas', 'room_user.room_id', '=', 'kelas.id_kelas')
        ->select('user_detail.*', 'users.name','users.email','kelas.room_name','room_user.school_name','kelas.room_name','kelas.tingkat')
        ->where('user_detail.user_id',$id)
        ->first();
    	return view('siswa.detail_siswa',compact('item'));
    }


     // DETAIL SISWA KURSUS
    // route:detail_siswakURSUS/{id}
    public function detail_siswaKursus($id)
    {
        $item = DB::table('room_user')
        ->join('users', 'users.partner_id', '=', 'room_user.user_id')
        ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
        ->leftjoin('room', 'room_user.room_id', '=', 'room.room_id')
        ->select('user_detail.*', 'users.name','users.email','room.room_name','room_user.school_name')
        ->where('user_detail.user_id',$id)
        ->first();
    	return view('siswa.detail_siswaKursus',compact('item'));
    }



    // public function getKliping()
    // {
    //     $siswa = DB::table('room_user')
    //     ->join('users', 'users.partner_id', '=', 'room_user.user_id')
    //     ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
    //     ->leftjoin('kelas', 'room_user.room_id', '=', 'kelas.id_kelas')
    //         // ->where('room_user.status','1')
    //     ->select('room_user.*', 'users.name','users.email','users.partner_id','user_detail.address as alamat','user_detail.phone','kelas.room_name')
    //         ->get();
    //         // $no=1;
    //         // foreach($siswa as $row)  
    //         // {  
    //         //     // $sub_array = array();   
    //             // $sub_array[] = $no++;                 
    //             // $sub_array[] = $row->name;            
    //             // $sub_array[] = $row->alamat;
    //             // $sub_array[] = $row->phone; 
    //             // $sub_array[] = '<button type="button" name="update" id="'.$row->partber_id.'" class="btn btn-info btn-xs update"><i class="fa fa-edit"></i></button>&nbsp;<button type="button" name="delete" id="'.$row->tingkat.'" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';  
    //         //     $data[] = $sub_array;  
    //         // } 
    //         // print_r ($data);
    //     return DataTables::of($siswa)->make(true);
    // }

}
