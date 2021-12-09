@extends('layout.template')
@section('contens')

<br>
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('kelas') }}">Kelas</a></li>
              <li class="breadcrumb-item active">Kelola Kelas</li>
            </ol>
          </div>
        <div class="col-sm-6 float-right">
          {{-- <h1>Profile</h1> --}}
          @if ($message = Session::get('info'))
          <div class="alert alert-success alert-dismissible alert-sm" id="alert" style="font-size:12px !important; height:75%;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5 style="font-size:14px !important;"><i class="icon fas fa-check"></i> Berhasil Membuat Tatap Muka</h5>
           Berhasil membuat jadwal tatap muka, cek di akun Zoom Meeting.
              {{-- <p>{{ $message }}</p> --}}
          </div>
          @endif
        </div>
        
      </div>
    </div>
  </section>

<div class="row">



<div class="col-xl-6 col-lg-6 col-md-6">
    <div class="card mb-3 shadow-sm border-light">
        <div class="card-header" style="background-color: grey; font-size: 15px;">
            <strong style="color:white;">Data Pendaftar</strong>
            <strong style="color: white;">
                Tingkat {{ $nama_kelas->tingkat }}
            </strong>
        </div>
        <div class="card-body" style="overflow: auto;">
              
            <div id="siswa_inaktif">
                @include('kelas.tabel_siswa_inactive')
            </div>
        </div>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6">
    <div class="card mb-3 shadow-sm border-light">
        <div class="card-header bg-success"  style="font-size: 15px;">
            <strong style="color:white;">Data Siswa Aktif</strong>
            <strong>
                Kelas {{ $nama_kelas->tingkat }}{{ $nama_kelas->room_name }}
            </strong>
        </div>
        <div class="card-body" style="overflow: auto;">
            <div id="siswa_aktif">
                @include('kelas.tabel_siswa_active')
            </div>
        </div>
    </div>
</div>
</div>


<br>
<div class="col-xl-12 col-lg-12 col-md-12">
    <div class="card mb-3 shadow-sm border-light">
        <div class="card-header bg-info">
            <strong style="color:white; font-size:15px;">Jadwal Mapel</strong>
            <strong>
                Kelas {{ $nama_kelas->tingkat }}{{ $nama_kelas->room_name }}
            </strong>
        </div>
        <div class="card-body" style="overflow: auto;">
            <button type="button" class="btn btn-primary float-left" style="padding:6px !important; font-size:14px !important;" data-toggle="modal" data-target="#modal-jadwal">
                Tambah Jadwal</button>
            <div class="table-responsive" id="jadwal">
                @include('kelas.tabel_jadwal')
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal-jadwal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jadwal Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ url('jadwalkelas_store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group mb-2">
                                <input type="hidden" name="id" value="{{ $nama_kelas->id_kelas }}">
                                <input type="hidden" name="tingkat" value="{{ $nama_kelas->tingkat }}">

                                <?php 
                                    $mapel = DB::table('mapel_kelas')
                                    ->join('tblmapel', 'mapel_kelas.mapel', '=', 'tblmapel.id_mapel')
                                    ->select('mapel_kelas.*', 'tblmapel.nama', 'tblmapel.id_mapel')
                                    ->where('mapel_kelas.tingkat',$nama_kelas->tingkat)
                                    ->get();
                                ?>
                                
                                <input type="hidden" name="room" value="{{ $nama_kelas->room_name }}">

                                <label>Mata Pelajaran</label>
                                <select name="mapel_name" id="mapel" class="form-control" required="">
                                    <option value="" selected="">-Pilih Mapel-</option>
                                    @foreach($mapel as $row)
                                        <option value="{{ $row->id_mapel_kelas }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Pengajar</label>
                                <select name="pengajar_name" id="pengajar_name" class="form-control guru" required="">
                                    <option value="" selected="">-Pilih Pengajar-</option>
                                </select><br>
                            </div>
                            <div class="form-group mb-2">
                                <label>Start Tatap Muka</label>
                                <input type="date" id="tanggal" name="tanggal" data-harinum="0" class="form-control" required="">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group mb-2">
                                <?php $hari = DB::table('tblhari')->get();?>
                                <label>Hari</label>
                                <input type="text" id="hari_name" class="form-control" readonly="">
                                <input type="text" id="hari_id" name="hari" hidden="">
                                <!-- <select name="hari" id="hari" class="form-control">
                                    <option value="0">-Pilih Hari-</option>
                                    @foreach($hari as $row)
                                        <option value="{{ $row->id }}">{{ ucfirst($row->namahari) }}</option>
                                    @endforeach
                                </select><br> -->
                            </div>
                            <div class="form-group mb-2">
                                <label>Jam</label>
                                <select name="jam" id="jam" class="form-control jam" required="">
                                    <option value="0">-Pilih jam-</option>
                                </select><br>
                            </div>
                            <div class="form-group mb-2">
                                <label>Jumlah Pengulangan</label>
                                <select name="pertemuan" id="" class="form-control" required="">
                                    <option value="0">-Pilih Petemuan-</option>
                                    @for ($i = 1; $i < 13; $i++)
                                        <option value="{{ $i }}">{{ $i }} x Pertemuan</option>
                                     @endfor
                                </select><br>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-md btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#tanggal').change(function(){
                console.log($(this));
                $.ajax({
                    type : 'get',
                    url : '{{URL::to('check_tanggal')}}',
                    data : {tanggal:$(this).val()},
                    success:function(data)
                    {
                        $('#hari_name').val(data.dayname);
                        $('#hari_id').val(data.date_in_week)
                        $('#tanggal').data('harinum', data.date_in_week);
                        change_hari($(".guru").val(),data.date_in_week);
                        // console.log(data);
                    }
                })
            })
        })

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
                        $('.guru').append(html);
                    }
                });
            });

            $('#pengajar_name').change(function(){
                var guru_id = $(this).val();
                console.log(guru_id)
                change_hari(guru_id,$('#tanggal').data('harinum'));
            })
        });

        function change_hari(id_guru, id_hari)
        {
            console.log(id_guru+id_hari)
            var idh=id_hari;
            // var id_guru = $(this).attr('id_guru');
            // var guru=$(this).val();
            $.ajax({
                url : "{{ url('change_jam') }}",
                method : "get",
                data : {idh:idh, guru:id_guru},
                async : false,
                dataType : 'json',
                success: function(data){
                    console.log(data);
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>Jam Ke-'+data[i].nama+' | '+data[i].start+' - '+data[i].end+'</option>';
                    }
                    $('.jam').html(html);   
                }
            });
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#hari').change(function(){
                var idh=$(this).val();
                // var id_guru = $(this).attr('id_guru');
                // var guru=$(this).val();
                $.ajax({
                    url : "{{ url('change_jam') }}",
                    method : "get",
                    data : {idh:idh, guru : $(".guru").val()},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        console.log(data);
                        var html = '';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].id+'>Jam Ke-'+data[i].nama+' | '+data[i].start+' - '+data[i].end+'</option>';
                        }
                        $('.jam').html(html);
                         
                    }
                });
            });
        });
    </script>

{{-- 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(Session::has('info1'))
            toastr.success("{{ Session::get('info1') }}");
        @endif

        
    </script> --}}

  