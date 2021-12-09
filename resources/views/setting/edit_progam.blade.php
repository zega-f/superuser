<form action="{{ url('progam_update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- <div class="card-body"> --}}
        <div class="form-group">
            <label>Nama Progam</label>
            <input type="hidden" class="form-control" name="id" value="{{$progam->id}}" required>
            <input type="text" class="form-control" name="name" value="{{$progam->name}}" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea class="form-control" id="" name="deskripsi" value="{{$progam->deskripsi}}">
                <?php echo $progam->deskripsi?>
            </textarea>
        </div>

        <div class="form-group">
            <label>Link</label>
            <input type="text" class="form-control" name="link" value="{{$progam->link}}" required>
        </div>

        <div class="form-group">
            <label>Logo </label>
            <input type="file" class="form-control" name="logo" value="{{$progam->logo}}">
        </div>
   
      {{-- </div> --}}
      <button type="submit" class="btn btn-success float-right">Simpan</button>
    {{-- </div> --}}
</form>

<script type="text/javascript">
    var konten = document.getElementById("progam{{$progam->id}}");
        CKEDITOR.replace(konten,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;
  </script>