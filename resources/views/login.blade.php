<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Login | Admin</title>
 
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <link rel="stylesheet" href="{{ url('public/assets/plugins/fontawesome-free/css/all.min.css') }}">
   <link rel="stylesheet" href="{{ url('public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
   <link rel="stylesheet" href="{{ url('public/assets/dist/css/adminlte.min.css')}}">
 </head>

 <body class="hold-transition login-page">
 <div class="login-box">
   <div class="card card-outline card-primary">
     <div class="card-header text-center">
       <a href="#" class="h2"><b>Admin</b>Login</a>
     </div>
     <div class="card-body">
       <p class="login-box-msg">Sign in to start your session</p>
       
 
       <form action="{{ url('login_post') }}" method="post">

        {{-- <div class="card-header">
            <h3 class="text-center">Form Login</h3>
        </div>
        <form action="{{ url('login_post') }}" method="post"> --}}
        @csrf
        {{-- <div class="card-body"> --}}
          @if ($message = Session::get('fail'))
          <div class="alert alert-danger alert-sm" id="alert">
              <p>{{ $message }}</p>
          </div>
          @endif
          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-sm" id="alert">
              <p>{{ $message }}</p>
          </div>
          @endif

         <div class="input-group mb-3">
           <input type="email" name="email" class="form-control" placeholder="Email">
           <div class="input-group-append">
             <div class="input-group-text">
               <span class="fas fa-envelope"></span>
             </div>
           </div>
         </div>

         <div class="input-group mb-3">
           <input type="password" name="password" class="form-control" placeholder="Password">
           <div class="input-group-append">
             <div class="input-group-text">
               <span class="fas fa-lock"></span>
             </div>
           </div>
         </div><br>

         <div class="row">
           {{-- <div class="col-8">
             <div class="icheck-primary">
               <input type="checkbox" id="remember">
               <label for="remember">
                 Remember Me
               </label>
             </div>
           </div> --}}
           <!-- /.col -->
           <div class="col-12">
             <button type="submit" class="btn btn-primary btn-block">Login</button>
           </div>
           <!-- /.col -->
         </div>
       </form><br>
 
       {{-- <div class="social-auth-links text-center mt-2 mb-3">
         <a href="#" class="btn btn-block btn-primary">
           <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
         </a>
         <a href="#" class="btn btn-block btn-danger">
           <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
         </a>
       </div> --}}
       <!-- /.social-auth-links -->
 
       <p class="mb-1">
         <a href="{{ url('lupa_password') }}">Lupa password</a>
       </p>
       {{-- <p class="mb-0">
         <a href="register.html" class="text-center">Register a new membership</a>
       </p> --}}
     </div>
     <!-- /.card-body -->
   </div>
   <!-- /.card -->
 </div>
 <!-- /.login-box -->
 
 <!-- jQuery -->
 <script src="{{ url('public/assets/plugins/jquery/jquery.min.js')}}"></script>
 <!-- Bootstrap 4 -->
 <script src="{{ url('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
 <!-- AdminLTE App -->
 <script src="{{ url('public/assets/dist/js/adminlte.min.js')}}"></script>
 </body>
 </html>
 