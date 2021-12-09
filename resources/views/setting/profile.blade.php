<div class="timeline timeline-inverse">
    <div class="time-label">
        <span class="bg-info">Promosi</span>
    </div>
     
    <div>
        <i class="fa fa-camera bg-purple"></i>
        <div class="timeline-item">
            <span class="time"> 
                <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#modal-promosi" data-toggle="tooltip" title="Tambah Banner Promosi"><i class="fas fa-plus"></i></button> 
            </span>

            <h3 class="timeline-header"><a href="#">Banner Promosi</a></h3>
            <div class="timeline-body">
                <div class="row">
                    @foreach ($promosi as $promo)
                    <div class="col-4">
                        <div class="container mb-3 pointer" style="background-color:transparent; padding: 10px; width:100%; height:80%">
                            <img src="{{ url('public/gambar/'.$promo->logo) }}" style="width: 100%;" class="images img img-responsive">
                    <div class="middle">
                      <div class="text">
                       <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#edit-promosi{{$promo->id}}"><i class="fas fa-pencil-alt"></i></button>
                       <a href="{{ url('delete_promosi/'.$promo->id) }}" class="btn btn-xs btn-danger" onclick="confirm('Yakin ingin menghapus Promosi?')"><i class="fas fa-trash"></i></a>
                      </div>
                      </div>
                  </div>
                </div>

                <div class="modal fade" id="edit-promosi{{$promo->id}}" role="dialog">
                  <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header bg-info">
                        <h4 class="modal-title">Edit Promosi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  
                      <div class="modal-body">
                        @include('setting.edit_promosi')
                      </div>
                    </div>
                  </div>
                </div>

                

                @endforeach
               
            </div>
          </div>
        </div>
    </div>
        

        <div class="timeline timeline-inverse">
            <div class="time-label">
              <span class="bg-info">
                Deskripsi
              </span>
            </div>
    
            <div>
              <i class="fas fa-info bg-primary"></i>
              <div class="timeline-item">
                <div class="timeline-body">
                   <?php echo $cms->deskripsi?>
                </div>
              </div>
            </div>
        </div>

        <div class="time-label">
          <span class="bg-info">Progam</span>
        </div>
     
        <div>
          <i class="fa fa ion-pricetags bg-purple"></i>
          <div class="timeline-item">
            <span class="time"> 
              <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#modal-default" data-toggle="tooltip" title="Tambah Progam Bimbel"><i class="fas fa-plus"></i></button> 

            </span>
            <h3 class="timeline-header"><a href="#">Progam yang ada di tempat Bimbel</a></h3>
            <div class="timeline-body">
              <div class="row">
                @foreach ($progam as $progam)
                <div class="col-3">
                  <div class="container rounded shadow mb-3 pointer" style="background-color: #692A93; padding: 20px; width:100%; height:80%">
                      <img src="{{ url('public/gambar/'.$progam->logo) }}" alt="Avatar" class="images img img-responsive" style="width:100%">
                      <div class="middle">
                        <div class="text">
                         <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#edit-progam{{$progam->id}}"><i class="fas fa-pencil-alt"></i></button>
                         <a href="{{ url('delete_promosi/'.$progam->id) }}" class="btn btn-xs btn-danger" onclick="confirm('Yakin ingin menghapus Progam?')"><i class="fas fa-trash"></i></a>
                         
                        </div>
                      </div>
                    <P style="text-align: center; color: white; line-height:28px;">{{ $progam->name }}</P>
                  </div>
                </div>

                <div class="modal fade" id="edit-progam{{$progam->id}}" role="dialog">
                  <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header bg-info">
                        <h4 class="modal-title">Edit Progam</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  
                      <div class="modal-body">
                        @include('setting.edit_progam')
                      </div>
                    </div>
                  </div>
                </div>

                

                @endforeach
            </div>
          </div>
        </div>
    </div>
    </div>
