@extends('layout.template')
@section('contens')<br>

<?php
	$nm_mapel = DB::table('tblmapel')
	->join('mapel_kelas', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
	->where('mapel_kelas.id_mapel_kelas',Request::segment(3))
	->first();
?>
<?php
	$nama_kelas = DB::table('db_jenjang')
	->where('tingkat',Request::segment(2))
	->first();
?>
<?php 
	$tingkat=Request::segment(2);
	$mapel=Request::segment(3);
	$bab=Request::segment(4);
?>


<form action="{{url('coba_sn')}}" id="materi_form" method="post" enctype="multipart/form-data">
	@csrf

	<div class="card">
		<div class="card-header">
			<h5 class="card-title" style="font-size:16px;">
				<b>Materi {{ $nm_mapel->nama }} {{ $nama_kelas->nama }}</b>
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
						<input type="hidden" value="{{ $tingkat }}" name="kelas">
						<input type="hidden" value="{{ $mapel }}" name="mapel">
						<input type="hidden" value="{{ $bab }}" name="bab_id">

						<label>Judul materi</label>
						<input type="text" name="judul" id="nama_materi" class="form-control" required placeholder="E.g. What is e-learning?" >
						<small class="text-muted">Berikan judul yang mewakili isi materi yang akan Anda buat.</small>
					</div>

					<div class="form-group">
						<label>Konten</label>
						<textarea id="konten_materi" name="konten" required></textarea>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title" style="font-size:16px;"><b>Video</b></h5>
					<input type="button" class="btn btn-sm btn-info check_video float-right" id="url" value="check" placeholder="Check">
				</div>

				<div class="card-body">
					<div class="col-12" id="videocek">
						@include('muatan.materi.check_video')
					</div>
								
					<input type="text" name="video" id="video" class="form-control input-sm mt-3" required placeholder="Link Video" onkeyup="copytextbox();">						
				</div>

				<div class="card-footer">
					<small class="text-muted">Berikan link video pembelajaran.</small>
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
					<small class="text-muted">Tambahkan dokumen pembelajaran.</small>
				</div>	
			</div>
		</div>
	</div>
</form>

<script src="{{url('public/ckeditor/ckeditor.js')}}"></script>  
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
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
</script>

<script type="text/javascript">
	$('#submit_button').click(function(){
		var lampiran_lenght = $('.lampiran').length;
		if (lampiran_lenght>0) {
			$('#canceled_form').submit();
		}else{
			alert('Harap unggah paling tidak satu lampiran');
		}
	})
</script>


<script type="text/javascript">
	$(".check_video").click(function(){
			var id_url = $(this).attr('id');
			console.log(id_url);
			// if(status){
				$.ajax({
					url: '{{URL::to('check_video')}}',
					type: 'get',
					data: {id_url:id_url},
					success: function(data){
						$('#videocek').html(data);
					}
				})
			// }
		})

	</script>


<script type="text/javascript">
function copytextbox() {    
			document.getElementById('url').id = document.getElementById('video').value; 
		}
</script>


<script type="text/javascript">
	var konten = document.getElementById("konten_materi");
	    CKEDITOR.replace(konten,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>
@endsection