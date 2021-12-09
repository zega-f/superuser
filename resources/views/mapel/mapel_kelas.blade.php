@extends('layout.template')
@section('contens')<br>

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('kelola_mapel') }}">Tingkat</a></li>
              <li class="breadcrumb-item active">Kelola Mapel</li>
            </ol>
          </div>
        {{-- <div class="col-sm-6 float-right">
          <h1>Profile</h1>
        </div> --}}
        
      </div>
    </div>
  </section>

<div class="row">
<div class="col-12 col-xl-9 col-lg-9 col-md-9">
    <div class="card mb-3 shadow-sm border-light">
        <div class="card-header bg-info">
            <strong style="color:white;">Data Mapel Aktif</strong>
            <strong>
                @foreach($kelas as $k):
                {{ $k->nama }}
                @endforeach
            </strong>
        </div>
        <div class="card-body" style="overflow: auto;">
            <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#modal-default" style="padding:6px !important; font-size:14px !important;">
                Tambah Mapel
            </button>
              
            {{-- @csrf --}}
            <div class="table-responsive" id="kelola">
                @include('mapel.tabel_kelola_mapel')
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-xl-3 col-lg-3 col-md-3">
    <div class="card mb-3 shadow-sm border-light">
        <div class="card-header">
            <strong>Biaya Registrasi</strong>
            <button type="button" class="btn btn-success btn-sm float-right fas fa-pencil-alt" data-toggle="modal" data-target="#modal-register" data-toggle="tooltip" data-placement="right" title="Update Biaya Registrasi Tingkat">
            
            </button>
        </div>
        <div class="card-body" style="overflow: auto;">
            
            <div class="table-responsive" id="">
                @foreach($kelas as $k)
                @if($k->registrasi==0)
                Belum terdapat biaya Registrasi
                @else
                Rp. {{ number_format($k->registrasi) }}
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mapel Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ url('mapelkelas_store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="jenjang" value="{{ $jenjang }}">
                    <input type="hidden" name="tingkat" value="{{ $tingkat }}">
                    <?php $mapel = DB::table('tblmapel')
                    ->where('aktif','1')
                    ->whereNotIn('id_mapel',function($q){
                      $q->select('mapel')->from('mapel_kelas')
                      ->where('tingkat',9)
                      ->get();
                    })
                    ->get();?>
                    <label>Nama Mapel</label>
                    <select name="mapel_name" id="" class="form-control">
                        <option value="0">-Pilih Mapel-</option>
                        @foreach($mapel as $row)
                            <option value="{{ $row->id_mapel }}">{{ $row->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control"  placeholder="harga mapel">
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" maxlength="200" placeholder="Deskripsi" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-sm btn-success">Simpan</button> 
            </div>
            </form>
        </div>
      </div>
    </div>
</div>


<div class="modal fade" id="modal-register">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Biaya Registrasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ url('registrasi_kelas') }}" method="POST">
                @csrf
                <div class="form-group">
                
                    <input type="hidden" name="tingkat" value="{{ $tingkat }}">
                    <input type="number" name="registrasi" class="form-control" value="{{ $regis->registrasi }}" placeholder="biaya registrasi">
 
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>


@endsection



<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
