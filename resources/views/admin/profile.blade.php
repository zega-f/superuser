@extends('layout.template')
@section('contens')<br>

<div class="row">
    <div class="col-md-5">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title">Profile</h5>
            </div>  

            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ url('public/assets/dist/img/avatar5.png')}}"
                        alt="User profile picture">
                </div>

                @foreach ($profile as $item)
                @endforeach<br>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                    <b>Nama</b> <a class="float-right">{{ $item->name }}</a>
                    </li>
                    <li class="list-group-item">
                    <b>Email</b> <a class="float-right">{{ $item->email }}</a>
                    </li>
                    <li class="list-group-item">
                    <b>Level</b> <a class="float-right">{{ $item->level }}</a>
                    </li>
                </ul>

                <a class="btn btn-primary btn-small float-right" id="edit_profil" data-toggle="modal" data-target="#modal-edit" data-name="{{ $item->name }}" data-email="{{ $item->email}}" data-id_admin="{{ $item->id }}" data-toggle="tooltip" title="Edit Profile Admin" style="display: inline; padding:5px !important; font-size:14px !important;">Edit Profile</a>
            </div>
        </div>
    </div>


    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Password</h5>
            </div>
     
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-xs alert-dismissible" style="height: 50%;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5 style="font-size: 15px;"><i class="icon fas fa-ban"></i> Alert!</h5>
                        <p style="font-size: 13px;">{{ session('error') }}</p>
                    </div>

                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-xs alert-dismissible" style="height: 50%;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5 style="font-size: 15px;"><i class="icon fas fa-check"></i> Alert!</h5>
                        <p style="font-size: 13px;">{{ session('success') }}</p>
                    </div>
                @endif

                <form class="form-horizontal" method="POST" action="{{ url('change_password') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ Session::get('admin_id') }}">
                    <div class="form-group{{ $errors->has('password_old') ? ' has-error' : '' }}">
                        <label for="password_old" class="col-md-4 control-label">Password Lama</label>
                        <div class="col-md-12">
                            <input id="password_old" type="password" class="form-control" name="password_old" required>
                            @if ($errors->has('password_old'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_old') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
     
                    <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                        <label for="new_password" class="col-md-4 control-label">Password Baru</label>
                        <div class="col-md-12">
                            <input id="new_password" type="password" class="form-control" name="new_password" required>
                            @if ($errors->has('new_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('new_password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

     
                    <div class="form-group">
                        <label for="new_password_confirm" class="col-md-4 control-label">Konfirmasi Password</label>
                        <div class="col-md-12">
                            <input id="new_password_confirm" type="password" class="form-control" name="new_password_confirm" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <div class="col-md-12 col-md-offset-4">
                            <button type="submit" class="btn btn-primary float-right" data-toggle="tooltip" title="Ganti Password Akun ini" style="display: inline; padding:5px !important; font-size:14px !important;">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>




    <div class="modal fade" id="modal-edit" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('update_profil/'.$item->id)}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="hidden" name="id" id="id_admin" class="form-control">
                            <input type="text" name="name" id="name" class="form-control"><br>
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control"><br>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(Session::has('update_profil')) 
            toastr.success("{{ Session::get('update_profil') }}");
        @endif
    </script>



<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#edit_profil', function() { 
            var name = $(this).data('name');
            var email = $(this).data('email');
            var id_admin = $(this).data('id_admin');
            $('#name').val(name);
            $('#email').val(email);
            $('#id_admin').val(id_admin);
        })
    });
</script>

@endsection

