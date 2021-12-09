@extends('layout.template')
@section('contens')<br>


<div class="card">
  <div class="card-header">
    <h3 class="card-title"><b>Kelola Mata Pelajaran</b></h3>
  </div>
        
  <div class="card-body">
   
  <div class="row">
    <div class="col-12 col-md-6 col-sm-6">
      <div class="card">
        <div class="card-header bg-maroon">
          <h3 class="card-title" style="font-size: 16px;"><b>Mapel SD</b></h3>
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead class="bg-dark" style="color:white; font-size:15px;">
                <tr align="center">
                  <th>#</th>
                  <th>Tingkat</th>
                  <th>Jumlah</th>
                  <th>status</th>
                  <th>Aksi</th>
                </tr> 
              </thead>
              
              <?php $num = 1;?> 
              <tbody style="font-size: 14px;">
                @foreach ($sd as $data)
                  <tr>
                    <td align="center">{{ $num++ }}</td>
                    <td>
                      {{ $data->nama }}
                    </td>
                    <td align="center">
                      <?php
                        $jum_sd = DB::table('mapel_kelas')
                        ->where('tingkat',$data->tingkat)
                        ->count();
                      ?>
                      {{ $jum_sd }}
                    </td>
                    <td align="center">
                      @if($data->status=='1')
                        <button class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;">Publish</button>
                        <button class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;">Unpublish</button>

                      @elseif($data->status=='0')
                        <button class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;">Unpublish</button>
                        <button" class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;" data-id="{{$data->id}}">Publish</button>
                      @endif   
                    </td>
                    <td align="center"><a href="mapel_kelas/{{$data->jenjang}}/{{$data->tingkat}}" class="btn btn-sm btn bg-navy" data-toggle="tooltip" data-placement="right" title="Kelola Mapel Tingkat" style="padding:5px !important; font-size:12px !important;">Kelola</a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


    <div class="col-12 col-md-6 col-sm-6">
      <div class="card">
        <div class="card-header bg-blue">
          <h3 class="card-title" style="font-size: 16px;"><b>Mapel SMP</b></h3>
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead class="bg-dark" style="color:white; font-size:15px;">
                <tr align="center">
                  <th>#</th>
                  <th>Tingkat</th>
                  <th>Jumlah</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr> 
            </thead>
            
            <?php $num = 1;  ?> 
            <tbody style="font-size:14px;">
              @foreach ($smp as $data)
                <tr>
                  <td align="center">{{ $num++ }}</td>
                  <td>
                    {{ $data->nama }}
                  </td>
                  <td align="center">
                    <?php
                      $jum_smp = DB::table('mapel_kelas')
                      ->where('tingkat',$data->tingkat)
                      ->count();
                    ?>
                    {{ $jum_smp }}
                  </td>
               
                 <td align="center">
                    @if($data->status=='1')
                      <button class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;">Publish</button>
                      <button class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;">Unpublish</button>

                    @elseif($data->status=='0')
                      <button class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;">Unpublish</button>
                      <button class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;" data-id="{{$data->id}}">Publish</button>
                    @endif   
                  </td>
                <td align="center"><a href="mapel_kelas/{{ $data->jenjang }}/{{ $data->tingkat }}" class="btn btn-sm btn bg-navy" data-toggle="tooltip" data-placement="right" title="Kelola Mapel Tingkat" style="padding:5px !important; font-size:12px !important;">Kelola</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    </div>
    </div>

    <div class="col-12 col-md-6 col-sm-6">
      <div class="card" style="height: 150px;">
        <div class="card-body">
          <div class="callout callout-info" style="font-size: 14px;">
            {{-- <h5>Kelola Mpael</h5> --}}

            <p>Pilih <b>Kelola</b> Untuk menambahkan Mapel disetiap tingkat</p>
            <p>Jika sudah pilih <b>Publish</b> untuk menampilkanya ke user</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-sm-6" style="margin-top: -160px;">
      <div class="card">
        <div class="card-header bg-info">
          <h3 class="card-title" style="font-size: 16px;"><b>Mapel SMA</b></h3>
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead class="bg-dark" style="color:white; font-size:15px;">
                <tr align="center">
                <th>#</th>
                <th>Tingkat</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
                </tr> 
              </thead>
              
              <?php $num = 1;  ?> 
              <tbody style="font-size: 14px;">
                @foreach ($sma as $data)
                  <tr>
                    <td align="center">{{ $num++ }}</td>
                    <td>
                      {{ $data->nama }}
                    </td>
                    <td align="center">
                      <?php
                        $jum_sma = DB::table('mapel_kelas')
                        ->where('tingkat',$data->tingkat)
                        ->count();
                      ?>
                      {{ $jum_sma }}
                    </td>
                    <td align="center">
                      @if($data->status=='1')
                        <button class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;">Publish</button>
                        <button class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;">Unpublish</button>

                      @elseif($data->status=='0')
                        <button class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id}}" data-id="{{$data->id}}" style="display: inline; padding:5px !important; font-size:12px !important;">Unpublish</button>
                        <button class="btn btn-success btn-sm aktif" id="aktif{{$data->id}}" style="display: none; padding:5px !important; font-size:12px !important;" data-id="{{$data->id}}">Publish</button>
                      @endif   
                    </td>
                    <td align="center"><a href="mapel_kelas/{{ $data->jenjang }}/{{ $data->tingkat }}" class="btn btn-sm btn bg-navy" data-toggle="tooltip" data-placement="right" title="Kelola Mapel Tingkat" style="padding:5px !important; font-size:12px !important;">Kelola</a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Tambah Mapel Kelas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>

          <div class="modal-body">
              <form action="{{ url('mapelkelas_store') }}" method="POST">
              @csrf
              <div class="form-group">

                  <input type="hidden" name="jenjang" value="<?php echo Request::segment(2);?>">
                  <input type="hidden" name="tingkat" value="<?php echo Request::segment(3);?>">
                  <?php 
                    $mapel = DB::table('tblmapel')
                    ->where('aktif','1')
                    ->whereNotIn('id_mapel',function($q){
                      $q->select('mapel')->from('mapel_kelas')
                      ->where('tingkat',9)
                      ->get();
                    })
                    ->get();
                  ?>
                  <select name="mapel_name" id="" class="form-control">
                      <option value="0">-Pilih Mapel-</option>
                      @foreach($mapel as $row)
                          <option value="{{ $row->id_mapel }}">{{ $row->nama }}</option>
                      @endforeach
                  </select><br>

                  <input type="number" name="harga" class="form-control" placeholder="harga mapel">

              </div>
              <button type="submit" class="btn btn-success">Simpan</button>
              </form>
          </div>
      </div>
    </div>
  </div>
</div>



<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="text/javascript">
        $('.aktif').click(function(){
            var tingkat = $(this).data('id');
            $.ajax({
                type : 'get',
              url : '{{URL::to('mapel_tingkat_non_aktif')}}',
                data: {tingkat:tingkat},
                success:function(data)
                {
                    // toastr.success('Berhasil  MeNonaktifkan Tingkat')
                    $('#aktif'+tingkat).hide();
                    $('#non_aktif'+tingkat).show();
                }
            });
        });
    
        $('.non_aktif').click(function(){
            var tingkat = $(this).data('id');
            $.ajax({
                type : 'get',
              url : '{{URL::to('mapel_tingkat_aktif')}}',
                data: {tingkat:tingkat},
                success:function(data)
                {
                    // toastr.success('Berhasil MengAktifkan Tingkat')
                    $('#aktif'+tingkat).show();
                    $('#non_aktif'+tingkat).hide();
                }
            });
        });
    
    </script>

@endsection


