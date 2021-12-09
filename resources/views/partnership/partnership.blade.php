@extends('layout.template')
@section('contens')<br>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><b>Partnership</b></h3>
    {{-- <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-default"> --}}
    {{-- Tambah Pelajaran</button> --}}
  </div>

  <div class="card-body">
    @csrf
    <div class="table-responsive" id="all">
      @include('partnership.table_partnership')
    </div>
  </div>
</div>





<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


@endsection









