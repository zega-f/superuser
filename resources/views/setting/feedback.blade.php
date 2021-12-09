<link rel="stylesheet" href="{{ url('public/assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ url('public/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="{{ url('public/assets/plugins/select2/js/select2.full.min.js')}}"></script>

<div class="card direct-chat direct-chat-warning">
    <div class="card-header">
      <h3 class="card-title">Feedback</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modal-add" data-toggle="tooltip" title="Tambahkan Feedback Manual">Add Feedback</button>

      </div>
    </div>

  

    <div class="card-body"  style="height: 640px;">
        <div class="direct-chat-messages" style="height: 620px;">
            @foreach($testimoni as $testi)
                <?php 
                    $star_gold=$testi->star;
                    $star_outline=5-$testi->star;
                ?>
                <div class="card" style="padding: 12px; margin-top:3px;">
                    <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                          
                            <span class="direct-chat-name float-left">
                                @if($testi->anonymous=='on')
                                Anonymous
                                @else
                                {{ $testi->name }}
                                @endif
                            </span> &nbsp;
                           
                            <?php $feedback=$testi->feedback_id;?>
                            @if($testi->type==1) 
                                <span class="badge badge-success">
                                    <?php
                                    $room = DB::table('room')
                                    ->join('testimoni','room.room_id','=','testimoni.room_id')
                                    ->where('testimoni.type',1)
                                    ->where('testimoni.user_id',$testi->user_id)
                                    ->select('testimoni.*','room.room_id','room.room_name')
                                    ->first();
                                    ?>
                                    Kursus {{ $room->room_name }}
                                </span>
                            @endif
                            @if($testi->type==0) 
                                <span class="badge badge bg-maroon">
                                    <?php
                                    $kelas = DB::table('testimoni')
                                    ->join('kelas','kelas.id_kelas','=','testimoni.room_id')
                                    ->where('testimoni.type',0)
                                    ->where('testimoni.user_id',$testi->user_id)
                                    ->select('testimoni.*','kelas.tingkat','kelas.room_name')
                                    ->first();
                                    ?>
                                    Kelas {{ $kelas->tingkat }}{{ $kelas->room_name }}
                                </span>
                             @endif

                            <span class="direct-chat-timestamp float-right">{{ $testi->created_at }}</span><br>
                            <span class="direct-chat-name float-left">
                                <?php for ($i = 0; $i < $star_gold; $i++) { ?>
                                    <i class="ion-android-star" style="color:gold; font-size:18px;"></i>
                                <?php } ?>
                                <?php for ($j = 0; $j < $star_outline; $j++) { ?>
                                    <i class="ion-ios-star-outline text-warning" style=" font-size:18px;"></i>
                                <?php } ?>
                            </span>
                        </div>

                        <?php
                            $nama=$testi->name;
                            $nama2=substr($nama,0,1);

                            $nilai = (['maroon','success','primary','info','purple']); 
                            for($w = 0;$w <5;$w++){ // melakukan perulangan
                            $warna = $nilai[array_rand($nilai, 1)];
                            }
                        ?>
                        <div class="direct-chat-img bg-{{$warna}}">
                            <div style="font-weight:bold; margin-top:6px;"><center>{{$nama2}}</center></div></div>
                       
                        @if($testi->star==3 || $testi->star==4 || $testi->star==5)
                            <div class="direct-chat-text">
                                {{ $testi->testimoni }}
                            </div>
                        @else
                        <div class="direct-chat-text bg-warning">
                            {{ $testi->testimoni }}
                        </div>
                        @endif

                        <?php 
                        $testi_lampiran = DB::table('testimoni_lampiran')
                            // ->join('testimoni','testimoni_lampiran.feedback_id','=','testimoni.feedback_id')
                            ->where('testimoni_lampiran.feedback_id',$testi->feedback_id)
                        ->get();
                        ?>
                        
                        <div class="row">
                        @foreach ($testi_lampiran as $item)
                            @if($item->lampiran==null)
                            -
                            @else
                            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
                           
                                <span class="col-md-2"><img src="{{ url('public/testimoni/'.$item->lampiran) }}" class="img img-responsive img-rounded" style="width: 50px; float-left; margin-top:10%; padding:1 -10px;" onclick="document.getElementById('modal{{$item->id}}').style.display='block'"></span>
                            @endif

                            <div class="w3-container">
                                <div id="modal{{$item->id}}" class="w3-modal" onclick="this.style.display='none'">
                                    <span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
                                    <div class="w3-modal-content w3-animate-zoom">
                                      <img src="{{ url('public/testimoni/'.$item->lampiran) }}" style="width:70%">
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        </div>
                       

                        <div  class="icheck-success d-inline ml-2 float-right">

                            <input type="checkbox" value="{{ $testi->id }}"{{ ($testi->publish_status == 1 ? "checked='checked'" : 0) }} name="todo1" id="status{{ $testi->id }}" data-toggle="tooltip" title="Tandai Untuk ditampilkan di website">
                            <label for="status{{ $testi->id }}"></label>           
                         </div>

                         <script type="text/javascript">
                            $(document).ready(function(){
                              $("#status{{ $testi->id }}").click(function(){    
                              var val = $(this).val();
                                   if($(this).is(':checked')){
                                   $.ajax({ type: "get", 
                                   url: "{{ url('checklist_testi') }}", 
                                   data: {val:val,apply:'1'} 
                          
                                   });
                                   }
                                   else
                                   {
                                   $.ajax({ type: "get", 
                                   url: "{{ url('checklist_testi') }}", 
                                   data: {val:val,apply:'0'} 
                          
                                   });
                          
                                   }
                                });
                             });
                           </script>

                    </div>
                </div>
            @endforeach  
        </div>
    </div>
</div>


<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Feedback</h4>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
            
                <form action="{{ url('feedback_store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <?php
                            $users = DB::table('room_user')
                            ->join('users','users.partner_id','=','room_user.user_id')
                            ->where('status',1)
                            ->get();
                        ?>
            
                        <label>Users</label>
                        <select class="form-control select2" name="user" data-placeholder="Pilih Users" style="" required>
                            @foreach($users as $row)
                                <option value="{{ $row->user_id }}" style="height: 200px;">{{ ucfirst($row->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Feedback</label>
                        <textarea class="form-control" id="" name="feedback"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success simpan">Simpan</button>
                </form>
                  
            </div>
        </div>
      </div>
    </div>
</div>


<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
  
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    });
</script>

<script type="text/javascript">
    $(".simpan").click(function(){
            var id = $(this).attr('id');
            // var status = confirm('Yakin ingin menghapus?');
            if(status){
                $.ajax({
                    url: '{{URL::to('feedback_store')}}',
                    // type: 'get',
                    data: {id:id},
                    success: function(data){
                        $('#feedback').html(data);
                    }
                })
            }
        })
</script>


