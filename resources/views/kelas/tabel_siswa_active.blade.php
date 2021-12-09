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
            
               <td align="center"> <button class="btn btn-danger btn-sm remove_siswa" id="remove_siswa{{$data->user_id}}" data-id="{{ $data->user_id }}" data-toggle="tooltip" data-placement="right" title="Keluarkan Siswa dari Kelas ini" style="padding:5px !important; font-size:12px !important;">Remove</button>
            
            </td>
            
        </tr>
        
    @endforeach
    </tbody>
</table>
{{-- @endif --}}



<script type="text/javascript">
	$('.remove_siswa').click(function(){
		var id_siswa_r = $(this).data('id');
        var id_kelas = '{{@$id_kelas}}';
        var jenjang = '{{@$jenjang}}';
        var tingkat = '{{@$tingkat}}';
		$.ajax({
	        type : 'get',
	        url : '{{URL::to('remove_siswa')}}',
	        data: {id_siswa_r:id_siswa_r,id_kelas:id_kelas,jenjang:jenjang,tingkat:tingkat},
	        success:function(data)
	        {
				toastr.success('Berhasil Mengeluarkan Siswa')
	        	var id_kelas = '{{@$id_kelas}}';
                var jenjang = '{{@$jenjang}}';
                var tingkat = '{{@$tingkat}}';

	        	$.ajax({
			        type : 'get',
			        url : '{{URL::to('siswa_aktif')}}',
			        data: {id_kelas:id_kelas,jenjang:jenjang,tingkat:tingkat},
			        success:function(data)
			        {
			          $('#siswa_aktif').html(data);
			        }
			      });

	        	$('#row'+id_siswa_r).css('display','none');
	        	$.ajax({
		        type : 'get',
		        url : '{{URL::to('siswa_inaktif')}}',
		        data: {id_kelas:id_kelas,jenjang:jenjang,tingkat:tingkat},
		        success:function(data)
		        {
		          $('#siswa_inaktif').html(data);
		        }
		      });
	        }
	    });
	})
</script>


<script type="text/javascript">
	$(document).ready( function () {
	    $('#myTable2').DataTable();
	} );
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   