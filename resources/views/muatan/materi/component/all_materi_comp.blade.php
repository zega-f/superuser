<?php 
$all_materi = DB::table('coba_materi')
->join('db_jenjang','coba_materi.id_kelas','=','db_jenjang.tingkat')
->join('tblmapel','coba_materi.mapel','=','tblmapel.id_mapel')
->select('coba_materi.*','tblmapel.nama as mapel_name','db_jenjang.nama as kelas')
->where('coba_materi.id_kelas',Request::segment(2))
->where('coba_materi.mapel',Request::segment(3))
->get(); 
?>
<table class="table mt-3" id="materi_table">
	<thead>
		<tr>
			<th>Judul</th>
			<th>Kelas</th
			<th>Mapel</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($all_materi as $materi)
			<tr>
				<td>{{$materi->judul}}</td>
				<td>{{$materi->kelas}}</td>
				<td>{{$materi->mapel_name}}</td>
				<td>
					<a href="{{url('preview_materi/'.$materi->id_materi)}}" class="btn btn-sm btn-secondary ion-eye"></a>
					<a href="{{url('edit_materi/'.$materi->id_materi)}}" class="btn btn-info btn-sm ion-edit"></a>
					<button class="btn btn-sm btn-danger ion-trash-b" data-toggle="tooltip" data-placement="bottom" title="Hapus materi" data-id="{{$materi->id_materi}}"></button>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
<div class="modal rounded" id="prog_modal" style="position: absolute;">
	<div class="rounded" style="padding: 20px; background-color: white;">Sedang Memproses</div>
</div>




<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
	$('.ion-trash-b').click(function(){
		var id = $(this).data('id');
		if (confirm('Apakah Anda yakin ingin menghapus materi ini? Menghapus materi akan menghapus semua lampiran dan file pendukung')) {
			$('#prog_modal').css({
				'display':'grid',
				'place-items':'center',
			});
			$.ajax({
				type : 'get',
				url : '{{URL::to('delete_materi')}}',
				data : {id_materi:id},
				success:function(data)
				{
					$('#prog_modal').hide();
					$('#materi_box').html(data);
				}
			})
		}
	})
	$(document).ready(function(){
		$('#materi_table').DataTable();
	})
</script>