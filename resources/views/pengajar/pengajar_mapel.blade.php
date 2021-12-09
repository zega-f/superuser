@extends('layout.template')
@section('contens')<br>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><b>Pengajar Mapel</b></h3>
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-default">
    Tambah Pengajar Mapel</button>
  </div>

  <div class="card-body">
    @csrf
    <div class="table-responsive" id="all">
      @include('mapel.tabel_pengajar_mapel')
    </div>
  </div>
</div>




<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Pengajar Mata Pelajaran</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="{{ url('pengajar_mapel_store') }}" method="POST">
        @csrf
          <div class="card-body">
            <div class="form-group">

              <?php $mapel = DB::table('tblmapel')->get();?>
              <select name="mapel" id="" class="form-control">
                <option value="0">-Pilih Mapel-</option>
                @foreach($mapel as $row)
                  <option value="{{ $row->id_mapel }}">{{ $row->nama }}</option>
                @endforeach
              </select><br>

              <?php $pengajar = DB::table('users')
                ->where('users.partner_type','1')
                ->get();?>
              <select name="pengajar" id="" class="form-control">
                <option value="0">-Pilih Pengajar-</option>
                @foreach($pengajar as $row)
                  <option value="{{ $row->partner_id }}">{{ $row->name }}</option>
                @endforeach
              </select><br>

            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  
  


<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


@endsection









