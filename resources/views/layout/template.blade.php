<!DOCTYPE html>
<html>
<head>
  <?php
    $cms = DB::table('cms')
    ->first();
  ?>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | {{ $cms->name }}</title>
  <link rel="icon" href="{{ url ('public/gambar/'.$cms->logo) }}" type="image/gif">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url ('public/assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url ('public/assets/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url ('public/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.1/css/all.min.css">
  <link rel="stylesheet" href="{{ url ('public/assets/plugins/toastr/toastr.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ url ('public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}"> 
  <link rel="stylesheet" href="{{ url ('public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ url ('public/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>


  <script>
    var pusher = new Pusher('b931337da2f27b477473', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('admin_notifications');
    channel.bind('App\\Events\\NewRegistered', function(data) {
      if(data.response=='200_new') {
        console.log('pendaftar_baru_Reguler');
        alert('Pendaftar Baru Reguler');
        $.ajax({
          url: '{{URL::to('notif_new_pendaftar')}}',
          type: 'get',
          success: function(data){
            $('#notif').html(data);
          }
        })
      }

      if(data.response=='200_kursus') {
        console.log('pendaftar_baru_kursus');
        alert('Pendaftar Baru Kursus');
        $.ajax({
          url: '{{URL::to('notif_new_pendaftar')}}',
          type: 'get',
          success: function(data){
            $('#notif').html(data);
          }
        })
      }

      if(data.response=='200_testi') {
        console.log('New_Feedback');
        alert('New Feedback');
        $.ajax({
          url: '{{URL::to('notif_testi')}}',
          type: 'get',
          success: function(data){
            $('#notif').html(data);
          }
        })
      }
    });
  </script>


{{-- <script type="text/javascript">
  window.history.forward();
  function noBack()
  {
      window.history.forward();
  }
</script> --}}
{{--  --}}
</head>

<div class="modal rounded" id="modal" style="position: absolute;">
  <div class="rounded" style="padding: 20px; background-color: white;">Sedang Memproses</div>      
</div>

{{-- {
  "response": "200_new"
} --}}


<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" onLoad="noBack();" onpageshow="if (event.persisted) noBack();">
  <div class="wrapper">
    <?php
      $cms = DB::table('cms')
      ->first();
    ?>

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{ url ('public/gambar/'.$cms->logo) }}" height="60" width="60">
      <p>loading...</p>
    </div>
  
    <!-- Navbar --><!-- Left navbar links -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ url('info') }}" class="nav-link" data-toggle="tooltip" title="Petunjuk Pengoperasian Aplikasi"><i class="fas fa-info-circle"></i> Petunjuk</a>
        </li>
      </ul>
  
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown" id="notif"data-toggle="tooltip" title="Notifikasi">
          @include('layout.notif')
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button" data-toggle="tooltip" title="Full Screen Mode">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>

       

        {{-- control --}}
        {{-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li> --}}

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container Logo -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <?php
        $cms = DB::table('cms')
        ->first();
      ?>

      <a href="#" class="brand-link" data-toggle="tooltip" title="Nama Bimbel"> <!-- Brand Logo -->
        <img src="{{ url ('public/gambar/'.$cms->logo) }}" class="brand-image" style="margin-top:5px;">
        <span class="brand-text font-weight-light">{{ $cms->name }}</span>
      </a>
  
      <!-- Sidebar Samping-->
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ url ('public/assets/dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="{{ url('profile/'.Session::get('admin_id')) }}" class="d-block" data-toggle="tooltip" title="Admin Online">
              {{Session::get('email')}}
            </a>
            <span>
              <diV class="row mt-2">
                <div class="col-6">
                  <a href="{{ url('profile/'.Session::get('admin_id')) }}" class="btn btn-primary btn-xs btn-block ion-android-settings" data-toggle="tooltip" title="Setting Profile dan Password"> Profile</a>
                </div>
                <div class="col-6">
                  <a href="{{ url('logout') }}" onclick="return confirm('Apakah anda yakin ingin Keluar dari sistem?')" class="btn btn-danger btn-xs btn-block ion-power" data-toggle="tooltip" title="Keluar dari Sistem"> Logout</a>
                </div>
              </diV>
            </span>
          </div>
        </div>
  
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">General</li>
            <li class="nav-item">
              <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Halaman Depan">
                <i class="nav-icon fas fa-th"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link {{ Request::segment(1) == 'pengajar' ? 'active' : ( Request::segment(1) == 'data_admin' ? 'active' : ( Request::segment(1) == 'data_admin' ? 'active' : ''))  }}" data-toggle="tooltip" data-placement="right" title="Data Pengguna Aplikasi">
                <i class="nav-icon fas fa-user-alt"></i>
                <p>
                  Data Pengguna
                  <i class="right fas fa-angle-left "></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item container">
                  <a href="{{ url('/pengajar') }}" class="nav-link {{ Request::segment(1) == 'pengajar' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Data Pengajar">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Pengajar</p>
                  </a>
                </li>
    
                <li class="nav-item container">
                  <a href="{{ url('/data_admin') }}" class="nav-link {{ Request::segment(1) == 'data_admin' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Data Admin">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Admin</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="{{ url('/partnership') }}" class="nav-link {{ Request::segment(1) == 'partnership' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Data Partnertship">
                <i class="fas fa-handshake nav-icon"></i>
                <p>Partnership</p>
              </a>
            </li>

            <li class="nav-header">Akademik</li>
            <li class="nav-item">
              <a href="#" class="nav-link {{ Request::segment(1) == 'pembayaran' ? 'active' : ( Request::segment(1) == 'data_siswa' ? 'active' : ( Request::segment(1) == 'data_siswa' ? 'active' : ''))  }}" data-toggle="tooltip" data-placement="right" title="Data Siswa Bimbel">
                <i class="nav-icon fas fa-user-graduate"></i>
                <p>
                  Siswa Bimbel
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item container">
                  <a href="{{ url('/data_siswa') }}" class="nav-link {{ Request::segment(1) == 'data_siswa' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Data Siswa Yang sudah terdaftar">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Siswa</p>
                  </a>
                </li>

                <li class="nav-item container">
                  <a href="{{ url('/pembayaran') }}" class="nav-link {{ Request::segment(1) == 'pembayaran' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Data Siswa Baru, Perlu dikonfirmasi oleh Admin">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      Pendaftar Baru
                    </p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item">
              <a href="#" class="nav-link {{ Request::segment(1) == 'kelola_mapel' ? 'active' : ( Request::segment(1) == 'kelola_kelas' ? 'active' : ( Request::segment(1) == 'jadwal_pelajaran' ? 'active' : ( Request::segment(1) == 'rombel' ? 'active' : '')))  }}" data-toggle="tooltip" data-placement="right" title="Mengelola Akademik Bimbel">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Akademik 
                  <i class="right fas fa-angle-left right"></i>
                  <?php  
                    $kelas=DB::table('kelas')
                    ->count();
                    $mapel_kelas=DB::table('mapel_kelas')
                    ->count();
                  ?>
                    @if($kelas <=0)
                      <span class="ion-alert-circled right" style="color: orange;"></span>
                    @elseif($mapel_kelas <=0)
                      <span class="ion-alert-circled right" style="color: orange;"></span>
                    @else

                    @endif
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item container">
                  <a href="{{ url('/kelola_mapel') }}" class="nav-link {{ Request::segment(1) == 'kelola_mapel' ? 'active' : ''
                    }}" data-toggle="tooltip" data-placement="right" title="Mengelola Mapel & Materi setiap Tingkat Kelas">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kelola Tingkat</p>
                    @if($mapel_kelas <=0)
                      <span class="right badge badge-danger">add mapel</span>
                    @else

                    @endif
                  </a>
                </li>

                <li class="nav-item container">
                  <a href="{{ url('/rombel') }}" class="nav-link {{ Request::segment(1) == 'rombel' ? 'active' :  ''
                   }}" data-toggle="tooltip" data-placement="right" title="Mengelola Rombongan Belajar Siswa">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rombongan belajar</p>
                  </a>
                </li>

                <li class="nav-item container">
                  <a href="{{ url('/kelas') }}" class="nav-link {{ Request::segment(1) == 'kelas' ? 'active' :  ''
                   }}" data-toggle="tooltip" data-placement="right" title="Mengelola Jadwal Kelas">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kelola Kelas</p>
                    @if($kelas <=0)
                      <span class="right badge badge-danger">kosong</span>
                    @else 

                    @endif
                  </a>
                </li>
            
                <li class="nav-item container">
                  <a href="{{ url('/jadwal_pelajaran') }}" class="nav-link {{ Request::segment(1) == 'data_siswa' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Data Jadwal Pembelajaran">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Jadwal</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item">
              <a href="{{ url('/kursus') }}" class="nav-link {{ Request::segment(1) == 'kursus' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Mengelola Kursus">
                <i class="fas fa-book nav-icon"></i>
                <p>Kursus Keahlian</p>
                <?php  
                  $room=DB::table('room')
                  ->count();
                ?>
                @if($room <=0)
                  <span class="ion-alert-circled right" style="color: orange;"></span>
                @else

                @endif
              </a>
            </li>

            <li class="nav-header">Master Data</li>
            <li class="nav-item">
              <a href="#" class="nav-link {{ Request::segment(1) == 'mapel' ? 'active' : ( Request::segment(1) == 'mapel' ? 'active' : ( Request::segment(1) == 'set_jam' ? 'active' : ''))  }}" data-toggle="tooltip" data-placement="right" title="Mengelola Master Data Aplikasi">
                <i class="nav-icon fas fa-database"></i>
                <p>
                  Data Master
                  <i class="right fas fa-angle-left"></i>
                  <?php  
                    $mapel=DB::table('tblmapel')
                    ->count();
                  ?>
                  @if($mapel <=0)
                    <span class="ion-alert-circled right" style="color: orange;"></span>
                  @else

                  @endif
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item container">
                  <a href="{{ url('/mapel') }}" class="nav-link {{ Request::segment(1) == 'mapel' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Data Mapel Yang Tersedia di Bimbel">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Mapel</p>
                    <?php  
                      $mapel=DB::table('tblmapel')
                      ->count();
                    ?>
                    @if($mapel <=0)
                      <span class="right badge badge-danger">kosong</span>
                    @else
    
                     @endif
                  </a>
                </li>
    
                <li class="nav-item container">
                  <a href="{{ url('/set_jam') }}" class="nav-link {{ Request::segment(1) == 'set_jam' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Mengatur Jam Pembelajaran Bimbel">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Setting Jam</p>
                  </a>
                </li>
              </ul>
            </li>

            

            <li class="nav-item">
              <a href="#" class="nav-link {{ Request::segment(1) == 'setting_cms' ? 'active' : ( Request::segment(1) == 'faq' ? 'active' : ( Request::segment(1) == 'faq' ? 'active' : ''))  }}" data-toggle="tooltip" data-placement="right" data-toggle="tooltip" data-placement="right" title="Setting Aplikasi">
                <i class="nav-icon fas fa-wrench"></i>
                <p>
                  Settings
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item container">
                  <a href="{{ url('/setting_cms') }}" class="nav-link {{ Request::segment(1) == 'setting_cms' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Mengatur Profile Bimbel">
                    <i class="far fa-circle nav-icon"></i>
                    <p>CMS</p>
                  </a>
                </li>
    
                <li class="nav-item container">
                  <a href="{{ url('/faq') }}" class="nav-link {{ Request::segment(1) == 'faq' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Informasi Yang Sering Ditanyakan">
                    <i class="far fa-circle nav-icon"></i>
                    <p>FAQ</p>
                  </a>
                </li>

                <li class="nav-item container">
                  <a href="{{ url('/artikel') }}" class="nav-link {{ Request::segment(1) == 'feedback' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Mengelola Artikel Webite Bimbel">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Artikel</p>
                  </a>
                </li>
              </ul>
            </li><br><br>

            {{-- <li class="nav-item">
              <a href="{{ url('logout') }}" class="nav-link" data-toggle="tooltip" data-placement="right" title="Keluar dari Sistem Aplikasi">
                <i class="nav-icon fas fa-power-off" style="color:red;"></i>
                <p>Logout</p>
              </a>
            </li> --}}
          </ul>
        </nav>
      </div>
    </aside>
  
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   
    {{-- Tampilan --}}
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          @yield('contens')
        </div>  
      </section>
    </div>

    <div class="modal fade" id="notif_feedback">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Feedback</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @include('layout.new_feedback')
          </div>
          <div class="modal-footer justify-content-between">
            <a href="setting_cms/#feedback" class="btn btn-default" style="padding:px !important; font-size:14px !important;">Tampilkan lebih banyak</a>
            <a href="" class="btn btn-primary" style="padding:6px !important; font-size:14px !important;">Refresh</a>
          </div>
        </div>
      </div>
    </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer" style="font-size: 12px;">
      <strong>Copyright &copy; 2021 <a href="#">{{ $cms->name }}</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0
      </div>
    </footer>
  </div>

   <!-- jQuery UI 1.11.4 -->
   <script src="{{ url ('public/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
   <script src="{{ url ('public/assets/plugins/jquery/jquery.min.js') }}"></script>

   <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

   <!-- Bootstrap 4 -->
   <script src="{{ url ('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ url ('public/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ url ('public/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url ('public/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url ('public/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url ('public/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url ('public/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ url ('public/assets/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url ('public/assets/dist/js/demo.js') }}"></script>
    <script>
      $(function () {
      $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });

      $('#example3').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });

      $('#example4').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      }); 
    });
    </script>
  </body>
</html>


