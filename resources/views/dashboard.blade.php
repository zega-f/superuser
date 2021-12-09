@extends('layout.template')
@section('contens')<br>

<h4>Dashboard</h4><br>

<div class="row">
    {{-- jUMLAH SISWA --}}
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ url('data_siswa') }}" style="color: black;" data-toggle="tooltip" title="Jumlah Siswa Terdaftar">
            <div class="info-box shadow-none">
                <span class="info-box-icon bg-info"><i class="fas fa-user-graduate"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Siswa</span>
                    <span class="info-box-number">
                        <?php  
                            $siswa=DB::table('room_user')
                            ->where('status','1')
                            ->count();
                        ?>
                        {{ $siswa }}
                    </span>
                </div>
            </div>
        </a>
    </div>
    
    {{-- JUMLAH PENGAJAR --}}
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ url('pengajar') }}" style="color: black;" data-toggle="tooltip" title="Jumlah Pengajar">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success"><i class="fas fa-user-tie"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pengajar</span>
                    <span class="info-box-number">
                        <?php  
                            $pengajar=DB::table('users')
                            ->where('partner_type','1')
                            ->count();
                        ?>
                        {{ $pengajar }}
                    </span>
                </div>
            </div>
        </a>
    </div>
    
    {{-- jUMLAH KELAS --}}
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ url('kelas') }}" style="color: black;" data-toggle="tooltip" title="Jumlah Kelas">
            <div class="info-box shadow">
                <span class="info-box-icon bg-warning"><i class="fas fa-landmark"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kelas</span>
                    <span class="info-box-number">
                        <?php  
                            $kelas=DB::table('kelas')
                            ->count();
                        ?>
                        {{ $kelas }}
                    </span>
                </div>
            </div>
        </a>
    </div>
    
    {{-- JUMLAH KURSUS --}}
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ url('kursus') }}" style="color: black;" data-toggle="tooltip" title="Jumlah Kursus">
            <div class="info-box shadow-lg">
                <span class="info-box-icon bg-purple"><i class="fas fa-chess-rook"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kursus</span>
                    <span class="info-box-number">
                        <?php  
                            $room=DB::table('room')
                            ->count();
                            echo $room;
                        ?>
                    </span>
                </div>
            </div>
        </a>
    </div>
</div>
{{-- END ROW --}}



