<?php

namespace App\Http\Controllers\quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

use DB;

class quizController extends Controller
{
    public function index()
    {
    	return view('muatan.quiz.index');
    }

    public function store(Request $request)
    {
        $mapel=$request->mapel;
    	$quiz_id = Str::random(8);

    	DB::table('quiz')
    	->insert([
    		'bab_id'=>$request->bab_id,
    		'room_id'=>$request->kelas,
    		'mapel_id'=>$mapel,
    		'quiz_id'=>$quiz_id,
    		'quiz_name'=>$request->nama,
    		'kkm'=>$request->kkm,
    		'time'=>$request->duration,
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
    		'type'=>'quiz',
    		'type_id'=>$quiz_id,
    	]);
        Session::flash('simpan_quiz', 'Berhasil Menambahkan Quiz');
    	return back();
    }

    public function edit($quiz_id)
    {
    	$this_quiz = DB::table('quiz')
        ->join('db_jenjang','db_jenjang.tingkat','=','quiz.room_id')
        // ->join('tblmapel','tblmapel.id_mapel','=','quiz.mapel_id')

        ->join('mapel_kelas', 'quiz.mapel_id', '=', 'mapel_kelas.id_mapel_kelas')
        ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')

        ->select('quiz.*','tblmapel.nama as mapel','db_jenjang.nama as tingkat')
    	->where('quiz_id',$quiz_id)
    	->first();

        $all_question = DB::table('quiz_question')
        ->where('quiz_id',$quiz_id)
        ->orderBy('id','DESC')
        ->get();

        if ($this_quiz->status==0) {
            return view('muatan.quiz.edit_quiz',compact('this_quiz','all_question','quiz_id'));
        }else{
            return view('muatan.quiz.published_quiz',compact('this_quiz','all_question','quiz_id'));
        }
    }

    public function update(Request $request, $id)
    {
        DB::table('quiz')
        ->where('quiz_id',$id)
        ->update([
            'quiz_name'=>$request->nama,
            'kkm'=>$request->kkm,
            'time'=>$request->duration,
        ]);
        Session::flash('update_quiz', 'Berhasil MengUpdate Quiz');
        return back();
    }

    // public function unpublish($quiz_id)
    // {
    //     $this_quiz = DB::table('quiz')
    //     ->where('quiz_id',$quiz_id);

    //     $status = $this_quiz->first()->status;
    //     $new_stat = 0;

    //     $this_quiz_question = DB::table('quiz_question')
    //     ->where('quiz_id',$quiz_id)
    //     ->get();

    //     $need_answer = 0;
    //     foreach ($this_quiz_question as $question) {
    //         $option = DB::table('quiz_option')
    //         ->where([
    //             ['quiz_id',$quiz_id],
    //             ['quiz_question_id',$question->id]
    //         ])
    //         ->count();

    //         if ($option==0) {
    //             $need_answer+=1;
    //         }
    //     }

    //     if ($need_answer==0) {
    //         if ($status==0) {
    //             $new_stat = 1;
    //         }

    //         DB::table('quiz')
    //         ->where('quiz_id',$quiz_id)
    //         ->update([
    //             'status'=>$new_stat
    //         ]);

    //         return redirect()->route('edit_quiz',['quiz_id'=>$quiz_id]);
    //     }else{
    //         return redirect()->route('edit_quiz',['quiz_id'=>$quiz_id])->with('fail','Terdapat soal tanpa jawaban');
    //     }
    // }

    public function unpublish($quiz_id)
    {
        $this_quiz = DB::table('quiz')
        ->where('quiz_id',$quiz_id);

        $status = $this_quiz->first()->status;
        $new_stat = 0;

        $this_quiz_question = DB::table('quiz_question')
        ->where('quiz_id',$quiz_id)
        ->get();

        $need_answer = 0;
        $need_right_answer = 0;
        // mencari quiz yang belum mempunyai jawaban
        foreach ($this_quiz_question as $question) {
            $option = DB::table('quiz_option')
            ->where([
                ['quiz_id',$quiz_id],
                ['quiz_question_id',$question->question_id]
            ])
            ->count();

            $right_option = DB::table('quiz_option')
            ->where([
                ['quiz_id',$quiz_id],
                ['quiz_question_id',$question->question_id],
                ['benar',1]
            ])
            ->count();

            if ($right_option==0) {
                $need_right_answer+=1;
            }

            if ($option==0) {
                $need_answer+=1;
            }
        }

        /*
            check apakah quiz ini sudah memiliki jawaban atau belum
            if pertanyaan < 1 then return back();
            else check pertanyaan butuh jawaban dan pertanyaan butuh jawaban benar
        */
        if (count($this_quiz_question)<1) {
            return back()->with('fail','Belum terdapat pertanyaan pada Quiz ini. Buat setidaknya satu pertanyaan untuk melanjutkan');
        }else{
            // check need_answer dan need_right_answer. Keduanya harus bernilai true
            if ($need_answer==0 && $need_right_answer==0) {
                $msg = 'Terdapat soal tanpa jawaban atau terdapat soal tanpa jawaban benar.';
                if ($status==0) {
                    $new_stat = 1;
                }

                DB::table('quiz')
                ->where('quiz_id',$quiz_id)
                ->update([
                    'status'=>$new_stat
                ]);

                return redirect()->route('edit_quiz',['quiz_id'=>$quiz_id]);
            }else{
                return redirect()->route('edit_quiz',['quiz_id'=>$quiz_id])->with('fail',$msg);
            }
        }
    }




    public function delete_quiz(Request $request)
    {
        $del_quiz = \DB::table('quiz')
        ->where(
            'quiz_id',$request->quiz_id)->delete();
        
        $del_question = \DB::table('quiz_question')
        ->where(
            'quiz_id',$request->quiz_id)->delete();

        $del_option = \DB::table('quiz_option')
        ->where(
            'quiz_id',$request->quiz_id)->delete();
        
            $delete_sub = DB::table('sub_bab')
            ->where([
                ['type_id',$request->quiz_id]
            ])
            ->delete();
            
        // return view('mapel.tabel_pengajar_mapel');
        $idbab = $request->bab;
        Session::flash('delete_quiz', 'Berhasil Menghapus Quiz');
		return view('kelola_mapel.index',compact('idbab'));
    }



}
