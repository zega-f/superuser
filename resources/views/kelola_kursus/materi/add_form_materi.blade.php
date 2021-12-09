@extends('layout.template')
@section('contens')<br>

<div class="container border mb-3 rounded" style="padding: 20px; background-color: white;">

	<form action="{{url('coba_sn')}}" id="materi_form" method="post" enctype="multipart/form-data">
		@csrf
		<h5 class="mb-3">
			Materi {{ $nm_kursus->room_name }}
			<span style="float: right; font-size: 14px; font-weight: normal;">
				<button class="btn btn-sm btn-warning">
					Kembali <i class="bi bi-check-square"></i>
				</button>
				<button class="btn btn-sm btn-success">
					Simpan <i class="bi bi-check-square"></i>
				</button>
			</span>
		</h5>
		<table class="table">
			<tr>
				<td>Judul materi</td>
				<td>
					<input 
					type="text" 
					name="judul" 
					id="nama_materi" 
					class="form-control" 
					required
					placeholder="E.g. What is e-learning?" 
					>
					<small class="text-muted">Berikan judul yang mewakili isi materi yang akan Anda buat.</small>
				</td>
			</tr>

			
			<tr>
				<td>Video</td>
				<td>
					<div class="row">
					<div class="col-6">
						<input type="text" name="video" id="video" class="form-control" required placeholder="Link Video" onkeyup="copytextbox();">
						<small class="text-muted">Berikan link video pembelajaran.</small>
					</div>
					<div class="col-2">
						<input type="button" class="btn btn-sm btn-info check_video" id="url" value="check video" placeholder="Check">
					</div>
					<div class="col-4" id="videocek">
						@include('muatan.materi.check_video')
					</div>
					</div>
				</td>
			</tr>
			
            <?php 
				$room=$room_id;
				$bab=$bab_id;
                $mapel=null;
			?>
				
			<input type="hidden" value="{{ $room }}" name="kelas">
			<input type="hidden" value="{{ $bab }}" name="bab_id">
            <input type="hidden" value="{{ $mapel }}" name="mapel">
						
			<tr>
				<td>Konten</td>
				<td><textarea id="konten_materi" name="konten" required></textarea>
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
	</form>
</div>



{{-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> --}}
<script src="{{url('public/ckeditor/ckeditor.js')}}"></script>  
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