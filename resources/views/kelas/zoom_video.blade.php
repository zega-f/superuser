<table id="example4" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        {{-- <th>#</th> --}}
        <th>Pertemuan</th>
        <th>Start Time</th>
        <th>Duration</th>
        <th>Status</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody style="font-size: 14px;">
        @foreach ($video as $data)
            <tr>
                {{-- <td>{{ $num+1 }}</td> --}}
                <td>Pertemuan Ke-{{ $data->pertemuan }}</td>
                <td>{{ $data->start_time }}</td>
                <td>{{ $data->duration }} menit</td>
                <td>
                    <?php
                        date_default_timezone_set('Asia/Jakarta'); 
                        $start = $data->start_time;
                        $sekarang = date('Y-m-d H:i:s');

                        if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
                        $date= date_create( ($start));
                        date_add($date, date_interval_create_from_date_string("$data->duration minutes"));
                        $end = date_format($date, 'Y-m-d H:i:s');
                                    
                        // echo $start;
                        // echo '<br>';
                        // echo $end;
                        // echo '<br>';
                        // echo $sekarang;
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
                    <a href="{{ $data->url }}" target="_blank" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="right" title="Detail" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-video"></i></a>

                    <button class="btn btn-danger btn-sm btn_hapus1" meet_id="{{$data->meet_id}}" id_jadwal="{{ $data->id_jadwal }}" occurrence_id="{{ $data->occurrence_id }}" data-toggle="tooltip" data-placement="right" title="Hapus Jadwal" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
           
        @endforeach
    </tbody>
    </table>
    <br><br>




    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        // $(document).ready(function() {
    
            //Hapus Data dengan konfirmasi
            $(".btn_hapus1").click(function(){
                    var meet_id = $(this).attr('meet_id');
                    var id_jadwal = $(this).attr('id_jadwal');
                    var occurrence_id = $(this).attr('occurrence_id');
                    var status = confirm('Yakin ingin menghapus tatap muka ini?');
                    if(status){
                        $.ajax({
                            url: '{{URL::to('del_zoom_video')}}',
                            type: 'get',
                            data: {meet_id:meet_id, id_jadwal:id_jadwal, occurrence_id:occurrence_id},
                            success: function(data){
                                $('#box').html(data);
                            }
                        })
                    }
                });

                $('#example4').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
      }); 
        </script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(Session::has('delete_pertemuan'))
        toastr.success("{{ Session::get('delete_pertemuan') }}");
    @endif

</script>
