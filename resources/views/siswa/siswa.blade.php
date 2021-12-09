@extends('layout.template')
@section('contens')<br>

<div class="card">
  <div class="card-header d-flex p-0">
    <h3 class="card-title  p-3"><b>Data Siswa Reguler</b></h3>
    <ul class="nav nav-pills ml-auto p-2">
      <li class="nav-item"><a class="nav-link active" href="{{ url('data_siswa') }}" data-toggle="tooltip" title="Data Siswa Kelas Reguler"> Reguler</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ url('siswa_kursus') }}" data-toggle="tooltip" title="Data Siswa Kelas Kursus"> Kursus</a></li>
    </ul>
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-sm" id="alert">
        <p>{{ $message }}</p>
    </div>
    @endif
  </div>
  

        
  <div class="card-body">
    <div class="row">
    <div class="col-4 col-lg-3 col-sm-6 col-xs-6">
    <?php $jenjang = DB::table('db_jenjang')->get();?>
    <form action="{{ url('filter_siswa_reguler') }}" method="post">
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
    <form action="{{ url('cetak_siswa_reguler') }}" target="_blank" method="post">
      @csrf
      <div class="input-group input-group-sm" style="width:250px;">
      <input name="id_tingkat" type="hidden" value="<?php echo @$nm_tingkat->tingkat ?>" required>
      <span class="input-group-append">
        <button type="submit" class="btn btn-primary btn-flat fas fa-print" data-toggle="tooltip" title="Cetak Data Siswa Berdasarkan Jenjang Kelas" style="padding:5px !important; font-size:12px !important;"> Cetak </button>
      </span>
      </div>
    </form>
    </div>
  </div>
  


    <div class="table-responsive">
      <table id="example4" class="table table-striped">
        <thead class="bg-dark" style="color:white; font-size:15px;">
          <tr align="center">
              <th>#</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Asal Sekolah</th>
              <th>Handphone</th>
              <th>Kelas</th>
              {{-- <th>Email</th> --}}
              <th>Aksi</th>
          </tr> 
        </thead>

        <tbody style="font-size: 14px;">
          <?php $num = 1; ?> 
            @foreach ($siswa as $data)
              <tr>
                <td align="center">{{ $num++ }}</td>
                <td>{{ $data->name }} </td>
                <td>{{ $data->alamat }}</td>
                <td>
                  <?php
                    $asal_sekolah = DB::table('room_user')
                      ->join('users', 'users.partner_id', '=', 'room_user.user_id')
                      ->where('room_user.user_id',$data->user_id)
                      ->select('room_user.*')
                      ->orderBy('school_name','desc')
                      ->first();
                  ?>
                  {{ $asal_sekolah->school_name }}
                </td>
                <td>{{ $data->phone }}</td>
                <td align="center">
                  @if($data->room_id==null)
                    Belum dapat kelas
                  @else
                    {{ $data->tingkat }}{{ $data->room_name }}
                  @endif
                </td>
                <td align="center">
                  <form action="{{ url('pass_siswa') }}" method="post">
                    @csrf
                    <input type="hidden" name="email_siswa" class="form-control" value="{{ $data->email }}">
                    <a href="{{ url('detail_siswa/'.$data->partner_id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Detai Siswa" style="padding:5px !important; font-size:12px !important;">Detail</a>
                    <button onclick="return confirm('Apakah yakin mereset password?');" style="padding:5px !important; font-size:12px !important;" type="submit" class="btn btn-info btn-sm" data-toggle="tooltip" title="Reset Password Akun Siswa ini">Reset Password</button>
                  </form>
                </td> 
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    
    <span class="float-right">
      {{ $siswa->onEachSide(1)->links() }}
    </span>
  </div>
</div>

<script>
  function copytextbox() {    
		document.getElementById('txttingkat').value = document.getElementById('tingkat11').selected;
  }

  $('select').change(function(){

    // $('input[name=id_tingkat]').val($('option:selected',this).text());
    $('input[name=id_tingkat]').val($(this).val());
});
</script>

@endsection


































