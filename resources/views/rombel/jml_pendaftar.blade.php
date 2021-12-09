@foreach ($all_tingkat as $item)
    <?php
        $tingkat1=$item->tingkat;
        $tingkat2=$tingkat;
        $tingkat12 = ($tingkat2==null ? $tingkat1 : $tingkat2);
    ?>

    <div class="col-md-4 col-sm-6 col-12" style="cursor: pointer;"  data-toggle="tooltip" data-placement="right" title="Siswa Pendaftar Baru">
        <a class="pilih_tingkat" tingkat="{{$tingkat12}}" style="color: black;">
            <div class="info-box shadow-none">
                <span class="info-box-icon {{$item->jenjang=='1' ? 'bg-maroon' : ($item->jenjang=='2' ? 'bg-blue' : 'bg-info')}}"><i class="fas fa-user-graduate"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pendaftar {{$item->nama}}</span>
                    <span class="info-box-number" id="jumlah{{$tingkat12}}">
                      @include('rombel.jml')
                    </span>
                </div>
            </div>
        </a>
    </div>
@endforeach
