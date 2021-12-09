@extends('layout.template')
@section('contens')<br>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><b>Data Admin</b></h3>
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-default">
    Tambah Admin</button>
  </div>

  <div class="card-body">
   
    {{-- @if ($message = Session::get('success'))
    <div class="alert alert-success alert-sm" id="alert">
        <p>{{ $message }}</p>
    </div>
    @endif--}}
    
    <div class="table-responsive" id="admin">
      @include('admin.tabel_admin')
    </div>
  </div>
</div>



<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Admin</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="{{ url('add_admin') }}" method="POST">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Nama Admin</label>
              <input type="text" class="form-control" name="admin_name" placeholder="" required>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Email</label>
              <input type="text" class="form-control" name="email" placeholder="" required>
            </div>

            <button type="submit" class="btn btn-success float-right mt-2">Simpan</button>
            
          </div>   
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@endsection