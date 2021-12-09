<div class="container shadow" id="option_edit_box" style="max-width: 800px; padding: 20px; background-color: white;">
	<h5>Edit Option <span style="float: right;" class="ion-android-close pointer" id="close_option_edit_box"></span></h5>
	<hr>
		<form style="max-height: 70vh; overflow: auto;" id="edit-option-form" enctype="multipart/form-data">
			@csrf
			<div id="errorbag"></div>
			<?php $default = url('public/muatan/quiz/lampiran_option/'.$this_option->attachment);?>
			<input type="text" hidden="" name="option_id" value="{{$this_option->id}}">
			<input type="text" hidden="" name="question_id" value="{{$this_option->quiz_question_id}}">
			<div class="form-group mb-3">
				<div style="position: relative; width: auto;">
					<header>
						Gambar Ilustrasi
						@if($this_option->attachment!=null)
							<i class="pointer ion-trash-b text-danger delete-lampiran" data-optionid="{{$this_option->id}}"></i>
						@endif
					</header>
					<img src="{{$default}}" style="max-width: 375px;" id="img_option_preview">
					<div style="position: absolute; top: 20px; right: 20px; display: none;" id="yn-option">
						<span style="font-size: 2rem; right: 30px; color: red;" class="yn-option ion-close-circled pointer cancel-image-option"></span>
					</div>
				</div>
				<input type="file" name="edit_option_img" id="option-file" accept="image/png, image/gif, image/jpeg" class="form-control-file form-control-sm" onchange="readOptionImage(this);">
			</div>
			<textarea name="option_edit_field" id="option_edit_field">{{$this_option->option_text}}</textarea>
			<button class="btn btn-info btn-sm mt-2" id="updating_option" type="button">Save</button>
		</form>
</div>
<script type="text/javascript">
	var default_img = '{{$default}}';

	$('.delete-lampiran').click(function(){
		var option_id = $(this).data('optionid');
		if (confirm('Apakah Anda yakin ingin menghapus lampiran untuk pilihan jawaban ini?')) {
			$.ajax({
				type : 'post',
				url : '{{URL::to('delete_this_option_attch')}}',
				data : {'_token':'{{ csrf_token() }}',option_id:option_id},
				success:function(data)
				{
					$('.img'+data['filename']).remove();
					$('.delete-lampiran').remove();
					$('#img_option_preview').attr('src','');
					default_img = null;
				}
			})
		}
	})

	function readOptionImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
            	var fileExtension = ['jpeg', 'jpg', 'png'];
		        if ($.inArray($('#option-file').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
		            alert("Only formats are allowed : "+fileExtension.join(', '));
		            $('#option-file').val('');
		        }else{
		        	var maxAllowedSize = 1000000;
					var thisFile = input.files[0].size;

					if (thisFile>maxAllowedSize) {
						alert('file terlalu besar');
						$('#option-file').val('');
					}else{
						$('#yn-option').fadeIn();
	                	$('#img_option_preview').attr('src', e.target.result);
					}
		        }
            	
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('.cancel-image-option').click(function(){
    	$('#yn-option').fadeOut();
    	$('#option-file').val('');
    	$('#img_option_preview').attr('src', default_img);
    })

	$('#updating_option').click(function(){
		var new_option = CKEDITOR.instances['option_edit_field'].getData();
		var option_id = '{{$this_option->id}}';
		var question_id = '{{$this_option->quiz_question_id}}';

		let formOptionEdit = document.getElementById('edit-option-form');
		let formOptionEditData = new FormData(formOptionEdit);
		formOptionEditData.append('option_edit_field', new_option);

		$.ajax({
			type : 'post',
			url : '{{URL::to('update_option')}}',
			data : formOptionEditData,
			// data : {'_token':'{{ csrf_token() }}',option_id:option_id,new_option:new_option,question_id:question_id},
			success:function(data)
			{
				$('#option_body'+question_id+'{{$this_option->quiz_id}}').html(data);
				$('#option_edit_box').remove();
				$('#editing_option_modal').hide();
			},
			cache: false,
		    contentType: false,
		    processData: false,
		})
	})
	$('#close_option_edit_box').click(function(){
		$('#option_edit_box').remove();
		$('#editing_option_modal').hide();
	})

	var option_edit = document.getElementById("option_edit_field");
	    CKEDITOR.replace(option_edit,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>