@extends('layout.template')
@section('contens')<br>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><b>Mata Pelajaran</b></h3>
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-default">
    Tambah Pelajaran</button>
  </div>

  <div class="card-body">
    @csrf
    <div class="table-responsive" id="all">
      @include('mapel.tabel_mapel')
    </div>
  </div>
</div>



<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Mata Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ url('mapel_store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Inisial Mapel</label>
            <input type="text" class="form-control" name="inisial" placeholder="MTK" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Nama Mapel</label>
            <input type="text" class="form-control" name="mapel_name" placeholder="Matematika" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Keluar</button>
          <button type="submit" class="btn btn-sm btn-success">Simpan</button>
        </div>   
      </form>
    </div>
  </div>
</div>

  
  


  


<div class="modal fade" id="konfirmasi_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <b>Anda yakin ingin menghapus data ini ?</b><br><br>
                <a class="btn btn-danger btn-ok"> Hapus</a>
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


@endsection









