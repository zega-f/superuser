<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use DB;
use Illuminate\Database\Seeder;
// use Carbon\Carbon;
use \MacsiDigital\Zoom\Facades\Zoom;

use \app\Traits\ZoomJWT;
use App\Zoom\Zoom_Api;

use App\Models\user;
use App\Traits\ZoomMeetingTrait;


class KelasController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;
    //akses
    function __construct()
    {
        $this->middleware('admin');
    }

    
    //DATA KELAS
    // route:/kelas
    public function index()
    {
        $kls = DB::table('kelas')->get();
    	return view('kelas.kelas',compact('kls'));
    }

    //TAMBAH KELAS
    // route:kelas_store
    public function kelas_store(Request $request)
    {
        $class_now = DB::table('kelas')
    	->where([
    			['jenjang', $request->jenjang],
    			['tingkat', $request->sub_jenjang],
    		])
    	->count();

    	if ($class_now==0) {
    		$name = 'A';
            $jenjang = $request->jenjang;
            // $room_name = implode('$jenjang','$name');
    		$store_kelas = DB::table('kelas')
    		->insert([
    		    'room_name'=>$name,
                'jenjang'=>$request->jenjang,
                'tingkat'=>$request->sub_jenjang,
                'id_kelas' => Str::random(6),
    		]);
            Session::flash('success', 'Berhasil menambahkan Kelas');
    		return redirect()->route('kelas');
    	}

        else {
            $class = DB::table('kelas')
    		->where([
    			['jenjang',$request->jenjang],
    			['tingkat',$request->sub_jenjang],
    		])
            ->latest()
    		->value('room_name');

            $alph = $class;
			$i = 1;
			$alph = chr(ord($alph)+$i);

    		// $class = DB::table('kelas')
    		// ->where([
    		// 	['jenjang',$request->jenjang],
    		// 	['tingkat',$request->sub_jenjang],
    		// ])
            // ->orderBy('room_name', 'desc')->first()->room_name+1;
            // $room_name2 = implode('$jenjang','$alph');
    		$store_kelas1 = DB::table('kelas')
    		->insert([
    		    'room_name'=>$alph,
                'jenjang'=>$request->jenjang,
                'tingkat'=>$request->sub_jenjang,
                'id_kelas' => Str::random(6),
    		]);

            Session::flash('success', 'Berhasil menambahkan Kelas');
            return redirect()->route('kelas');
    		// return back();
       }
    }


    //KELAS AKTIF
    // route:kelas_aktif
    public function kelas_non_aktif(Request $request)
    {
        $non_aktif = DB::table('kelas')
        ->where(
            'id',$request->id_kelas)
        ->update([
            'status'=>'0',
        ]);
        
        
    }

    //KELAS NON AKTIF
    // route:kelas_non_aktif
    public function kelas_aktif(Request $request)
    {
        $aktif = DB::table('kelas')
        ->where(
            'id',$request->id_kelas)
        ->update([
            'status'=>'1',
        ]);
    }


    //HAPUS KELAS
    // route:del_kelas
    public function delete_kelas(Request $request)
    {
        $del_kelas = \DB::table('kelas')
        ->where(
            'id_kelas',$request->id_kelas)->delete();

        $kls = DB::table('kelas')->get();
        Session::flash('success', 'Berhasil menghapus Kelas');
        return view('kelas.tabel_kelas',compact('kls'));
        
    }

    //DETAIL KELAS/SISWA DIKELAS INI
    // route:/detail_kelas/{id}
    public function detail_kelas($id)
    {
        $kelas = DB::table('room_user')
        ->join('kelas', 'room_user.room_id', '=', 'kelas.id_kelas')
        ->join('users', 'room_user.user_id', '=', 'users.partner_id')
        ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
        ->select('room_user.*', 'kelas.room_name', 'users.name as siswa', 'users.email', 'users.partner_id','kelas.id_kelas','users.partner_id','user_detail.address','user_detail.phone')
        ->where('room_id',$id)
        ->get();

        $nama_kelas = DB::table('kelas')
                    ->where('id_kelas',$id)
                    ->get();

    	return view('kelas.detail_kelas',compact('kelas','nama_kelas'));
    }


    /////////////////////////////////////////////////////////
    //KELOLA KELAS
    // route:/kelola_kelas/{id_kelas}/{jenjang}/{tingkat}
    public function kelola_kelas($id_kelas,$jenjang,$tingkat)
    {
        //Siswa belum dapat kelas
        $all_siswa = DB::table('room_user')
                    ->join('users', 'users.partner_id', '=', 'room_user.user_id')
                    ->select('room_user.*', 'users.name')
                    ->where([
                        ['room_user.jenjang',$jenjang],
                        ['room_user.tingkat',$tingkat],
                        ['room_user.room_id',null],
                        ['room_user.type',0],
                        ['room_user.status',1],
                    ])
                    ->get();

        //siswa dapat kelas
        $all_siswa_active = DB::table('room_user')
                    ->join('users','room_user.user_id','=','users.partner_id')
                    ->select('room_user.*', 'users.name')
                    ->where([
                        ['room_user.jenjang',$jenjang],
                        ['room_user.tingkat',$tingkat],
                        ['room_user.room_id',$id_kelas],
                        ['room_user.type',0],
                        ['room_user.status',1],
                    ])
                    ->get();


        $nama_kelas = DB::table('kelas')
                    ->join('db_jenjang', 'kelas.tingkat', '=', 'db_jenjang.tingkat')
                    ->select('kelas.*', 'db_jenjang.nama')
                    ->where('kelas.id_kelas',$id_kelas)
                    ->first();

        
        $jadwal = DB::table('jadwal_kelas')
        
                    ->join('kelas', 'jadwal_kelas.kelas', '=', 'kelas.id_kelas')
                    ->join('mapel_kelas', 'jadwal_kelas.mapel', '=', 'mapel_kelas.id_mapel_kelas')
                    ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
                    ->join('users', 'jadwal_kelas.pengajar', '=', 'users.partner_id')
                    ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
                    ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.id')
                    ->select('jadwal_kelas.*', 'tblmapel.nama as nama_mapel', 'users.name as pengajar', 'users.partner_id as id_pengajar', 'tblhari.namahari as hari', 'tblhari.id as id_hari', 'atur_jam.start as mulai', 'atur_jam.end as akhir')
                    ->where('jadwal_kelas.kelas',$id_kelas)
                    ->orderBy('jadwal_kelas.jam', 'asc')
                    ->get();

                    
    	return view('kelas.kelola_kelas',compact('all_siswa','all_siswa_active','id_kelas','jenjang','tingkat','nama_kelas','jadwal'));
    }

    //INSERT SISWA IN KELAS
    // route:siswa_into_class
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

    //BUTTON AKTIFKAN SISWA
    // route:siswa_aktif
    public function siswa_aktif(Request $request)
    {
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
        
        // Session::flash('info1', 'aktif');
        return view('kelas.tabel_siswa_active',compact('all_siswa_active','id_kelas','jenjang','tingkat'));
    }

     //BUTTON NON-AKTIFKAN SISWA
    // route:siswa_inaktif
    public function siswa_nonaktif(Request $request)
    {
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
       
        // Session::flash('info1', 'Nonaktif');
        return view('kelas.tabel_siswa_inactive',compact('all_siswa','id_kelas','tingkat','tingkat'));
    }

    //HAPUS SISWA DARI KELAS INI
    //route:remove_siswa
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


    public function list_video_zoom(Request $request) 
    {
        $video = DB::table('zoom_video')
        ->join('jadwal_kelas','jadwal_kelas.id_jadwal','=','zoom_video.id_jadwal')
        ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
        ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.id')
        ->select('zoom_video.*','atur_jam.end','atur_jam.start')
        ->where('zoom_video.id_jadwal',$request->id_jadwal)
        ->get();

        return view('kelas.zoom_video',compact('video'));
    }


    public function delete_video_zoom(Request $request) 
    {
        $meeting = Zoom::meeting()->find($request->meet_id)->occurrences()->find($request->occurrence_id);
        $meeting->delete();

        $del_occurrences = \DB::table('zoom_video')
        ->where('occurrence_id',$request->occurrence_id)->delete();

        $video = DB::table('zoom_video')
        ->join('jadwal_kelas','jadwal_kelas.id_jadwal','=','zoom_video.id_jadwal')
        ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
        ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.id')
        ->select('zoom_video.*','atur_jam.end','atur_jam.start')
        ->where('zoom_video.id_jadwal',$request->id_jadwal)
        ->get();

        Session::flash('delete_pertemuan', 'Berhasil menghapus Tatap muka');
        return view('kelas.zoom_video',compact('video'));
    }
    

    // public function mbuh(Request $request) //get per id
    // {
    //     $occurrence = Zoom::meeting()->find('81480468430')->occurrences()->find('1644216300000');
    //     echo $occurrence;
    // }

    // public function mbuh(Request $request) //hapus per id
    // {
    //     $meeting=Zoom::meeting()->find('82640743934')->occurrences()->find('1638684000000');
    //     $meeting->delete();
    // }

    public function mbuh(Request $request) //hapus per id
    {
        $meeting=Zoom::meetingparticipants()->find('86042698559');
        // $meetings->get();
        // $user = Zoom::user()->find('fauzytamimkdr@gmail.com');
        $meeting->get();
        echo $meeting;
    }

    public function cek_tanggal(Request $request)
    {
        $datetime = date($request->tanggal);
        $date_in_week =  date('N',strtotime($datetime));
        // convert day name to indonesia
        setlocale(LC_ALL, 'IND');
        $waktu_ina = \Carbon\Carbon::parse($request->tanggal)->formatLocalized("%A");
        return response(['date_in_week'=>$date_in_week,'dayname'=>$waktu_ina]);
    }


    

    // public function mbuh1(Request $request)
    // {
    //     $meeting=Zoom::meeting()->find('82640743934')
    //     ->update([
    //         'topic' => "menjajal",
    //         'type' => 8,
    //         'duration' => 30, // In minutes, optional
    //         // "start_time" => "2021-11-23 15:08:38",
    //         'timezone' => 'Asia/Jakarta',
    //         "password" => "123456",

    //         "recurrence" => [
    //             "type"=>2,  //weekly
    //             "repeat_interval"=> 1,
    //             // "weekly_days" => "3",
    //             // "end_times"=> "20",
    //         ],

    //         "settings" => [
    //             "host_video"=> true,
    //             "participant_video"=> true,
    //         ],
    //       ]);
    //       $meeting->save();
    //       echo $meeting;
    // }
    




    ////TAMBAH JADWAL KELAS
    // route:jadwalkelas_store
    public function jadwalkelas_store(Request $request)
    {   
        // converting php date to zoom date
        $zoom_date = array(
            '1' => '2', 
            '2' => '3', 
            '3' => '4', 
            '4' => '5', 
            '5' => '6', 
            '6' => '7', 
            '7' => '1', 
        );

        $id_jadwal=Str::random(6);
        //ambil jam pelajaran
        $start_time = DB::table('atur_jam')
            ->where('id',$request->jam)
            ->first();
        $mulai=$start_time->start; //jam pelajaran

        $mapel = DB::table('mapel_kelas')
        ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id')
        ->select('mapel_kelas.*', 'tblmapel.nama', 'tblmapel.id_mapel')
        ->where('mapel_kelas.tingkat',$request->tingkat)
        ->where('mapel_kelas.id_mapel_kelas',$request->mapel_name)
        ->first();
        $mapel_zoom = $mapel->nama;

        $user = Zoom::user()->find('fauzytamimkdr@gmail.com');
        $meeting = Zoom::meeting()->make([
            'topic' => "$mapel_zoom $request->tingkat$request->room jam ke-$request->jam",
            'type' => 8,
            'duration' => 45, // In minutes, optional
            "start_time" => $request->tanggal.' '.$mulai,
            'timezone' => 'UTC',
            "password" => "123456",

            "recurrence" => [
                "type"=>2,  //weekly
                "repeat_interval"=> 1,
                "weekly_days" => $zoom_date[$request->hari],
                "end_times"=>$request->pertemuan,
            ],

            "settings" => [
                "host_video"=> true,
                "participant_video"=> true,
            ],
          ]);
          $user->meetings()->save($meeting);
        
        $var = json_decode($meeting,true);
        $pertemuan=1;

        $store = DB::table('jadwal_kelas')
        ->insert([
            'kelas'=>$request->id,
            'mapel'=>$request->mapel_name,
            'tingkat'=>$request->tingkat,
            'pengajar'=>$request->pengajar_name,
            'hari'=>$request->hari,
            'jam'=>$request->jam,
            'id_jadwal'=>$id_jadwal,
            'url'=>$var['join_url'],
            'meet_id'=>$var['id'],
        ]);

        $occurrence = $var['occurrences'];
        foreach ($occurrence as $item) { 
            date_default_timezone_set('Asia/Jakarta'); 
            $time1 = strtotime($item['start_time'].' UTC');
            $format1 = date("Y-m-d H:i:s", $time1);
            $data[] = array(
                    'occurrence_id' => $item['occurrence_id'],
                    'start_time' => $format1,
                    'duration' => $item['duration'],
                    'meet_id'=>$var['id'],
                    'url'=>$var['join_url'],
                    'id_jadwal'=>$id_jadwal,
                    'pertemuan'=>$pertemuan++,    
            );
        }           

        $store1 = DB::table('zoom_video')
        ->insert($data);

        return back()->with(['info' => 'Data Berhasil Disimpan!']);
      
    }

    //DROPDOWN PILIH GURU BERDASARKAN MAPEL TERTENTU
    // route:change_guru
    // view:kelola_kelas
    public function change_guru(Request $request)
    {
        $guru = \DB::table('mapel_pengajar')
        ->join('users', 'mapel_pengajar.id_pengajar', '=', 'users.partner_id')
        ->join('mapel_kelas', 'mapel_pengajar.id_mapel','=' ,'mapel_kelas.mapel')
        ->select('mapel_pengajar.*', 'users.name','mapel_kelas.mapel')
        ->where('mapel_kelas.id_mapel_kelas',$request->id)
        ->get();
        return response()->json($guru);
    }

    
    //DROPDOWN PILIH JAM BERDASARKAN jam kosong guru
    // route:change_jam
    // view:kelola_kelas
    public function change_jam(Request $request)
    {
        $idh = $request->idh;
        $guru = $request->guru;
        $id = [$idh,$guru];

        $jam = \DB::table('atur_jam')
        ->whereNotin('id', function($q) use ($id){
            $q->select('jam')->from('jadwal_kelas')
            ->where([
                ['hari',$id[0]],
                ['pengajar',$id[1]]
            ]);
        })        
        ->get();
        return response()->json($jam);
    }


    public function change_jam_kursus(Request $request)
    {
        $idt = $request->idt;
        $guru = $request->guru;
        $room = $request->room;
        $id = [$idt,$guru,$room];

        $jam = \DB::table('atur_jam')
        ->whereNotin('id', function($q) use ($id){
            $q->select('jam')->from('video_conference')
            ->where([
                ['tanggal',$id[0]],
                // ['owner_id',$id[1]],
                ['room_id',$id[2]]
            ]);
        })        
        ->get();
        return response()->json($jam);
    }
    
    //HAPUS JADWAL
    // route:del_jadwal
    public function delete_jadwal(Request $request)
    {
        $meeting=Zoom::meeting()->find($request->id_jadwal);
        $meeting->delete();

        $del_jadwal = \DB::table('jadwal_kelas')
        ->where('meet_id',$request->id_jadwal)->delete();

        $del_occurrences = \DB::table('zoom_video')
        ->where('meet_id',$request->id_jadwal)->delete();

        $jadwal = DB::table('jadwal_kelas')
        ->join('kelas', 'jadwal_kelas.kelas', '=', 'kelas.id_kelas')
        ->join('mapel_kelas', 'jadwal_kelas.mapel', '=', 'mapel_kelas.id_mapel_kelas')
        ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
        ->join('users', 'jadwal_kelas.pengajar', '=', 'users.partner_id')
        ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
        ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.id')
        ->select('jadwal_kelas.*', 'tblmapel.nama as nama_mapel', 'users.name as pengajar', 'users.partner_id as id_pengajar', 'tblhari.namahari as hari', 'tblhari.id as id_hari', 'atur_jam.start as mulai', 'atur_jam.end as akhir')
        ->where('jadwal_kelas.kelas',$request->jadwal)//kelas
        ->orderBy('jadwal_kelas.jam', 'asc')
        ->get();

        Session::flash('delete', 'Berhasil menghapus Jadwal Tatap muka');

        return view('kelas.tabel_jadwal', compact('jadwal'));
    }


    // DETAIL SISWA
    // route:detaol_siswa/{id}
    public function detail_siswa($id)
    {
        $kelas_siswa = DB::table('room_user_mapel')
        ->join('kelas', 'room_user_mapel.room_id', '=', 'kelas.id_kelas')
        ->join('users', 'room_user_mapel.user_id', '=', 'users.partner_id')
        ->join('tblmapel', 'room_user_mapel.mapel', '=', 'tblmapel.id_mapel')
        ->select('room_user_mapel.*', 'kelas.room_name', 'users.name as siswa', 'tblmapel.nama as mapel','users.partner_id')
        ->where('users.partner_id',$id)
        ->get();
    	return view('kelas.detail_siswa',compact('kelas_siswa'));
    }
    
}
