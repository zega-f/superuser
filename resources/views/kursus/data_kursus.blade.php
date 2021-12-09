@extends('layout.template')
@section('contens')<br>



<div class="card">
  <div class="card-header">
    <h3 class="card-title"><b>Data Kursus</b></h3>
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-default">
    Buat Kursus</button>
  </div>
        
  <div class="card-body">
    @csrf
    <div class="table-responsive" id="kursus">
      @include('kursus.tabel_kursus')
    </div>
    {{-- <div class="row" id="kursus">
      @include('kursus.view_kursus')
    </div> --}}
  </div>
</div>







<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Kursus</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="{{ url('kursus_store') }}" method="POST">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label>Nama Kursus</label>
              <input type="text" class="form-control" name="kursus_name" placeholder="" required>
            </div> 

            <div class="form-group">
              <label>Deskripsi</label>
              <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
              <label>Biaya Registrasi</label>
              <input type="number" class="form-control" name="biaya" placeholder="" required>
            </div>

            <?php
              $spv = DB::table('users')
              ->where('partner_type',1)
              ->get();
            ?>
            <div class="form-group">
              <label>Penanggung Jawab</label>
              <select name="kursus_spv" class="form-control guru" required>
                  <option value="0">-Pilih Penanggung Jawab-</option>
                  @foreach($spv as $row)
                      <option value="{{ $row->partner_id }}">{{ ucfirst($row->name) }}</option>
                  @endforeach
              </select>
            </div>


            <div class="form-group">
              
              <label>Icon Kursus</label>
              {{-- <div class="row"> --}}
                <?php
                  $dir1 = "public/all_mapel_icon/";
                  $b = scandir($dir1);
                ?>
                <ul class="nav nav-pills ml-auto p-2">
                <?php for ($k = 2; $k < count($b); $k++) {	?>
                  
                    <li class="nav-item">
                      <a class="nav-link" href="#tab_{{$k}}" data-toggle="tab">
                        <img src="{{ url('public/all_mapel_icon/'.$b[$k]) }}" class="img img-responsive img-rounded gambar" style="width: 50px;" data-uri="{{ $b[$k] }}">
                      </a>
                    </li>
                     
                <?php } ?>
                </ul>
              {{-- </div> --}}
              <input type="hidden" name="icon" value="" id="icon_uri">
            </div>

            </div>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script>
    $('.gambar').click(function(){
      var uri=$(this).data('uri');
      $('#icon_uri').val(uri);
    })

  </script>
 
   

@endsection