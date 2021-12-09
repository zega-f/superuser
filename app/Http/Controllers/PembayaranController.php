<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use DB;

class PembayaranController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $semua_user = DB::table('room_user_mapel')
        ->join('users','room_user_mapel.user_id','=','users.partner_id')
        ->leftjoin('room_user','room_user_mapel.user_id','=','room_user.user_id')
        ->join('db_jenjang','room_user.tingkat','=','db_jenjang.tingkat')
        ->select('users.partner_id','users.name','room_user.status','room_user.id','room_user_mapel.bukti_pembayaran','db_jenjang.nama as room_name','room_user.user_id','room_user.tingkat','room_user_mapel.register_id','room_user_mapel.verify','room_user.register_id as id_register','room_user_mapel.register_type as status_daftar','room_user_mapel.created_at')
        

        ->groupBy('room_user_mapel.register_id')
        ->where('room_user.type',0)
        ->where('room_user.status',0)
        ->where('room_user_mapel.verify',0)
        
        ->orderBy('room_user_mapel.created_at','desc')
        // ->paginate(3);
        ->get();
        return view('pembayaran.pembayaran',compact('semua_user'));
    }   
    

    public function regis_kursus()
    {
        $regis_kursus = DB::table('room_user')
        ->join('users','room_user.user_id','=','users.partner_id')
        ->join('room','room_user.room_id','=','room.room_id')
        ->select('users.partner_id','users.name','room_user.status','room_user.id','room_user.bukti_pembayaran','room.room_name','room_user.user_id','room_user.tingkat','room.biaya','room_user.created_at')
        ->where('room_user.status',0)
        ->where('room_user.type',1)
        ->orderBy('room_user.created_at','desc')
        // ->paginate(3);
        ->get();
        return view('pembayaran.regis_kursus',compact('regis_kursus'));
    }   
    


    
    public function verify($id,$register_id)
    {
        if($id!=0) {
    
        $bayar = \DB::table('room_user')->where('register_id',$register_id)->first();
        // $status_bayar = $bayar->status;
        // $room_id = $bayar->room_id;
        // echo $room_id;

         \DB::table('room_user')->where('register_id',$register_id)->update([
                'status'=>'1',
            ]);
       
        DB::table('room_user_mapel')->where('register_id',$register_id)
        ->update([
		    'verify' => 1,
            // 'room_id'=> $room_id,
	    ]);

        } else {
        
        DB::table('room_user_mapel')->where('register_id',$register_id)
        ->update([
		    'verify' => 1,
            // 'room_id'=> $room_id,

        ]);

        }

        // $response = Http::get('http://192.168.0.4:8080/bimbel_2/verify_this_user',[
    	// 	'id'=>$id,
    	// ]);
        Session::flash('verify_pendaftar_kelas', 'Berhasil Verifikasi Pendaftaran Kelas');
        return back();
        // return redirect('/pembayaran');
    }


    public function verify_kursus($id)
    {
        $bayar = \DB::table('room_user')->where('id',$id)->first();
        $status_bayar = $bayar->status;

            \DB::table('room_user')->where('id',$id)->update([
                'status'=>'1',
            ]);
       
        Session::flash('verify_pendaftar_kursus', 'Berhasil Verifikasi Pendaftaran Kursus');
         return back();
        // return redirect('/pembayaran');
    }

      


    public function detail_pendaftar(Request $request)
    {
        $id = $request->id_siswa;
        $tingkat = $request->tingkat;
        $register_id = $request->register_id;

        $detail = DB::table('room_user')
        ->join('users','room_user.user_id','=','users.partner_id')
        ->join('room_user_mapel','room_user_mapel.user_id','=','room_user.user_id')
        ->join('user_detail','room_user.user_id','=','user_detail.user_id')
        ->join('db_jenjang','room_user.tingkat','=','db_jenjang.tingkat')
        ->select('users.*','user_detail.jenis_kelamin','user_detail.address','db_jenjang.nama as kelas','user_detail.phone','users.name as siswa','room_user.register_id','room_user_mapel.created_at') 
        ->where('room_user_mapel.register_id',$register_id)
        ->first();

        

        $bukti = DB::table('room_user_mapel')
        ->select('room_user_mapel.*') 
        ->where('room_user_mapel.user_id',$id)
        ->where('room_user_mapel.register_id',$register_id)
        ->first();

        $mapel_user = DB::table('room_user_mapel')
        ->join('mapel_kelas','room_user_mapel.mapel','=','mapel_kelas.id_mapel_kelas')
        ->join('tblmapel','tblmapel.id_mapel','=','mapel_kelas.mapel')
        ->select('room_user_mapel.*','tblmapel.nama as mapel') 
        ->where('room_user_mapel.user_id',$id)
        ->where('mapel_kelas.tingkat',$tingkat)
        ->where('room_user_mapel.register_id',$register_id)
        ->get();

        $sum_mapel = DB::table('room_user_mapel')
        ->join('mapel_kelas','room_user_mapel.mapel','=','mapel_kelas.id_mapel_kelas')
        ->join('tblmapel','tblmapel.id_mapel','=','mapel_kelas.mapel')
        ->select('room_user_mapel.*','tblmapel.nama as mapel') 
        ->where('room_user_mapel.user_id',$id)
        ->where('room_user_mapel.tingkat',$tingkat)
        ->where('room_user_mapel.register_id',$register_id)
        ->sum('room_user_mapel.harga');

        $kelas = DB::table('db_jenjang')
        ->where('tingkat',$tingkat)
        ->first();

        return view('pembayaran.detail',compact('detail','bukti','mapel_user','sum_mapel','kelas'));
    }


    
    public function detail_pendaftar_kursus(Request $request)
    {
        $id = $request->id_siswa;
        $idb = $request->idbayar;

        $detail = DB::table('room_user')
        ->join('users','room_user.user_id','=','users.partner_id')
        ->join('user_detail','room_user.user_id','=','user_detail.user_id')
        ->join('room','room_user.room_id','=','room.room_id')
        ->select('users.*','user_detail.jenis_kelamin','user_detail.address','room.room_name','room.biaya','user_detail.phone','users.name as siswa','room_user.created_at') 
        ->where('room_user.user_id',$id)
        ->get();

        $kursus = DB::table('room_user')
        ->join('room','room_user.room_id','=','room.room_id')
        ->select('room_user.*','room.room_name','room.biaya') 
        ->where('room_user.user_id',$id)
        ->where('room_user.id',$idb)
        ->first();

        $bukti = DB::table('room_user')
        ->select('room_user.*') 
        ->where('room_user.user_id',$id)
        ->first();

      

        return view('pembayaran.detail_pendaftarKursus',compact('detail','bukti','kursus'));
    }




}
