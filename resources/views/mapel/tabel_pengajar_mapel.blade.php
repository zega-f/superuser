@if(count($pengajar_mapel)<=0)
	<div class="alert alert-warning mt-3">
		<p>Belum terdapat data</p>
	</div>
@else
{{-- {{ $id }} --}}

<table id="example2" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Mapel</th>
        <th>Pengajar</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody style="font-size: 14px;">
    <?php $num = 1; ?> 
    @foreach ($pengajar_mapel as $data)
        <tr>
            <td align="center">{{ $num++ }}</td>
            <td>{{  $data->pengajar }} </td>
            <td>{{  $data->mapel }} </td>
           
            <td align="center">
                <button class="btn btn-danger btn-sm btn_hapus" id="{{$data->id}}" id_pengajar="{{ $data->id_pengajar }}" data-toggle="tooltip" title="Hapus Mapel yang diampu Pengajar ini" style="padding:5px !important; font-size:12px !important;">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>



    <div class="modal fade" id="modal-edit" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Mapel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <form action="{{ url('update_mapel/'.$data->id)}}" method="POST">
                            @csrf
                        <label>Nama Mapel</label>
                        <input type="hidden" name="id" id="id_mapel" class="form-control">
                        <input type="text" name="nama" id="nama" class="form-control"><br>
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
        $(document).ready(function() {
            $(document).on('click', '#edit_mapel', function() { 
                var nama = $(this).data('nama');
                var info = $(this).data('info');
                var id_mapel = $(this).data('id_mapel');
                $('#nama').val(nama);
                $('#info').val(info);
                $('#id_mapel').val(id_mapel);
            })
        });
    </script>
    
    
    
    
    <script type="text/javascript">
    
        $(".btn_hapus").click(function(){
                var id_mapel = $(this).attr('id');
                var id_pengajar = $(this).attr('id_pengajar');
                var status = confirm('Yakin ingin menghapus?');
                if(status){
                    $.ajax({
                        url: '{{URL::to('del_mapel_pengajar')}}',
                        type: 'get',
                        data: {id_mapel:id_mapel,id_pengajar:id_pengajar},
                        success: function(data){
                            $('#all').html(data);
                        }
                    })
                }
            })
    </script>