<?php
$kursus = DB::table('room')
->where('room_id',$data->room_id)
->first();
?>

{{-- @foreach ($kursus as $kursus) --}}
<div class="col-12 col-md-12">
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h5 class="d-inline-block d-sm-none">{{ $kursus->room_name }}</h5>
                    <div class="col-12">
                        <img src="{{ url('public/all_mapel_icon/'.$kursus->icon) }}" class="product-image img omg-responsive"  alt="Product Image">
                    </div>

                    <div class="col-12 product-image-thumbs mt-0">
                        <div class="bg-teal py-2 px-3 mt-0" style="border-radius:8px; 8px;">
                            <h5 class="mb-0">Rp. {{ number_format($kursus->biaya) }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <h4 class="my-3">
                        {{ $kursus->room_name }}<br>  
                        <small style="font-size:14px; color:grey">
                            <i class="fas fa-star fa-xs" style="color: gold;"></i> 
                            <b>
                                <?php
                                $rate = DB::table('testimoni')
                                ->where('room_id', $kursus->room_id)
                                ->avg('star');
                                ?>
                                {{ $rate }}
                            </b>&nbsp; &nbsp;
                            <i class="fas fa-user" style="font-size:12px;"></i>
                            <?php  
                            $jmlsiswa=DB::table('room_user')
                            ->where('room_id', $kursus->room_id)
                            ->groupBy('room_id')
                            ->count();
                        ?>
                        {{ $jmlsiswa }} Participant
                        </small>
                    </h4>
           
                    <p>{{ $kursus->description }}</p>
    
                    
                    <div class="mt-4 product-share">
                        {{-- @if($kursus->locked=='1')
                            <a href="#" class="btn btn-success btn-sm aktif" id="aktif{{$kursus->room_id}}" data-id="{{$kursus->room_id}}" style="display: inline;">Aktif</a>
                            <a href="#" class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$kursus->room_id}}" data-id="{{$kursus->room_id}}" style="display: none;">Non-aktif</a>
        
                        @elseif($kursus->locked=='0')
                            <a href="#" class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$kursus->room_id}}" data-id="{{$kursus->room_id}}" style="display: inline;">Non-aktif</a>
                            <a href="#" class="btn btn-success btn-sm aktif" id="aktif{{$kursus->room_id}}" style="display: none;" data-id="{{$kursus->room_id}}">Aktif</a>
                        @endif --}}

                        <a href="{{ url('kelola_kursus/'.$kursus->room_id) }}" class="btn btn-sm btn-primary">Kelola</a>
                        {{-- <a class="btn btn-info btn-sm" id="edit_kursus" data-toggle="modal" data-target="#modal-edit{{ $kursus->id }}"><i class="fas fa-solid fa-pencil-alt"></i></a>
                        <button class="btn btn-danger btn-sm btn_hapus" data-toggle="tooltip" data-placement="bottom" title="Hapus Kelas" id="{{ $kursus->room_id }}"><i class="fa fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit{{$kursus->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Kursus</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
  
            <div class="modal-body">
                {{-- @include('kursus.edit_kursus') --}}
            </div>
        </div>
    </div>
</div>

    
{{-- @endforeach --}}



<script type="text/javascript">
    $('.aktif').click(function() {
        var room_id = $(this).data('id');
        $.ajax({
            type : 'get',
            url  : '{{URL::to('kursus_non_aktif')}}',
            data : {room_id:room_id},
            success:function(data)
            {
                $('#aktif'+room_id).hide();
                $('#non_aktif'+room_id).show();
            }
        });
    });
    
    $('.non_aktif').click(function() {
        var room_id = $(this).data('id');
        $.ajax({
            type : 'get',
            url  : '{{URL::to('kursus_aktif')}}',
            data : {room_id:room_id},
            success:function(data)
            {
                $('#aktif'+room_id).show();
                $('#non_aktif'+room_id).hide();
            }
        });
    });
</script>



    

<script type="text/javascript">
    $(".btn_hapus").click(function(){
        var room_id = $(this).attr('id');
        var status = confirm('Yakin ingin menghapus?');
        if(status){
            $.ajax({
                url: '{{URL::to('del_kursus')}}',
                type: 'get',
                data: {room_id:room_id},
                success: function(data){
                    $('#kursus').html(data);
                }
            })
        }
    })
</script>