<!-- TABLE: PENDAFTAR BARU -->
<div class="row">
    <div class="card col-12 col-md-8 col-sm-12 col-xs-12">
        <div class="card-header border-transparent">
            <h3 class="card-title"><i class="fas fa-user-plus"></i> Pendaftar Baru</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Show/Hide">
                    <i class="fas fa-minus"></i>
                 </button>
            </div>
        </div>
   
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-dark" style="color:white; font-size:15px;">
                    <tr>
                        <th><center>#</th>
                        <th><center>Tanggal</th>
                        <th><center>Nama</th>
                        <th><center>Room</th>
                        <th><center>Type</th>
                        <th><center>Aksi</th>
                    </tr> 
                    </thead>

                    <?php
                        $regis = DB::table('room_user')
                        ->join('users','room_user.user_id','=','users.partner_id')
                        ->leftjoin('room_user_mapel','room_user.register_id','=','room_user_mapel.register_id')
                        ->select('users.partner_id','users.name','room_user.status','room_user.id','room_user.bukti_pembayaran','room_user.user_id','room_user.tingkat','room_user.type','room_user.register_id','room_user.created_at as daftar_kursus','room_user_mapel.created_at as daftar_kelas')
                        ->where('room_user.status',0)
                        ->groupBy('room_user_mapel.register_id')
                        ->orderBy('room_user_mapel.created_at','desc')
                        ->limit(5)
                        ->get();
                        $num = 1;  
                    ?>

                    <tbody style="font-size:14px;">
                    @foreach ($regis as $data)
                    <tr>
                        <td align="center">{{ $num++ }}</td>
                        <td>
                            @if($data->type==0)
                                 {{ $data->daftar_kelas }}
                            @else
                            {{ $data->daftar_kursus }}
                            @endif
                        </td>
                        <td>{{ $data->name }}</td>
                        <td>
                            @if($data->type==0)
                                <?php
                                    $tingkat = DB::table('room_user')
                                    ->join('users','room_user.user_id','=','users.partner_id')
                                    ->join('db_jenjang','room_user.tingkat','=','db_jenjang.tingkat')
                                    ->select('users.partner_id','users.name','room_user.status','room_user.id','room_user.bukti_pembayaran','db_jenjang.nama as kelas','room_user.user_id','room_user.tingkat','room_user.register_id')
                                    ->where('room_user.type',0)
                                    ->where('room_user.status',0)
                                    ->first();
                                ?>
                                {{ $tingkat->kelas }}
                            @else
                                <?php
                                    $room = DB::table('room_user')
                                        ->join('users','room_user.user_id','=','users.partner_id')
                                        ->join('room','room_user.room_id','=','room.room_id')
                                        ->where('room_user.status',0)
                                        ->select('users.partner_id','room_user.tingkat','room.room_name as kursus')
                                        ->first();
                                ?>
                                {{ $room->kursus }}
                            @endif
                        </td>

                        <td align="center">
                            @if($data->type==0)
                                Kelas
                            @else
                                Kursus
                            @endif
                        </td>

                        <td align="center">
                            @if($data->type==0)
                                <button class="btn btn-sm btn-info det_daftar" data-toggle='modal' data-target="#modal_det" id_siswa="{{$data->user_id}}" tingkat="{{ $data->tingkat }}" data-id_room="{{ $data->id }}" data-id_register="{{ $data->register_id }}" data-register_id="{{ $data->register_id }}" data-toggle="tooltip" title="Detail Pendaftar Baru" style="padding:5px !important; font-size:12px !important;">Detail</button>
                            @else
                                <button class="btn btn-sm btn-info det_daftar1" data-toggle='modal' data-target="#modal_det1" id_siswa="{{$data->user_id}}" idbayar="{{$data->id}}" data-id_room1="{{ $data->id }}" data-toggle="tooltip" title="Detail Pendaftar Baru" style="padding:5px !important; font-size:12px !important;">Detail</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>   
            </table>
            </div>
        </div>

        <div class="card-footer clearfix">
            <a href="{{ url('pembayaran') }}" class="btn btn-sm btn-secondary float-right" style="padding:5px !important; font-size:12px !important;">View All Pendaftar Baru</a>
        </div>
    </div>

    
    <div class="col-md-4">
        <a href="{{ url('pembayaran') }}" data-toggle="tooltip" title="Jumlah Pendaftar Baru Kelas Reguler">
            <div class="info-box mb-3 bg-primary">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pendaftar Kelas</span>
                    <span class="info-box-number">
                        <?php
                        $reguler = DB::table('room_user')
                        ->where('type','0')//reguler
                        ->where('status','0')
                        // ->where('verify','0')
                        // ->groupBy('room_user_mapel.register_id')
                        ->get();
                        ?>
                    {{ count($reguler) }}
                    </span>
                </div>       
            </div>
        </a>

        <a href="{{ url('register_kursus') }}" data-toggle="tooltip" title="Jumlah Pendaftar Baru Kelas Kursus">
            <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pendaftar Kursus</span>
                    <span class="info-box-number">
                        <?php
                        $kursus = DB::table('room_user')
                        ->where('type','1')//kursus
                        ->where('status','0')
                        ->count();
                        ?>
                        {{ $kursus }}
                    </span>
                </div>
            </div>
        </a>

        <a href="{{ url('pembayaran') }}" data-toggle="tooltip" title="Jumlah Pendaftar Baru Kelas Reguler">
            <div class="info-box mb-3 bg-primary">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tambah Mapel</span>
                    <span class="info-box-number">
                        <?php
                        $tambah_mapel = DB::table('room_user_mapel')
                        // ->where('type','0')//reguler
                        ->where('verify','0')
                        ->where('register_type','1')
                        ->groupBy('room_user_mapel.register_id')
                        ->get();
                        ?>
                    {{ count($tambah_mapel) }}
                    </span>
                </div>       
            </div>
        </a>
    </div>
</div>


