@foreach ($kategori as $item)
<ul class="todo-list" data-widget="todo-list">
  <li>
    <span class="text">{{ $item->name }}</span>
    <div class="tools">
      <i class="fas fa-edit" data-toggle="modal" data-target="#edit-kategori{{$item->id}}" data-toggle="tooltip" data-placement="right" title="Edit Kategori"></i>
      <i class="fas fa-trash btn_hapus1" id="{{$item->id}}" data-toggle="tooltip" data-placement="right" title="Hapus Kategori"></i>

    </div>
  </li>
  </ul>

  <div class="modal fade" id="edit-kategori{{$item->id}}">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Kategori Artikel</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
  
          <div class="modal-body">
              <form action="{{ url('kategori_update') }}" method="POST">
                  @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Kategori</label>
                      <input type="hidden" name="id" value="{{$item->id}}" required>
                      <input type="text" class="form-control" name="name" value="{{$item->name}}" required>
                 
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                  </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(".btn_hapus1").click(function(){
                var id_kategori = $(this).attr('id');
                var status = confirm('Yakin ingin menghapus?');
                if(status){
                    $.ajax({
                        url: '{{URL::to('del_kategori')}}',
                        type: 'get',
                        data: {id_kategori:id_kategori},
                        success: function(data){
                            $('#kategori').html(data);
                        }
                    })
                }
            })
    </script>

    
@endforeach