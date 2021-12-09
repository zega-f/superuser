@extends('layout.template')
@section('contens')<br>

<div class="card">
    <div class="card-header bg-info">
       
        <h3 class="card-title"><b>Jadwal Pelajaran</b></h3>
    </div>
          
    <div class="card-body">
        
      <div class="row">
        <div class="col-4 col-lg-3 col-sm-6 col-xs-6">
          <?php $jenjang = DB::table('db_jenjang')->get();?>
        <form action="{{ url('filter_jadwal_kelas') }}" method="post">
          @csrf
          <div class="input-group input-group-sm" style="width:250px;">
            <select name="tingkat" onkeyup="copytextbox();" class="form-control" style="width:150px;">
              <option value="0">-Filter Jenjang-</option>
              @foreach($jenjang as $row)
                <option value="{{ $row->id }}"{{ ($row->id == @$nm_tingkat->id ? "selected" : null) }}>{{ $row->nama }}</option>
              @endforeach
            </select>
            <span class="input-group-append">&nbsp;&nbsp;&nbsp;
              <button type="submit" class="btn btn-info btn-flat fas fa-eye" data-toggle="tooltip" title="Tampilkan Data Siswa Berdasarkan Jenjang Kelas" style="padding:5px !important; font-size:12px !important;"> Show </button>
            </span>
          </div>
        </form>
        </div>
    
        <div class="col-6 col-lg-3 col-sm-6 col-xs-6">
          <form action="{{ url('cetak_jadwal_kelas') }}" target="_blank" method="post">
            @csrf
            <div class="input-group input-group-sm" style="width:250px;">
            <input name="tingkat" type="hidden" value="<?php echo @$nm_tingkat->tingkat ?>" required>
            <span class="input-group-append">
              <button type="submit" class="btn btn-primary btn-flat fas fa-print" data-toggle="tooltip" title="Cetak Data Siswa Berdasarkan Jenjang Kelas" style="padding:5px !important; font-size:12px !important;"> Cetak </button>
            </span>
            </div>
            {{--  --}}
          </form>
          </div>
        </div>
      <div class="table-responsive" id="">
        
        <table id="example2" class="table table-striped">
            <thead class="bg-dark" style="color:white; font-size:15px;">
                <tr align="center">
                <th>#</th>
                <th>Pengajar</th>
                <th>Mapel</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Jam</th>
                </tr> 
            </thead>
            <?php
            
            ?>
        
            <tbody style="font-size: 14px;">
                @foreach ($jadwal as $num=>$data)
                    <tr>
                        <td>{{ $num+1 }}</td>
                        <td>{{ $data->pengajar }}</td>
                        <td>{{ $data->mapel_nama }}</td>
                        <td>{{ $data->tingkat }}{{ $data->room_name }}</td>
                        <td> {{ ucfirst($data->hari); }}</td> 
                        <td align="center">Jam ke-{{$data->jam_ke}} | {{ $data->mulai }} - {{ $data->akhir }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
   
  <script>
    function copytextbox() {    
      document.getElementById('txttingkat').value = document.getElementById('tingkat11').selected;
    }
  
    $('select').change(function(){
  
      // $('input[name=id_tingkat]').val($('option:selected',this).text());
      $('input[name=tingkat]').val($(this).val());
  });
  </script>

@endsection
