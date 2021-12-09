<div class="invoice p-3 mb-3">
  <div class="row invoice-info">
    @foreach ($detail as $detail)
      
   
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
          {{-- <tr>
            <td><b>Jenjang</b></td><td><b>:</b></td>
            <td>{{ $detail->kelas }}</td>
          </tr> --}}
        </tbody>
      </table>
    </div>
    <div class="col-sm-4 invoice-col">

    </div>
    <div class="col-sm-4 invoice-col">
      <b>Pendaftaran Kursus</b><br>
      <small>{{ $detail->email }}</small><br>
      <small>{{ $detail->phone }}</small><br>
      <br>
      <b>Tanggal</b> {{ $detail->created_at }}<br>
    </div>
    @endforeach
  </div>
  <br>
  <span><b>Kursus yang di ikuti</b></span>
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>#</th>
          <th>Kursus</th>
          <th>Harga</th>
        </tr>
        </thead>
        <tbody>
          <?php $no=1;?>
          {{-- @foreach ($kursus as $item) --}}
            
        <tr>
          <td>{{$no++ }}</td>
          <td> {{ $kursus->room_name }}</td>
          <td>{{ number_format($kursus->biaya) }}</td>
        </tr>
        {{-- @endforeach --}}
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <p> 
       
        @if($bukti->bukti_pembayaran==NULL)
        <small class="lead">Belum Upload bukti pembayaran**</small>
        @else
          <img src="{{ url('public/bukti/'.$bukti->bukti_pembayaran) }}" width="360" class="img img-rounded"> 
      @endif
      </p>
    </div>
    <div class="col-6">
      {{-- <p class="lead">Amount Due 2/22/2014</p> --}}
      <div class="table-responsive">
        <table class="table">
          <tr>
            <th style="width:50%">Subtotal:</th>
            <td><b>Rp. {{ number_format($kursus->biaya)}}</b></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
