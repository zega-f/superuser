<div class="container shadow" id="option_create_box" style="max-width: 800px; padding: 20px; background-color: white;">
	<h5>Make Option <span style="float: right;" class="ion-android-close pointer" id="close_option_create_box"></span></h5>
	<hr>
	<header><b>Question</b></header>
	<div style="font-size: 14px;">
		<?php echo $this_question->question; ?>
	</div>
		<form>
			<div id="errorbag"></div>
			<textarea name="option_field" id="option_field"></textarea>
			<button class="btn btn-info btn-sm mt-2" id="saving_option" type="button">Save</button>
		</form>
</div>
<script type="text/javascript">
	$('#saving_option').click(function(){
		var option = CKEDITOR.instances['option_field'].getData();
		var question_id = '{{$this_question->id}}';
		$.ajax({
			type : 'post',
			url : '{{URL::to('store_option')}}',
			data : {'_token':'{{ csrf_token() }}',option:option,question_id:question_id},
			success:function(data)
			{
				if (data['type']=='fail') {
					$('#errorbag').html('<div class="alert alert-danger temp-alert">'+data['message']+'</div>')
					$('.temp-alert').delay(3000).fadeOut();
				}else{
					// var new_option = decodeURIComponent(data['option_text']);
					// $('#list'+question_id).append('<li class="option_text">'+new_option+'</li>');
					$('#option_body'+question_id).html(data);
					$('#option_create_box').remove();
					$('#new_option_modal').hide();
				}
			}
		})
	})
	$('#close_option_create_box').click(function(){
		$('#option_create_box').remove();
		$('#new_option_modal').hide();
	})

	var option = document.getElementById("option_field");
	    CKEDITOR.replace(option,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>