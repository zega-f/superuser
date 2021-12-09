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
    ->where('type','1')//kelas
    ->where('status','0')
    ->count();
?>
<div class="card">
    <div class="card-header d-flex p-0">
        <h3 class="card-title  p-3"><b>Pendaftar Baru Reguler</b></h3>
        <ul class="nav nav-pills ml-auto p-2">
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('pembayaran') }}" data-toggle="tooltip" title="Data Siswa Pendaftar Baru Kelas Reguler">
                    {{-- <i class="fas fa-user-clock"></i>  --}}
                    Reguler 
                    <span class="badge bg-warning">
                         {{ count($reguler) }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('register_kursus') }}" data-toggle="tooltip" title="Data Siswa Pendaftar Baru Kelas Kursus">
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
                        <th>Register</th>
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
                    @foreach ($semua_user as $data)
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
                            <?php
                            $user=$data->user_id;
                            $total_bayar = DB::table('room_user_mapel')
                            ->join('mapel_kelas','room_user_mapel.mapel','=','mapel_kelas.id_mapel_kelas')
                            ->join('tblmapel','tblmapel.id_mapel','=','room_user_mapel.mapel')
                            ->select('room_user_mapel.*','tblmapel.nama as mapel') 
                            ->where('room_user_mapel.user_id',$user)
                            ->where('mapel_kelas.tingkat',$data->tingkat)
                            ->where('room_user_mapel.register_id',$data->register_id)
                            ->sum('room_user_mapel.harga');

                            $jenjang = DB::table('db_jenjang')
                            ->where('tingkat',$data->tingkat)
                            ->first();
                            ?>
                            @if($data->register_id == $data->id_register)
                                {{number_format ($total_bayar + $jenjang->registrasi)}}
                            @else
                                {{number_format($total_bayar)}}
                            @endif


                        </td>
                        <td align="center">
                            @if($data->status_daftar == 0)
                            {{-- {{ $data->register_id }} {{ $data->id_register }} --}}
                            <span class="badge badge-primary" style="font-size: 13px;">Registrasi</span>
                            @else
                            
                            <span class="badge badge-warning" style="font-size: 13px;">Tambah Mapel</span>
                            @endif
                        </td>
                       
                        <td align="center">

                            <button class="btn btn-sm btn-info det_daftar" data-toggle='modal' data-target="#modal_det" id_siswa="{{$data->user_id}}" tingkat="{{ $data->tingkat }}" data-id_room="{{ $data->id }}" data-id_register="{{ $data->register_id }}" register_id="{{ $data->register_id }}" data-toggle="tooltip" title="Detail Pembayaran" style="padding:5px !important; font-size:12px !important;">Detail</button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="modal fade" id="modal_det" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pendaftaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="box">
             
            </div>
            <div class="modal-footer">
                <a href="#" id="link" class="btn btn-success" data-toggle="tooltip" title="Konfirmasi Pembayaran">verify</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>


    {{-- <div class="modal fade" id="modal-detail" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cek Pembayaran <span id="name"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <span>Pembayaran</span> <span id="room_name"></span><br><br>
    
                        <div align="center">
                            <img src="" class="img img-rounded" width="350px;" id="bukti_pembayaran">
                        </div><br>

                    </div>
                </div>
                <div class="modal-footer">
                    <a href="" id="link" class="btn btn-success">verify</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div> --}}


   



    
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
    $(".det_daftar").click(function(){
        var id_siswa = $(this).attr('id_siswa');
        var id_room = $(this).data('id_room');
        var id_register = $(this).data('id_register');
        var tingkat = $(this).attr('tingkat');
        var register_id = $(this).attr('register_id');
        $('#link').attr('href', 'verify_pembayaran/'+id_room+'/'+id_register);
        $.ajax({
            url: '{{URL::to('detail_pendaftar')}}',
            type: 'get',
            data: {id_siswa:id_siswa,tingkat:tingkat,register_id:register_id},
            success: function(data) {
                $('#box').html(data);
                $('#modal_det').show(data);
            }
        })
    })
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(Session::has('verify_pendaftar_kelas')) 
            toastr.success("{{ Session::get('verify_pendaftar_kelas') }}");
      
        @endif
    </script>

@endsection
