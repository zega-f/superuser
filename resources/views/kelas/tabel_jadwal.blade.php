<table id="example3" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Waktu</th>
        <th>Nama</th>
        <th>Pengajar</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody style="font-size: 14px;">
        @foreach ($jadwal as $num=>$data)
            <tr>
                <td>{{ $num+1 }}</td>
                {{-- <td>{{ $data->id_jadwal }}</td> --}}
                <td>
                   {{ ucfirst($data->hari); }} {{ $data->mulai }} - {{ $data->akhir}}
                </td>
                <td>{{ $data->nama_mapel }}</td>
                <td>{{ $data->pengajar }}</td>
                <td align="center">
                    <a href="#" data-toggle="modal" data-target="#modal_video" id="{{ $data->id_jadwal }}" class="btn btn-primary btn-sm video" data-toggle="tooltip" data-placement="right" title="Detail" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-clock"></i></a>

                    {{-- <a href="#" data-toggle="modal" data-target="#modal_edit{{ $data->id }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="right" title="Edit Jadwal" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-pencil-alt"></i></a> --}}

                    <button class="btn btn-danger btn-sm btn_hapus" id="{{$data->meet_id}}" jadwal="{{ $data->kelas }}" data-toggle="tooltip" data-placement="right" title="Hapus Jadwal" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-trash"></i></button>
                </td>
            </tr>

            <div class="modal fade" id="modal_edit{{ $data->id }}" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Jadwal Kursus</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('kelola_kursus.jadwal.edit_jadwal')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                        </div>
                    </div>
                </div>
            </div>

            
        

        @endforeach
    </tbody>
    </table>
    <br><br>

    <div class="modal fade" id="modal_video" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Jadwal Tatap Muka</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="box">
                    <div class="table-responsive" id="zoom_video">
                        {{-- @include('kelas.zoom_video') --}}
                      </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>

    

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript">
        $('#example3').DataTable({
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
        // $(document).ready(function() {
    
            //Hapus Data dengan konfirmasi
            $(".btn_hapus").click(function(){
                    var id_jadwal = $(this).attr('id');
                    var jadwal = $(this).attr('jadwal');
                    var status = confirm('Yakin ingin menghapus Jadwal Tatap Muka?');
                    if(status){
                        $.ajax({
                            url: '{{URL::to('del_jadwal')}}',
                            type: 'get',
                            data: {id_jadwal:id_jadwal, jadwal:jadwal},
                            success: function(data){
                                $('#jadwal').html(data);
                            }
                        })
                    }
                })
        </script>


<script type="text/javascript">
    $(".video").click(function(){
        var id_jadwal = $(this).attr('id');
        $.ajax({
            url: '{{URL::to('zoom_video')}}',
            type: 'get',
            data: {id_jadwal:id_jadwal},
            success: function(data) {
                $('#box').html(data);
                $('#modal_video').show(data);
            }
        })
    })
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(Session::has('delete'))
            toastr.success("{{ Session::get('delete') }}");
        @endif

        
    </script>
