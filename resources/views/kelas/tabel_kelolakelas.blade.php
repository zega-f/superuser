{{-- @if (@$data == '')
     Data Masih Kosong
@else --}}
@if(count($mapel_kelas)<=0)
	<div class="alert alert-warning mt-1">
		<p>Belum terdapat data</p>
	</div>
@else

<table id="example2" class="table table-striped">
    <thead>
        <tr align="center">
        <th>#</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Aksi</th>
        </tr> 
    </thead>
    

    <tbody>
        
        @foreach ($mapel_kelas as $num=>$data)
            <tr>
                <td>{{ $num+1 }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ number_format($data->harga) }}</td>
                <td align="center">
                    <a href="{{ url('materi/'.$data->kelas,$data->id_mapel) }}" class='btn btn-info btn-sm'>Kelola</a>
                    <a class="btn btn-default btn-sm" id="edit_mapel" data-toggle="modal" data-target="#modal-edit" data-nama="{{ $data->nama }}" data-mapel="{{ $data->mapel }}" data-harga="{{ $data->harga }}" data-id_mapel_kelas="{{ $data->id }}"><i class="fas fa-solid fa-pencil-alt"></i></a>
                    <button class="btn btn-danger btn-sm btn_hapus" id="{{$data->id}}" idkel="{{ $data->kelas }}"><i class="fas fa-solid fa-trash"></i></button>
                </td>
               
            </tr>
        @endforeach
       
    </tbody>
  
    </table>




    
    <div class="modal fade" id="modal-edit" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Mapel Kelas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <form action="{{ url('update_mapel_kelas/'.$data->id)}}" method="POST">
                            @csrf
                        <label>Nama Mapel</label>
                        <input type="hidden" name="id" id="id_mapel_kelas" class="form-control">

                        <div class="form-group">
                            <select name="nama" id="" class="form-control">
                                <option value="{{ $data->mapel }}" selected="selected" id="nama"><b></b></option>
                                 <?php $mapel = DB::table('tblmapel')->get();?>
                                @foreach($mapel as $row)
                                    <option value="{{ $row->id_mapel }}"> {{ $row->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" name="harga" id="harga" class="form-control">
                        </div>

                       
                        
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(".btn_hapus").click(function() {
            var id_kelas = $(this).attr('id');
            var id_kel = $(this).attr('idkel');
            var status = confirm('Yakin ingin menghapus?');
            if(status){
                $.ajax({
                    url: '{{URL::to('del_kelolakelas')}}',
                    type: 'get',
                    data: {id_kelas:id_kelas, id_kel:id_kel},
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
            var mapel = $(this).data('mapel');
            var harga = $(this).data('harga');
            var pengajar = $(this).data('pengajar');
            var id_pengajar = $(this).data('id_pengajar');
            var hari = $(this).data('hari');
            var id_hari = $(this).data('id_hari');
            var id_mapel_kelas = $(this).data('id_mapel_kelas');
            $('#mapel').val(mapel);
            $('#nama').text(nama);
            $('#harga').val(harga);
            $('#id_pengajar').val(id_pengajar);
            $('#pengajar').text(pengajar);
            $('#hari').text(hari);
            $('#id_hari').val(id_hari);
            $('#id_mapel_kelas').val(id_mapel_kelas);
        })
    });
</script>