<div class="row">
    <div class="card col-12 col-md-8 col-sm-12 col-xs-12">
        <div class="card-header border-transparent">
            <h3 class="card-title"><i class="fas fa-user-plus"></i> Tambah Mapel</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Show/Hide">
                    <i class="fas fa-minus"></i>
                 </button>
            </div>
        </div>
   
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-dark" style="color:white; font-size:15px;">
                    <tr>
                        <th><center>#</th>
                        <th><center>Tanggal</th>
                        <th><center>Nama</th>
                        <th><center>Room</th>
                        <th><center>Aksi</th>
                    </tr> 
                    </thead>

                    <?php
                        $tambah_mapel = DB::table('room_user_mapel')
                        ->join('users','room_user_mapel.user_id','=','users.partner_id')
                        ->leftjoin('room_user','room_user_mapel.register_id','=','room_user.register_id')
                        ->join('db_jenjang','room_user_mapel.tingkat','=','db_jenjang.tingkat')
                        ->select('users.partner_id','users.name','room_user_mapel.bukti_pembayaran','db_jenjang.nama as room_name','room_user_mapel.register_id','room_user_mapel.verify','room_user_mapel.created_at','room_user.register_id as id_register','room_user_mapel.user_id','room_user_mapel.tingkat','room_user.id')
                        ->groupBy('room_user_mapel.register_id')
                        ->where('room_user_mapel.verify',0)
                        ->paginate(5);
                        $num = 1;  
                    ?>

                    <tbody style="font-size:14px;">
                        @foreach ($tambah_mapel as $data1)
                        @if($data1->register_id != $data1->id_register)
                        <tr>

                            <td align="center">{{ $num++ }}</td>
                            <td>{{ $data1->created_at }}</td>
                            <td>{{ $data1->name }} </td>
                            <td>
                                    <?php
                                        $tingkat1 = DB::table('room_user_mapel')
                                        ->join('users','room_user_mapel.user_id','=','users.partner_id')
                                        ->join('kelas','room_user_mapel.room_id','=','kelas.id_kelas')
                                        ->select('users.partner_id','users.name','room_user_mapel.verify','room_user_mapel.id','room_user_mapel.bukti_pembayaran','kelas.room_name as kelas','room_user_mapel.user_id','room_user_mapel.tingkat','room_user_mapel.register_id')
                                        ->where('room_user_mapel.verify',0)
                                        ->first();
                                    ?>
                                     {{ $tingkat1->tingkat }}{{ $tingkat1->kelas }}
                                
                            </td>
    
                            <td align="center">
                                <button class="btn btn-sm btn-info det_daftar" data-toggle='modal' data-target="#modal_det" id_siswa="{{$data1->user_id}}" tingkat="{{ $data1->tingkat }}" data-id_room="0" data-id_register="{{ $data1->register_id }}" data-register_id="{{ $data1->register_id }}" data-toggle="tooltip" title="Detail Pendaftar Baru" style="padding:5px !important; font-size:12px !important;">Detail</button>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix">
            <a href="{{ url('pembayaran') }}" class="btn btn-sm btn-secondary float-right" style="padding:5px !important; font-size:12px !important;">View All Pendaftar Baru</a>
        </div>
    </div>

    <div class="col-md-4">
        {{-- <a href="{{ url('pembayaran') }}" data-toggle="tooltip" title="Jumlah Pendaftar Baru Kelas Reguler">
            <div class="info-box mb-3 bg-primary">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pendaftar Reguler</span>
                    <span class="info-box-number">
                        <?php
                        $reguler = DB::table('room_user_mapel')
                        // ->where('type','0')//reguler
                        ->where('verify','0')
                        ->groupBy('room_user_mapel.register_id')
                        ->get();
                        ?>
                    {{ count($reguler) }}
                    </span>
                </div>       
            </div>
        </a>

        <a href="{{ url('register_kursus') }}" data-toggle="tooltip" title="Jumlah Pendaftar Baru Kelas Kursus">
            <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pendaftar Kursus</span>
                    <span class="info-box-number">
                        <?php
                        $kursus = DB::table('room_user')
                        ->where('type','1')//kursus
                        ->where('status','0')
                        ->count();
                        ?>
                        {{ $kursus }}
                    </span>
                </div>
            </div>
        </a> --}}
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
                <a href="#" id="link1" class="btn btn-success" data-toggle="tooltip" title="Konfirmasi Pembayaran">verify</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-detail" role="dialog">
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
</div>



<script type="text/javascript">
    $(".det_daftar").click(function(){
        var id_siswa = $(this).attr('id_siswa');
        var id_room = $(this).data('id_room');
        var tingkat = $(this).attr('tingkat');
        var id_register = $(this).data('id_register');
        var register_id = $(this).data('register_id');
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


<script type="text/javascript">
    $(".det_daftar1").click(function(){
        var id_siswa = $(this).attr('id_siswa');
        var idbayar = $(this).attr('idbayar');
        var id_room1 = $(this).data('id_room1');
        $('#link1').attr('href', 'verify_kursus/'+id_room1);
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
        @elseif(Session::has('verify_pendaftar_kelas')) 
            toastr.success("{{ Session::get('verify_pendaftar_kelas') }}");
      
        @endif
    </script>

@endsection