<link rel="stylesheet" href="{{ url('public/assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ url('public/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="{{ url('public/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<?php
     $testimoni = DB::table('testimoni')
        ->join('users','users.partner_id','=','testimoni.user_id')
        ->select('testimoni.*', 'users.name')
        ->where('testimoni.read_status',0)
        // ->orderBy('testimoni.read_status','desc')
        ->orderBy('testimoni.created_at','asc')
        ->limit(5)
        ->get();
?>

    <div class="direct-chat-messages" style="height: 400px;">
        @foreach($testimoni as $testi)
            <?php 
                $star_gold=$testi->star;
                $star_outline=5-$testi->star;
            ?>

            <div class="card" style="padding: 12px; margin-top:3px; height:130px;">
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
                            <div class="direct-chat-text" style="font-size: 14px;">
                                {{ $testi->testimoni }}
                            </div>
                        @else
                        <div class="direct-chat-text bg-warning" style="font-size: 14px;">
                            {{ $testi->testimoni }}
                        </div>
                        @endif

                       
                       

                        <div  class="icheck-success d-inline ml-2 float-right">
                            <input type="checkbox" value="{{ $testi->id }}"{{ ($testi->read_status == 1 ? "checked='checked'" : 0) }} name="todo1" id="read_status{{ $testi->id }}" data-toggle="tooltip" title="Tandai Sudah dibaca">
                            <label for="read_status{{ $testi->id }}"></label>           
                        </div>

                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#read_status{{ $testi->id }}").click(function(){    
                                var val = $(this).val();
                                    if($(this).is(':checked')){ 
                                        $.ajax({ type: "get", 
                                            url: "{{ url('checklist_read_testi') }}", 
                                            data: {val:val,apply:'1'} 
                                        });

                                    } else {
                                        $.ajax({ type: "get", 
                                            url: "{{ url('checklist_read_testi') }}", 
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


