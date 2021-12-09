@if($inactive_status==0)
  <div class="alert alert-warning mt-3">
      <p>untuk mengatur Rombel pilih tingkat diatas</p>
  </div>
@elseif(count($all_siswa)<=0)
  <div class="alert alert-warning mt-3">
      <p>kosong</p>
  </div>
@else
  
<table id="myTable3" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Nama</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody id="tbody_inactive" style="font-size: 14px;">
    <?php $num = 1;?> 
    @foreach ($all_siswa as $data)
    <?php
    $jenjang = $data->jenjang;
    $tingkat = $data->tingkat;
    ?>
        <tr id="row{{$data->user_id}}">
            <td align="center">{{ $num++ }}</td>
            <td>{{ $data->name }}</td>
            <td align="center">
                @if($active_status==1)
                <button class="btn btn-info btn-sm" disabled  data-toggle="tooltip" data-placement="right" title="Pilih Kelas diatas Terlebih dahulu" style="padding:5px !important; font-size:12px !important;">Add</button>
                @else
                <button class="btn btn-info btn-sm add_2_class" id="add_2_class{{$data->user_id}}" data-idsiswa="{{$data->user_id}}" data-id_kelas="{{ $data->room_id }}" data-tingkat="{{$data->tingkat}}"  data-toggle="tooltip" data-placement="right" title="Tambahkan Siswa Pada kelas ini"  style="padding:5px !important; font-size:12px !important;">Add</button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif

<script type="text/javascript">
	$(document).ready( function () {
	    $('#myTable3').DataTable();
	} );
</script>

<script type="text/javascript">
	$('.add_2_class').click(function(){
		var siswa_id = $(this).data('idsiswa');
		var id_kelas = '{{@$id_kelas}}';
    var jenjang = '{{@$jenjang}}';
    var tingkat = '{{@$tingkat}}';

		$('.add_2_class').prop('disabled',true);
		$.ajax({
      type : 'get',
      url :  '{{URL::to('siswa_into_class1')}}',
      data: {siswa_id:siswa_id,id_kelas:id_kelas,jenjang:jenjang,tingkat:tingkat},
      success:function(data)
      {
        $('#row'+siswa_id).css('display','none');
        var id_kelas = '{{@$id_kelas}}';
        var jenjang = '{{@$jenjang}}';
        var tingkat = '{{@$tingkat}}';
        $('.add_2_class').prop('disabled',false);

			  $.ajax({
		      type : 'get',
		      url : '{{URL::to('siswa_aktif1')}}',
		      data: {id_kelas:id_kelas,jenjang:jenjang,tingkat:tingkat},
		      success:function(data)
		      {
		        $('#siswa_aktif').html(data);
		      }
		    });

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
