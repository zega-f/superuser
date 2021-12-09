@if(count($partnership)<=0)
	<div class="alert alert-warning mt-3">
		<p>Belum terdapat data</p>
	</div>
@else


<table id="example2" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Instansi</th>
        <th>Alamat</th>
        <th>Telpon</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody style="font-size: 14px;">
    <?php $num = 1; ?> 
    @foreach ($partnership as $data)
        <tr>
            <td align="center">{{ $num++ }}</td>
            <td>{{  $data->nama }} </td>
            <td>{{  $data->email }} </td>
            <td>{{  $data->instansi }} </td>
            <td>{{  $data->alamat }} </td>
            <td>{{  $data->telpon }} </td>
           
            <td align="center">
                <button class="btn btn-danger btn-sm btn_hapus" id="{{$data->id}}" style="padding:5px !important; font-size:12px !important;">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>



    

@endif
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
      </script>


   
    
    
    <script type="text/javascript">
        $(".btn_hapus").click(function(){
                var id = $(this).attr('id');
                var status = confirm('Yakin ingin menghapus?');
                if(status){
                    $.ajax({
                        url: '{{URL::to('del_partnership')}}',
                        type: 'get',
                        data: {id:id},
                        success: function(data){
                            $('#all').html(data);
                        }
                    })
                }
            })
    </script>