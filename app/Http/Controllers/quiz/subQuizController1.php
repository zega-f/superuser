<?php

namespace App\Http\Controllers\quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class subQuizController extends Controller
{
    public function store_question(Request $request)
    {
    	$new_question = DB::table('quiz_question')
    	->insert([
    		'quiz_id'=>$request->quiz_id,
    		'question'=>$request->question,
    	]);

        $quiz_id = $request->quiz_id;

        $all_question = DB::table('quiz_question')
        ->where('quiz_id',$quiz_id)
        ->orderBy('id','DESC')
        ->get();
    	
    	return view('muatan.quiz.component.all_question',compact('quiz_id','all_question'));
    }

    public function edit_this_question(Request $request)
    {
    	$this_question = DB::table('quiz_question')->where('id',$request->question_id)->first();
    	// print_r($this_question);
    	return view('muatan.quiz.component.edit_this_question',compact('this_question'));
    }

    public function update_this_question(Request $request)
    {
    	DB::table('quiz_question')
    	->where('id',$request->question_id)
    	->update([
    		'question'=>$request->edited_question,
    	]);
    }

    public function delete_this_question(Request $request)
    {
    	$quiz_id = DB::table('quiz_question')
    	->where('id',$request->question_id)
    	->first()->quiz_id;

    	DB::table('quiz_option')
    	->where([
    		['quiz_id',$quiz_id],
    		['quiz_question_id',$request->question_id]
    	])
    	->delete();

    	DB::table('quiz_question')
    	->where('id',$request->question_id)
    	->delete();
    }

    public function create_option(Request $request)
    {
    	$this_question = DB::table('quiz_question')->where('id',$request->question_id)->first();
    	return view('muatan.quiz.component.make_option',compact('this_question'));
    }

    public function store_option(Request $request)
    {
    	$quiz_id = DB::table('quiz_question')
    	->where('id',$request->question_id)
    	->first()->quiz_id;

    	if ($request->option==null) {
    		$response = array(
    			'type' => 'fail',
    			'message' => 'Opsi tidak boleh kosong',
    		);

            return response($response);
    	}else{
            $first_option = DB::table('quiz_option')
            ->where([
                ['quiz_id',$quiz_id],
                ['quiz_question_id',$request->question_id]
            ])
            ->count();

            if ($first_option==0) {
                DB::table('quiz_option')
                ->insert([
                    'quiz_id'=>$quiz_id,
                    'quiz_question_id'=>$request->question_id,
                    'option_text'=>$request->option,
                    'benar'=>1,
                ]);
            }else{
                DB::table('quiz_option')
                ->insert([
                    'quiz_id'=>$quiz_id,
                    'quiz_question_id'=>$request->question_id,
                    'option_text'=>$request->option,
                ]);
            }

            $question_id = $request->question_id;

    		return view('muatan.quiz.component.option_list',compact('question_id'));
    	}
    }

    public function edit_option(Request $request)
    {
        $this_option = DB::table('quiz_option')
        ->where('id',$request->option_id)
        ->first();

        return view('muatan.quiz.component.edit_option',compact('this_option'));
    }

    public function update_option(Request $request)
    {
        $this_option = DB::table('quiz_option')
        ->where('id',$request->option_id)
        ->update([
            'option_text'=>$request->new_option
        ]);

        $question_id = $request->question_id;
        // echo $question_id;
        return view('muatan.quiz.component.option_list',compact('question_id'));
    }

    public function set_as_right_answer(Request $request)
    {
        $this_option = DB::table('quiz_option')
        ->where('id',$request->option_id)
        ->first();

        $set_as_wrong_ans = DB::table('quiz_option')
        ->where([
            ['quiz_id',$this_option->quiz_id],
            ['quiz_question_id',$this_option->quiz_question_id]
        ])
        ->update([
            'benar'=>0,
        ]);

        $set_as_right_answer = DB::table('quiz_option')
        ->where('id',$request->option_id)
        ->update([
            'benar'=>1
        ]);
    }

    public function delete_option(Request $request)
    {
        DB::table('quiz_option')
        ->where('id',$request->option_id)
        ->delete();

        $question_id = $request->question_id;

        return view('muatan.quiz.component.option_list',compact('question_id'));
    }
}
