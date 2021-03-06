<h5 class="mb-3">
	Pertanyaan 
	<span style="float: right;">
		<button class="btn btn-info btn-sm mb-3" id="add_question">Pertanyaan <i class="ion-android-add"></i></button>
	</span>
</h5>
<!-- <div class="alert alert-danger" style="max-width: 500px; font-size: 14px;">
	Pertanyaan tanpa jawaban benar tidak akan ditampilkan pada user dan tetap bernilai benar.
</div> -->

@if(count($all_question)==0)
<div class="alert alert-info">Belum terdapat pertanyaan. Buat satu untuk memulai</div>
@else
	@foreach($all_question as $question)
		<div class="mb-3 border rounded question_body" id="question_container{{$question->id}}" style="padding: 20px; font-size: 14px;">
			<header class="mb-3" style="text-align: right;">
				<button class="btn btn-sm btn-info ion-edit edit_this_question" data-id="{{$question->id}}" data-toggle="tooltip" data-placement="bottom" title="Edit question"></button>
				<button class="btn btn-sm btn-success ion-android-add add_option" data-id="{{$question->id}}" data-toggle="tooltip" data-placement="bottom" title="Add Option"></button>
				<button class="btn btn-sm btn-danger ion-trash-b delete_this_question" data-id="{{$question->id}}" data-toggle="tooltip" data-placement="bottom" title="Delete Question"></button>
			</header>
			<div id="question_body{{$question->id}}">
				<?php echo $question->question; ?>
			</div>
			<div id="option_body{{$question->id}}">
				@include('muatan.quiz.component.option_list')
			</div>
		</div>


		<script src="{{url ('public/ckeditor/ckeditor.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script type="text/javascript">
			$('#option_body{{$question->id}}').on('click','.edit-option{{$question->id}}',function(){
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

			$('#option_body{{$question->id}}').on('click','.delete-option{{$question->id}}',function(){
				var id = $(this).data('id');
				var question_id = $(this).data('question');
				$.ajax({
					type : 'get',
					url : '{{URL::to('delete_option')}}',
					data : {option_id:id,question_id:question_id},
					success:function(data)
					{
						$('#option_body'+question_id).html(data);
						// $('#option_text'+id).remove();
					}
				})
			})

			$('#option_body{{$question->id}}').on('click','.option_radio{{$question->id}}',function(e){
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
@endif

<div class="modal" id="edit_question_modal">
	
</div>

<div class="modal" id="new_option_modal">
	
</div>