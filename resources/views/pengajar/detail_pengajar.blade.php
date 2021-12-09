@extends('layout.template')
@section('contens')<br>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('pengajar') }}">Data Pengajar</a></li>
            <li class="breadcrumb-item active">Detail Pengajar</li>
          </ol>
        </div>
      {{-- <div class="col-sm-6">
        <h1>Profile</h1>
      </div> --}}
      
    </div>
  </div>
</section>

<div class="card">
    <div class="card-header bg-info">
        <h3 class="card-title"><b>Profil Pengajar</b></h3>
        <a href="" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#modal-default" data-toggle="tooltip" data-placement="right" title="Tambah Mapel yang diampu pengajar ini"><i class="fa fa-plus"></i> Mapel</a>
    </div>
<div class="card-body">
<div class="col-12">
    <div class="card bg-light d-flex flex-fill"><br>
    <?php
        $detail_pengajar = DB::table('detail_pengajar')
        ->join('users', 'users.partner_id', '=', 'detail_pengajar.pengajar')
        ->select('detail_pengajar.*', 'users.name')
        ->where('pengajar',Request::segment(2))
        ->get();
    ?>
      
    @foreach ($detail_pengajar as $item)
        
      <div class="card-body pt-0">
        <div class="row">
            <div class="col-2 text-center">
                @if($item->jenis_kelamin=='L')
                    <img src="{{ url('public/assets/dist/img/avatar5.png') }}" alt="user-avatar" class="img-circle img-fluid">
                @else
                    <img src="{{ url('public/assets/dist/img/avatar3.png') }}" alt="user-avatar" class="img-circle img-fluid">
                @endif
              </div>

          <div class="col-5" style="line-height: 12px;">
            <h5 class="lead"><b></b></h5>
            <table class="text-muted text-md" style="line-height: 20px;">
            <tbody>

                <p class="text-muted text-md"><tr><td><b>Nama</b></td><td><b>:</b></td><td>{{ $item->name }}</td></tr></p>
                <p class="text-muted text-md"><tr><td><b>Tempat, Tanggal Lahir</b></td><td><b>:</b></td><td>{{ $item->tempat_lahir }}, {{ $item->tgl_lahir }}</td></tr></p>
                <p class="text-muted text-md">
                    <tr>
                        <td><b>Jenis Kelamin</b></td><td><b>:</b></td>
                        <td> 
                            @if($item->jenis_kelamin=='L')
                            Laki-Laki
                            @else
                            Perempuan
                            @endif
                        </td>
                    </tr>
                </p>
                <p class="text-muted text-md"><tr><td><b>Alamat</b></td><td><b>:</b></td><td>{{ $item->alamat }}</td></tr></p>

               
            </tbody>
            </table>
          </div>

          <div class="col-5" style="line-height: 12px;">
            <h5 class="lead"><b></b></h5>
            <table class="text-muted text-md" style="line-height: 20px;">
            <tbody>
            <p class="text-muted text-md"><tr><td><b>pendidikan</b></td><td><b>:</b></td><td>{{ $item->pendidikan }}</td></tr></p>
            <p class="text-muted text-md"><tr><td><b>Universitas</b></td><td><b>:</b></td><td>{{ $item->universitas }}</td></tr></p>

            <p class="text-muted text-md">
                <?php
                    $tentor = DB::table('mapel_pengajar')
                    ->join('users', 'users.partner_id', '=', 'mapel_pengajar.id_pengajar')
                    ->join('tblmapel', 'tblmapel.id_mapel', '=', 'mapel_pengajar.id_mapel')
                    ->select('mapel_pengajar.*', 'tblmapel.nama as mapel')
                    ->where('id_pengajar',Request::segment(2))
                    ->get();
                ?>
                <tr>
                    <td><b>Tentor Progam</b></td>
                    <td><b>:</b></td>
                    <td> 
                        @foreach ($tentor as $tentor) 
                        {{-- {{ $tentor->mapel }}, --}}
                        @endforeach
                        <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal-kelola" data-toggle="tooltip" data-placement="right" title="Daftar Mapel yang diampu pengajar ini"><i class="fas fa-solid fa-bars"></i></a>
                        
                    </td>
                </tr>
            </p>
          
            <p class="text-muted text-md"><tr><td><b>No Handphone</b></td><td><b>:</b></td><td>+62{{ $item->tlp }}</td></tr></p>
            </tbody>
            </table>
          </div>
          
        </div>
      </div>
      @endforeach
     
    </div>
  </div>
</div>
</div>



    
<div class="card">
    <div class="card-header bg-info">
        @foreach ($nama_guru as $item)
            
        @endforeach
        <h3 class="card-title"><b>Jadwal Pengajar {{ $item->name }}</b></h3>
    </div>
          
    <div class="card-body">
      <div style="margin-top: -8px;"><button class="btn btn-sm btn-default fas fa-print"> Cetak Jadwal</button></div>
      <div class="table-responsive">
        
        <table id="example2" class="table table-striped">
            <thead style="background-color: black; color:white;">
                <tr align="center">
                <th>#</th>
                <th>Mapel</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Jam</th>
                </tr> 
            </thead>
        
            <tbody>
                @foreach ($jadwal as $num=>$data)
                    <tr>
                        <td>{{ $num+1 }}</td>
                        <td>{{ $data->mapel_nama }}</td>
                        <td>{{ $data->tingkat }}{{ $data->room_name }}</td>
                        <td> {{ ucfirst($data->hari); }}</td> 
                        <td align="center">Jam Ke-{{ $data->nama }} | {{ $data->mulai }} - {{ $data->akhir }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>



  <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pengajar Mata Pelajaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
  
        <div class="modal-body">
          <form action="{{ url('pengajar_mapel_store') }}" method="POST">
          @csrf
            <div class="card-body">
              <div class="form-group">
                <input type="hidden" name="pengajar" value="{{ Request::segment(2) }}">
                <?php $mapel = DB::table('tblmapel')->get();?>
                <select name="mapel" id="" class="form-control">
                  <option value="0">-Pilih Mapel-</option>
                  @foreach($mapel as $row)
                    <option value="{{ $row->id_mapel }}">{{ $row->nama }}</option>
                  @endforeach
                </select>
              </div>
              <button type="submit" class="btn btn-success float-right mt-3">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="modal-kelola">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Kelola Mapel</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
  
        <div class="modal-body">
            <div class="card-body">
                <div class="table-responsive" id="all">
                    @include('mapel.tabel_pengajar_mapel')
                  </div>
            </div>
      </div>
    </div>
  </div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if(Session::has('add_mapel_pengajar')) 
        toastr.success("{{ Session::get('add_mapel_pengajar') }}");
    // @elseif(Session::has('gagal_pengajar')) 
    //     toastr.success("{{ Session::get('gagal_pengajar') }}");
    // @elseif(Session::has('del_pengajar')) 
    //     toastr.success("{{ Session::get('del_pengajar') }}");
    @endif
    
   
@endsection