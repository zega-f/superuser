@if(count($all_kelas)==0)
<div class="alert alert-info">
	tidak terdapat hasil
</div>
@else
@foreach($all_kelas as $kelas)
<option value="{{$kelas->id_kelas}}">{{$kelas->room_name}}</option>
@endforeach
<script type="text/javascript">
	$('.pick').click(function(){
		$('#kelas_box').hide();
		var id_kelas = $(this).data('id');
		var name = $(this).data('name');
		$('#kelas_field').val(name);
		$('#kelas').val(id_kelas);
	})
</script>
@endif