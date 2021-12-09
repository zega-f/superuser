@extends('layout.template')
@section('contens')<br>

<?php  
	$materi_file = file_get_contents("public/artikel/".$this_materi->id_artikel.'.json');
    $string = json_decode($materi_file,true);
?>
<div class="container border mb-3 rounded" style="padding: 20px; background-color: white;">
	<form action="{{url('update_artikel/'.$this_materi->id_artikel)}}" id="materi_form" method="post" enctype="multipart/form-data">
		@csrf
		<a href="{{url('artikel')}}" class="mb-3 link-secondary"><i class="ion-arrow-left-c"></i> Back</a>
		<h5 class="mb-3">
			Edit Artikel
			<span style="float: right; font-size: 14px; font-weight: normal;">
				{{-- <button type="reset" class="btn btn-warning btn-sm" onclick="reset_mapel();">Batal <i class="ion-android-refresh"></i></button> --}}
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
					placeholder=""
					value="{{$this_materi->judul}}" 
					>
					<small class="text-muted">Berikan judul yang mewakili isi Artikel yang akan Anda buat.</small>
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
								<option value="{{$kategori->id}}" {{ ($kategori->id == $this_materi->kategori ? "selected" : null) }}>{{$kategori->name}}</option>
								@endforeach
							</select>
							 <small class="text-muted">Pilih kategori Artikel</small>
						</div>	
				</td>
			</tr>
			<tr>
				<td>Description</td>
				<td>
					<textarea name="intro" maxlength="200" style="width:100%; min-height:150px;" value="{{ $this_materi->intro }}" required><?php echo $this_materi->intro?></textarea>
				</td>
			</tr>
			<tr>
				<td>Konten</td>
				<td>
					<textarea id="konten_artikel2" name="konten" required><?php echo $string['konten']; ?></textarea>
				</td>
			</tr>
			
		</table>
	</form>
</div>

{{-- <div class="container rounded border" style="padding: 20px; background-color: white;">
	<h5 class="mb-3">Edit History</h5>
	<?php 
    // $all_history  = DB::table('coba_materi_history')->where('materi_id',$this_materi->id_materi)->get(); 
    ?>
	<table class="table" id="history">
		<thead>
			<tr>
				<th>Oleh</th>
				<th>@</th>
			</tr>
		</thead>
		<tbody>
			@foreach($all_history as $history)
			<tr>
				<td>{{$history->updated_by}}</td>
				<td>{{$history->updated_at}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#history').DataTable();
		})
	</script>
</div> --}}
{{-- <div class="modal" id="cancel_confirm">
	<div class="card shadow" style="border: none; max-width: 500px;">
		<div class="card-header bg-info text-light">
			<header>Batalkan edit materi? <span style="float: right;" class="ion-android-close pointer" onclick="cancel_reset();"></span></header>
		</div>
		<div class="card-body">
			<div class="alert alert-warning">
				Apakah anda yakin ingin membatalkan proses edit materi ini?
			Perubahan yang tidak disimpan akan hilang.
			</div>
			<header>
				<a href="{{url()->current()}}" class="btn btn-warning btn-sm">Ya, lanjutkan</a>
			<button class="btn btn-info btn-sm" onclick="cancel_reset();">Tidak</button>
			</header>
		</div>
	</div>
</div> --}}



<!-- <script type="text/javascript">
	$('#submit_button').click(function(){
		var lampiran_lenght = $('.lampiran').length;
		if (lampiran_lenght>0) {
			$('#canceled_form').submit();
		}else{
			alert('Harap unggah paling tidak satu lampiran');
		}
	})
</script> -->

<script src="{{url ('public/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
	var konten = document.getElementById("konten_artikel2");
	    CKEDITOR.replace(konten,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>
@endsection