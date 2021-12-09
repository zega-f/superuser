@extends('layout.template')
@section('contens')<br>


<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('kursus') }}">Kursus</a></li>
              <li class="breadcrumb-item active">Kelola Materi</li>
            </ol>
          </div>
        {{-- <div class="col-sm-6 float-right">
          <h1>Profile</h1>
        </div> --}}
        
      </div>
    </div>
  </section>

<div class="card">
    <div class="card-header d-flex p-0">
      <h3 class="card-title p-3"><b>Kursus {{ $nm_kursus->room_name }}</b></h3>
      <ul class="nav nav-pills ml-auto p-2">
        <li class="nav-item"><a class="nav-link active" href="{{ url('kelola_kursus/'.$nm_kursus->room_id) }}" data-toggle="tooltip" data-placement="bottom" title="Data Materi Kursus"><i class="fas fa-book"></i> Materi</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('jadwal_kursus/'.$nm_kursus->room_id) }}" data-toggle="tooltip" data-placement="bottom" title="Jadwal Tatap Muka"><i class="fas fa-user-clock"></i> Tatap Muka</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('participant_kursus/'.$nm_kursus->room_id) }}" data-toggle="tooltip" data-placement="bottom" title="Data Peserta Kursus"><i class="fas fa-users"></i> Participant</a></li>
      </ul>
    </div>

    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                @include('kursus.kelola_kursus')
            </div>
        </div>
    </div>
  </div>
@endsection
