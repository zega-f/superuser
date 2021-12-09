@extends('layout.template')
@section('contens')<br>
<div class="container border mb-3 rounded" style="padding: 20px; background-color: white; max-width: 1000px;">
	<h5 class="mb-3">
		Quiz {{ $this_quiz->mapel }} {{ $this_quiz->tingkat }}
		<span style="float: right; font-size: 14px; font-weight: normal;">
			<a href="{{url('unpublish_quiz/'.$this_quiz->quiz_id)}}" class="btn btn-sm btn-warning">
				Batalkan publikasi <i class="bi bi-check-square"></i>
			</a>
		</span>
	</h5>
	<table class="table">
		<tr>
			<td>Nama Quiz</td>
			<td>
				<input 
				type="text"
				class="form-control" 
				value="{{$this_quiz->quiz_name}}" 
				readonly="" 
				>
				<small class="text-muted">Berikan nama yang mewakili isi quiz yang akan Anda buat.</small>
			</td>
		</tr>
		
		<tr>
			<td>
				Batas Waktu
			</td>
			<td>
				<input type="number" name="duration" class="form-control form-control-sm" required="" min="1" value="{{$this_quiz->time}}" readonly="">
				<small>Berikan waktu pengerjaan pada quiz ini. <br>Ketika waktu pengerjaan telah habis, quiz pada siswa akan otomatis di kirim dan di nilai.</small>
			</td>
		</tr>
		<tr>
			<td>Nilai Minimum</td>
			<td>
				<input type="number" name="kkm" class="form-control form-control-sm" required="" max="100" value="{{$this_quiz->kkm}}" readonly="">
				<small>Berikan nilai minimum kelulusan pada quiz ini</small>
			</td>
		</tr>
	</table>
	@if(count($all_question)==0)
	<div class="alert alert-info">Belum terdapat pertanyaan. Buat satu untuk memulai</div>
	@else
		@foreach($all_question as $question)
			<div class="mb-3 border rounded question_body" id="question_container{{$question->id}}" style="padding: 20px; font-size: 14px;">
				<div id="question_body{{$question->id}}">
					<?php echo $question->question; ?>
				</div>
				<div id="option_body{{$question->id}}">
					<?php
						if (isset($all_question)) {
							$question_id = $question->id;
						}

						$all_option = DB::table('quiz_option')
						->where([
							['quiz_question_id',$question_id]
						])
						->get();
						
					?>
					<table class="table" style="border: none;">
						@foreach($all_option as $option)
							<tr class="option_text" id="option_text{{$option->id}}" style="position: relative;">
								<td id="column{{$option->id}}"><?php echo $option->option_text; ?></td>
								<td style="width: 50px;">
									@if($option->benar==1)
									<div class="badge badge-success">Benar</div>
									@endif
								</td>
							</tr>
						@endforeach
					</table>
				</div>
			</div>
		@endforeach
	@endif
</div>
@endsection