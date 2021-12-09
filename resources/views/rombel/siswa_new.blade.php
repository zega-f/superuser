<div class="col-xl-6 col-lg-6 col-md-6">
    <div class="card mb-3 shadow-sm border-light">
        <div class="card-header" style="background-color: grey;">
            <strong style="color:white;">Data Pendaftar {{ $namatingkat }}{{ $namakelas }} </strong>

            <strong class="float-right" style="color: white;">
                @if($inactive_status==0)
                -
                @else
                <div class="btn-group float-right">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"  data-toggle="tooltip" data-placement="right" title="Daftar Kelas">
                      <span class="">Kelas<i class=""></i></span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="background-color: black;">
                       
                        @if(count($room)<=0)
                            <a class="dropdown-item bg-navy btn btn-sm btn-default">belum ada kelas</a>
                        @else
                        @foreach ($room as $item)
                            <a href="#" class="dropdown-item bg-navy pilih_kelas" id_kelas="{{$item->id_kelas}}" tingkat="{{$item->tingkat}}">Room {{ $item->tingkat }}{{ $item->room_name }}</a>
                        @endforeach
                        @endif
                    </div>
                </div>
                @endif
            </strong>
        </div>
        <div class="card-body" style="overflow: auto;">
            <div id="siswa_inaktif">
                @include('rombel.tabel_siswa_inactive')
            </div>
        </div>
    </div>
</div>




<div class="col-xl-6 col-lg-6 col-md-6">
    <div class="card mb-3 shadow-sm border-light">
        <div class="card-header bg-success">
            <strong style="color:white;">Data Siswa Aktif </strong>
            <strong>
                {{ $namatingkat }}{{ $namakelas }}
            </strong>
        </div>
        <div class="card-body" style="overflow: auto;">
            <div id="siswa_aktif">
                @include('rombel.tabel_siswa_active')
            </div>
        </div>
    </div>         
</div>




<script type="text/javascript">
    $(".pilih_kelas").click(function(){
        var id_kelas = $(this).attr('id_kelas');
        var tingkat = $(this).attr('tingkat');
        $.ajax({
            url: '{{URL::to('pilih_kelas')}}',
            type: 'get',
            data: {id_kelas:id_kelas,tingkat:tingkat},
            success: function(data) {
                $('#siswa_new').html(data);
            }
        })
    })
</script>







