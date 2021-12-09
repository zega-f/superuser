{{-- @extends('layout.template')
@section('contens')<br> --}}
<?php
    $this_quiz = DB::table('quiz')
    	->where('quiz_id',$item->type_id)
    	->first();

        $all_question = DB::table('quiz_question')
        ->where('quiz_id',$item->type_id)
        ->orderBy('id','DESC')
        ->get();
?>


{{-- <div class="container border mb-3 rounded" style="padding: 20px; background-color: white; max-width: 1000px;">
	<h5 class="mb-3">
		Quiz
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
			<td>Kelas/Mapel</td>
			<td>
				<div class="row">
					<div class="col-md-6">
						<div class="" style="position: relative;">
							<input type="text" name="kelas" class="form-control form-control-sm" value="VusuSJ" readonly="">
						</div>
						<small class="text-muted">Pilih kelas dimana materi ini akan diberikan</small>
					</div>
					<div class="col-md-6">
						<input type="text" name="mapel" class="form-control form-control-sm" value="3" readonly="">
						<small class="text-muted">Pilih mata pelajaran</small>
					</div>
				</div>
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
</div> --}}

{{-- <div class="card container border mb-3">
	<div class="row">
		<div class="col-10">
			<div class="card-body">
				<h5 class="mb-3">
					Quiz {{ $this_quiz->mapel }} <small>{{ $this_quiz->tingkat }}</small>
				</h5>

				<div class="row" style="font-size: 14px;">
					<div class="col-3">
						<small class="mb-0" style="color: grey">Nama Quiz</small><br>
						<span class="mt-0">{{$this_quiz->quiz_name}}</span>
					</div>
					<div class="col-3">
						<small class="mb-0" style="color: grey">Kelas/Mapel</small><br>
						<span class="mt-0">{{ $this_quiz->mapel }} <small>{{ $this_quiz->tingkat }}</small></span>
					</div>
					<div class="col-3">
						<small class="mb-0" style="color: grey">Batas Waktu</small><br>
						<span class="mt-0">{{$this_quiz->time}}</span>
					</div>
					<div class="col-3">
						<small class="mb-0" style="color: grey">Nilai Minimum</small><br>
						<span class="mt-0">{{$this_quiz->kkm}}</span>
					</div>
				</div>
			</div>

		</div>
		<div class="col-2 mt-4">
			<span style="float: right; font-size: 14px; font-weight: normal;">
				<a href="{{url('unpublish_quiz/'.$this_quiz->quiz_id)}}" class="btn btn-sm btn-warning">
					Batalkan publikasi <i class="bi bi-check-square"></i>
				</a><br>
				<a href="{{ url('kelola_mapelkelas/'.$this_quiz->room_id.'/'.$this_quiz->mapel_id)}}" class="btn btn-sm btn-light mt-2">
					Menu Bab <i class="ion-ios-undo"></i>
				</a>
			</span>
		</div>
	</div>
</div> --}}





<div class="row">
	<div class="col-md-9 col-sm-12">
		<div class="card">
			<div class="card-body">

				@if(count($all_question)==0)
				<div class="alert alert-info">Belum terdapat pertanyaan. Buat satu untuk memulai</div>
				@else

				<div class="tab-content">
					<?php $no=1;?>
					@foreach($all_question as $question)
					<?php $no_urut=$no++;?>

						<div class="tab-pane {{ $no_urut == 1 ? 'active' : '' }} question_body" id="question_container{{$question->id}}">

							<?php  
								$check_attachment = DB::table('quiz_question_attachment')
								->where([
									['quiz_id',$question->quiz_id],
									['question_id',$question->question_id]
								])
								->first();
							?>
							@if($check_attachment)
							<a href="{{url('public/muatan/quiz/lampiran/'.$check_attachment->filename)}}">
								<img src="{{url('public/muatan/quiz/lampiran/'.$check_attachment->filename)}}" width="300" style="margin: 0 auto; display: block;">
							</a>
							@endif
							<?php echo $question->question; ?>
						

							<div id="option_body{{$question->id}}">
								<?php
									if (isset($all_question)) {
										$question_id = $question->question_id;
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
				</div>
				@endif
			</div>
		</div>
	</div>

	<div class="col-md-3">

		<div class="card">
			<div class="card-header">
				<h5 class="card-title" style="font-size:16px;"><b>Menu Soal</b></h5>
			</div>
	
			<div class="card-body">
				<?php $urutan=1;?>
				<ul class="nav nav-pills">
					@foreach($all_question as $question)
						<?php $nomer=$urutan++; ?>
						<li class="nav-item" style="padding:5px !important; font-size:12px !important;">
							<a class="nav-link {{ $nomer == 1 ? 'active' : '' }} btn btn-sm btn-light question_body" href="#question_container{{$question->id}}" data-toggle="tab" data-toggle="tooltip" title="Menu Soal" id="question_container2{{$question->id}}">{{ $nomer }}</a>
						</li>

						<script type="text/javascript">

							$('#question-lampiran{{$question->id}}').on('click','.preview-question-img', function(){
								var url = $(this).data('url');
								$('#preview-img').attr('src',url);
								$('#preview-img-modal').css({
									'display':'grid',
									'place-items':'center',
								});
							});
							
							$('#option_body{{$question->question_id}}{{$question->quiz_id}}').on('click','.edit-option{{$question->question_id}}{{$question->quiz_id}}',function(){
								var id = $(this).data('id');
								$.ajax({
									type : 'get',
									url : '{{URL::to('edit_option')}}',
									data : {option_id:id},
									success:function(data)
									{
										$('#editing_option_modal').css({
											'display':'grid',
											'place-items':'center',
										}).html(data);
									}
								})
							})
				
							$('#option_body{{$question->question_id}}{{$question->quiz_id}}').on('click','.delete-option{{$question->question_id}}{{$question->quiz_id}}',function(){
								var id = $(this).data('id');
								var question_id = $(this).data('question');
								$.ajax({
									type : 'get',
									url : '{{URL::to('delete_option')}}',
									data : {option_id:id,question_id:question_id,quiz_id:'{{$question->quiz_id}}'},
									success:function(data)
									{
										$('#option_body'+question_id+'{{$question->quiz_id}}').html(data);
										$('#option_text'+id).remove();
									}
								})
							})
				
							$('#option_body{{$question->question_id}}{{$question->quiz_id}}').on('click','.option_radio{{$question->question_id}}{{$question->quiz_id}}',function(e){
								e.preventDefault();
								var id = $(this).data('id');
								var question_id = $(this).data('question');
								$.ajax({
									type : 'get',
									url : '{{URL::to('set_as_right_answer')}}',
									data : {option_id:id},
									success:function(data)
									{
										$('#radio'+question_id+id).prop("checked",true);
									},
									error: function()
									{
										alert('gagal');
									}
								})
							})
						</script>

					@endforeach
				</ul>
			</div>
	
			<div class="card-footer">
				{{-- <button class="btn btn-sm btn-primary fas fa-plus" id="add_question" style="padding:5px !important; font-size:13px !important;"> Pertanyaan</button> --}}
			</div>	
		</div>

	</div>

</div>