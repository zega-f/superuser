@extends('layout.template')
@section('contens')<br>

<?php  
	$tugas_file = file_get_contents("public/muatan/tugas/".$this_tugas->id_tugas.'.json');
    $string = json_decode($tugas_file,true);
    $datetime = explode(' ', $this_tugas->waktu);
?>
<div class="container border mb-3 rounded" style="padding: 20px; background-color: white;">
	<form action="{{url('update_tugas_kursus/'.$this_tugas->id_tugas.'/'.$this_tugas->id_kelas)}}" id="materi_form" method="post" enctype="multipart/form-data">
		@csrf
		<a href="{{url('/tugas')}}" class="mb-3 link-secondary"><i class="ion-arrow-left-c"></i> Back</a>
		<h5 class="mb-3">
			Tugas {{ $this_tugas->room_name }}
			<span style="float: right; font-size: 14px; font-weight: normal;">
				<button type="reset" class="btn btn-warning btn-sm" onclick="reset_mapel();">Batal <i class="ion-android-refresh"></i></button>
				<button class="btn btn-sm btn-success">
					Simpan <i class="bi bi-check-square"></i>
				</button>
			</span>
		</h5>
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
					value="{{$this_tugas->judul}}" 
					>
					<small class="text-muted">Berikan judul yang mewakili isi tugas yang akan Anda buat.</small>
				</td>
			</tr>
			{{-- <tr>
				<td>Kelas/Mapel</td>
				<td>
					<div class="row">
						<div class="col-md-6">
							<div class="" style="position: relative;">
								<input type="text" name="kelas" class="form-control form-control-sm" value="1" readonly="">
							</div>
							<small class="text-muted">Pilih kelas dimana materi ini akan diberikan</small>
						</div>
						<div class="col-md-6">
							<input type="text" name="mapel" class="form-control form-control-sm" value="3" readonly="">
							<!-- <select class="form-control form-control-sm" id="mapel" name="mapel" required="" disabled="">
								
							</select> -->
							<small class="text-muted">Pilih mata pelajaran</small>
						</div>
					</div>
				</td>
			</tr> --}}
			<tr>
				<td>Instruksi</td>
				<td>
					<textarea id="konten_materi" name="konten" required><?php echo $string['konten']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					Batas Waktu
				</td>
				<td>
					<div class="row">
						<div class="col-6">
							<input type="date" name="date" class="form-control form-control-sm" required="" value="{{$datetime[0]}}">
							<small>Pilih hari</small>
						</div>
						<div class="col-6">
							<input type="time" name="time" class="form-control form-control-sm" required="" value="{{$datetime[1]}}">
							<small>Tentukan Waktu</small>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Lampiran</td>
				<td>
					<ul id="attachmentBox" style="list-style: none;">
						<?php $i=0; ?>
						@foreach($this_tugas_lampiran as $lampiran)
						<?php $i++; ?>
						<li id="list{{$i}}" class="lampiran">
							<a href="{{url('public/muatan/tugas/lampiran/'.$lampiran->attachment_name)}}" class="btn btn-sm mb-2" type="button">
								{{$lampiran->attachment_original_name}}
							</a>
							<i style="margin-left:20px; cursor:pointer;" class="ion-android-close delete-file" data-id="{{$i}}" data-lampiran="{{$lampiran->id}}"></i>
						</li>
						@endforeach
					</ul>
					<div id="file-box"></div>
					<button class="btn btn-info btn-sm" id="add" type="button">Unggah File <i class="ion-upload"></i></button>
				</td>
			</tr>
		</table>
	</form>
</div>
<div class="modal" id="cancel_confirm">
	<div class="card shadow" style="border: none; max-width: 500px;">
		<div class="card-header bg-info text-light">
			<header>Batalkan edit materi? <span style="float: right;" class="ion-android-close pointer" onclick="cancel_reset();"></span></header>
		</div>
		<div class="card-body">
			<div class="alert alert-warning">
				Apakah anda yakin ingin membatalkan proses edit tugas ini?
			Perubahan yang tidak disimpan akan hilang.
			</div>
			<header>
				<a href="{{url()->current()}}" class="btn btn-warning btn-sm">Ya, lanjutkan</a>
			<button class="btn btn-info btn-sm" onclick="cancel_reset();">Tidak</button>
			</header>
		</div>
	</div>
</div>


<script src="{{url('public/ckeditor/ckeditor.js')}}"></script>  

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
	function reset_mapel()
	{
		$('#cancel_confirm').css({
			'display':'grid',
			'place-items':'center'
		});
	}

	function cancel_reset()
	{
		$('#cancel_confirm').hide();
	}

	$('.delete-file').click(function(){
		var id = $(this).data('id');
		var id_lampiran = $(this).data('lampiran');
		if (confirm('File ini telah diunggah, apakah Anda yakin ingin menghapus file ini? File yang telah dihapus tidak dapat dipulihkan walaupun materi ini direset seperti semula')) {
			// $('#list'+id).remove();
			$.ajax({
				type : 'get',
				url : '{{URL::to('delete_tugas_file')}}',
				data : {lampiran_id:id_lampiran},
				success:function(data)
				{
					$('#list'+id).remove();
				}
			})
		}
	})

	var i = '{{$i}}';
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

	var konten = document.getElementById("konten_materi");
	    CKEDITOR.replace(konten,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>
@endsection