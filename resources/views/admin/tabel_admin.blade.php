@if(count($admin)<=0)
	<div class="alert alert-warning mt-3">
		<p>Belum terdapat data</p>
	</div>
@else
<table id="example2" class="table table-striped">
    <thead style="background-color: black; color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Level</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody style="font-size: 14px;">
    <?php $num = 1; ?> 
    @foreach ($admin as $data)
        <tr>
            <td align="center">{{ $num++ }}</td>
            <td>{{  $data->name }} </td>
            <td>{{  $data->email }} </td>
            <td align="center">Level {{  $data->level }} </td>
            <td align="center" style="font-size:14px;">

                @if($data->status=='1')
                    <button class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;"><i class="fas fa-user-check" data-toggle="tooltip" title="Non Aktifkan Admin"></i></button>
                    <button class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: none;"  style="padding:5px !important; font-size:12px !important;"><i class="fas fa-user-slash" data-toggle="tooltip" title="Aktifkan Admin"></i></button>

                @elseif($data->status=='0')
                    <button class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;"><i class="fas fa-user-slash" data-toggle="tooltip" title="Non Aktifkan Admin"></i></button>
                    <button class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;" data-id="{{$data->id}}"><i class="fas fa-user-check" data-toggle="tooltip" title="Non Aktifkan Admin"></i></button>
                @endif   

                <button class="btn btn-danger btn-sm btn_hapus" id="{{$data->id}}"  style="padding:5px !important; font-size:12px !important;"><i class="fas fa-trash" data-toggle="tooltip" title="Hapus Admin"></i></button>
                <form action="{{ url('pass_admin') }}" method="post">
                    @csrf
                    <input type="hidden" name="email_admin" class="form-control" value="{{ $data->email }}">
                    <button onclick="return confirm('Apakah yakin mereset password?');" type="submit" class="btn btn-default btn-sm" data-toggle="tooltip" title="Reset Password Admin" style="padding:5px !important; font-size:12px !important;">Reset Pass</button>
                </form>
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
        $('.aktif').click(function(){
            var id_admin = $(this).data('id');
            $.ajax({
                type : 'get',
                url : '{{URL::to('admin_non_aktif')}}',
                data: {id_admin:id_admin},
                success:function(data)
                {
                    toastr.success('Berhasil MeNonaktifkan Admin')
                    $('#aktif'+id_admin).hide();
                    $('#non_aktif'+id_admin).show();
                }
            });
        });
    
        $('.non_aktif').click(function(){
            var id_admin = $(this).data('id');
            $.ajax({
                type : 'get',
              url : '{{URL::to('admin_aktif')}}',
                data: {id_admin:id_admin},
                success:function(data)
                {
                    toastr.success('Berhasil MengAktifkan Admin')
                    $('#aktif'+id_admin).show();
                    $('#non_aktif'+id_admin).hide();
                }
            });
        });
    </script>
    

    <script type="text/javascript">
        $(".btn_hapus").click(function(){
            var id_admin = $(this).attr('id');
            var status = confirm('Yakin ingin menghapus?');
            if(status){
                $.ajax({
                    url: '{{URL::to('del_admin')}}',
                    type: 'get',
                    data: {id_admin:id_admin},
                    success: function(data){
                        $('#admin').html(data);
                    }
                })
            }
        })
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(Session::has('add_admin')) 
            toastr.success("{{ Session::get('add_admin') }}");
        @elseif(Session::has('del_admin')) 
            toastr.success("{{ Session::get('del_admin') }}");
        @endif
    </script>