<?php
	if (isset($all_question)) {
		$question_id = $question->question_id;
		$quiz_id = $question->quiz_id;
	}

	$all_option = DB::table('quiz_option')
	->where([
		['quiz_question_id',$question_id],
		['quiz_id',$quiz_id]
	])
	->orderBy('id','DESC')
	->get();

	$right_answer = 0;
?>
@if(count($all_option)>0)
<table class="table option-table" style="border: none;">
	@foreach($all_option as $option)
	<?php 
		if ($option->benar==1) {
			$right_answer+=1;
		}
		$img_id = explode('.', $option->attachment);
	?>
		<tr class="option_text" id="option_text{{$option->id}}" style="position: relative; font-size: 14px;">
			<td id="column{{$option->id}}">
				<div class="option-text">
					@if($option->attachment!=null)
					<img src="{{url('public/muatan/quiz/lampiran_option/'.$option->attachment)}}" style="max-width: 100px; background-color: none;" class="img{{$img_id[0]}}">
					@endif
					<div>
						<?php echo $option->option_text; ?>
					</div>
				</div>
			</td>
			<td style="width: 100px;">
				<i class="delete-option{{$question_id}}{{$quiz_id}} ion-trash-b text-danger pointer" data-id="{{$option->id}}" data-question="{{$question_id}}"></i>
				<i class="edit-option{{$question_id}}{{$quiz_id}} ion-edit text-info pointer" data-id="{{$option->id}}"></i>
				<input type="radio" name="right_answer{{$question_id}}" id="radio{{$question_id}}{{$option->id}}" class="option_radio{{$question_id}}{{$quiz_id}}"  data-id="{{$option->id}}" data-question="{{$question_id}}" <?php if ($option->benar==1) {
					echo "checked";
				}?>>
			</td>
		</tr>
		
	@endforeach
</table>

@if($right_answer==0)
<div class="alert alert-danger mt-3" style="display: inline-block;">
	Belum terdapat jawaban benar
</div>
@endif

@else
<div class="alert alert-danger need_option mt-3">
	Belum terdapat pilihan jawaban pada soal ini
</div>
@endif
<div class="modal" id="editing_option_modal"></div>
