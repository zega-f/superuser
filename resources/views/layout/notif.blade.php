

<?php
 $notif = DB::table('room_user')
                        ->join('users','room_user.user_id','=','users.partner_id')
                        ->leftjoin('room_user_mapel','room_user_mapel.user_id','=','room_user.user_id')
                        ->select('users.partner_id','users.name','room_user.status','room_user.id','room_user.bukti_pembayaran','room_user.user_id','room_user.tingkat','room_user.type','room_user_mapel.register_id','room_user.register_id as id_register')
                        ->where('room_user.status',0)
                        ->where('room_user.type',0)
                        ->orwhere('room_user_mapel.verify',0)
                        ->groupBy('room_user_mapel.register_id')
                        ->get();
        // $testi = DB::table('testimoni')
        // ->count();

        $notif_kursus = DB::table('room_user')
                        ->join('users','room_user.user_id','=','users.partner_id')
                        ->where('room_user.status',0)
                        ->where('room_user.type',1)
                        ->get();

        $feedback = DB::table('testimoni')
                        ->where('read_status',0)
                        ->get();
?>

<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-bell"></i>
    <span class="badge badge-warning navbar-badge"> {{ count($notif) + count($notif_kursus) +  count($feedback) }}</span>
</a>

  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <span class="dropdown-item dropdown-header">
        {{ count($notif)+count($notif_kursus) + count($feedback) }} Notifications
    </span>

    <div class="dropdown-divider"></div>
    <a href="{{ url('pembayaran') }}" class="dropdown-item">
        <i class="fas fa-users mr-2"></i> 
        {{ count($notif) }} Pendaftar Baru Reguler
        <span class="float-right text-muted text-sm">
          {{-- 3 mins --}}
        </span>
    </a>

    <a href="{{ url('register_kursus') }}" class="dropdown-item">
      <i class="fas fa-users mr-2"></i> 
      {{ count($notif_kursus) }} Pendaftar Baru Kursus
        <span class="float-right text-muted text-sm">
        </span>
    </a> 

    <button type="button" class="btn dropdown-item" data-toggle="modal" data-target="#notif_feedback">
      <i class="fas fa-envelope mr-2"></i> 
      {{ count($feedback) }} Feedback
        <span class="float-right text-muted text-sm">
        </span>
    </button> 
   
    <div class="dropdown-divider"></div>
  </div>



  
  