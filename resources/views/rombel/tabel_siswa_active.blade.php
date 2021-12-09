@if($active_status==0)
	<div class="alert alert-warning mt-3">
		<p>untuk mengatur Rombel pilih tingkat diatas</p>
	</div>
@elseif($active_status==1)
  <div class="alert alert-warning mt-3">
      <p>pilih kelas</p>
  </div>
@elseif(count($all_siswa_active)<=0)
    <div class="alert alert-warning mt-3">
        <p>Belum ada siswa di Kelas ini</p>
    </div>
@else

<table id="myTable2" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Nama</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody id="tbody_active" style="font-size: 14px;">
    <?php $num = 1;?>   
    @foreach ($all_siswa_active as $data)
    <?php
    $jenjang = $data->jenjang;
    $tingkat = $data->tingkat;
    ?>
        <tr id="row{{$data->user_id}}">
            <td align="center">{{ $num++ }}</td>
            <td>{{ $data->name }}</td>
            <td align="center"> 
				<button class="btn btn-danger btn-sm remove_siswa" id="remove_siswa{{$data->user_id}}" data-id="{{ $data->user_id }}" data-tingkat="{{$data->tingkat}}"  data-toggle="tooltip" data-placement="right" title="Keluarkan Siswa dari Kelas ini" style="padding:5px !important; font-size:12px !important;">Remove</button>
            </td> 
        </tr> 
    @endforeach
    </tbody>
</table>
@endif

<script type="text/javascript">
	$(document).ready( function () {
	    $('#myTable2').DataTable();
	} );
</script>

<script type="text/javascript">
	$('.remove_siswa').click(function(){
		var id_siswa_r = $(this).data('id');
        var id_kelas = '{{@$id_kelas}}';
        var jenjang = '{{@$jenjang}}';
        var tingkat = '{{@$tingkat}}';

		$.ajax({
	        type : 'get',
	        url : '{{URL::to('remove_siswa1')}}',
	        data: {id_siswa_r:id_siswa_r,id_kelas:id_kelas,jenjang:jenjang,tingkat:tingkat},
	        success:function(data)
	        {
	        	var id_kelas = '{{@$id_kelas}}';
                var jenjang = '{{@$jenjang}}';
                var tingkat = '{{@$tingkat}}';

	        	$.ajax({
			        type : 'get',
			        url : '{{URL::to('siswa_aktif1')}}',
			        data: {id_kelas:id_kelas,jenjang:jenjang,tingkat:tingkat},
			        success:function(data)
			        {
			          $('#siswa_aktif').html(data);
			        }
			      });

	        	$('#row'+id_siswa_r).css('display','none');
				
	        	$.ajax({
		        type : 'get',
		        url : '{{URL::to('siswa_inaktif1')}}',
		        data: {id_kelas:id_kelas,jenjang:jenjang,tingkat:tingkat},
		        success:function(data)
		        {
		          $('#siswa_inaktif').html(data);
		        }
		     	});

			  	$.ajax({
					type : 'get',
					url : '{{URL::to('reload_pendaftar')}}',
					data : {tingkat:tingkat},
					success:function(data)
					{
						$('#jumlah'+tingkat).html(data);
					}
				});
	        }
	    });
	})
</script>

