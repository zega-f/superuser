@extends('layout.template')
@section('contens')<br>


<div class="container border mb-3 rounded" style="padding: 20px; background-color: white;">
	<form action="{{url('store_artikel')}}" id="materi_form" method="post" enctype="multipart/form-data">
		@csrf
		<h5 class="mb-3">
			Artikel
			<span style="float: right; font-size: 14px; font-weight: normal;">
				<button class="btn btn-sm btn-success">
					Simpan <i class="bi bi-check-square"></i>
				</button>
			</span>
		</h5>
		<table class="table">
			<tr>
				<td>Judul Artikel</td>
				<td>
					<input 
					type="text" 
					name="judul" 
					id="nama_materi" 
					class="form-control" 
					required
					placeholder="">
					<small class="text-muted">Berikan judul yang mewakili isi artikel yang akan Anda buat.</small>
				</td>
			</tr>
            <?php
                $kategori = \DB::table('kategori_artikel')
                ->get();
            ?>
			<tr>
				<td>Kategori</td>
				<td>
					<div class="row">
						<div class="col-md-6">
							 <select class="form-control" id="kategori" name="kategori" required="">
								<option value="" selected="">- PilihKategori -</option>
								@foreach($kategori as $kategori)
								<option value="{{$kategori->id}}">{{$kategori->name}}</option>
								@endforeach
							</select>
							 <small class="text-muted">Pilih kategori Artikel</small>
						</div>
						
				</td>
			</tr>
			<tr>
				<td>Description</td>
				<td><textarea name="intro" maxlength="350" style="width:100%; min-height:150px;" required></textarea>
				</td>
			</tr>
			<tr>
				<td>Konten</td>
				<td><textarea id="konten_artikel" name="konten" required></textarea>
				</td>
			</tr>
			
		</table>
	</form>
</div>

{{-- <div class="container rounded border" style="padding: 20px; background-color: white;">
	<header class="mb-2"><b>Semua Materi</b></header>
	<div class="alert alert-info" style="max-width: 600px; font-size: 14px;">
		Tabel dibawah ini menampilkan materi secara keseluruhan. Untuk mengelola materi pada kelas, harap masuk pada kelas masing - masing.
	</div>
	<div id="materi_box" style="position: relative;">
		@include('muatan.materi.component.all_materi_comp')
	</div>
</div> --}}

<script src="{{url ('public/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
	
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
	var konten = document.getElementById("konten_artikel");
	    CKEDITOR.replace(konten,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>


@endsection