@extends('layout.template')
@section('contens')<br>

<div class="row">
  <div class="col-md-9">
    <div class="card card-primary collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Sorotan</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus" data-toggle="tooltip" data-placement="right" title="Daftar Artikel Sorotan"></i></button>
        </div>
      </div>
   
      <div class="card-body">
        <div class="table-responsive" id="sorotan">
          @include('artikel.tabel_sorotan')
        </div>
      </div>
    </div>
  </div>
  

    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Artikel</b></h3>
               
                <a href="{{ url('create_artikel') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="right" title="Tambahkan Artikel">Post Artikel</a>
            </div>

            <div class="card-body">
                @csrf
                <div class="table-responsive" id="artikel">
                    @include('artikel.tabel_artikel')
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Kategori</b></h3>
                <button type="button" class="btn btn-success btn-xs float-right fas fa-plus" data-toggle="modal" data-target="#modal-default" data-toggle="tooltip" data-placement="right" title="Tambah Kategori Artikel">
                </button>
            </div>

            <div class="card-body">
                @csrf
                <div class="table-responsive" id="kategori">
                 @include('artikel.data_kategori')
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Kategori Artikel</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <form action="{{ url('kategori_store') }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Kategori</label>
                    <input type="text" class="form-control" name="name" placeholder="name kategori" required>
               
                  </div>
                  <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

 


@endsection