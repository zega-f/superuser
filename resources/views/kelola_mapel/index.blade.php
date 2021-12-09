@extends('layout.template')
@section('contens')
<br>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('mapel_kelas/'.$nm_kelas->jenjang.'/'.$nm_kelas->tingkat) }}">Mapel Kelas</a></li>
            <li class="breadcrumb-item active">Kelola Mapel Kelas</li>
          </ol>
        </div>
      {{-- <div class="col-sm-6 float-right">
        <h1>Profile</h1>
      </div> --}}
      
    </div>
  </div>
</section>

<div class="card mb-3 shadow-sm border-light" id="">
  <div class="card-header" style="background-color: grey;">
    <strong style="color:white;">Materi</strong>
    <strong style="color: white;">
      {{ $nm_mapel->nama}} {{ $nm_kelas->nama }}
    </strong>
  </div>

  <div class="card-body" style="overflow: auto;" id="bab">
    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-default" data-toggle="tooltip" title="Tambahkan Bab Baru">Tambah Bab</button><br><br>
    <?php $no=1;?>
    @foreach ($bab_materi as $bab)
      <div class="card card-primary {{ $no == '1' ? '' : 'collapsed-card' }}"> 
        <div class="card-header" style="padding:8px !important; font-size:14px !important;">
          <div class="card-tools float-left">
            <button type="button" class="btn btn-sm btn bg-navy" data-card-widget="collapse" data-toggle="tooltip" title="Sho/Hide Sub-bab"  style="padding:5px !important; font-size:12px !important;">
              <i class="fas fa-solid fa-caret-down"></i>
            </button>
          </div>
          <span class="float-left">
            <h3 class="card-title" style="font-size: 16px;">
              &nbsp;&nbsp;&nbsp;&nbsp; <b>BAB {{ $no++ }} | {{ $bab->bab_name }}</b>
            </h3>
          </span>

          <div class="btn-group float-right">
            <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" data-toggle="tooltip" title="Kelola Bab" style="padding:5px !important; font-size:12px !important;">
              <span class=""><i class=""></i></span>
            </button>
            <div class="dropdown-menu" role="menu" style="background-color: black;">
              <a class="dropdown-item bg-navy" href="{{ url('materi/'.$bab->room_id.'/'.$bab->mapel.'/'.$bab->id) }}" data-toggle="tooltip" title="Tambah Materi">Materi</a>
              <a class="dropdown-item bg-navy" href="{{ url('tugas/'.$bab->room_id.'/'.$bab->mapel.'/'.$bab->id) }}" data-toggle="tooltip" title="Tambah Tugas">Tugas</a>
              <a href="#" class="dropdown-item bg-navy" data-toggle="modal" data-target="#quiz" id="add_quiz" data-babid="{{$bab->id}}" data-toggle="tooltip" title="Tambah Quiz">Quiz</a>
              <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item bg-navy" data-toggle="modal" data-target="#edit_bab{{ $bab->id }}" data-toggle="tooltip" title="Edit Bab">Edit Bab</a>
                <a class="dropdown-item bg-navy hapus_bab" href="{{ url('delete_bab/'.$bab->id) }}"  onclick="return confirm('Yakin Hapus Bab, Menghapus bab akan menghapus data Materi, Tugas dan Quiz')" data-toggle="tooltip" title="Hapus Bab">Hapus Bab</a>
              </div>
            </div>
          </div>

          <style>
            #page_list{{ $bab->id }} ul
            {
             padding:1px;
             height:60px;
             background-color:#f9f9f9;
             border:1px dotted #ccc;
             cursor:move;
             margin-top:12px;
            }
            #page_list{{ $bab->id }} ul.ui-state-highlight{{ $bab->id }}
            {
             padding:24px;
             background-color:#ffffcc;
             border:1px dotted #ccc;
             cursor:move;
             margin-top:12px;
            }
           </style>
     
          <div class="card-body">
            <div class="table-responsive">
              <?php
                $sub_bab = DB::table('sub_bab')
                ->where('sub_bab.bab_id',$bab->id)
                ->orderBy('sub_id','asc')
                ->get();
              ?>

              <ul class="list-unstyled" id="page_list{{ $bab->id }}">
                @foreach ($sub_bab as $sub)
                  @if ($sub->type == 'materi')
                    <ul class="materi_box{{$sub->type_id}}" id="{{ $sub->id }}">
                      @include('kelola_mapel.materi.data_materi')
                    </ul>
                  @elseif ($sub->type == 'tugas')
                    <ul class="tugas_box{{$sub->type_id}}" id="{{ $sub->id }}">
                      @include('kelola_mapel.tugas.data_tugas')
                    </ul>
                  @elseif ($sub->type == 'quiz')
                    <ul class="quiz_box{{$sub->type_id}}" id="{{ $sub->id }}">
                      @include('kelola_mapel.quiz.data_quiz')
                    </ul>
                  @endif
                @endforeach
              </ul>
              <input type="hidden" name="page_order_list" id="page_order_list" />

              <script type="text/javascript">
                $(document).ready(function(){
                  $( "#page_list{{ $bab->id }}").sortable({
                    placeholder : "ui-state-highlight{{ $bab->id }}",
                    update  : function(event, ui) {
                      var page_id_array = new Array();
                      $('#page_list{{ $bab->id }} ul').each(function() {
                        page_id_array.push($(this).attr("id"));
                      });
              
                      $.ajax({
                        url:'{{URL::to('update_test')}}',
                        method:"get",
                        data:{page_id_array:page_id_array},
                        success:function(data)
                        {
                          // alert(data);
                          toastr.success(data);
                        }
                      });
                    }
                  });
                });
              </script>

            </div>
          </div>
        </div>


        <div class="modal fade" id="edit_bab{{ $bab->id }}" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-info">
                <h4 class="modal-title"><small><b>Edit Bab</b>
                  <strong style="color: white;">
        
                  </strong>
                </small></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
          
              <div class="modal-body">
                <form action="{{ url('update_bab') }}" method="POST">
                  @csrf
                  <div class="form-group">
                    <label>Nama Bab</label>
                    <input type="hidden" name="id" value="{{$bab->id}}" class="form-control">
                    <input type="text"  name="nama" value="{{ $bab->bab_name}}" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-sm btn-success float-right">Update</button>
                </form>
              </div>
            </div>
          </div>
        </div>

      @endforeach
    </div>
  </div>



