<div class="invoice p-3 mb-3">
  <div class="row invoice-info">
  {{-- @foreach ($detail as $detail) --}}
      
   
    <div class="col-sm-4 invoice-col">
      <table>
        <tbody>
          <tr>
            <td><b>Nama Lengkap</b></td><td><b>:</b></td>
            <td> {{ $detail->siswa }}</td>
          </tr>
          <tr>
            <td><b>Jenis Kelamin</b></td><td><b>:</b></td>
            <td> 
                @if($detail->jenis_kelamin=='L')
                Laki-Laki
                @else
                Perempuan
                @endif
            </td>
          </tr>
          <tr>
            <td><b>Alamat</b></td><td><b>:</b></td>
            <td>{{ $detail->address }}</td>
          </tr>
          <tr>
            <td><b>Jenjang</b></td><td><b>:</b></td>
            <td>{{ $detail->kelas }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-sm-4 invoice-col">

    </div>

    <div class="col-sm-4 invoice-col">
      <b>Pendaftaran Bimbel</b><br>
      <small>{{ $detail->email }}</small><br>
      <small>{{ $detail->phone }}</small><br>
      <br>
      <b>Tanggal</b> <?php echo $detail->created_at ?><br>
    </div>
  {{-- @endforeach --}}
  </div>

  <br>
  <span><b>Mata Pelajaran yang diambil</b></span>
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>#</th>
          <th>Mapel</th>
          <th>Harga</th>
        </tr>
        </thead>
        <tbody>
          <?php $no=1;?>
          @foreach ($mapel_user as $item)
            
        <tr>
          <td>{{$no++ }}</td>
          <td> {{ $item->mapel }}</td>
          <td>{{ number_format($item->harga) }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <span></span>
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped">
        <tr>
         
          <td><b>Registrasi Kelas {{ $detail->kelas }}</b></td>
          <td align="left">
            @if($detail->register_id == $bukti->register_id)
              {{ number_format($kelas->registrasi) }}
            @else
              Sudah Lunas
            @endif
          </td>
         
        </tr>
      
      </table>
    </div>
  </div>


  <div class="row">
    <div class="col-6">
      <div class="table-responsive">
        <table class="table">
          <tr></tr>
        </table>
      </div>
    </div>
    <div class="col-6">
      {{-- <p class="lead">Amount Due 2/22/2014</p> --}}
      <div class="table-responsive">
        <table class="table">
          <tr>
            <th style="width:50%">Subtotal:</th>
            <td>
              @if($detail->register_id == $bukti->register_id)
                <b>Rp. {{ number_format($sum_mapel + $kelas->registrasi)}}</b>
              @else
              <b>Rp. {{ number_format($sum_mapel)}}</b>
              @endif
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="col-12">
    <p> 
     
      @if($bukti->bukti_pembayaran==NULL)
      <small class="lead">Belum Upload bukti pembayaran**</small>
      @else
        <img src="{{ url('public/bukti/'.$bukti->bukti_pembayaran) }}" width="100%" class="img img-rounded"> 
    @endif
    </p>
  </div>

</div>
</div>
