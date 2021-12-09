<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Test||ZoomMeet </title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="/">ZoomMeet Data</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
     <!--  <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link"  href="/home">Home</a>
        </li>
       
      </ul> -->
    </div>
  </div>
</nav>
    <div class="container mt-4">
      
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Jadwal Tatap Muka</b></h3>
        </div>
              
        <div class="card-body">
          <div class="table-responsive" id="kls">
            <table id="example3" class="table table-striped">
              <thead class="bg-dark" style="color:white; font-size:15px;">
                  <tr align="center">
                  <th>#</th>
                  {{-- <th>Meeting id</th>
                  <th>Title</th> --}}
                  {{-- <th>Url</th> --}}
                  {{-- <th>Tanggal</th>
                  <th>Jam</th>
                  <th>Pengajar</th> --}}
                  <th>Aksi</th>
                  </tr> 
              </thead>
          
              <tbody style="font-size: 14px;">
                  @foreach ($jadwal as $num=>$data)
                      <tr>
                          <td>{{ $num+1 }}</td>
                          {{-- <td>{{ $data->meet_id }}</td>
                          <td>{{ $data->title }}</td> --}}
                          {{-- <td>{{ $data->url }}</td> --}}
                          {{-- <td>{{ $data->tanggal }}</td>
                          <td>
                              {{ $data->mulai }} - {{ $data->akhir}}
                          </td> --}}
                          <td>{{ $data->video }}</td>
                          <td align="center">
                          
                              <a href="{{ $data->video }}" class="btn btn-sm btn-primary" style="padding:5px !important; font-size:12px !important;"><i class="fas fa-eye-alt"></i>Stream</a>
                          </td>
                      </tr>

                  @endforeach
              </tbody>
          </table>
          </div>
        </div>
      </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    
  </body>
</html>