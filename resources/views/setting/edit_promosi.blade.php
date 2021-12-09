<form action="{{ url('promosi_update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Nama Promosi</label>
        <input type="hidden" class="form-control" name="id" value="{{$promo->id}}" required>
        <input type="text" class="form-control" name="name" value="{{$promo->name}}" required><br>

        <label for="exampleInputEmail1">Deskripsi</label>
        <textarea class="form-control" name="deskripsi" value="{{$promo->deskripsi}}">
        {{ $promo->deskripsi }}
        </textarea><br>

        <label for="exampleInputEmail1">Link</label>
        <input type="text" class="form-control" name="link" value="{{$promo->link}}" required><br>

        <label for="exampleInputEmail1">Foto <small> / <i>Aspec Ratio= 16:9</i></small></label>
        <input type="file" class="form-control" name="logo" value="{{$promo->logo}}">
   
      </div>
      <button type="submit" class="btn btn-success float-right">Simpan</button>
    </div>
</form>