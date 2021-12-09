@extends('layout.template')
@section('contens')<br>
<?php
	$kelas = DB::table('coba_materi')
			->join('db_jenjang','coba_materi.id_kelas','=','db_jenjang.tingkat')
			->join('mapel_kelas', 'coba_materi.mapel', '=', 'mapel_kelas.id_mapel_kelas')
			->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
			->select('coba_materi.*','tblmapel.nama as mapel','db_jenjang.nama as jenjang','mapel_kelas.id_mapel_kelas')
			->where('coba_materi.id_materi',Request::segment(2))
			->first();
?>
<?php  
	$materi_file = file_get_contents("public/muatan/materi/".$this_materi->id_materi.'.json');
    $string = json_decode($materi_file,true);
?>

{{-- <div class="container border mb-3 rounded" style="padding: 20px; background-color: white;"> --}}


<form action="{{url('update_materi/'.$this_materi->id_materi.'/'.$this_materi->id_kelas.'/'.$this_materi->mapel)}}" id="materi_form" method="post" enctype="multipart/form-data">
	@csrf

	<div class="card">
		<div class="card-header">
			<h5 class="card-title" style="font-size:16px;">
				<b>Edit Materi {{ $kelas->mapel }} {{ $kelas->jenjang }}</b>
			</h5>
	
			<span style="float: right; font-size: 14px; font-weight: normal;">
				<a href="{{ url('kelola_mapelkelas/'.$kelas->id_kelas.'/'.$kelas->id_mapel_kelas)}}" class="btn btn-sm btn-warning">
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
						<label>Judul Materi</label>
						<input type="text" name="judul" id="nama_materi" class="form-control" requiredplaceholder="E.g. What is e-learning?"value="{{$this_materi->judul}}">
						<small class="text-muted">Berikan judul yang mewakili isi materi yang akan Anda buat.</small>
					</div>

					<div class="form-group">
						<label>Konten</label>
						<textarea id="konten_materi" name="konten" required><?php echo $string['konten']; ?></textarea>
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
						@if ($this_materi->video!=null)
							<?php $video='https://www.youtube.com/watch?v='.$this_materi->video;?>

							<div class="embed-responsive embed-responsive-16by9">
								<iframe src="https://www.youtube.com/embed/{{@$this_materi->video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						@else

						@endif

						@if ($this_materi->video!=null)
							<?php $video='https://www.youtube.com/watch?v='.$this_materi->video;?>
						@endif
				
						<input type="text" name="video" id="video" value="{{@$video}}" class="form-control input-sm mt-3" required placeholder="Link Video">
						<small class="text-muted">Berikan link video pembelajaran.</small>
					</div>	
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
					<ul id="attachmentBox" style="list-style: none;">
						<?php $i=0; ?>
						@foreach($this_materi_lampiran as $lampiran)
							<?php $i++; ?>
							<li id="list{{$i}}" class="lampiran">
								<button class="btn btn-sm mb-2" type="button">
									{{$lampiran->attachment_original_name}}
								</button>
								<i style="margin-left:20px; cursor:pointer;" class="ion-android-close delete-file" data-id="{{$i}}" data-lampiran="{{$lampiran->id}}"></i>
							</li>
						@endforeach
					</ul>

					<div id="file-box"></div>
						<button class="btn btn-info btn-sm" id="add" type="button">Unggah File <i class="ion-upload"></i></button>
					</div>
				</div>

				<div class="card-footer">
					<small class="text-muted">Berikan dokumen pembelajaran.</small>
				</div>
			</div>
		</div>
	</div>
</form>



{{-- <div class="container rounded border" style="padding: 20px; background-color: white;">
	<h5 class="mb-3">Edit History</h5>
	<?php $all_history  = DB::table('coba_materi_history')->where('materi_id',$this_materi->id_materi)->get(); ?>
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

<script src="{{url('public/ckeditor/ckeditor.js')}}"></script>  

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
	$('.delete-file').click(function(){
		var id = $(this).data('id');
		var id_lampiran = $(this).data('lampiran');
		if (confirm('File ini telah diunggah, apakah Anda yakin ingin menghapus file ini? File yang telah dihapus tidak dapat dipulihkan walaupun materi ini direset seperti semula')) {
			// $('#list'+id).remove();
			$.ajax({
				type : 'get',
				url : '{{URL::to('delete_file')}}',
				data : {lampiran_id:id_lampiran},
				success:function(data)
				{
					$('#list'+id).remove();
				}
			})
		}
	})

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

	$('#kelas').on('change',function(){
		var value = $(this).val();
		var type = 'xhr'
		$.ajax({
			type : 'get',
			url : '{{URL::to('this_class_available_mapel')}}',
			data : {id_kelas:value,type:type},
			success:function(data)
			{
				$('#mapel').prop('disabled',false).html(data);
			}
		})
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
</script>

<script type="text/javascript">
	$(".check_video").click(function(){
			var id_url = $('#video').val();
			// console.log(id_url);
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
// 		function klik(){
//    document.getElementById("video").innerHTML = "Hallo Dunia";
//   }
</script>



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
<script type="text/javascript">
	var konten = document.getElementById("konten_materi");
	    CKEDITOR.replace(konten,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>
@endsection