{{-- <div class="alert alert-danger" style="max-width: 500px; font-size: 14px;">
	Pertanyaan tanpa jawaban benar tidak akan ditampilkan pada user dan tetap bernilai benar.
</div> --}}



<div class="row">
	<div class="col-md-9 col-sm-12">
		<div class="card">
			<div class="card-body">

				@if(count($all_question)==0)
					<div class="alert alert-info mt-2">Belum terdapat pertanyaan. Buat satu untuk memulai</div>
				@else

				<div class="tab-content">
					<?php $no=1;?>
					@foreach($all_question as $question)
					<?php $no_urut=$no++;?>
					
							
					<div class="tab-pane {{ $no_urut == 1 ? 'active' : '' }} question_body" id="question_container{{$question->id}}">
						
						<header class="mb-3">
							<small style="color: grey;"><b> Quiz {{ $this_quiz->mapel }} {{ $this_quiz->tingkat }}</b></small>

							<span class="float-right">
								<button class="btn btn-sm btn-primary fas fa-plus" id="add_question" style="padding:5px !important; font-size:13px !important;"> Pertanyaan</button>

								<button class="btn btn-sm btn-info fas fa-pencil-alt edit_this_question" data-id="{{$question->id}}" data-toggle="tooltip" data-placement="bottom" title="Edit question" style="padding:5px !important; font-size:13px !important;"></button>
								
								<button class="btn btn-sm btn-danger fas fa-trash delete_this_question" data-id="{{$question->id}}" data-toggle="tooltip" data-placement="bottom" title="Delete Question" style="padding:5px !important; font-size:13px !important;"></button>
							</span>
						</header>
						<hr>

						<small class="mb-0" style="color: grey;"><b>Question {{ $no_urut }}</b></small>
						
						<p  class="mt-0" id="question_body{{$question->id}}">
							<?php  
								$check_attachment = DB::table('quiz_question_attachment')
								->where([
									['quiz_id',$quiz_id],
									['question_id',$question->question_id]
								])
								->first();
								$question_img_id='';

								if ($check_attachment) {
									$question_img_id = explode('.', @$check_attachment->filename);
								}
							?>
							
							@if($check_attachment)

								<header><b>Attachment : </b></header>
								<div id="question-lampiran{{$question->id}}">
									<img 
										src="{{url('public/muatan/quiz/lampiran/'.$check_attachment->filename)}}" 
										width="200" 
										style="display: block;" 
										class="preview-question-img pointer" 
										data-url="{{url('public/muatan/quiz/lampiran/'.$check_attachment->filename)}}"
										id="img{{ $question_img_id[0] }}">
								</div>
							@endif
						<p>



						<div id="question_body{{$question->id}}" style="font-size: 16px;">
							<?php
								echo $question->question; 
							?>
						</div>

						<hr>
						<header style="color: grey;">
							<small><b>Choice :</b></small>
							<span class="float-right">
								<button class="btn btn-sm btn-success fas fa-plus add_option mb-2" data-id="{{$question->id}}" data-toggle="tooltip" data-placement="bottom" title="Add Option" style="padding:5px !important; font-size:13px !important;"> Pilihan Ganda</button>
							</span>
						</header>
						<div id="option_body{{$question->question_id}}{{$quiz_id}}">
							@include('muatan.quiz.component.option_list')
						</div>

						
	

					</div>


					
					@endforeach

					
				</div>
				@endif
			</div>

			<div class="card-footer">
				<span style="float: right;">
					
				</span>
			</div>

		</div>
	</div>
		
		
		
	<div class="col-md-3 col-sm-12">
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
							<a class="nav-link {{ $nomer == 1 ? 'active' : '' }} btn btn-sm btn-default question_body" href="#question_container{{$question->id}}" data-toggle="tab" data-toggle="tooltip" title="Menu Soal" id="question_container2{{$question->id}}">{{ $nomer }}</a>
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
							
							$('#option_body{{$question->question_id}}{{$quiz_id}}').on('click','.edit-option{{$question->question_id}}{{$quiz_id}}',function(){
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
				
							$('#option_body{{$question->question_id}}{{$quiz_id}}').on('click','.delete-option{{$question->question_id}}{{$quiz_id}}',function(){
								var id = $(this).data('id');
								var question_id = $(this).data('question');
								$.ajax({
									type : 'get',
									url : '{{URL::to('delete_option')}}',
									data : {option_id:id,question_id:question_id,quiz_id:'{{$quiz_id}}'},
									success:function(data)
									{
										$('#option_body'+question_id+'{{$quiz_id}}').html(data);
										$('#option_text'+id).remove();
									}
								})
							})
				
							$('#option_body{{$question->question_id}}{{$quiz_id}}').on('click','.option_radio{{$question->question_id}}{{$quiz_id}}',function(e){
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
				<button class="btn btn-sm btn-primary fas fa-plus" id="add_question" style="padding:5px !important; font-size:13px !important;"> Pertanyaan</button>
			</div>	
		</div>
	</div>		
</div>





<div class="modal" role="dialog" id="edit_question_modal" aria-hidden="true" width="100%">
	
</div>

<div class="modal" id="new_option_modal">
	
</div>