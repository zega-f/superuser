@extends('layout.template')
@section('contens')<br>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><b>Data Pengajar</b></h3>
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-default" data-toggle="tooltip" title="Tambahkan Pengajar Baru">
    Tambah Pengajar</button>
  </div>
        
  <div class="card-body">
    @if ($message = Session::get('fail'))
      <div class="alert alert-danger alert-sm" id="alert">
        <p>{{ $message }}</p>
      </div>
    @endif
    
    <div class="table-responsive" id="guru">
      @include('pengajar.tabel_pengajar')
    </div>
  </div>
</div>


  

<div class="modal fade" id="modal-default" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pengajar</h5>
        <ul class="nav nav-pills ml-auto p-2">
          <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab" data-toggle="tooltip" title="Tambahkan Pengajar Baru">New</a></li>
          <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab" data-toggle="tooltip" title="Tambahkan Mapel Pengajar yang sudah ada">Existed</a></li>
        </ul>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div style="line-height: 1px; color:red;">
          <p><i><small>* New Tambahkan Pengajar baru</small></i></p>
          <p><i><small>* Existed Tambahkan Mapel Pengajar yang sudah ada</small></i></p>
        </div>

        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <form action="{{ url('pengajar_store') }}" method="POST">
              @csrf
              <div class="card-body" style="font-size:14px;"> 

                <div class="row">
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label>Nama Pengajar</label>
                      <input type="text" class="form-control form-control-sm" name="pengajar_name" placeholder="" required>
                    </div> 
              
                    <div class="form-group">
                      <label>Jenis Kelamin</label>
                      <select class="form-control form-control-sm" name="jenis_kelamin" required="" style="font-size: 14px;">
                        <option value="">- Pilih Jenis Kelamin -</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                    </div>
              
                    <div class="form-group">
                      <label>Tempat Lahir</label>
                      <input type="text" class="form-control form-control-sm" name="tempat_lahir" placeholder="" required>
                    </div>
              
                    <div class="form-group">
                      <label>Tanggal Lahir</label>
                      <input type="date" class="form-control form-control-sm" name="tgl_lahir" placeholder="" required>
                    </div>
              
                    <div class="form-group">
                      <label>Alamat</label>
                      <input type="text" class="form-control form-control-sm" name="alamat" placeholder="" required>
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label>Pendidikan</label>
                      <select class="form-control form-control-sm" name="pendidikan" required="" style="font-size: 14px;">
                        <option value="">- Pilih Pendidikan -</option>
                        <option value="Strata 1">Strata 1</option>
                        <option value="Strata 2">Strata 2</option>
                        <option value="Strata 3">Strata 3</option>
                      </select>
                    </div>
              
                    <div class="form-group">
                      <label>Universitas</label>
                      <input type="text" class="form-control form-control-sm" name="universitas" placeholder="" required>
                    </div>

                    <div class="form-group">
                      <label>Mapel</label>
                      <?php $mapel = DB::table('tblmapel')->get();?>
                      <select name="mapel" id="" class="form-control form-control-sm" style="font-size: 14px;">
                        <option value="0">-Pilih Mapel-</option>
                        @foreach($mapel as $row)
                          <option value="{{ $row->id_mapel }}">{{ $row->nama }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control form-control-sm" name="email" placeholder="" required>
                    </div>
              
                    <div class="form-group">
                      <label>No Telepon</label>
                      <input type="number" class="form-control form-control-sm" name="tlp" placeholder="" required>
                    </div>
                  </div>
                </div>

              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-md btn-success">Simpan</button>
              </div>
            </form>
          </div>
                
          <div class="tab-pane" id="tab_2">
            <form action="{{ url('pengajar_mapel_store') }}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label>Nama Pengajar</label>
                  <?php $pengajar = DB::table('users')
                    ->where('users.partner_type','1')
                    ->get();?>
                  <select name="pengajar" id="" class="form-control">
                    <option value="0">-Pilih Pengajar-</option>
                    @foreach($pengajar as $row)
                      <option value="{{ $row->partner_id }}">{{ $row->name }}</option>
                    @endforeach
                  </select>
                </div> 
          
                <div class="form-group">
                  <label>Mapel</label>
                  <?php $mapel = DB::table('tblmapel')->get();?>
                  <select name="mapel" id="" class="form-control">
                    <option value="0">-Pilih Mapel-</option>
                    @foreach($mapel as $row)
                      <option value="{{ $row->id_mapel }}">{{ $row->nama }}</option>
                    @endforeach
                  </select>
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






<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>



@endsection









