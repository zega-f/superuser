@extends('layout.template')
@section('contens')<br>
<div class="container border mb-3 rounded" style="padding: 20px; background-color: white; max-width: 1000px;">
	<form action="{{url('update_quiz_kursus/'.$this_quiz->quiz_id)}}" id="materi_form" method="post" enctype="multipart/form-data">
		@csrf
		<h5 class="mb-3">
			Quiz {{ $this_quiz->room_name }}
			<span style="float: right; font-size: 14px; font-weight: normal;">
				<button class="btn btn-sm btn-primary">
					Simpan <i class="bi bi-check-square"></i>
				</button>
				<a href="#" id="publish_this_quiz" class="btn btn-success btn-sm">
					Publish <i class="ion-android-bulb"></i>
				</a>
				<!-- <button class="button orange-button" type="button" id="test_option">Warning button</button> -->
			</span>
		</h5>
		@if ($message = Session::get('fail'))
        <div class="alert alert-danger alert-sm" id="alert">
            <p>{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-sm" id="alert">
            <p>{{ $message }}</p>
        </div>
        @endif
		<table class="table">
			<tr>
				<td>Nama Quiz</td>
				<td>
					<input 
					type="text" 
					name="nama" 
					id="nama_materi" 
					class="form-control" 
					required
					placeholder="E.g. Quiz akhir tahun"
					value="{{$this_quiz->quiz_name}}" 
					>
					<small class="text-muted">Berikan nama yang mewakili isi quiz yang akan Anda buat.</small>
				</td>
			</tr>
			
			<tr>
				<td>
					Batas Waktu
				</td>
				<td>
					<input type="number" name="duration" class="form-control form-control-sm" required="" min="1" value="{{$this_quiz->time}}">
					<small>Berikan waktu pengerjaan pada quiz ini. <br>Ketika waktu pengerjaan telah habis, quiz pada siswa akan otomatis di kirim dan di nilai.</small>
				</td>
			</tr>
			<tr>
				<td>Nilai Minimum</td>
				<td>
					<input type="number" name="kkm" class="form-control form-control-sm" required="" max="100" value="{{$this_quiz->kkm}}">
					<small>Berikan nilai minimum kelulusan pada quiz ini</small>
				</td>
			</tr>
		</table>
	</form>
	<hr>
	<div id="question_box">
		@include('muatan.quiz.component.all_question')
	</div>
</div>

{{-- <div class="modal" id="add_question_modal">
	<div class="container" style="padding: 20px; background-color: white; max-width: 600px;">
		<h5>New Question <span style="float: right;" class="ion-android-close pointer" id="close_add_question_modal"></span></h5>
		<hr>
		<div id="errorbag"></div>
		<form id="question_form">
			<textarea name="question_field" id="question_field"></textarea>
			<button class="btn btn-info btn-sm" id="saving_question" type="button">Save</button>
		</form>
	</div>
</div> --}}
<div class="modal" id="add_question_modal">
	<div class="container shadow" style="padding: 20px; background-color: white; max-width: 800px; height:500px;">
		<h5>New Question <span style="float: right;" class="ion-android-close pointer" id="close_add_question_modal"></span></h5>
		<hr>
		<div id="errorbag"></div>
		<form id="question_form" style="max-height: 400px; overflow: auto;" enctype="multipart/form-data">
			@csrf
			<input type="text" name="quiz_id" hidden="" value="{{$quiz_id}}">
			<div class="form-group mb-3">
				<label>Gambar Ilustrasi</label>
				<img src="" style="width: 100%; position: relative;" id="blah">
				<input type="file" name="img" id="file" accept="image/png, image/gif, image/jpeg" class="form-control-file form-control-sm" onchange="readURL(this);">
			</div>
			<textarea name="question_field" id="question_field"></textarea><br>
			<div class="form-group mb-3">
				<button class="btn btn-info btn-sm" id="saving_question" type="button">Save</button>
			</div>
		</form>
	</div>
</div>
	

<script src="{{url ('public/ckeditor/ckeditor.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
            	var fileExtension = ['jpeg', 'jpg', 'png'];
		        if ($.inArray($('#file').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
		            alert("Only formats are allowed : "+fileExtension.join(', '));
		            $('#file').val('');
		        }else{
		        	var maxAllowedSize = 1000000;
					var thisFile = input.files[0].size;

					if (thisFile>maxAllowedSize) {
						alert('file terlalu besar');
						$('#file').val('');
					}else{
						$('.yn').fadeIn();
	                	$('#blah').attr('src', e.target.result)
	                	$('.ion-checkmark-circled').data('id', e.target.result);
					}
		        }
            	
            };
            reader.readAsDataURL(input.files[0]);
        }
    }


	$('#publish_this_quiz').click(function(){
		// e.preventDefault();
		var new_url = "{{url('unpublish_quiz_kursus/'.$this_quiz->quiz_id)}}";
		var need_answer = $('.need_option').length;
		if (need_answer==0) {
			$('#publish_this_quiz').attr("href",new_url);
			$('#publish_this_quiz').click
		}else{
			alert('Terdapat soal tanpa jawaban.')
		}
	})

	$('#test_option').click(function(){
		var jumlah_soal = $('.question_body').length;
		var jumlah_pilihan = $('.option-table').length;
		var need_answer = $('.need_option').length;
		console.log(jumlah_soal+' dan '+need_answer);
	})

	$('#question_box').on('click','.delete_this_question',function(){
		var id = $(this).data('id');
		if (confirm('Apakah Anda yakin ingin menghapus pertanyaan ini? Semua pilihan jawaban juga akan dihapus')) {
			$.ajax({
				type : 'get',
				url : '{{URL::to('delete_this_question')}}',
				data : {question_id:id},
				success:function(data)
				{
					$('#question_container'+id).remove();
				}
			})
		}
	});

	$('#question_box').on('click','.add_option',function(){
		var id = $(this).data('id');
		$.ajax({
			type : 'get',
			url : '{{URL::to('create_option')}}',
			data : {question_id:id},
			success:function(data)
			{
				$('#new_option_modal').css({
					'display':'grid',
					'place-items':'center',
				}).html(data);
			}
		})
	})

	$('#question_box').on('click','.edit_this_question',function(){
		var id = $(this).data('id');
		$.ajax({
			type : 'get',
			url : '{{URL::to('edit_this_question')}}',
			data : {question_id:id},
			success:function(data)
			{
				$('#edit_question_modal').html(data).css({
					'display':'grid',
					'place-items':'center',
				});
			}
		})
	})

	// $('#saving_question').click(function(){
	// 	var quiz_id = '{{$quiz_id}}';
	// 	// var question = $('textarea[name="question_field"]').val();
	// 	var question = CKEDITOR.instances['question_field'].getData();
	// 	$.ajax({
	// 		type : 'post',
	// 		url : '{{URL::to('store_question')}}',
	// 		data : {'_token':"{{ csrf_token() }}",quiz_id:quiz_id,question:question},
	// 		success:function(data)
	// 		{
	// 			$('#add_question_modal').hide();
	// 			$('#question_form')[0].reset();
	// 			CKEDITOR.instances['question_field'].setData('');
	// 			$('#question_box').html(data);
	// 		},
	// 	    error: function() { 
	// 	        $('#errorbag').html('<div class="alert alert-danger form-alert">Pertanyaan tidak boleh kosong</div>');
	// 	    } 
	// 	})
	// })

	$('#saving_question').click(function(){
		var quiz_id = '{{$quiz_id}}';
		var question = CKEDITOR.instances['question_field'].getData();
		let form = document.getElementById('question_form');
	    let formData = new FormData(form);
	    formData.append('question_field', question);

		$.ajax({
			type : 'post',
			url : '{{URL::to('store_question')}}',
			data : formData,
			success:function(data)
			{
				$('#add_question_modal').hide();
				$('#question_form')[0].reset();
				CKEDITOR.instances['question_field'].setData('');
				$('#question_box').html(data);
			},
		    error: function() { 
		        $('#errorbag').html('<div class="alert alert-danger form-alert">Pertanyaan tidak boleh kosong</div>');
		    },
		    cache: false,
		    contentType: false,
		    processData: false,
		})
	})

	$('#question_box').on('click','#add_question',function(){
		$('#add_question_modal').css({
			'display':'grid',
			'place-items':'center',
		});
	})
	$('#close_add_question_modal').click(function(){
		$('#add_question_modal').hide();
		$('#question_form')[0].reset();
	})
</script>

<script type="text/javascript">
	var konten = document.getElementById("question_field");
	    CKEDITOR.replace(konten,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>
@endsection