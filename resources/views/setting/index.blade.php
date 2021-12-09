@extends('layout.template')
@section('contens')<br>
<style>
  /* .container {
    position: relative;
    width: 50%;
  }
   */
  .images {
    opacity: 1;
    display: block;
    width: 100%;
    height: auto;
    transition: .5s ease;
    backface-visibility: hidden;
  }
  
  .middle {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%)
  }
  
  .container:hover .images {
    opacity: 0.3;
  }
  
  .container:hover .middle {
    opacity: 1;
  }
  
  .text {
    background-color:purple;
    color: white;
    font-size: 12px;
    /* padding: 14px 24px; */
  }
  </style>


<div class="row">
  <div class="col-md-3">
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid" style="border:none;"
          src="{{ url('public/gambar/'.$cms->logo) }}" alt="User profile picture">
        </div>
        <h3 class="profile-username text-center">{{ $cms->name }}</h3>
      </div>
    </div>
         
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">About Bimbel</h3>
      </div>
        
      <div class="card-body">
        <strong><i class="fas fa ion-location"></i> Alamat</strong>
          <p class="text-muted">{{ $cms->footer_alamat }}</p>
        <hr>

        <strong><i class="fas fa-envelope"></i> Email</strong>
          <p class="text-muted">{{ $cms->footer_email }}</p>
        <hr>

        <strong><i class="fas fa-phone"></i> Whatsapp</strong>
          <p class="text-muted">{{ $cms->footer_whatsapp }}</p>
        <hr>

        <strong><i class="fas fa ion-social-wordpress"></i> Website</strong>
          <p class="text-muted">
            <span class="tag tag-danger">{{ $cms->footer_website }}</span>
          </p>
        <hr>

        <strong><i class="fas fa ion-social-youtube"></i> Youtube</strong>
          <p class="text-muted">{{ $cms->footer_youtube }}</p>

        <strong><i class="fas fa-money-check"></i> Rekening /an: {{ $cms->an }}</strong>
          <p class="text-muted">{{ $cms->rekening }} <b></b></p>
      </div>
    </div>
  </div>

  <div class="col-md-9">
    <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab" data-toggle="tooltip" title="Profile yang ditampilkan di Website">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab" data-toggle="tooltip" title="Edit Profile Website">Settings</a></li>
          <li class="nav-item"><a class="nav-link" href="#feed" data-toggle="tab" data-toggle="tooltip" title="Data Testimoni Pengguna Aplikasi">Feedback</a></li>
        </ul>

        <ul class="float-right"style="margin-top:-40px;">
          @if (session('error'))
            <div class="alert alert-danger alert-dismissible">
              <i class="icon fas fa-ban"></i>  {{ session('error') }}
            </div>
          @endif

          @if (session('success'))
            <div class="alert alert-success alert-dismissible" style="height:50px;">
              <i class="icon fas fa-check"></i>  {{ session('success') }}
            </div>
          @endif
        </ul>
      </div>

      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="timeline">
            @include('setting.profile')
          </div>

          <div class="tab-pane" id="settings">
            @include('setting.setting_form')
          </div>

          <div class="tab-pane" id="feed">
            @include('setting.feedback')
          </div>
         
        </div>
      </div>
    </div>
  </div>  
</div>




<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content modal-xl">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Progam Bimbel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
          <form action="{{ url('progam_store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Progam</label>
                  <input type="text" class="form-control" name="name" placeholder="" required><br>

                  <label for="exampleInputEmail1">Deskripsi</label>
                  <textarea class="form-control" id="" name="deskripsi"></textarea><br>

                  <label for="exampleInputEmail1">Link</label>
                  <input type="text" class="form-control" name="link" placeholder="" required><br>

                  <label for="exampleInputEmail1">Logo <small> / <i>Aspec Ratio= 1:1<i></small></label>
                  <input type="file" class="form-control" name="logo" placeholder="" required>
             
                </div>
                <button type="submit" class="btn btn-success float-right">Simpan</button>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-promosi">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content modal-xl">
      <div class="modal-header">
        <h4 class="modal-title">Tambah promosi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
          <form action="{{ url('promosi_store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Promosi</label>
                  <input type="text" class="form-control" name="name" placeholder="" required><br>

                  <label for="exampleInputEmail1">Deskripsi</label>
                  <textarea class="form-control" id="" name="deskripsi"></textarea><br>

                  <label for="exampleInputEmail1">Link</label>
                  <input type="text" class="form-control" name="link" placeholder="" required><br>

                  <label for="exampleInputEmail1">Foto <small> / <i>Aspec Ratio= 16:9<i></small></label>
                  <input type="file" class="form-control" name="logo" placeholder="" required>
             
                </div>
                <button type="submit" class="btn btn-success float-right">Simpan</button>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  var konten = document.getElementById("cms");
      CKEDITOR.replace(konten,{
      language:'en-gb'
    });
    CKEDITOR.config.allowedContent = true;
</script>
{{-- <script type="text/javascript">
  var konten = document.getElementById("progam");
      CKEDITOR.replace(konten,{
      language:'en-gb'
    });
    CKEDITOR.config.allowedContent = true;
</script> --}}




@endsection