@if(count($mapel)<=0)
	<div class="alert alert-warning mt-3">
		<p>Belum terdapat data</p>
	</div>
@else


<table id="example2" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Status</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody style="font-size: 14px;">
    <?php $num = 1; ?> 
    @foreach ($mapel as $data)
        <tr>
            <td align="center">{{ $num++ }}</td>
            <td>{{  $data->inisial }} </td>
            <td>{{  $data->nama }} </td>
            <td align="center" style="font-size:14px;">
                @if($data->aktif=='1')
                    <button class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;"" data-toggle="tooltip" data-placement="right" title="Non Aktifkan Mapel" >Aktif</button>
                    <button href="#" class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;"" data-toggle="tooltip" data-placement="right" title="Aktifkan Mapel">Non-aktif</button>
                @elseif($data->aktif=='0')
                    <button class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;"" data-toggle="tooltip" data-placement="right" title="Aktifkan Mapel">Non-aktif</button>
                    <button class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;"" data-id="{{$data->id}}" data-toggle="tooltip" data-placement="right" title="Non Aktifkan Mapel">Aktif</>
                @endif   
            </td>
            <td align="center">
                <button class="btn btn-danger btn-sm btn_hapus" id="{{$data->id}}" data-toggle="tooltip" data-placement="right" title="Hapus Mapel" style="padding:5px !important; font-size:12px !important;">Delete</button>
                <a class='btn btn-default btn-small' id="edit_mapel" data-toggle="modal" data-target="#modal-edit" data-nama="{{ $data->nama }}" data-inisial="{{ $data->inisial}}" data-id_mapel="{{ $data->id }}" data-toggle="tooltip" data-placement="right" title="Edit Mapel" style="padding:5px !important; font-size:12px !important;">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>



    <div class="modal fade" id="modal-edit" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Mapel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form action="{{ url('update_mapel/'.$data->id)}}" method="POST">
                    @csrf
                <div class="modal-body">
                    <div class="">
                        <label>Kode</label>
                        <input type="hidden" name="id" id="id_mapel" class="form-control">
                        <input type="text" name="inisial" id="inisial" class="form-control"><br>
                        <label>Nama Mapel</label>
                        <input type="text" name="nama" id="nama" class="form-control"><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
            </form>
            </div>
        </div>
    </div>

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
            var id_mapel = $(this).data('id');
            $.ajax({
                type : 'get',
              url : '{{URL::to('mapel_non_aktif')}}',
                data: {id_mapel:id_mapel},
                success:function(data)
                {
                    toastr.success('Berhasil MeNonaktifkan Mapel')
                    $('#aktif'+id_mapel).hide();
                    $('#non_aktif'+id_mapel).show();
                }
            });
        });
    
        $('.non_aktif').click(function(){
            var id_mapel = $(this).data('id');
            $.ajax({
                type : 'get',
              url : '{{URL::to('mapel_aktif')}}',
                data: {id_mapel:id_mapel},
                success:function(data)
                {
                    toastr.success('Berhasil MengAktifkan Mapel')
                    $('#aktif'+id_mapel).show();
                    $('#non_aktif'+id_mapel).hide();
                }
            });
        });
    
    </script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '#edit_mapel', function() { 
                var nama = $(this).data('nama');
                var inisial = $(this).data('inisial');
                var id_mapel = $(this).data('id_mapel');
                $('#nama').val(nama);
                $('#inisial').val(inisial);
                $('#id_mapel').val(id_mapel);
            })
        });
    </script>
    
    
    <script type="text/javascript">
      //Hapus Data
      $(document).ready(function() {
            $('#konfirmasi_hapus').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });
        });
    </script>
    
    <script type="text/javascript">
        $(".btn_hapus").click(function(){
                var id_mapel = $(this).attr('id');
                var status = confirm('Yakin ingin menghapus?');
                if(status){
                    $.ajax({
                        url: '{{URL::to('del_mapel')}}',
                        type: 'get',
                        data: {id_mapel:id_mapel},
                        success: function(data){
                            $('#all').html(data);
                        }
                    })
                }
            })
    </script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  @if(Session::has('add_mapel')) 
      toastr.success("{{ Session::get('add_mapel') }}");
  @elseif(Session::has('del_mapel')) 
      toastr.success("{{ Session::get('del_mapel') }}");
  @elseif(Session::has('update_mapel')) 
      toastr.success("{{ Session::get('update_mapel') }}");
  @endif

</script>