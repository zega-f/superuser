<table id="example2" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Nama</th>
        <th>Jenjang</th>
        <th>Tingkat</th>
        <th>Status</th>
        <th>Siswa</th>
        {{-- <th>Registrasi</th>
        <th>Info</th> --}}
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody style="font-size: 14px;">
        <?php 
        $num = 1;    
    ?> 
    @foreach ($kls as $data)
        <tr>
            <td align="center">{{ $num++ }}</td>
            <td>
                @if($data->jenjang=='1')
                SD
                @elseif($data->jenjang=='2')      
                SMP
                @elseif($data->jenjang=='3')
                SMA
                @endif 
                {{  $data->tingkat }}{{  $data->room_name }} 
            </td>
            <td align="center">
                @if($data->jenjang=='1')
                SD
                @elseif($data->jenjang=='2')      
                SMP
                @elseif($data->jenjang=='3')
                SMA
                @endif  
            </td>
            <td>Kelas {{ $data->tingkat }}</td>
            <td align="center">
                @if($data->status=='1')
                <a href="#" class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;" data-toggle="tooltip" data-placement="right" title="Non Aktifkan Kelas">Aktif</a>
                <a href="#" class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;" data-toggle="tooltip" data-placement="right" title="Aktifkan Kelas">Non-aktif</a>

            @elseif($data->status=='0')
                <a href="#" class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;" data-toggle="tooltip" data-placement="right" title="Aktifkan Kelas">Non-aktif</a>
                <a href="#" class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;" data-id="{{$data->id}}" data-toggle="tooltip" data-placement="right" title="Non Aktifkan Kelas">Aktif</a>
            @endif   
            </td>
            <td align="center"> 
                <?php  
                    $jmlsiswa=DB::table('room_user')
                    ->where('room_id', $data->id_kelas)
                    ->groupBy('room_id')
                    ->count();
                ?>
                {{ $jmlsiswa }}
            </td>
            {{-- <td align="center"> 
                @if($data->registrasi==0)
                    -
                @else
                    {{ number_format($data->registrasi) }}
                @endif
            </td>
            <td> {{ $data->info }}</td> --}}
            
            <td align="center">
                <a href="kelola_kelas/{{$data->id_kelas}}/{{$data->jenjang}}/{{$data->tingkat}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="right" title="Kelola Kelas"  style="padding:5px !important; font-size:12px !important;">Kelola</a>
                <a href="{{ url('detail_kelas/'.$data->id_kelas) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="right" title="Daftar Siswa Kelas ini"  style="padding:5px !important; font-size:12px !important;"><i class="fas fa-user-graduate"></i></a>
                <button class="btn btn-danger btn-sm btn_hapus" data-toggle="tooltip" data-placement="bottom" title="Hapus Kelas" id="{{$data->id_kelas}}" style="padding:5px !important; font-size:12px !important;"><i class="fa fa-solid fa-trash"></i></button>
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
    $('.aktif').click(function() {
        var id_kelas = $(this).data('id');
        $.ajax({
            type : 'get',
            url  : '{{URL::to('kelas_non_aktif')}}',
            data : {id_kelas:id_kelas},
            success:function(data)
            {
                toastr.success('Berhasil MeNonaktifkan Kelas')
                $('#aktif'+id_kelas).hide();
                $('#non_aktif'+id_kelas).show();
            }
        });
    });
    
    $('.non_aktif').click(function() {
        var id_kelas = $(this).data('id');
        $.ajax({
            type : 'get',
            url  : '{{URL::to('kelas_aktif')}}',
            data : {id_kelas:id_kelas},
            success:function(data)
            {   
                toastr.success('Berhasil MengAktifkan Kelas')
                $('#aktif'+id_kelas).show();
                $('#non_aktif'+id_kelas).hide();
            }
        });
    });
</script>
    

<script type="text/javascript">
        $(".btn_hapus").click(function(){
                var id_kelas = $(this).attr('id');
                var status = confirm('Yakin ingin menghapus?');
                if(status){
                    $.ajax({
                        url: '{{URL::to('del_kelas')}}',
                        type: 'get',
                        data: {id_kelas:id_kelas},
                        success: function(data){
                            $('#kls').html(data);
                        }
                    })
                }
            })
    </script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(Session::has('success')) 
        toastr.success("{{ Session::get('success') }}");
    @endif

</script>