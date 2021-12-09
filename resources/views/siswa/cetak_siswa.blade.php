<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
  </head>

  <body onload="window.print()">
    <div class="kertas">
      <div class="judul-report">
        <h1>DATA SISWA REGULER {{ $nm_tingkat->nama }}</h1>
      </div>

      <table class="tablebordered" style="margin-top:20px;">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Asal Sekolah</th>
            <th>Handphone</th>
          </tr>
        </thead>

        <tbody>
          <?php $num = 1; ?> 
          @foreach ($siswa as $data)
            <tr>
              <td align="center">{{ $num++ }}</td>
              <td>{{ $data->name }} </td>
              <td> 
                @if($data->jenis_kelamin=='L')
                  Laki-Laki
                @else
                  Perempuan
                @endif
              </td>
              <td>{{ $data->alamat }}</td>
              <td>
                <?php
                  $asal_sekolah = DB::table('room_user')
                    ->join('users', 'users.partner_id', '=', 'room_user.user_id')
                    ->where('room_user.user_id',$data->user_id)
                    ->select('room_user.*')
                    ->orderBy('school_name','desc')
                    ->first();
                ?>
                {{ $asal_sekolah->school_name }}
              </td>
              <td>{{ $data->phone }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  

    <style>
      @page {
        /* width = 21cm */
        size: 8.5in 12.99in;
        margin: 1cm 1cm 0.5cm;

      }
      @media print{
        table{
          width: 19cm;
        }

      }
      .kertas{
        width: 100%;
        margin: 0 auto;
        font-family: Source Sans Pro,Helvetica Neue,Helvetica,Arial,sans-serif;
      }

      .kertas.ganti-halaman{
        page-break-before: always;
      }
              
      .kop-surat img{
        width:100%;
      }
      table{
        width: 100%;
      }

      .tablebordered {border-collapse:collapse; font-size:10pt}
      .tablebordered th { color:#000; vertical-align:middle; font-weight:regular;}
      .tablebordered td, .tablebordered th { padding:3px;border:0.5px solid #000; }
      table tr td{
        padding: 1px 0;
        vertical-align: top;
        text-align: left;
      }
      table tr th{
        padding: 3px 0;
        vertical-align: top;
        text-align: center;
      }
      table tr td.label{
        width: 30%;
      }
      table tr td.label + td{
        width: 1%;
      }
      table tr td.label + td + td{
        width: 69%;
      }
      table.formulir{
        margin-bottom: 20px;
      }
      .judul-report{
        text-align: center;
        position: relative;
        margin-top: 10px;
      }
      .nomor-surat{
        margin:0;
      }
      .judul-report h1{
        font-size: 12pt;
        display: inline;
        padding: 0 5px;
        margin-bottom:0;
        margin-top: 5px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        line-height: 11pt;
      }
      .tingkat-surat{
        position: absolute;
        top: 13px;
        left: 0;
        font-size: 14pt;
        font-weight: bold;
        padding: 2px 5px;
      
      }
      .pengembalian-surat{
        position: absolute;
        top: 142px;
        right: 0;
        font-size: 10pt;
        padding: 0px 5px;
        width:235px;
        border: 1px solid #dd4b39;
      }
      h3{
        font-weight:regular;
        text-align: center;
        font-size: 11pt;
        margin:0 0 3px;
        line-height: 11pt;
      }
      .blank{
        margin-top:40px;
      }
      .lm-20{
        margin-left: 20px;
      }
      .lwidth{
        width:140px;
      }
      .tgl-surat{
        text-align: right;
        padding-right: 40px;
      }
      .tanda-tangan{
        margin-bottom: 10px;
      }

      .tanda-tangan tr td{
        vertical-align: bottom;
        text-align: center;
        padding: 0;
      }
      .tanda-tangan tr:first-child td{
        vertical-align: top;
        height:  62px;
      }
      .garis-nama{
        padding: 0 5px 0;
        text-align:center;
        display: inline;
        border-bottom: 1px solid #000;
        min-width: 100px;
      }
      .catatan{
        font-style: italic;
        margin-top: 10px;
        font-size: 10pt;
      }
      table.col-2 tr td{
        width: 50%;
      }
      table.col-4 tr td{
        width: 25%;
      }
      p{
        margin:5px 0;
        text-align: justify;
      }
    </style>

  </body>
</html>
