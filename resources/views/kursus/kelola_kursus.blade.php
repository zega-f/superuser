{{-- @extends('layout.template')
@section('contens')<br> --}}


{{-- <div class="card"> --}}
  {{-- <div class="card-header">
    <h3 class="card-title"><b>Kursus {{ $nm_kursus->room_name }}</b></h3>
  </div> --}}
          
  <div class="card-body" style="overflow: auto;" id="bab">
    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-default" data-toggle="tooltip" data-placement="bottom" title="Tambahkan Bab Baru">Tambah Bab</button>
    <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modal-spv" data-toggle="tooltip" data-placement="bottom" title="Data Penaggung Jawab Kursus">Penanggung Jawab</button>
    <br><br>


    <?php $no=1;?>
    @foreach ($bab_kursus as $bab)
      <div class="card card-primary {{ $no == '1' ? '' : 'collapsed-card' }}">
        <div class="card-header">
          <div class="card-tools float-left">
            <button type="button" class="btn btn-sm btn bg-navy" data-card-widget="collapse" data-toggle="tooltip" data-placement="right" title="Show/Hidden Sub Bab">
              <i class="fas fa-solid fa-caret-down"></i>
            </button>
          </div>
          <span class="float-left">
            <h3 class="card-title">
              &nbsp;&nbsp;&nbsp;&nbsp; <b>BAB {{ $no++ }} | {{ $bab->bab_name }}</b>
            </h3>
          </span>
    
          <div class="btn-group float-right">
            <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" data-toggle="tooltip" data-placement="right" title="Kelola Bab">
              <span class=""><i class=""></i></span>
            </button>
            <div class="dropdown-menu" role="menu" style="background-color: black;">
              <a class="dropdown-item bg-navy" href="{{ url('add_materi/'.$bab->room_id.'/'.$bab->id) }}" data-toggle="tooltip" data-placement="right" title="Tambah Materi">Materi</a>
              <a class="dropdown-item bg-navy" href="{{ url('add_tugas/'.$bab->room_id.'/'.$bab->id) }}" data-toggle="tooltip" data-placement="right" title="Tambah Tugas">Tugas</a>
              <a href="#" class="dropdown-item bg-navy" data-toggle="modal" data-target="#quiz" id="add_quiz" data-babid="{{$bab->id}}" data-toggle="tooltip" data-placement="right" title="Tambah Quiz">Quiz</a>
              <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item bg-navy" data-toggle="modal" data-target="#edit_bab{{ $bab->id }}"  data-toggle="tooltip" data-placement="right" title="Edit Bab">Edit Bab</a>

                <a class="dropdown-item bg-navy hapus_bab" href="{{ url('delete_bab/'.$bab->id) }}"  onclick="return confirm('Yakin Hapus Bab, Menghapus bab akan menghapus data Materi, Tugas dan Quiz')" data-toggle="tooltip" data-placement="right" title="Hapus Bab">Hapus Bab</a>
              </div>
            </div>
          </div>

          <style>
            #page_list1{{ $bab->id }} ul
            {
             padding:1px;
             height:60px;
             background-color:#f9f9f9;
             border:1px dotted #ccc;
             cursor:move;
             margin-top:12px;
            }
            #page_list1{{ $bab->id }} ul.ui-state-highlight1{{ $bab->id }}
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

            <ul class="list-unstyled" id="page_list1{{ $bab->id }}">
              @foreach ($sub_bab as $sub)
                @if ($sub->type == 'materi')
                  <ul class="materi_box{{$sub->type_id}}" class="" id="{{ $sub->id }}">
                    @include('kelola_kursus.materi.data_materi')
                  </ul>
                @elseif ($sub->type == 'tugas')
                  <ul class="tugas_box{{$sub->type_id}}" id="{{ $sub->id }}">
                    @include('kelola_kursus.tugas.data_tugas')
                  </ul>
                @elseif ($sub->type == 'quiz')
                  <ul class="quiz_box{{$sub->type_id}}" id="{{ $sub->id }}">
                    @include('kelola_kursus.quiz.data_quiz')
                  </ul>
                @endif
              @endforeach
            </ul>
            <input type="hidden" name="page_order_list" id="page_order_list" />

            
            <script type="text/javascript">
              $(document).ready(function(){
                $( "#page_list1{{ $bab->id }}").sortable({
                  placeholder : "ui-state-highlight1{{ $bab->id }}",
                    update  : function(event, ui) {
                      var page_id_array = new Array();
                        $('#page_list1{{ $bab->id }} div').each(function() {
                          page_id_array.push($(this).attr("id"));
                        });
              
                        $.ajax({
                          url:'{{URL::to('update_test')}}',
                          method:"get",
                          data:{page_id_array:page_id_array},
                          success:function(data)
                          {
                            alert(data);
                            
                          }
                        });
                      }
                 }  );
                });
              </script>
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
                    <input type="text" name="nama" value="{{$bab->bab_name}}" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-sm btn-success float-right">Update</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
{{-- </div> --}}

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
        <form action="{{ url('store_bab_kursus') }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Nama Bab</label>
            <input type="hidden" name="room_id" value="{{ $nm_kursus->room_id }}" class="form-control" required>
            <input type="hidden" name="type" value="kursus" class="form-control" required>
            <input type="text" name="bab_name" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success">Simpan</button>
        </form>
      </div>
    
    </div>
  </div>
</div>

<div class="modal fade" id="modal-spv">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Penanggung Jawab</h4>
        <button class="btn btn-success btn-xs fas fa-plus float-right" data-toggle="modal" data-target="#modal-add" data-toggle="tooltip" data-placement="bottom" title="Tambahkan Penangung Jawab Kursus"></button>
      </div>
      <div class="modal-body" id="spv">
        @include('kelola_kursus.spv.tabel_spv')
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modal-add">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Penanggung Jawab kursus {{ $nm_kursus->room_name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="{{ url('kursus_spv_store') }}" method="POST">
          @csrf
          <div class="card-body">
            
            <?php
              $spv = DB::table('users')
              ->where('partner_type',1)
              ->get();
            ?>
            <div class="form-group">
              <input type="hidden" value="{{ $nm_kursus->room_id }}" class="form-control" name="room_id">
              <label>Tambah Penanggung Jawab</label>
              <select name="kursus_spv" class="form-control guru" required>
                  <option value="0">-Pilih Penanggung Jawab-</option>
                  @foreach($spv as $row)
                      <option value="{{ $row->partner_id }}">{{ ucfirst($row->name) }}</option>
                  @endforeach
              </select>
            </div>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  


<div class="modal fade" id="berhasil">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
          <div class="form-group">
           Berhasil Update urutan Materi
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
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
              {{ $nm_kursus->room_name}}
            </strong>
          </small></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
    
        <div class="modal-body">
          @include('kelola_kursus.quiz.add_quiz') 
        </div>
      </div>
    </div>
  </div> 

{{-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

 
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  

<script type="text/javascript">
  $(document).ready(function() {
      $(document).on('click', '#edit_bab', function() { 
          var nama = $(this).data('nama');
          var id = $(this).data('id');
          $('#nama').val(nama);
          $('#id').val(id);
      })
  });
</script>



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







{{-- @endsection --}}





