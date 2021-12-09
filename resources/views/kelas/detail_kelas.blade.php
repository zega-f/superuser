@extends('layout.template')
@section('contens')<br>

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('kelas') }}">Data Kelas</a></li>
              <li class="breadcrumb-item active">Data Siswa</li>
            </ol>
          </div>
        {{-- <div class="col-sm-6 float-right">
          <h1>Profile</h1>
        </div> --}}
        
      </div>
    </div>
  </section>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><b>Data Siswa Kelas
        <strong>
            @foreach($nama_kelas as $k):
            @if($k->jenjang==1)
                SD
            @elseif($k->jenjang==2)
                SMP
            @else
                SMA
            @endif
            {{ $k->tingkat }}{{ $k->room_name }}
            @endforeach
        </strong>
    </b></h3>
  </div>
        
  <div class="card-body">

    <div class="table-responsive" id="">
        <table id="example2" class="table table-striped">
            <thead  class="bg-dark" style="color:white; font-size:15px;">
                <tr align="center">
                <th>#</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>email</th>
                <th>Aksi</th>
                </tr> 
            </thead>
        
            <tbody style="font-size: 14px;">
                <?php $num = 1; ?> 
            @foreach ($kelas as $data)
                <tr>
                    <td align="center">{{ $num++ }}</td>
                    <td>{{  $data->siswa }} </td>
                    <td>{{  $data->address }} </td>
                    <td>{{ $data->email }}</td>
                    <td align="center"> 
                        <a href="{{ url('detail_siswa/'.$data->partner_id) }}" data-toggle="tooltip" title="Detail Siswa" class="btn btn-sm btn-info" style="padding:5px !important; font-size:12px !important;">Detail</a>
                    </td>
                    {{-- <td>
                        <?php
                        // $mapel_siswa = DB::table('room_user_mapel')
                        // ->join('users', 'users.partner_id', '=', 'room_user_mapel.user_id')
                        // ->join('tblmapel', 'tblmapel.id_mapel', '=', 'room_user_mapel.mapel')
                        // ->select('room_user_mapel.*', 'users.name','tblmapel.nama as mapel')
                        // ->where('room_user_mapel.user_id',$data->partner_id)
                        // ->where('room_id',Request::segment(2))
                        // ->get();
                        ?>
                        @foreach($mapel_siswa as $item)
                            <li>{{ $item->mapel }}</li>
                        @endforeach
                    </td> --}}
                </tr>
            @endforeach
            </tbody>
        </table>
        
        

      
    </div>
  </div>
</div>


    

@endsection