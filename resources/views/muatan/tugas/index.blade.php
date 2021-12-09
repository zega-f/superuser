@extends('layout.template')
@section('contens')<br>
<?php
	$nm_mapel = DB::table('tblmapel')
	->join('mapel_kelas', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
		->where('id_mapel_kelas',Request::segment(3))
		->first();

	$nama_kelas = DB::table('db_jenjang')
		->where('tingkat',Request::segment(2))
		->first();
?>

<?php 
	$tingkat=Request::segment(2);
	$mapel=Request::segment(3);
	$bab_id=Request::segment(4);
?>

<div class="card">
	<form action="{{url('store_tugas')}}" id="materi_form" method="post" enctype="multipart/form-data">
		@csrf

		<div class="card">
			<div class="card-header">
				<h5 class="card-title" style="font-size:16px;">
					<b>Tugas {{ $nm_mapel->nama }} {{ $nama_kelas->nama }}</b>
				</h5>
	
				<span style="float: right; font-size: 14px; font-weight: normal;">
					<a href="{{ url('kelola_mapelkelas/'.$tingkat.'/'.$mapel)}}" class="btn btn-sm btn-warning">
						Batal <i class="bi bi-check-square"></i>
					</a>
					<button class="btn btn-sm btn-success">
						Simpan <i class="bi bi-check-square"></i>
					</button>
				</span>
			</div>
		</div>


		<div class="row">
			<div class="col-md-9 col-sm-12">
				<div class="card">
					<div class="card-body">
			
						<div class="form-group">
							<input type="hidden" name="bab_id" class="form-control form-control-sm" value="{{ $bab_id }}" readonly="">
							<input type="hidden" name="kelas" class="form-control form-control-sm" value="{{ $tingkat }}" readonly="">
							<input type="hidden" name="mapel" class="form-control form-control-sm" value="{{ $mapel }}" readonly="">

							<label>Judul Tugas</label>
							<input type="text" name="judul" id="nama_materi" class="form-control" required placeholder="E.g. What is e-learning?" >
							<small class="text-muted">Berikan judul yang mewakili isi tugas yang akan Anda buat.</small>
						</div>

						<div class="form-group">
							<label>Instruksi</label>
							<textarea id="konten_tugas" name="konten" required></textarea>
						</div>
					</div>
				</div>
			</div>

				
		<div class="col-md-3 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title" style="font-size:16px;"><b>Batas Waktu</b></h5>
				</div>

				<div class="card-body">
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
							<label><small><b>Tanggal</b></small></label>
							<input type="date" name="date" class="form-control form-control-sm" required="">
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
							<label><small><b>Jam</b></small></label>
							<input type="time" name="time" class="form-control form-control-sm" required="">
						</div>
					</div>
				</div>

				<div class="card-footer">
					<small class="text-muted">Berikan Batas waktu Pengumpulan.</small>
				</div>
			</div>
			
			<div class="card">
				<div class="card-header">
					<h5 class="card-title" style="font-size:16px;"><b>Lampiran</b></h5>
				</div>

				<div class="card-body">
					<ul id="attachmentBox" style="list-style: none;"></ul>
					<div id="file-box"></div>
					<button class="btn btn-info btn-sm" id="add" type="button">Unggah File <i class="ion-upload"></i></button>
				</div>

				<div class="card-footer">
					<small class="text-muted">Tambahkan dokumen tugas <b>(optional)</b>.</small>
				</div>	
			</div>
		</div>
	</div>
			
</form>



<script src="{{url('public/ckeditor/ckeditor.js')}}"></script>  

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