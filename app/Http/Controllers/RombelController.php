<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;

class RombelController extends Controller
{
    public function rombel()
    {
        $all_tingkat = DB::table('room_user')
            ->join('db_jenjang', 'room_user.tingkat', '=', 'db_jenjang.tingkat')
            ->select('db_jenjang.*')
            ->where('room_user.room_id',null)
            ->where([
                ['room_user.type',0],
                ['room_user.status',1],
            ])
            ->groupBy('room_user.tingkat')
        ->get();

        //Siswa belu dapat kelas
        $all_siswa = DB::table('room_user')
                    ->join('users', 'users.partner_id', '=', 'room_user.user_id')
                    ->select('room_user.*', 'users.name')
                    ->where('room_user.tingkat',0)
                    ->where([
                        ['room_user.type',0],
                        ['room_user.status',1],
                    ])
                    ->get();

        //siswa dapat kelas
        $all_siswa_active = DB::table('room_user')
                    ->join('users','room_user.user_id','=','users.partner_id')
                    ->select('room_user.*', 'users.name')
                    ->where('room_user.tingkat',0)
                    ->where([
                        ['room_user.type',0],
                        ['room_user.status',1],
                    ])
                    ->get(); 

        $room = DB::table('kelas')
                    ->where('tingkat','0')
                    ->get();

        $namakelas='';
        $namatingkat='';
            
        $inactive_status=0;
        $active_status=0;
        $tingkat=null;
        
    	return view('rombel.rombel',compact('all_tingkat','all_siswa','all_siswa_active','namatingkat','namakelas','room','inactive_status','active_status','tingkat'));
    }



    public function pilih_tingkat(Request $request)
    {
        $inactive_status=1;
        $active_status=1;
        $tingkat=$request->tingkat;

        //Siswa belu dapat kelas
        $all_siswa = DB::table('room_user')
                    ->join('users', 'users.partner_id', '=', 'room_user.user_id')
                    ->select('room_user.*', 'users.name')
                    ->where([
                        ['room_user.tingkat',$tingkat],
                        ['room_user.room_id',null],
                        ['room_user.type',0],
                        ['room_user.status',1],
                    ])
                    ->get();

        $kelas = DB::table('db_jenjang')
            ->where('tingkat',$tingkat)
            ->first();
       
        $namakelas= $kelas->nama;
        $namatingkat='';


        $room = DB::table('kelas')
        ->where([
            ['tingkat',$tingkat],
        ])
        ->get();

        $all = 'kosong';
        $all_siswa_active = DB::table('room_user')
        ->join('users','room_user.user_id','=','users.partner_id')
        ->select('room_user.*', 'users.name')
        ->where('room_user.tingkat',0)
        ->where([
            ['room_user.type',0],
            ['room_user.status',1],
        ])
        ->get();    
        
        $all_tingkat = DB::table('room_user')
            ->join('db_jenjang', 'room_user.tingkat', '=', 'db_jenjang.tingkat')
            ->select('db_jenjang.*')
            ->where('room_user.room_id',null)
            ->where([
                ['room_user.type',0],
                ['room_user.status',1],
            ])
            ->groupBy('room_user.tingkat')
        ->get();
       
           
    	return view('rombel.siswa_new',compact('all_siswa','namakelas','namatingkat','room','kelas','all','all_siswa_active','inactive_status','active_status','all_tingkat','tingkat'));

    }


    
    public function pilih_kelas(Request $request)
    {
        $inactive_status=2;
        $active_status=2;

        $tingkat=$request->tingkat;
        $id_kelas=$request->id_kelas;

        $all_tingkat = DB::table('room_user')
            ->join('db_jenjang', 'room_user.tingkat', '=', 'db_jenjang.tingkat')
            ->select('db_jenjang.*')
            ->where('room_user.room_id',null)
            ->where([
                ['room_user.type',0],
                ['room_user.status',1],
            ])
            ->groupBy('room_user.tingkat')
        ->get();

        //Siswa belu dapat kelas
        $all_siswa = DB::table('room_user')
                    ->join('users', 'users.partner_id', '=', 'room_user.user_id')
                    ->select('room_user.*', 'users.name')
                    ->where([
                        ['room_user.tingkat',$tingkat],
                        ['room_user.room_id',null],
                        ['room_user.type',0],
                        ['room_user.status',1],
                    ])
                    ->get();

        $kelas = DB::table('kelas')
            ->where('id_kelas',$request->id_kelas)
            ->first();

        $namakelas= $kelas->room_name;
        $namatingkat= $kelas->tingkat;
        
        $room = DB::table('kelas')
        ->where([
            ['tingkat',$tingkat],
        ])
        ->get();
        $all = 'kosong';

        $all_siswa_active = DB::table('room_user')
        ->join('users','room_user.user_id','=','users.partner_id')
        ->select('room_user.*', 'users.name')
        ->where([
            ['room_user.tingkat',$tingkat],
            ['room_user.room_id',$id_kelas],
            ['room_user.type',0],
            ['room_user.status',1],
        ])
        ->get();          
    	return view('rombel.siswa_new',compact('all_siswa','namakelas','all','namatingkat','room','kelas','id_kelas','all_siswa_active','inactive_status','active_status','all_tingkat','tingkat'));
    }


