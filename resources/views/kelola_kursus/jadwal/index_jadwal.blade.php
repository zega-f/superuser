@extends('layout.template')
@section('contens')<br>

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('kursus') }}">Kursus</a></li>
              <li class="breadcrumb-item active">Tatap Muka</li>
            </ol>
          </div>
        {{-- <div class="col-sm-6 float-right">
          <h1>Profile</h1>
        </div> --}}
        
      </div>
    </div>
  </section>

<div class="card">
    <div class="card-header d-flex p-0">
      <h3 class="card-title p-3"><b>Kursus {{ $nm_kursus->room_name }}</b></h3>
      <ul class="nav nav-pills ml-auto p-2">
        <li class="nav-item"><a class="nav-link" href="{{ url('kelola_kursus/'.$nm_kursus->room_id) }}" data-toggle="tooltip" data-placement="bottom" title="Data Materi Kursus"><i class="fas fa-book"></i> Materi</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ url('jadwal_kursus/'.$nm_kursus->room_id) }}" data-toggle="tooltip" data-placement="bottom" title="Jadwal Tatap Muka"><i class="fas fa-user-clock"></i> Tatap Muka</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('participant_kursus/'.$nm_kursus->room_id) }}" data-toggle="tooltip" data-placement="bottom" title="Data Peserta Kursus"><i class="fas fa-users"></i> Participant</a></li>
      </ul>
    </div>

    <div class="card-body">
        <div class="tab-content">

            <div class="tab-pane active" id="tab_1">

                <div class="card mb-3 shadow-sm border-light" id="jadwal1">
                    <div class="card-header bg-info">
                        <strong style="color:white; font-size:15px;">Jadwal Tatap Muka Kursus</strong>
                    </div>
                    <div class="card-body" style="overflow: auto;">
                        <button type="button" class="btn btn-primary float-left" style="padding:6px !important; font-size:14px !important;" data-toggle="modal" data-target="#modal-jadwal">
                            Tambah Jadwal Kursus
                        </button>
                        <div class="table-responsive" id="jadwal">
                             @include('kelola_kursus.jadwal.tabel_jadwal')
                        </div>
                    </div>
                 </div>
                
                 <div class="modal fade" id="modal-jadwal">
                    <div class="modal-dialog">
                      <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Jadwal Kursus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                
                            <div class="modal-body">
                                <form action="{{ url('jadwalkursus_store') }}" method="post" class="form-user">
                                @csrf
                                
                                <div class="card-body">
                                    <div class="form-group">
                                        <?php $segment = Request::segment(4); ?>
                                        <input type="hidden" name="room_id" id="room" class="room" value="{{ $nm_kursus->room_id }}">
                
                                        <?php
                                            $pengajar = DB::table('users')
                                            ->where('partner_type',1)
                                            ->get();

                                            $jam = DB::table('atur_jam')
                                            ->get();
                                        ?>

                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control" required><br>
                                    
                                        <label>Pengajar</label>
                                        <select name="pengajar_name" id="guru" class="form-control guru" required>
                                            <option value="0">-Pilih Pengajar-</option>
                                            @foreach($pengajar as $row11)
                                                <option value="{{ $row11->partner_id }}">{{ ucfirst($row11->name) }}</option>
                                            @endforeach
                                        </select><br>
                                    
                                        <label>Tanggal</label>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                                        <br>

                                        <label>Jam</label>
                                        <select name="jam" id="jam11" class="form-control jam11" required>
                                            <option value="0">-Pilih jam-</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success float-right">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
               
            </div>
        </div>
    </div>
  </div>







<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


{{-- <script type="text/javascript">
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
</script> --}}



<script type="text/javascript">
    $(document).ready(function(){
        $('#tanggal').change(function(){
            var idt=$(this).val();
            // var id_guru = $(this).attr('id_guru');
            var guru=$(this).val();
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
                    $('.jam11').html(html);
                     
                }
            });
        });
    });
</script>

@endsection
