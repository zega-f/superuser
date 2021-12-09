@extends('layout.template')
@section('contens')<br>

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Frequently Asked Question</h3>
      <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modal-default" data-toggle="tooltip" title="Tambah Kategori Pertanyaan">Add FAQ</button>
    </div>
    <!-- /.card-header -->
    <div class="card-body">


    
    @foreach ($faq as $item)
      <div id="accordion{{$item->id}}">
        <div class="card card-danger">
          <div class="card-header bg-light" style="color: black;">
            <h4 class="card-title w-100" style="color: black;">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo{{ $item->id }}" style="color: black;"  data-toggle="tooltip" title="Show/Hide Pertanyaan">
                <i class="fas fa-angle-down"></i> {{ $item->category }} ?
              </a>
            </h4>

            <h4 class="card-title float-right">
                <a class="btn btn-success btn-xs" id="question" data-toggle="modal" data-target="#modal-question" data-idc="{{$item->category_id}}" data-kategori="{{$item->category}}" data-toggle="tooltip" title="Tambah Pertanyaan"><i class="fas fa-plus"></i></a>

                <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#edit-category{{$item->id}}"  data-toggle="tooltip" title="Edit Kategori Pertanyaan"><i class="fas fa-pencil-alt"></i></a>

                <div class="modal fade" id="edit-category{{$item->id}}" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-info">
                          <h4 class="modal-title"><small><b>Edit FAQ <small>{{$item->category}}</small></b>
                            <strong style="color: white;">
                  
                            </strong>
                          </small></h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                    
                        <div class="modal-body">
                          <form action="{{ url('update_faq_category') }}" method="POST">
                            @csrf
                            <div class="form-group">
                              <label>Category</label>
                              <input type="hidden" name="id" value="{{$item->category_id}}" class="form-control">
                              <input type="text" name="category" value="{{$item->category}}" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-sm btn-success float-right">Update</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
               
                <a href="{{ url('del_faqcategory/'.$item->category_id) }}" class="btn btn-danger btn-xs" onclick="confirm('Yakin ingin menghapus faq?')"  data-toggle="tooltip" title="Hapus Kategori Pertanyaan"><i class="fas fa-trash"></i></a>
            </h4>
           

          </div>
          <div id="collapseTwo{{$item->id}}" class="collapse" data-parent="#accordion{{$item->id}}">
            <div class="card-body">
                <?php
                    $faq2 = DB::table('faq_question')
                    ->join('faq_category', 'faq_category.category_id', '=', 'faq_question.faq_category')
                    ->where('faq_category',$item->category_id)
                    ->get();
                ?>
                <ul class="faq-list">
                  @if(count($faq2)<=0)
                  <div class="alert alert-warning" style="height:50px;">
                    <p>Belum terdapat item</p>
                  </div>
                  @else
                    @foreach ($faq2 as $item2)
                    
                    <li>
                        <div class="border alert alert-info" style="padding: 5px 10px;">
                            {{ $item2->question }}
                            <div class="float-right">
                                <i class="fas fa-pencil-alt" data-toggle="modal" data-target="#edit-question{{$item2->id}}" data-toggle="tooltip" title="Edit Pertanyaan"></i>

                                <div class="modal fade" id="edit-question{{$item2->id}}" role="dialog">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header bg-info">
                                          <h4 class="modal-title"><small><b>Edit Question <small>{{$item2->category}}</small></b>
                                            <strong style="color: white;">
                                  
                                            </strong>
                                          </small></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                    
                                        <div class="modal-body">
                                          <form action="{{ url('update_answer') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                              <label>Question</label>
                                              <input type="hidden" name="id" value="{{$item2->category_id}}" class="form-control">
                                              <input type="text" name="question" value="{{$item2->question}}" class="form-control">
                                              <label>Answer</label>
                                              <textarea name="answer" id="questionedit{{$item2->id}}" class="form-control" value="{{$item2->answer}}"><?php echo $item2->answer?></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-success float-right">Update</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <script type="text/javascript">
                                    var konten = document.getElementById("questionedit{{$item2->id}}");
                                        CKEDITOR.replace(konten,{
                                        language:'en-gb'
                                      });
                                      CKEDITOR.config.allowedContent = true;
                                </script>
                               

                                <a href="{{ url('del_answer/'.$item->category_id) }}" onclick="confirm('Yakin ingin menghapus question?')"  data-toggle="tooltip" title="Hapus Pertanyaan"><i class="fas fa-trash"></i></a>
                            </div> 
                        </div>
                        <div style="margin-left: 20px;">
                            <?php echo $item2->answer?>
                        </div>
                    </li><br>
                    @endforeach
                    @endif
                </ul>   
            </div>
          </div>
        </div>
       
      </div>
      @endforeach
    </div>
  </div>
</div>



<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add FAQ Category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('store_faq') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Category</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="modal-question">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Question/<small><span id="kategori"></span></small></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('add_question') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Question</label>
              <input type="hidden" name="category_id" id="idc" class="form-control" required>
              <input type="text" name="question" class="form-control" required>
              <label>Answer</label>
              <textarea name="answer" id="question1" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <script type="text/javascript">
	var konten = document.getElementById("question1");
	    CKEDITOR.replace(konten,{
	    language:'en-gb'
	  });
  	CKEDITOR.config.allowedContent = true;
</script>


  
@endsection
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#question', function() { 
            var kategori = $(this).data('kategori');
            var idc = $(this).data('idc');
            $('#kategori').text(kategori);
            $('#idc').val(idc);
        })
    });
  </script>

  
  
