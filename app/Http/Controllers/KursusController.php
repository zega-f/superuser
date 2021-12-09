<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
use \MacsiDigital\Zoom\Facades\Zoom;
use \app\Traits\ZoomJWT;
use App\Zoom\Zoom_Api;

use App\Models\user;
use App\Traits\ZoomMeetingTrait;

class KursusController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    public function store1(Request $request)
    {
        $this->create($request->all());

        return back();
    }

    // public function show($id)
    // {
        
    //     $meeting = $this->get($id);
    //     print_r ($meeting);
    //     // return view('meetings.index', compact('meeting'));
    // }

    public function index()
    {
        $kursus = DB::table('room')
        ->get();
        return view('kursus/data_kursus',compact('kursus'));
    }



    //add kursus
    public function kursus_store(Request $request)
    {
        $room_id = Str::random(6);
        $store = DB::table('room')
        ->insert([
            'room_name'=>$request->kursus_name,
            'description'=>$request->description,
            'biaya'=>$request->biaya,
            'kursus_spv'=>$request->kursus_spv,
            'room_id'=>$room_id,
            'icon'=>$request->icon,
        ]);

        $store = DB::table('kursus_spv')
        ->insert([
            'id_spv'=>$request->kursus_spv,
            'room_id'=>$room_id,
        ]);

        if ($store) {
            Session::flash('add_kursus', 'Berhasil Menambahkan Kursus');
            return back();
        }  
    }


    public function kursus_spv_store(Request $request)
    {
        $store = DB::table('kursus_spv')
        ->insert([
            'id_spv'=>$request->kursus_spv,
            'room_id'=>$request->room_id,
        ]);

        if ($store) {
            return back();
        }  
    }


    public function kursus_non_aktif(Request $request)
    {
        $non_aktif = DB::table('room')
        ->where(
            'room_id',$request->room_id,
        )
        ->update([
            'locked'=>'0',
        ]);
    }

    public function kursus_aktif(Request $request)
    {
        $aktif = DB::table('room')
        ->where(
            'room_id',$request->room_id,
        )
        ->update([
            'locked'=>'1',
        ]);
    }


    public function delete_kursus(Request $request)
    {
        $del_kursus = \DB::table('room')
        ->where(
            'room_id',$request->room_id)->delete();

        $kursus = DB::table('room')->get();
        Session::flash('del_kursus', 'Berhasil Menghapus Kursus');
        return view('kursus.tabel_kursus', compact('kursus'));

    }

    public function delete_spv(Request $request)
    {
        $del_spv = \DB::table('kursus_spv')
        ->where(
            'id',$request->id)->delete();

            $spv = DB::table('users')
            ->join('kursus_spv','.users.partner_id','=','kursus_spv.id_spv')
            ->where('kursus_spv.room_id',$request->room_id)
            ->get();
        return view('kelola_kursus.spv.tabel_spv', compact('spv'));

    }


    public function kursus_update(Request $request)
    {
	    DB::table('room')->where('room_id',$request->room_id)
        ->update([
           
		    'room_name' => $request->nama,
            'description' => $request->info,
            'biaya' => $request->biaya,
            // 'kursus_spv' => $reuqest->kursus_spv,
            'icon' => $request->icon,
	    ]);
        Session::flash('update_kursus', 'Berhasil MengUpdate Kursus');
	    return back();
    }


    //// Kelola Kurusus ///////////
    public function kelola_kursus($room_id)
    {
        $bab_kursus = DB::table('bab')
        ->where('bab.room_id',$room_id)
        ->get();

        $nm_kursus = DB::table('room')
        ->where('room_id',$room_id)
        ->first();

        $spv = DB::table('users')
        ->join('kursus_spv','.users.partner_id','=','kursus_spv.id_spv')
        ->where('kursus_spv.room_id',$room_id)
        ->get();

    
        return view('kelola_kursus/index_kelola_kursus',compact('bab_kursus','nm_kursus','spv'));
    }



    public function store_bab_kursus(Request $request)
    {
        // $type='kursus';
        $cekrow = DB::table('bab')->count();
        $id_bab = 1;

        if ($cekrow == 0) {
            DB::table('bab')->truncate();
        } else {
            $id_bab = DB::table('bab')->orderBy('id', 'desc')->first()->id+1;
        }
        
        $store = DB::table('bab')
        ->insert([
            'room_id'      =>  $request->room_id,
            'bab_name'     => $request->bab_name,
            'type'         =>  $request->type,
            'id_bab'       => $id_bab,
        ]);

        if ($store) {
            Session::flash('tambah_bab', 'Berhasil Menambahkan Bab');
            return back();
        }else{
            Session::flash('gagal_bab', 'Gagal Menambahkan Bab');
            return back();
        }
    }


    public function add_materi($room_id, $bab_id)
    {
        $nm_kursus = DB::table('room')
        ->where('room_id',$room_id)
        ->first();
    	return view('kelola_kursus.materi.add_form_materi',compact('nm_kursus','room_id','bab_id'));
    }


    public function edit_materi($materi_id,$room_id)
    {
        $this_materi = DB::table('coba_materi')
        ->join('room','coba_materi.id_kelas','=','room.room_id')
        ->select('coba_materi.*','room.room_id','room.room_name')
    	->where('coba_materi.id_materi',$materi_id)
    	->first();

    	$this_materi_lampiran = DB::table('coba_materi_lampiran')
    	->where([
    		['materi_id',$materi_id]
    	])
    	->get();


    	$type = 'edit';


    	return view('kelola_kursus.materi.edit_form_materi',compact('this_materi','this_materi_lampiran','type'));
    }


    public function update_materi(Request $request, $id_materi,$room_id)
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
			return redirect('kelola_kursus/'.$room_id);
        // return back();
    }



    public function add_tugas($room_id,$bab_id)
    {
    	$nm_kursus = DB::table('room')
        ->where('room_id',$room_id)
        ->first();
    	return view('kelola_kursus.tugas.add_form_tugas',compact('nm_kursus','room_id','bab_id'));
    }



    public function edit_tugas($tugas_id, $room_id)
    {
        $this_tugas = DB::table('coba_tugas')
        ->join('room','coba_tugas.id_kelas','=','room.room_id')
        // ->join('tblmapel','coba_tugas.mapel','=','tblmapel.id_mapel')
        ->select('coba_tugas.*','room.room_id','room.room_name')
        ->where('coba_tugas.id_tugas',$tugas_id)
        ->first();

        $this_tugas_lampiran = DB::table('coba_tugas_lampiran')
        ->where([
            ['tugas_id',$tugas_id]
        ])
        ->get();

        return view('kelola_kursus.tugas.edit_tugas',compact('this_tugas','this_tugas_lampiran'));
    }

    public function update_tugas(Request $request, $tugas_id,$room_id)
    {
        $string_random = Str::random(32);
        $directory = "public/muatan/tugas/";
        $lampiran_dir = "public/muatan/tugas/lampiran/";
        $file_array = array();

        $update_tugas = DB::table('coba_tugas')
        ->where('id_tugas',$tugas_id)
        ->update([
            'judul'=>$request->judul,
            'waktu'=>$request->date.' '.$request->time,
        ]);

        $json_content = array(
            'id_tugas' => $tugas_id,
            'judul'=>$request->judul,
            'konten' => $request->konten,
        );

        $text = json_encode($json_content);

        $myfile = fopen($directory.$tugas_id.'.json', "w");
        fwrite($myfile, $text);

        if ($request->attachment) {
            for ($i=0; $i <count($request->attachment) ; $i++) { 
                $file_array[] = array(
                    'tugas_id'=>$tugas_id,
                    'attachment_name'=>$string_random.$request->attachment[$i]->getClientOriginalName(),
                    'attachment_original_name'=>$request->attachment[$i]->getClientOriginalName(),
                );
                $request->attachment[$i]->move($lampiran_dir,$string_random.$request->attachment[$i]->getClientOriginalName());
            }

            $store_lampiran = DB::table('coba_tugas_lampiran')
            ->insert($file_array);
        }
        Session::flash('update_tugas', 'Berhasil MengUpdate Tugas');
        return redirect('kelola_kursus/'.$room_id);
    }




    public function edit_quiz($quiz_id)
    {
    	$this_quiz = DB::table('quiz')
        ->join('room','room.room_id','=','quiz.room_id')
        // ->join('tblmapel','tblmapel.id_mapel','=','quiz.mapel_id')
        ->select('quiz.*','room.room_id','room.room_name')
    	->where('quiz_id',$quiz_id)
    	->first();

        $all_question = DB::table('quiz_question')
        ->where('quiz_id',$quiz_id)
        ->orderBy('id','DESC')
        ->get();

        if ($this_quiz->status==0) {
            return view('kelola_kursus.quiz.edit_quiz',compact('this_quiz','all_question','quiz_id'));
        }else{
            return view('kelola_kursus.quiz.published_quiz',compact('this_quiz','all_question','quiz_id'));
        }
    }

    public function update_quiz(Request $request, $id)
    {
        DB::table('quiz')
        ->where('quiz_id',$id)
        ->update([
            'quiz_name'=>$request->nama,
            'kkm'=>$request->kkm,
            'time'=>$request->duration,
        ]);

        Session::flash('update_quiz', 'Berhasil MengUpdate Quiz');
        return back()->with('success','Berhasil mengupdate Quiz');
    }



    public function unpublish_quiz($quiz_id)
    {
        $this_quiz = DB::table('quiz')
        ->where('quiz_id',$quiz_id);

        $status = $this_quiz->first()->status;
        $new_stat = 0;

        $this_quiz_question = DB::table('quiz_question')
        ->where('quiz_id',$quiz_id)
        ->get();

        $need_answer = 0;
        foreach ($this_quiz_question as $question) {
            $option = DB::table('quiz_option')
            ->where([
                ['quiz_id',$quiz_id],
                ['quiz_question_id',$question->id]
            ])
            ->count();

            if ($option==0) {
                $need_answer+=1;
            }
        }

        if ($need_answer==0) {
            if ($status==0) {
                $new_stat = 1;
            }

            DB::table('quiz')
            ->where('quiz_id',$quiz_id)
            ->update([
                'status'=>$new_stat
            ]);

            return redirect('edit_quiz_kursus/'.$quiz_id);
        }else{
            return redirect('edit_quiz_kursus/'.$quiz_id)->with('fail','Terdapat soal tanpa jawaban');
        }
    }



    public function jadwal_kursus($room_id)
    {
        // ($room_id==null ? 0 : $id);
        // $room_id=$request->room_id;
        $bab_kursus = DB::table('bab')
        ->where('bab.room_id',$room_id)
        ->get();

        $nm_kursus = DB::table('room')
        ->where('room_id',$room_id)
        ->first();
      
        // $edit_jadwal = \DB::table('jadwal_kelas')
        // ->where('id',$room_id)
        // ->get();
        $pengajar = DB::table('users')
        ->where('partner_type',1)
         ->get();

        $jadwal = DB::table('video_conference')
        ->join('users', 'video_conference.owner_id', '=', 'users.partner_id')
        // ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
        ->join('atur_jam', 'video_conference.jam', '=', 'atur_jam.id')
        ->select('video_conference.*','users.name as pengajar', 'users.partner_id as id_pengajar', 'atur_jam.start as mulai', 'atur_jam.end as akhir')
        ->where('video_conference.room_id',$room_id)
        // ->orderBy('.jam', 'asc')
        ->get();

        // $edit_jadwal = \DB::table('jadwal_kelas')
        // ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.nama')
        // // ->where('jadwal_kelas.id','9')
        // ->first();

        return view('kelola_kursus.jadwal.index_jadwal',compact('bab_kursus','nm_kursus','jadwal','pengajar'));
    }


   

    public function jadwalkursus_store(Request $request)
    {
        $meet_id = Str::random(16);

        $start_time = DB::table('atur_jam')
            ->where('id',$request->jam)
            ->first();

        $mulai=$start_time->start;

        $meetings = Zoom::user()->find('fauzytamimkdr@gmail.com')->meetings()->create([
            'topic' => $request->title,
            'duration' => 45, // In minutes, optional
            "start_time" => "$request->tanggal $mulai",
            'timezone' => 'Asia/Jakarta',
            "password" => "123456"
          ]);

       
        $store = DB::table('video_conference')
        ->insert([
            'title'=>$request->title,
            'url'=>$meetings->join_url,
            'meet_id'=>$meetings->id,
            'room_id'=>$request->room_id,
            'owner_id'=>$request->pengajar_name,
            'tanggal'=>$request->tanggal,
            'jam'=>$request->jam,
        ]);

        Session::flash('add_jadwal_kursus', 'Berhasil Menambahkan Jadwal Tatap Muka, Cek di Akun Zoom Meeting');
        return back();
    }



    


    public function delete_jadwal(Request $request)
    {
        $meeting=Zoom::meeting()->find($request->id_jadwal);
        $meeting->delete();

        $del_jadwal = \DB::table('video_conference')
        ->where(
            'meet_id',$request->id_jadwal)->delete();
        
            $jadwal = DB::table('video_conference')
            ->join('users', 'video_conference.owner_id', '=', 'users.partner_id')
            // ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
            ->join('atur_jam', 'video_conference.jam', '=', 'atur_jam.id')
            ->select('video_conference.*','users.name as pengajar', 'users.partner_id as id_pengajar', 'atur_jam.start as mulai', 'atur_jam.end as akhir')
            ->where('video_conference.room_id',$request->jadwal)
            // ->orderBy('jadwal_kelas.jam', 'asc')
            ->get();

        Session::flash('del_jadwal_kursus', 'Berhasil Menghapus Jadwal Tatap Muka');
        return view('kelola_kursus.jadwal.tabel_jadwal', compact('jadwal'));
    }


    public function edit_jadwal(Request $request,$id)
    {
        $edit_jadwal = \DB::table('jadwal_kelas')
            ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.nama')
            // ->select('jadwal_kelas.*','atur_jam.nama as jam','atur_jam.start as mulai', 'atur_jam.end as akhir')
            ->where('jadwal_kelas.id',$id)
            ->first();

        return view('kelola_kursus.jadwal.edit_jadwal', compact('edit_jadwal'));
    }


    public function update_jadwal(Request $request)
    {
        $start_time = DB::table('atur_jam')
            ->where('id',$request->jam)
            ->first();

        $mulai=$start_time->start;

        $meetings = Zoom::meeting()->find($request->meet_id)->update([
            'meet_id'=>$request->meet_id,
            'topic' => $request->title,
            'duration' => 30, // In minutes, optional
            "start_time" => "$request->tanggal $mulai",
            'timezone' => 'Asia/Jakarta',
            "password" => "123456"
          ]);
          $meetings->save();

        $update_jadwal = \DB::table('video_conference')
        ->where('id',$request->id_jadwal)
            ->update([
               
                'title'=>$request->title,
                'url'=>$request->url,
                'owner_id'=>$request->pengajar_name,
                'tanggal'=>$request->tanggal,
                'jam'=>$request->jam,
            ]);
       
        Session::flash('update_jadwal_kursus', 'Berhasil MengUpdate Jadwal Tatap Muka');
        return back();
    }


    
    public function participant_kursus($room_id)
    {
        // $room_id=$request->room_id;
        $bab_kursus = DB::table('bab')
        ->where('bab.room_id',$room_id)
        ->get();

        $nm_kursus = DB::table('room')
        ->where('room_id',$room_id)
        ->first();

        $participant = DB::table('room_user')
        ->join('users', 'users.partner_id', '=', 'room_user.user_id')
        ->join('user_detail', 'room_user.user_id', '=', 'user_detail.user_id')
        ->leftjoin('kelas', 'room_user.room_id', '=', 'kelas.id_kelas')
        ->where('room_user.status','1')
        ->where('room_user.type','1')
         ->where('room_user.room_id',$room_id)
        ->select('room_user.*', 'users.name','users.email','users.partner_id','user_detail.address','user_detail.phone')
        ->paginate(3);

        return view('kelola_kursus.participant.index_participant', compact('participant','bab_kursus','nm_kursus'));
    }



    public function test()
    {
        $test = DB::table('sub_bab')
        ->where('bab_id','20')
        ->orderBy('sub_id','asc')
        ->get();
    	// return view('siswa.detail_siswa',compact('det_siswa'));
        return view('kursus/test',compact('test'));
    }


    public function update_test(Request $request) 
    {
        $a=$request->page_id_array;
        for($i=0; $i<count($a); $i++) {
            $update = DB::table('sub_bab')
            ->where(
                'id',$a[$i]
            )
            ->update([
                'sub_id'=>$i+1,
            ]);
        }
        echo 'Page Order has been updated'; 
        // toastr.success('dddddd');
    //    Session::flash('ordering', 'Urutan Materi telah diperbarui');
        // echo $id; 
    }

    // for($i=0; $i<count(1); $i++)
    // {
    //  $query = "
    //  UPDATE page 
    //  SET page_order = '".$i."' 
    //  WHERE page_id = '".$_POST["page_id_array"][$i]."'";
    //  mysqli_query($connect, $query);
    // }
    // echo 'Page Order has been updated'; 


    // }
}
