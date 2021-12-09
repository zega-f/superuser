@extends('layout.template')
@section('contens')<br>

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('siswa_kursus') }}">Siswa Kursus</a></li>
              <li class="breadcrumb-item active">Detail Siswa</li>
            </ol>
          </div>
        {{-- <div class="col-sm-6 float-right">
          <h1>Profile</h1>
        </div> --}}
        
      </div>
    </div>
  </section>

<div class="card">
    <div class="card-header bg-info">
        <h3 class="card-title"><b>Profil Siswa Kursus</b></h3>
    </div>
<div class="card-body">
<div class="col-12">
    <div class="card bg-light d-flex flex-fill"><br>
      
    {{-- @foreach ($det_siswa as $item) --}}
        
      <div class="card-body pt-0">
        <div class="row">
            <div class="col-md-2 col-sm-12 text-center">
                @if($item->jenis_kelamin=='L')
                    <img src="{{ url('public/assets/dist/img/avatar5.png') }}" alt="user-avatar" class="img-circle img-fluid">
                @else
                    <img src="{{ url('public/assets/dist/img/avatar3.png') }}" alt="user-avatar" class="img-circle img-fluid">
                @endif
              </div>

        <div class="col-sm-10 col-md-5" style="line-height: 12px;">
            <h5 class="lead"><b></b></h5>
           
            <table class="text-muted text-md" style="line-height: 20px;">
            <tbody>

                <p class="text-muted text-md"><tr><td><b>Nama</b></td><td><b>:</b></td><td> &nbsp;{{ $item->name }}</td></tr></p>
                <p class="text-muted text-md"><tr><td><b>Tempat, Tanggal Lahir</b></td><td><b>:</b></td><td> &nbsp;{{ $item->b_place }}, {{ $item->b_date }}</td></tr></p>
                <p class="text-muted text-md">
                    <tr>
                        <td><b>Jenis Kelamin</b></td><td><b>:</b></td>
                        <td> &nbsp;
                            @if($item->jenis_kelamin=='L')
                            Laki-Laki
                            @else
                            Perempuan
                            @endif
                        </td>
                    </tr>
                </p>
                <p class="text-muted text-md"><tr><td><b>Alamat</b></td><td><b>:</b></td><td> &nbsp;{{ $item->address }}</td></tr></p>
                <p class="text-muted text-md"><tr><td><b>Asal Sekolah</b></td><td><b>:</b></td><td> &nbsp;{{ $item->school_name }}</td></tr></p>
                <p class="text-muted text-md"><tr><td><b>Kursus</b></td><td><b>:</b></td><td> &nbsp;{{ $item->room_name }}</td></tr></p>
                {{-- <?php
                    // $mapel_siswa = DB::table('room_user_mapel')
                    // ->join('users', 'users.partner_id', '=', 'room_user_mapel.user_id')
                    // ->join('tblmapel', 'tblmapel.id_mapel', '=', 'room_user_mapel.mapel')
                    // // ->join('kelas', 'kelas.id_kelas', '=', 'room_user_mapel.room_id')
                    // ->select('room_user_mapel.*', 'users.name','tblmapel.nama as mapel')
                    // ->where('user_id',Request::segment(2))
                    // ->get();
                ?>
   
                <p class="text-muted text-md"><tr><td><b>Mapel yang diikuti</b></td>
                    <td><b>:</b></td>
                    <td>
                        @foreach($mapel_siswa as $mapel)   
                            &nbsp;{{ $mapel->mapel }}<br>
                        @endforeach
                    </td>
                </tr></p> --}}

            </tbody>
            </table>
        </div>

          <div class="col-sm-10 col-md-5" style="line-height: 12px;">
            <h5 class="lead"><b></b></h5>
            <table class="text-muted text-md" style="line-height: 20px;">
            <tbody>
                <p class="text-muted text-md"><tr><td><b>User Name</b></td><td><b>:</b></td><td> &nbsp;{{ $item->username }}</td></tr></p>
                <p class="text-muted text-md"><tr><td><b>First Name</b></td><td><b>:</b></td><td> &nbsp;{{ $item->first_name }}</td></tr></p>
                <p class="text-muted text-md"><tr><td><b>Last Name</b></td><td><b>:</b></td><td> &nbsp;{{ $item->last_name }}</td></tr></p>
                <p class="text-muted text-md"><tr><td><b>No Handphone</b></td><td><b>:</b></td><td> &nbsp;{{ $item->phone }}</td></tr></p>
                <p class="text-muted text-md"><tr><td><b>Email</b></td><td><b>:</b></td><td> &nbsp;{{ $item->email }}</td></tr></p><p><tr><td></td></tr></p>
                <p class="text-muted text-md"><tr><td><small>Orang Tua Siswa</small></td></tr></p>
                <p class="text-muted text-md"><tr><td><b>Nama</b></td><td><b>:</b></td><td> &nbsp;{{ $item->parent_name }}</td></tr></p>
                <p class="text-muted text-md"><tr><td><b>Pekerjaan</b></td><td><b>:</b></td><td> &nbsp;{{ $item->parent_job }}</td></tr></p>
                <p class="text-muted text-md"><tr><td><b>Handphone</b></td><td><b>:</b></td><td> &nbsp;{{ $item->parent_phone }}</td></tr></p>
            </tbody>
            </table>  
          </div>
          
        </div>
      </div>
      {{-- @endforeach --}}
     
    </div>
  </div>
</div>
</div>




    
@endsection