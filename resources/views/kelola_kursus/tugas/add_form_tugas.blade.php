@extends('layout.template')
@section('contens')<br>

<div class="card">
	<div class="card-header bg-info">
	  <h3 class="card-title"><b>Tugas {{ $nm_kursus->room_name }}</b></h3>
	</div>
  
	<div class="card-body">
	<form action="{{url('store_tugas')}}" id="materi_form" method="post" enctype="multipart/form-data">
		@csrf
		<table class="table">
			<tr>
				<td>Judul Tugas</td>
				<td>
					<input 
					type="text" 
					name="judul" 
					id="nama_materi" 
					class="form-control" 
					required
					placeholder="E.g. What is e-learning?" 
					>
					<small class="text-muted">Berikan judul yang mewakili isi tugas yang akan Anda buat.</small>
				</td>
			</tr>
			
			<?php 
				$mapel=null;
			?>
					
			<input type="hidden" name="bab_id" class="form-control form-control-sm" value="{{ $bab_id }}" readonly="">
			<input type="hidden" name="kelas" class="form-control form-control-sm" value="{{ $room_id }}" readonly="">
			<input type="hidden" name="mapel" class="form-control form-control-sm" value="{{ $mapel }}" readonly="">
								
			<tr>
				<td>Instruksi</td>
				<td>
					<textarea id="konten_tugas" name="konten" required></textarea>
				</td>
			</tr>
			<tr>
				<td>
					Batas Waktu
				</td>
				<td>
					<div class="row">
						<div class="col-6">
							<input type="date" name="date" class="form-control form-control-sm" required="">
							<small>Pilih hari</small>
						</div>
						<div class="col-6">
							<input type="time" name="time" class="form-control form-control-sm" required="">
							<small>Tentukan Waktu</small>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Lampiran</td>
				<td>
					<ul id="attachmentBox" style="list-style: none;"></ul>
					<div id="file-box"></div>
					<button class="btn btn-info btn-sm" id="add" type="button">Unggah File <i class="ion-upload"></i></button>
				</td>
			</tr>
			
		</table>
		<span style="float: right;">
			<button class="btn btn-sm btn-success btn-block">
				Simpan <i class="bi bi-check-square"></i>
			</button>
		</span>
	</form>
</div>
	</div></div>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#kelas').select2();
	});
	$('#kelas').on('change',function(){
		var value = $(this).val();
		var type = 'xhr';
		$.ajax({
			type : 'get',
			url : '{{URL::to('this_class_available_mapel')}}',
			data : {id_kelas:value,type:type},
			success:function(data)
			{
				$('#mapel').prop('disabled',false).html(data);
			}
		})
	});

	var i = 0;
	$('#add').click(function(){
		i++;
		console.log(i);
		$('#file-box').append('<div style="display:none;" class="form-file-box" id="form-file-box'+i+'"><input type="file" id="attachment'+i+'" name="attachment[]" data-id="'+i+'" class="form-control-file mb-2 file"></div><div class="col-4"></div>')
		$('#attachment'+i).click();

		$('.file').bind('change', function() {
			var maxAllowedSize = 10000000;
			var thisFile = this.files[0].size;

			if (thisFile>maxAllowedSize) {
				alert('file terlalu besar')
				$(this).val('');
				$('#submit').prop('disabled',true);
			}else{
				$('#attachmentBox').append('<li id="list'+i+'" class="lampiran"><button class="btn btn-sm mb-2" type="button">'+$('#attachment'+i).val().replace(/C:\\fakepath\\/i, '')+'</button><i style="margin-left:20px; cursor:pointer;" class="ion-android-close remove-file" data-id="'+i+'"></i></li>');
				$('.remove-file').click(function(){
					var id = $(this).data('id');
					$('#form-file-box'+id).remove();
					$('#list'+id).remove();
				})
				$('#submit').prop('disabled',false);
			}
		});
	})

	var konten = document.getElementById("konten_tugas");
	    CKEDITOR.replace(konten,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>
@endsection