<div class="container shadow" id="option_edit_box" style="max-width: 800px; padding: 20px; background-color: white;">
	<h5>Edit Option <span style="float: right;" class="ion-android-close pointer" id="close_option_edit_box"></span></h5>
	<hr>
		<form>
			<div id="errorbag"></div>
			<textarea name="option_edit_field" id="option_edit_field">{{$this_option->option_text}}</textarea>
			<button class="btn btn-info btn-sm mt-2" id="updating_option" type="button">Save</button>
		</form>
</div>
<script type="text/javascript">
	$('#updating_option').click(function(){
		var new_option = CKEDITOR.instances['option_edit_field'].getData();
		var option_id = '{{$this_option->id}}';
		var question_id = '{{$this_option->quiz_question_id}}';
		console.log(question_id);
		$.ajax({
			type : 'post',
			url : '{{URL::to('update_option')}}',
			data : {'_token':'{{ csrf_token() }}',option_id:option_id,new_option:new_option,question_id:question_id},
			success:function(data)
			{
				// var new_option_decoded = decodeURIComponent(new_option);
				// $('#column'+option_id).html(new_option_decoded);
				$('#option_body'+question_id+'{{$this_option->quiz_id}}').html(data);
				$('#option_edit_box').remove();
				$('#editing_option_modal').hide();
			}
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