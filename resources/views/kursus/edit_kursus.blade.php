
<form action="{{ url('kursus_update') }}" method="POST">
    @csrf
    <div class="card-body">
      <div class="form-group">
        <label>Nama Kursus</label>
        <input type="hidden" class="form-control" name="room_id" value="{{ $data->room_id }}" placeholder="" required>
        <input type="text" class="form-control" name="nama" value="{{ $data->room_name }}" placeholder="" required>
      </div> 

      <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="info" class="form-control" value="{{ $data->description }}" rows="4" required><?php echo $data->description?></textarea>
        {{-- <input type="text" class="form-control" name="description" placeholder="" required> --}}
      </div>

      <div class="form-group">
        <label>Biaya Registrasi</label>
        <input type="number" class="form-control" name="biaya" value="{{ $data->biaya }}" placeholder="" required>
      </div>

    


      <div class="form-group">
      
        <label>Icon Kursus</label>
        <div class="row">
          {{-- <div class="col-2"> --}}
          <?php
            $dir = "public/all_mapel_icon/";
            $a = scandir($dir);
          ?>
           <input type="hidden" name="icon" value="{{ $data->icon }}" id="icon_url{{$data->id}}">
          <ul class="nav nav-pills ml-auto p-2">
          <?php for ($i = 2; $i < count($a); $i++) {	?>
              <li class="nav-item">
                <a class="nav-link {{ $data->icon==$a[$i] ? 'active' : '' }}" href="#tab_{{$i}}" data-toggle="tab">
                  <img src="{{ url('public/all_mapel_icon/'.$a[$i]) }}" class="img img-responsive img-rounded icon{{$data->id}}" style="width: 50px;" data-url="{{ $a[$i] }}">
                </a>
              </li>
              <script>
                $('.icon{{$data->id}}').click(function(){
                  var url=$(this).data('url');
                  $('#icon_url{{$data->id}}').val(url);
                })
              </script>
          <?php } ?>
          </ul>
          {{-- </div> --}}
        </div>
       
      </div>

     
      </div>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>

    </form>