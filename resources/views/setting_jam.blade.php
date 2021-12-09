@extends('layout.template')
@section('contens')<br>

<div class="card mb-3 shadow-sm border-light">
    <div class="card-header bg-info">
        <strong style="color:white;">Setting Jam</strong>
    </div>

    <div class="card-body" style="overflow: auto;">
        <?php $jam = DB::table('a_jam')->get(); ?>
        @foreach ($jam as $item)
            <div class="table" id="">
                <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Start Bimbel</label>
                        <input type="time" value="{{ $item->start }}" class="form-control" disabled>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Durasi/Menit</label>
                        <input type="number" value="{{ $item->durasi }}" class="form-control" disabled>
                      </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                          <label>Jam/hari</label>
                          <input type="number" value="{{ $item->jam }}" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label><br></label>
                            <a class='btn btn-primary btn-small form-control' id="update_jam" data-toggle="modal" data-target="#modal-edit" data-start="{{ $item->start }}" data-durasi="{{ $item->durasi}}" data-id="{{ $item->id }}" data-jam="{{ $item->jam }}" data-toggle="tooltip" data-placement="right" title="Ubah Jam Belajar Bimbel">Update</a>
                        </div>
                    </div>
                </div>
            </div> 
        @endforeach
    </div>
</div>




<?php $cek_jam = DB::table('a_jam')->get(); ?>
@foreach ($cek_jam as $item)
    <?php
        $mulai = $item->start;
        $durasi = $item->durasi;
        $jam = $item->jam;
    ?>
@endforeach
<br>



<div class="card">
    <div class="card-header">
        <h3 class="card-title"><b>Jam Mapel</b></h3>
    </div>
 
<?php $setjam = DB::table('atur_jam')->get(); ?>
<div class="card-body">

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-sm alert-dismissible" id="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>{{ $message }}</p>
    </div>
    @endif

    

    <div class="table-responsive" id="">
        <table id="example2" class="table table-striped">
            <thead class="bg-dark" style="color:white; font-size:15px;">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Start</th>
                    <th>End</th>
                </tr> 
            </thead>

            <tbody style="font-size: 14px;">
                @foreach ($setjam as $num=>$data)
                <tr>
                    <td>{{ $num+1 }}</td>
                    <td>Jam Ke-{{ $data->nama }}</td>
                    <td>{{ $data->start }}</td>
                    <td>{{ $data->end }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div><br><br>




<div class="modal fade" id="modal-edit" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Jam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ url('simpanjam2') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    
                    <label>Nama start</label>
                    <input type="time" name="mulai" id="start" class="form-control"><br>
                    <label>Durasi</label>
                    <input type="number" name="durasi" id="durasi" class="form-control"><br>
                    <label>Jumlah Jam</label>
                    <input type="number" name="jam" id="jam" class="form-control"><br>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection





<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#update_jam', function() { 
            var start = $(this).data('start');
            var durasi = $(this).data('durasi');
            var id = $(this).data('id');
            var jam = $(this).data('jam');
            $('#start').val(start);
            $('#durasi').val(durasi);
            $('#id').val(id);
            $('#jam').val(jam);
        })
    });
</script>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  @if(Session::has('success')) 
      toastr.success("{{ Session::get('success') }}");
  @endif

</script>

