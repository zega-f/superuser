@extends('layout.template')
@section('contens')<br>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  {{-- @if ($message = Session::get('fail'))
    <div class="alert alert-success" id="alert">
        <p>{{ $message }}</p>
    </div>
    @endif --}}

    {{-- @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <p><i class="icon fas fa-check"></i> {{ $message }}</p>
    </div>
    @endif --}}

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><b>Data Kelas</b></h3>
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-default">
    Tambah Kelas</button>
  </div>
        
  <div class="card-body">
    @csrf
    <div class="table-responsive" id="kls">
      @include('kelas.tabel_kelas')
    </div>
  </div>
</div>


    
  

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Kelas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="{{ url('kelas_store') }}" method="POST">
          @csrf
          <div class="card-body">
            {{-- <div class="form-group">
              <label>Nama Kelas</label>
              <input type="text" class="form-control" name="kelas_name" placeholder="" required>
            </div>  --}}

			      <div class="form-group mb-3">
				      <label>Jenjang</label>
				      <select class="form-control form-control-sm border-light shadow-sm" style="height: 50px;" id="jenjang" name="jenjang" required>
					      <option value="" selected="">Pilih Jenjang</option>
					      <option value="1">Sekolah Dasar</option>
					      <option value="2">Sekolah Menengah Pertama</option>
					      <option value="3">Sekolah Menengah Atas</option>
				      </select>
			      </div>

			      <div class="input-group mb-3" id="sub_jenjang_div" style="display: none;">
              <select class="form-control form-control-sm border-light shadow-sm sub_jenjang" style="height: 50px;" id="_sd" name="sub_jenjang" required style="display: none;" disabled>
                  <option value="" selected>Pilih tingkat SD</option>
                  <option value="1">SD 1</option>
                  <option value="2">SD 2</option>
                  <option value="3">SD 3</option>
                  <option value="4">SD 4</option>
                  <option value="5">SD 5</option>
                  <option value="6">SD 6</option>
              </select>
              <select class="form-control form-control-sm border-light shadow-sm sub_jenjang" style="height: 50px;" id="_smp" name="sub_jenjang" required style="display: none;" disabled>
                  <option value="" selected>Pilih tingkat SMP</option>
                  <option value="7">SMP 7</option>
                  <option value="8">SMP 8</option>
                  <option value="9">SMP 9</option>
              </select>
              <select class="form-control form-control-sm border-light shadow-sm sub_jenjang" style="height: 50px;" id="_sma" name="sub_jenjang" required style="display: none;" disabled>
                  <option value="" selected>Pilih tingkat SMA</option>
                  <option value="10">SMA 10</option>
                  <option value="11">SMA 11</option>
                  <option value="12">SMA 12</option>
              </select>
			      </div>

            {{-- <div class="form-group">
              <label>Deskripsi</label>
              <input type="text" class="form-control" name="info" placeholder="" required>
            </div> --}}

            {{-- <div class="card card-default collapsed-card">
              <div class="card-header">
                <h5 class="card-title">Biaya Registrasi</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <span><small style="font-style: italic; color:red;">* Kosongkan bila tidak ada biaya registrasi</small></span>
                  <input type="number" class="form-control" name="registrasi" placeholder="Biaya Registrasi" autofocus>
                </div> 
              </div>
            </div> --}}
            </div>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>

          </form>
        </div>
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


<script type="text/javascript">
	$('#jenjang').on('change',function(){
		var id_jenjang = $(this).val();
		$('#sub_jenjang_div').show();
		
		if (id_jenjang==1) {
			$('#base_name').html('SD_');
			// $('#_tk').css('display','none').prop('disabled',true);
			$('#_sd').css('display','block').prop('disabled',false);
			$('#_smp').css('display','none').prop('disabled',true);
			$('#_sma').css('display','none').prop('disabled',true);
		}
		if (id_jenjang==2) {
			$('#base_name').html('SMP_');
			// $('#_tk').css('display','none').prop('disabled',true);
			$('#_sd').css('display','none').prop('disabled',true);
			$('#_smp').css('display','block').prop('disabled',false);
			$('#_sma').css('display','none').prop('disabled',true);
		}
		if (id_jenjang==3) {
			$('#base_name').html('SMA_');
			// $('#_tk').css('display','none').prop('disabled',true);
			$('#_sd').css('display','none').prop('disabled',true);
			$('#_smp').css('display','none').prop('disabled',true);
			$('#_sma').css('display','block').prop('disabled',false);
		}
	});

	$('.sub_jenjang').on('change',function(){
		var sj_id = $(this).val();
		$('#sub_name').html(sj_id);
	});
</script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(Session::has('success')) 
            toastr.success("{{ Session::get('success') }}");
        @endif
    </script> --}}



@endsection