    public function reload_pendaftar(Request $request)
    {
        $tingkat=$request->tingkat;
        $all_tingkat = DB::table('room_user')
            ->join('db_jenjang', 'room_user.tingkat', '=', 'db_jenjang.tingkat')
            ->select('db_jenjang.*')
            ->where('room_user.room_id',null)
            ->where([
                ['room_user.type',0],
                ['room_user.status',1],
            ])
            ->groupBy('room_user.tingkat')
        ->get();

    	return view('rombel.jml',compact('all_tingkat','tingkat'));
    }


    public function siswaIntoClass(Request $request)
    {
        $id_kelas = $request->id_kelas;
        $siswaIntoClass = DB::table('room_user')
        ->where([
            ['user_id',$request->siswa_id],
            ['room_id',null],
            ['jenjang',$request->jenjang],
            ['tingkat',$request->tingkat],
            ['room_user.type',0],
            ['room_user.status',1],
        ])
        ->update([
            'room_id'=>$request->id_kelas,
        ]);

        $all_siswa_active = DB::table('room_user')
        ->join('users','room_user.user_id','=','users.partner_id')
        ->select('room_user.*','users.name')
        ->where([
            ['room_user.room_id',$request->id_kelas],
            ['room_user.jenjang',$request->jenjang],
            ['room_user.tingkat',$request->tingkat],
            ['room_user.type',0],
            ['room_user.status',1],
        ])
        ->get();
       
    }

    public function siswa_aktif(Request $request)
    {
        $inactive_status=3;
        $active_status=3;
        $id_kelas = $request->id_kelas;
        $jenjang = $request->jenjang;
        $tingkat = $request->tingkat;
        $all_siswa_active = DB::table('room_user')
        ->join('users','room_user.user_id','=','users.partner_id')
        ->select('room_user.*','users.name')
        ->where([
            
            ['room_user.room_id',$request->id_kelas],
            ['room_user.jenjang',$request->jenjang],
            ['room_user.tingkat',$request->tingkat],
            ['room_user.type',0],
            ['room_user.status',1],
        ])
        ->get();

        return view('rombel.tabel_siswa_active',compact('all_siswa_active','id_kelas','jenjang','tingkat','inactive_status','active_status'));
    }

    public function siswa_nonaktif(Request $request)
    {
        $inactive_status=3;
        $active_status=3;
        $id_kelas = $request->id_kelas;
        $tingkat = $request->tingkat;
        $all_siswa = DB::table('room_user')
        ->join('users','room_user.user_id','=','users.partner_id')
        ->select('room_user.*','users.name')
        ->where([
          
            ['room_user.room_id',null],
            ['room_user.jenjang',$request->jenjang],
            ['room_user.tingkat',$request->tingkat],
            ['room_user.type',0],
            ['room_user.status',1],
        ])
        ->get();
       
        return view('rombel.tabel_siswa_inactive',compact('all_siswa','id_kelas','tingkat','tingkat','inactive_status','active_status'));
    }

    public function removeSiswaFromClass(Request $request)
    {
        $siswaOutClass = DB::table('room_user')
        ->where([
            ['user_id',$request->id_siswa_r],
            ['room_id',$request->id_kelas],
            ['jenjang',$request->jenjang],
            ['tingkat',$request->tingkat], 
            ['room_user.type',0],
            ['room_user.status',1],
        ])
        ->update([
            'room_id'=>null,
        ]);
    }


    

}
