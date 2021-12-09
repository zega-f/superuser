<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;
use Hash;
use Session;
use App\Models\Admin;
use DB;


class AuthController extends Controller
{
    //FORM LOGIN
    // route : login
    public function login()
    {
        return view('login');
    }

    public function Zoom()
    {
        // $jadwal = DB::table('video_conference')
        // ->join('users', 'video_conference.owner_id', '=', 'users.partner_id')
        // // ->join('tblhari', 'jadwal_kelas.hari', '=', 'tblhari.id')
        // ->join('atur_jam', 'video_conference.jam', '=', 'atur_jam.id')
        // ->select('video_conference.*','users.name as pengajar', 'users.partner_id as id_pengajar', 'atur_jam.start as mulai', 'atur_jam.end as akhir')
        // ->where('video_conference.room_id','Hb1TGu')
        // // ->orderBy('jadwal_kelas.jam', 'asc')
        // ->get();
        $jadwal = DB::table('coba_materi')
        ->get();
        return view('layout.main',compact('jadwal'));
    }

    //LOGIN POST
    // route: login_post
    public function AuthCheck(Request $request) 
    {
        $email = $request->email;
    	$password = $request->password;
        $user_hashed_pass = Hash::make($password);
        
        $login_sequence = DB::table('admin')->where('email',$email)->first();
        if ($login_sequence) {
            if ($login_sequence->status==0) {
                $verify_password = Hash::check($password,$login_sequence->password);
                if ($verify_password) {
                    return back()->withInput()->with('fail','Maaf akun Anda sedang disuspend oleh Superadmin!');
                } else {
                    return back()->withInput()->with('fail','Email atau password mungkin tidak cocok');
                }

            } else {
                $verify_password = Hash::check($password,$login_sequence->password);
                if ($verify_password) {
                    $login_result = DB::table('admin')->where('email',$email)->first();
                    Session::put('admin_id',$login_result->admin_id);
                    Session::put('name',$login_result->name);
                    Session::put('email',$login_result->email);
                    Session::put('level',$login_result->level);
                    Session::put('login',TRUE);
                    return redirect()->route('dashboard')->with('Success','Login Berhasil');
                   
                } else {
                    return back()->withInput()->with('fail','Email atau password mungkin tidak cocok');
                }
            }
        } else {
           return back()->withInput()->with('fail','Email atau password mungkin tidak cocok');
        }
    }


    //FUNGSI LOGOUT
    // route:logout
    public function logout(Request $request){
    	$request->Session()->flush();
    	return redirect()->route('login');
    }


    //FORM LUPA PASSWORD
    // route:lupa_password
    public function lupa_password(Request $request)
    {
	    return view('lupa_password');
    }


    //LUPA PASSWORD POST
    // route:sendEmail
    //Controller: EmailController


  
}