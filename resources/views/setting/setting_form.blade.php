<form class="form-horizontal" action="{{ url('store') }}" method="post" enctype="multipart/form-data">
    @csrf
      <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input type="hidden" class="form-control" name="id" value="{{ $cms->id }}" required>
          <input type="text" class="form-control" name="name" value="{{ $cms->name }}" required>
        </div>
      </div>

      <div class="form-group row">
        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" name="email" value="{{ $cms->footer_email }}" required>
        </div>
      </div>

      <div class="form-group row">
        <label for="inputName2" class="col-sm-2 col-form-label">Whatsapp</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="whatsapp" value="{{ $cms->footer_whatsapp }}" required>
        </div>
      </div>

      <div class="form-group row">
        <label for="inputExperience" class="col-sm-2 col-form-label">Alamat</label>
        <div class="col-sm-10">
          <input type="texxt" class="form-control" name="alamat" value="{{ $cms->footer_alamat }}"></textarea>
        </div>
      </div>

      <div class="form-group row">
        <label for="inputExperience" class="col-sm-2 col-form-label">Deskripsi</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="cms" name="deskripsi" value="{{ $cms->deskripsi }}">
            <?php echo $cms->deskripsi?>
          </textarea>
        </div>
      </div> 

      <div class="form-group row">
        <label for="inputSkills" class="col-sm-2 col-form-label">Website</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="website" value="{{ $cms->footer_website }}">
        </div>
      </div>

      <div class="form-group row">
        <label for="inputSkills" class="col-sm-2 col-form-label">Youtube</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="youtube" value="{{ $cms->footer_youtube }}">
        </div>
      </div>

      <div class="form-group row">
        <label for="inputSkills" class="col-sm-2 col-form-label">Rekening</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" name="rekening" value="{{ $cms->rekening}}">
        </div>
        <label for="inputSkills" class="col-sm-1 col-form-label">an</label>
        <div class="col-sm-4" style="left:-20px;">
          <input type="text" class="form-control" name="an" value="{{ $cms->an}}" style="width: 108%;">
        </div>
      </div>
    

      <div class="form-group row">
        <label for="inputSkills" class="col-sm-2 col-form-label">Logo</label>
        <div class="col-sm-10">
          <input type="file" class="form-control" name="logo" value="{{ $cms->logo }}">
        </div>
      </div>

      <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
          <div class="checkbox">
            <label>
              {{-- <input type="checkbox"> I agree to the  --}}
              {{-- <a href="#">terms and conditions</a> --}}
             <small style="color:grey;"> ubah sesuai kebutuhan **</small>
            </label>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>