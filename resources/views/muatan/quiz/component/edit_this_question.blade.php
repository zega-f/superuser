<div class="container shadow" id="question_editor_box" style="max-width: 800px; height:570px; padding: 20px; background-color: white;">
	<h5>Edit Question <span style="float: right;" class="ion-android-close pointer" id="close_question_editor_box"></span></h5>
	<hr>
	<form style="height: 400px; overflow: auto;" id="edit_question_form">
		@csrf
		<input type="text" name="quiz_id" value="{{$this_question->quiz_id}}" hidden="">
		<input type="text" name="question_id" value="{{$this_question->question_id}}" hidden="">
		<?php  
			$default = '';
			$check_attachment = DB::table('quiz_question_attachment')
			->where([
				['quiz_id',$this_question->quiz_id],
				['question_id',$this_question->question_id]
			])
			->first();
		?>
		@if($check_attachment)
		<?php  
			$default = url('public/muatan/quiz/lampiran/'.$check_attachment->filename);
		?>
		<div style="position: relative;">
			<label>Gambar Ilustrasi</label>
			@if($check_attachment)
				<i class="pointer ion-trash-b text-danger delete-question-lampiran" data-questionid="{{$this_question->id}}"></i>
			@endif
			<img src="{{url('public/muatan/quiz/lampiran/'.$check_attachment->filename)}}" width="300" style="margin: 0 auto; display: block;" id="edit_preview">
			<div style="position: absolute; top: 20px; right: 20px; display: none;" id="yesno">
				<span style="font-size: 2rem; right: 30px; color: red;" class="yn ion-close-circled pointer no"></span>
			</div>
		</div>
		@endif
		<div class="form-group mb-3">
			<input type="file" name="img_edit" id="file_edit" accept="image/png, image/gif, image/jpeg" class="form-control-file form-control-sm" onchange="readURL_edit(this);">
		</div>
		<textarea name="edit_question_field" id="edit_question_field"><?php echo $this_question->question; ?></textarea>
		<button class="btn btn-info btn-sm mt-2" id="updating_question" type="button">Save</button>
	</form>
</div>
<script type="text/javascript">
	$('.delete-question-lampiran').click(function(){
		if (confirm('Apakah Anda yakin ingin menghapus lampiran untuk pilihan jawaban ini?')) {
			$('.delete-question-lampiran').remove();
			var question_id = $(this).data('questionid');
			$.ajax({
				type : 'post',
				url : '{{URL::to('delete_question_lampiran')}}',
				data : {'_token':'{{ csrf_token() }}',id:question_id},
				success:function(data)
				{
					console.log(data['filename']);
					$('#img'+data['filename']).remove();
					$('#edit_preview').attr('src','');
				}
			})
		}
	});

	function readURL_edit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
            	var fileExtension = ['jpeg', 'jpg', 'png'];
		        if ($.inArray($('#file_edit').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
		            alert("Only formats are allowed : "+fileExtension.join(', '));
		            $('#file_edit').val('');
		        }else{
		        	var maxAllowedSize = 1000000;
					var thisFile = input.files[0].size;

					if (thisFile>maxAllowedSize) {
						alert('file terlalu besar');
						$('#file_edit').val('');
					}else{
	                	$('#edit_preview').attr('src', e.target.result)
	                	$('#yesno').fadeIn();
					}
		        }
            	
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('.no').click(function(){
    	$('#yesno').fadeOut();
    	$('#file_edit').val('');
    	$('#edit_preview').attr('src', '{{$default}}')
    })

	$('#updating_question').click(function(){
		var quiz_id = '{{$this_question->quiz_id}}';   
		var id = '{{$this_question->id}}';
		var new_question = CKEDITOR.instances['edit_question_field'].getData();
		
		let formEdit = document.getElementById('edit_question_form');
		let formEditData = new FormData(formEdit);
	    formEditData.append('edit_question_field', new_question);

		$.ajax({
			type : 'post',
			url : '{{URL::to('updating_question')}}',
			data : formEditData,
			success:function(data)
			{
				$('#question_body'+id).html(new_question);
				$('#edit_question_modal').hide();
				$('#question_editor_box').remove();

				if (data.msg=='new_file') {
					$('#img'+data.old_img_id).remove();
					var baseurl = '{{url('')}}';
					var url = baseurl+'/public/muatan/quiz/lampiran/'+data.src;
					$('#question-lampiran'+id).html('<img width="300" class="preview-question-img pointer" data-url="'+url+'" id="img'+data.new_img_id+'" src='+url+'>')
				}
				// console.log(id);
			},
			cache: false,
		    contentType: false,
		    processData: false,
		})
	})
	$('#close_question_editor_box').click(function(){
		$('#edit_question_modal').hide();
		$('#question_editor_box').remove();
	})
	var edit_question = document.getElementById("edit_question_field");
	    CKEDITOR.replace(edit_question,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>