<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Bab</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
        <form action="{{ url('add_bab') }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Nama Bab</label>
            <input type="hidden" name="tingkat" value="{{ $nm_kelas->tingkat }}" class="form-control" required>
            <input type="hidden" name="mapel" value=" {{ $nm_mapel->id_mapel_kelas}} " class="form-control" required>
            <input type="text" name="bab_name" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>







<div class="modal fade" id="quiz" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title"><small><b>Buat Quiz</b>
          <strong style="color: white;">
            {{ $nm_mapel->nama}} {{ $nm_kelas->nama }}
          </strong>
        </small></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
  
      <div class="modal-body">
        @include('muatan.quiz.index') 
      </div>
    </div>
  </div>
</div>





<div class="modal fade" id="modal-sm">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Small Modal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>


{{-- <script type="text/javascript">
  $(document).ready(function() {
      $(document).on('click', '#edit_bab', function() { 
          var nama = $(this).data('nama');
          var id = $(this).data('id');
          $('#nama').val(nama);
          $('#id').val(id);
      })
  });
</script> --}}


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(Session::has('simpan_materi')) 
            toastr.success("{{ Session::get('simpan_materi') }}");
        @elseif(Session::has('update_materi')) 
            toastr.success("{{ Session::get('update_materi') }}");
        @elseif(Session::has('simpan_tugas')) 
            toastr.success("{{ Session::get('simpan_tugas') }}");
        @elseif(Session::has('update_tugas')) 
            toastr.success("{{ Session::get('update_tugas') }}");
        @elseif(Session::has('simpan_quiz')) 
            toastr.success("{{ Session::get('simpan_quiz') }}");
        @elseif(Session::has('update_quiz')) 
            toastr.success("{{ Session::get('update_quiz') }}");
        @elseif(Session::has('tambah_bab')) 
            toastr.success("{{ Session::get('tambah_bab') }}");
        @elseif(Session::has('gagal_bab')) 
            toastr.danger("{{ Session::get('gagal_bab') }}");
        @elseif(Session::has('update_bab')) 
            toastr.success("{{ Session::get('update_bab') }}");
        @elseif(Session::has('hapus_bab')) 
            toastr.success("{{ Session::get('hapus_bab') }}");
        @endif
    </script>
@endsection







