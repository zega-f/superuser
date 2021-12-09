@if(count($mapel_kelas)<=0)
	<div class="alert alert-warning mt-1">
		<p>Belum terdapat Kelas, Tambahkan kelas</p>
	</div>
@else

<table id="example2" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Aksi</th>
        </tr> 
    </thead>
    

    <tbody style="font-size: 14px;">
        @foreach ($mapel_kelas as $num=>$data)
            <tr>
                <td>{{ $num+1 }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ number_format($data->harga) }}</td>
                <td align="center">
                    <a href="{{ url('kelola_mapelkelas/'.$data->tingkat,$data->id_mapel_kelas) }}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="right" title="Kelola Materi/Tugas/Quiz" style="padding:5px !important; font-size:12px !important;">Kelola</a>

                    <a class="btn btn-default btn-sm" id="edit_mapel" data-toggle="modal" data-target="#modal-edit"  data-mapel="{{ $data->mapel }}" data-nama="{{ $data->nama }}" data-nama_mapel="{{ $data->nama }}" data-harga="{{ $data->harga }}" data-id_mapel_kelas="{{ $data->id }}" data-id_mapel="{{$data->id_mapel}}" data-deskripsi="{{ $data->deskripsi }}" data-toggle="tooltip" data-placement="right" title="Edit Mapel" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-solid fa-pencil-alt"></i></a>
                    
                    <button class="btn btn-danger btn-sm btn_hapus" id="{{$data->id}}" tingkat="{{ $data->tingkat }}" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-solid fa-trash" data-toggle="tooltip" data-placement="right" title="Hapus Mapel"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



    
    <div class="modal fade" id="modal-edit" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Mapel Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ url('update_mapel_kelas/'.$data->id)}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="">
                        
                        <input type="hidden" name="id" id="id_mapel_kelas" class="form-control">
                        <input type="hidden" name="nama" id="id_mapel" class="form-control">

                        <div class="form-group">
                            <label>Nama Mapel</label>
                            <input type="text" name="nama_mapel1" id="nama_mapel" class="form-control" readonly> 
                        </div>

                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" name="harga" id="harga" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" maxlength="200" class="form-control"></textarea>
                        </div>                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button> 
                </div>
            </form>
            </div>
        </div>
    </div>
    @endif

    {{-- @if ($message = Session::get('success'))
    <div class="alert alert-success alert-sm" id="alert">
        <p>{{ $message }}</p>
    </div>
    @endif --}}
    
   
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(Session::has('add_mapel_kelas')) 
            toastr.success("{{ Session::get('add_mapel_kelas') }}");
            // toastr.clear();
        @elseif(Session::has('update_mapel_kelas')) 
            toastr.success("{{ Session::get('update_mapel_kelas') }}");
            // toastr.clear();
        @elseif(Session::has('delete_mapel_kelas')) 
            toastr.success("{{ Session::get('delete_mapel_kelas') }}");
            // toastr.clear();
        @elseif(Session::has('registrasi')) 
            toastr.success("{{ Session::get('registrasi') }}");
            // toastr.clear();
        @elseif(Session::has('gagal_mapel_kelas')) 
            toastr.error("{{ Session::get('gagal_mapel_kelas') }}", {  maxOpened: 1, });
            // (Session::remove();
        @endif
    </script>

    <script type="text/javascript">
        $(".btn_hapus").click(function() {
            var id_kelas = $(this).attr('id');
            var tingkat = $(this).attr('tingkat');
            var status = confirm('Yakin ingin menghapus?');
            if(status){
                $.ajax({
                    url: '{{URL::to('del_mapel_kelas')}}',
                    type: 'get',
                    data: {id_kelas:id_kelas,tingkat:tingkat},
                    success: function(data) {
                        $('#kelola').html(data);
                    }
                })
            }
        })
    </script>



<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#edit_mapel', function() { 
            var nama = $(this).data('nama');
            var nama_mapel = $(this).data('nama_mapel');
            var mapel = $(this).data('mapel');
            var id_mapel = $(this).data('id_mapel');
            var harga = $(this).data('harga');
            var pengajar = $(this).data('pengajar');
            var id_pengajar = $(this).data('id_pengajar');
            var hari = $(this).data('hari');
            var id_hari = $(this).data('id_hari');
            var id_mapel_kelas = $(this).data('id_mapel_kelas');
            var deskripsi = $(this).data('deskripsi');
            $('#mapel').val(mapel);
            $('#nama').text(nama);
            $('#nama_mapel').val(nama_mapel);
            $('#harga').val(harga);
            $('#id_mapel').val(id_mapel);
            $('#id_pengajar').val(id_pengajar);
            $('#pengajar').text(pengajar);
            $('#hari').text(hari);
            $('#id_hari').val(id_hari);
            $('#id_mapel_kelas').val(id_mapel_kelas);
            $('#deskripsi').val(deskripsi);
        })
    });
</script>

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


  
