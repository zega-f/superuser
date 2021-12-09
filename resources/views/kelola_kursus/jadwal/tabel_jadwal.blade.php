
<table id="example3" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        {{-- <th>Meeting id</th> --}}
        <th>Title</th>
        {{-- <th>Url</th> --}}
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Pengajar</th>
        <th>Status</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody style="font-size: 14px;">
        @foreach ($jadwal as $num=>$data)
            <tr>
                <td>{{ $num+1 }}</td>
                <td>{{ $data->title }}</td>
                <td>{{ $data->tanggal }}</td>
                <td>
                    {{ $data->mulai }} - {{ $data->akhir}}
                </td>
                <td>{{ $data->pengajar }}</td>
                <td>
                    <?php
                        date_default_timezone_set('Asia/Jakarta'); 
                        $start = date("$data->tanggal $data->mulai");
                        $sekarang = date('Y-m-d H:i:s');

                        if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
                        $date= date_create( ($start));
                        date_add($date, date_interval_create_from_date_string("45 minutes"));
                        $end = date_format($date, 'Y-m-d H:i:s');
                       
                    ?>

                        @if ($start > $sekarang)
                            <span class="badge badge-warning"><i class="far fa-clock"></i> waiting</span>
                        @elseif($sekarang <=  $end && $end >= $sekarang)
                            <span class="badge badge-success"><i class="far fa-clock"></i> berlangsung</span>
                        @elseif($start < $sekarang)
                            <span class="badge badge-danger"><i class="far fa-clock"></i> berakhir</span>
                        @endif
                </td>
                <td align="center">
                    <a href="#" data-toggle="modal" data-target="#modal_edit{{ $data->id }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit Jadwal Kursus" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-pencil-alt"></i></a>
                    <button class="btn btn-danger btn-sm btn_hapus" id="{{$data->meet_id}}" jadwal="{{ $data->room_id }}" data-toggle="tooltip" data-placement="bottom" title="Hapus Jadwal Kursus" style="padding:5px !important; font-size:12px !important;"><i class="
                        fas fa-solid fa-trash"></i></button>
                    <a href="{{ $data->url }}" class="btn btn-sm btn-primary" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-video"></i></a>

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
                            @include('kelola_kursus.jadwal.edit_jadwal_kursus')
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
    

{{-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

<script type="text/javascript">
    $(".btn_hapus").click(function(){
        var id_jadwal = $(this).attr('id');
        var jadwal = $(this).attr('jadwal');
        var status = confirm('Yakin ingin menghapus?');
            if(status){
                $.ajax({
                    url: '{{URL::to('del_jadwal_kursus')}}',
                    type: 'get',
                    data: {id_jadwal:id_jadwal,jadwal:jadwal},
                    success: function(data){
                    $('#jadwal').html(data);
                }
            })
        }
    })
</script>





<script type="text/javascript">
    $(document).ready(function(){
        $('#mapel').change(function(){
            var id=$(this).val();
            // var kelas=$(this).attr('kelas');
            $.ajax({
                url : "{{ url('change_guru') }}",
                method : "get",
                data : {id:id},
                async : false,
                dataType : 'json',
                success: function(data){
                    console.log(data);
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id_pengajar+'>' +(data[i]==null ? 'Kosong' : data[i].name)+ '</option>';
                    }
                    $('.guru').html(html);
                }
            });
        });
    });
</script>



<script type="text/javascript">
    $(document).ready(function(){
        $('#tanggal1').change(function(){
            var idt=$(this).val();
            // var id_guru = $(this).attr('id_guru');
            // var guru=$(this).val();
            var room=$(this).val();
            $.ajax({
                url : "{{ url('change_jam_kursus') }}",
                method : "get",
                data : {idt:idt, guru : $(".guru").val(),  room : $(".room").val()},
                async : false,
                dataType : 'json',
                success: function(data){
                    console.log(data);
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>Jam Ke-'+data[i].nama+' | '+data[i].start+' - '+data[i].end+'</option>';
                    }
                    $('.jam1').html(html);
                     
                }
            });
        });
    });
</script>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  @if(Session::has('add_jadwal_kursus')) 
      toastr.success("{{ Session::get('add_jadwal_kursus') }}");
  @elseif(Session::has('del_jadwal_kursus')) 
      toastr.success("{{ Session::get('del_jadwal_kursus') }}");
  @elseif(Session::has('update_jadwal_kursus')) 
      toastr.success("{{ Session::get('update_jadwal_kursus') }}");
  @endif

</script>





{{-- <script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#edit_jadwal', function() { 
            var pengajar = $(this).data('pengajar');
            var id_pengajar = $(this).data('id_pengajar');
            var nmhari = $(this).data('nmhari');
            var id_hari = $(this).data('id_hari');
            var id = $(this).data('id');
            $('#id_pengajar').val(id_pengajar);
            $('#pengajar').text(pengajar);
            $('#nmhari').text(nmhari);
            $('#id_hari').val(id_hari);
            $('#id').val(id);
        })
    });
</script> --}}

