<table id="example2" class="table table-striped">
    <thead style="background-color: black; color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Mata Pelajaran</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody style="font-size: 14px;">
        <?php 
        $num = 1;    
    ?> 
    @foreach ($pengajar as $data)
        <tr>
            <td align="center">{{ $num++ }}</td>
            {{-- <td> </td> --}}
            <td>{{  $data->name }} </td>
            <td>{{ $data->email }}</td>
            <td>
                <?php
                $tentor = DB::table('mapel_pengajar')
                ->join('users', 'users.partner_id', '=', 'mapel_pengajar.id_pengajar')
                ->join('tblmapel', 'tblmapel.id_mapel', '=', 'mapel_pengajar.id_mapel')
                ->select('mapel_pengajar.*', 'tblmapel.nama as mapel')
                ->where('id_pengajar',$data->partner_id)
                ->get();
                ?>
                @foreach ($tentor as $map)
                
                {{ $map->mapel }}, 
                @endforeach
               
            </td>
            <td align="center"> 
               
               
                
                    <a href="{{ url('detail_pengajar/'.$data->partner_id) }}" data-toggle="tooltip" data-placement="right" title="Detail Pengajar" class="btn btn-info"  style="padding:5px !important; font-size:12px !important;"><i class="fas fa-solid fa-info"></i></a>
                    <button class="btn btn-sm btn-danger btn_hapus" data-toggle="tooltip" data-placement="right" title="Hapus Pengajar" id="{{$data->partner_id}}"  style="padding:5px !important; font-size:12px !important;"><i class="fas fa-solid fa-trash"></i></button>
                    <form action="{{ url('pass_guru') }}" method="post">
                    @csrf
                    <input type="hidden" name="email_guru" class="form-control" value="{{ $data->email }}">
                    <button onclick="return confirm('Apakah yakin mereset password?');" type="submit" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="right" title="Reset Password Akun"  style="padding:5px !important; font-size:12px !important;"><i class="fas fa-user-lock"></i> Reset Pass</button>
                </form>
            </td>
            
        </tr>
    @endforeach
    </tbody>
</table>



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
        var id_pengajar = $(this).attr('id');
        var status = confirm('Yakin ingin menghapus?');
        if(status){
            $.ajax({
                url: '{{URL::to('del_pengajar')}}',
                type: 'get',
                data: {id_pengajar:id_pengajar},
                success: function(data){
                    $('#guru').html(data);
                }
            })
        }
    })
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if(Session::has('add_pengajar')) 
        toastr.success("{{ Session::get('add_pengajar') }}");
    @elseif(Session::has('gagal_pengajar')) 
        toastr.success("{{ Session::get('gagal_pengajar') }}");
    @elseif(Session::has('del_pengajar')) 
        toastr.success("{{ Session::get('del_pengajar') }}");
    @endif
</script>