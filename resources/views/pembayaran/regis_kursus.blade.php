@extends('layout.template')
@section('contens')
<br>
<?php 
     $reguler = DB::table('room_user_mapel')
    ->where('verify',0)
    ->select('register_id')
    ->groupBy('register_id')
    ->get();

    $kursus = DB::table('room_user')
    ->where('type','1')//kursus
    ->where('status','0')
    ->count();
?>
<div class="card">
    <div class="card-header d-flex p-0">
        <h3 class="card-title  p-3"><b>Pendaftar Baru Kursus</b></h3>
        <ul class="nav nav-pills ml-auto p-2">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('pembayaran') }}" data-toggle="tooltip" title="Data Siswa Pendaftar Baru Kelas Reguler">
                    {{-- <i class="fas fa-user-clock"></i>  --}}
                    Reguler 
                    <span class="badge bg-warning">
                        {{ count($reguler) }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('register_kursus') }}" data-toggle="tooltip" title="Data Siswa Pendaftar Baru Kelas Kursus">
                    {{-- <i class="fas fa-users"></i> --}}
                    Kursus 
                    <span class="badge bg-warning">
                        {{ $kursus }}
                    </span>
                </a>
            </li>
          </ul>
    </div>
        
    <div class="card-body">
    @csrf
        <div class="table-responsive">
            <table id="example3" class="table table-striped">
                <thead align="center" class="bg-dark" style="color:white; font-size:15px;">
                    <tr>
                        <th>#</th>
                        <th>Regis</th>
                        <th>Nama</th>
                        <th>Room</th>
                        <th>Bukti</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr> 
                </thead>

                <?php $num = 1; ?>
            
                <tbody style="font-size: 14px;">
                    @foreach ($regis_kursus as $data)
                    <tr>
                        <td align="center">{{ $num++ }}</td>
                        <td>{{ $data->created_at }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->room_name }}</td>
                        <td align="center">
                            @if($data->bukti_pembayaran==null)
                                -
                            @else
                                <img src="{{ url('public/bukti/'.$data->bukti_pembayaran) }}" width="50" class="img img-rounded"> 
                            @endif
                        </td>
                        <td>
                            {{number_format($data->biaya)}}
                        </td>
                        <td align="center">
                            @if($data->status==0)
                            <span class="badge badge-danger" style="font-size: 13px;">Belum Bayar</span>
                            @else
                            <span class="badge badge-success" style="font-size: 13px;">Sudah</span>
                            @endif
                        </td>
                       
                        <td align="center">
        

                            <button class="btn btn-sm btn-info det_daftar1" data-toggle='modal' data-target="#modal_det1" id_siswa="{{$data->user_id}}" idbayar="{{$data->id}}" data-id_room="{{ $data->id }}" data-toggle="tooltip" title="Detail Pembayaran" style="padding:5px !important; font-size:12px !important;">Detail</button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="modal fade" id="modal_det1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pendaftaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="box1">
             
            </div>
            <div class="modal-footer">
                <a href="#" id="link" class="btn btn-success" data-toggle="tooltip" title="Konfirmasi Pembayaran">verify</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>




    
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


  {{-- <script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#detail', function() { 
            var bukti_pembayaran = $(this).data('bukti_pembayaran');
            var id = $(this).data('id');
            var name = $(this).data('name');
            var room_name = $(this).data('room_name');
            $('#bukti_pembayaran').attr('src', 'public/bukti/'+bukti_pembayaran);
            $('#link').attr('href', 'verify_pembayaran/'+id);
            $('#name').text(name);
            $('#room_name').text(room_name);

        })
    });
    </script>     --}}


<script type="text/javascript">
    $(".det_daftar1").click(function(){
        var id_siswa = $(this).attr('id_siswa');
        var idbayar = $(this).attr('idbayar');
        var id_room = $(this).data('id_room');
        $('#link').attr('href', 'verify_kursus/'+id_room);
        $.ajax({
            url: '{{URL::to('detail_pendaftar_kursus')}}',
            type: 'get',
            data: {id_siswa:id_siswa,idbayar:idbayar},
            success: function(data) {
                $('#box1').html(data);
                $('#modal_det1').show(data);
            }
        })
    })
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(Session::has('verify_pendaftar_kursus')) 
            toastr.success("{{ Session::get('verify_pendaftar_kursus') }}");
      
        @endif
    </script>
@endsection
