@extends('layout.template')
@section('contens')<br>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('kursus') }}">Kursus</a></li>
            <li class="breadcrumb-item active">Data Participants</li>
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
      <li class="nav-item"><a class="nav-link" href="{{ url('kelola_kursus/'.$nm_kursus->room_id) }}" data-toggle="tooltip" data-placement="bottom" title="Data Materi Kursus"><i class="fas fa-book"></i> Materi</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ url('jadwal_kursus/'.$nm_kursus->room_id) }}" data-toggle="tooltip" data-placement="bottom" title="Jadwal Tatap Muka"><i class="fas fa-user-clock"></i> Tatap Muka</a></li>
      <li class="nav-item"><a class="nav-link active" href="{{ url('participant_kursus/'.$nm_kursus->room_id) }}" data-toggle="tooltip" data-placement="bottom" title="Data Peserta Kursus"><i class="fas fa-users"></i> Participant</a></li>
    </ul>
  </div>

  <div class="card-body">
      <div class="tab-content">

          <div class="tab-pane active" id="tab_1">
{{-- 
<section class="content-header">
  <div class="row">
    <div class="col-12">
      <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item">Data Participant</li>
      </ol>
    </div>
  </div>
</section> --}}


<div class="row">
    @foreach ($participant as $data)
    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
      <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">
        </div>
        <div class="card-body pt-0">
          <div class="row">
            <div class="col-7">
              <h2 class="lead"><b>{{ $data->name }}</b></h2>
              <ul class="ml-4 mb-0 fa-ul text-muted">
                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: {{ $data->address }}</li>
                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone: {{ $data->phone }}</li>
              </ul>
            </div>
            <div class="col-5 text-center">
              <img src="{{ url('public/assets/dist/img/avatar5.png')}}" alt="user-avatar" class="img-circle img-fluid">
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="text-right">
            {{-- <a href="#" class="btn btn-sm bg-teal">
              <i class="fas fa-comments"></i>
            </a> --}}
            <a href="{{ url('detail_siswa/'.$data->partner_id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="bottom" title="Detail Peserta Kursus">
              <i class="fas fa-user"></i> View Profile
            </a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
</div>

{{-- Halaman : {{ $participant->currentPage() }} <br/>
	Jumlah Data : {{ $participant->total() }} <br/>
	Data Per Halaman : {{ $participant->perPage() }} <br/> --}}
 
 
<div class="card-footer">
  <nav aria-label="Contacts Page Navigation">
    <ul class="pagination justify-content-center m-0">
      {{ $participant->onEachSide(1)->links() }}
      {{-- <li class="page-item active"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li> --}}
    </ul>
  </nav>
</div>
          </div></div></div></div>



@endsection