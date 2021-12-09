<table id="example2" class="table table-striped">
  <thead class="bg-dark" style="color:white; font-size:15px;">
    <tr align="center">
      <th>#</th>
      <th>Nama</th>
      <th>Registrasi</th>
      <th>SPV</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr> 
  </thead>

  <tbody style="font-size: 14px;">
    <?php $num = 1;?> 
    @foreach ($kursus as $data)
      <tr>
        <td align="center">{{ $num++ }}</td>
            
        <td>{{ $data->room_name }}</td>
        <td align="center">{{ number_format($data->biaya) }}</td>
        <td>
          <?php
            $spv = DB::table('users')
            ->join('kursus_spv','.users.partner_id','=','kursus_spv.id_spv')
            ->where('kursus_spv.room_id',$data->room_id)
            ->get();
          ?>
          @foreach ($spv as $item)
            {{ $item->name}},
          @endforeach
        </td>

        <td  align="center">
          @if($data->locked=='1')
            <a href="#" class="btn btn-success btn-sm aktif" id="aktif{{$data->room_id}}" data-id="{{$data->room_id}}" style="display: inline; adding:5px !important; font-size:12px !important;" data-toggle="tooltip" data-placement="right" title="Non Aktifkan Kursus" data-toggle="tooltip" data-placement="right" title="Aktifkan Kursus">Aktif</a>
            <a href="#" class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->room_id}}" data-id="{{$data->room_id}}" style="display: none; adding:5px !important; font-size:12px !important;">Non-aktif</a>
          @elseif($data->locked=='0')
            <a href="#" class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->room_id}}" data-id="{{$data->room_id}}" style="display: inline; adding:5px !important; font-size:12px !important;" data-toggle="tooltip" data-placement="right" title="Aktifkan Kursus">Non-aktif</a>
            <a href="#" class="btn btn-success btn-sm aktif" id="aktif{{$data->room_id}}" style="display: none; adding:5px !important; font-size:12px !important;" data-id="{{$data->room_id}}" data-toggle="tooltip" data-placement="right" title="Non Aktifkan Kursus">Aktif</a>
          @endif
        </td>
           
        <td align="center">
          <a href="{{ url('kelola_kursus/'.$data->room_id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="right" title="Kelola Kursus" style="padding:5px !important; font-size:12px !important;">Kelola</a>
          <a class="btn btn bg-teal btn-sm" id="view_kursus" data-toggle="modal" data-target="#modal-view{{ $data->id }}" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-solid fa-eye" data-toggle="tooltip" data-placement="right" title="Detail Kursus"></i></a>
          <a class="btn btn-info btn-sm" id="edit_kursus" data-toggle="modal" data-target="#modal-edit{{ $data->id }}" data-toggle="tooltip" data-placement="right" title="Edit Kursus" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-solid fa-pencil-alt"></i></a>
          <button class="btn btn-danger btn-sm btn_hapus" data-toggle="tooltip" data-placement="bottom" title="Hapus Kelas" id="{{ $data->room_id }}" data-toggle="tooltip" data-placement="right" title="Hapus Kursus" style="padding:5px !important; font-size:12px !important;"><i class="fa fa-solid fa-trash"></i></button>
        </td>
      </tr>

      <div class="modal fade" id="modal-edit{{$data->id}}">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Kursus</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        
            <div class="modal-body">
              @include('kursus.edit_kursus')
            </div>

        </div>
      </div>
   

      <div class="modal fade" id="modal-view{{$data->id}}">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail Kursus</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              @include('kursus.view_kursus')
            </div>

          </div>
        </div>
      </div>
    @endforeach
  </tbody>
</table>



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
        var room_id = $(this).data('id');
        $.ajax({
            type : 'get',
            url  : '{{URL::to('kursus_non_aktif')}}',
            data : {room_id:room_id},
            success:function(data)
            {
                toastr.success('Berhasil MeNonaktifkan Kursus')
                $('#aktif'+room_id).hide();
                $('#non_aktif'+room_id).show();
            }
        });
    });
    
    $('.non_aktif').click(function() {
        var room_id = $(this).data('id');
        $.ajax({
            type : 'get',
            url  : '{{URL::to('kursus_aktif')}}',
            data : {room_id:room_id},
            success:function(data)
            {
                toastr.success('Berhasil MengAktifkan Kursus')
                $('#aktif'+room_id).show();
                $('#non_aktif'+room_id).hide();
            }
        });
    });
</script>



    

<script type="text/javascript">
    $(".btn_hapus").click(function(){
        var room_id = $(this).attr('id');
        var status = confirm('Yakin ingin menghapus?');
        if(status){
            $.ajax({
                url: '{{URL::to('del_kursus')}}',
                type: 'get',
                data: {room_id:room_id},
                success: function(data){
                    $('#kursus').html(data);
                }
            })
        }
    })
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  @if(Session::has('add_kursus')) 
      toastr.success("{{ Session::get('add_kursus') }}");
  @elseif(Session::has('del_kursus')) 
      toastr.success("{{ Session::get('del_kursus') }}");
  @elseif(Session::has('update_kursus')) 
      toastr.success("{{ Session::get('update_kursus') }}");
  @endif

</script>

