<?php  
	// tambah where condition ketika sudah dimasukkan dalam kelas
	$all_tugas = DB::table('coba_tugas')
	->join('db_jenjang','coba_tugas.id_kelas','=','db_jenjang.tingkat')
	->join('tblmapel','coba_tugas.mapel','=','tblmapel.id_mapel')
	->select('coba_tugas.*','db_jenjang.nama as room_name','tblmapel.nama as mapel_name')
	->where('coba_tugas.id_kelas',Request::segment(2))
	->where('coba_tugas.mapel',Request::segment(3))
	->get();
?>
@if(count($all_tugas)==0)
<div class="alert alert-info">Tidak terdapat data</div>
@else
<table class="table" id="tugas_table">
	<thead>
		<tr>
			<th>Judul</th>
			<th>Kelas</th>
			<th>Mapel</th>
			<th>@</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($all_tugas as $tugas)
			<tr>
				<td>{{$tugas->judul}}</td>
				<td>{{$tugas->room_name}}</td>
				<td>{{$tugas->mapel_name}}</td>
				<td>{{$tugas->waktu}}</td>
				<td>
					<a href="{{url('preview_tugas/'.$tugas->id_tugas)}}" class="btn btn-sm btn-secondary ion-eye"></a>
					<a href="{{url('edit_tugas/'.$tugas->id_tugas)}}" class="btn btn-info btn-sm ion-edit"></a>
					<button class="btn btn-sm btn-danger ion-trash-b" data-toggle="tooltip" data-placement="bottom" title="Hapus materi" data-id="{{$tugas->id_tugas}}"></button>
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
				url : '{{URL::to('delete_tugas')}}',
				data : {id_tugas:id},
				success:function(data)
				{
					$('#prog_modal').hide();
					$('#all_tugas_box').html(data);
				}
			})
		}
	})
	$(document).ready(function(){
		$('#tugas_table').DataTable();
	})
</script>
@endif