<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Mail\lupa_pass;
use DB;
use Hash;


class EmailController extends Controller
{
    public function sendemail(Request $request)
	{
        $check_user = DB::table('admin')
        ->where('email',$request->recovery_email)
        ->count();
        if ($check_user>=1) {
            $random = Str::random(8);
            $recipient = ['email' =>$request->recovery_email,'otp'=>$random];

            // Log::info('Start');
            Mail::to($recipient['email'])->send(new lupa_pass($recipient));
            
            // Log::info('End');
            $update_otp_b = DB::table('admin')
                ->where('email',$request->recovery_email)
                ->update([
                    'password'=>Hash::make($random),  
                ]);
                
            if ($update_otp_b) {
                // return redirect()->route('use_otp_b');
                // echo 'berhasil';
                return redirect('login')->with('success',"Recovery Password anda berhasil silahkan cek Email ".$request->recovery_email);
            }
            else{
                echo "gagal";
            }
        }
        else{
            return back()->with('fail',"Tidak terdapat akun dengan Email ".$request->recovery_email);
        }
		
	}




    public function pass_siswa(Request $request)
	{
        $check_siswa = DB::table('users')
        ->where('email',$request->email_siswa)
        ->count();
        if ($check_siswa>=1) {
            $random = Str::random(8);
            $pass = strtolower($random);
            $recipient = ['email' =>$request->email_siswa,'otp'=>$pass];

            Mail::to($recipient['email'])->send(new lupa_pass($recipient));
            
            $update_otp = DB::table('users')
                ->where('email',$request->email_siswa)
                ->update([
                    'password'=>Hash::make($pass),  
                ]);
                
            if ($update_otp) {
                
                return back()->with('success',"Recovery Password berhasil, password dikirimkan ke Email SIswa".$request->email_siswa);
            }
            else{
                echo "gagal";
            }
        }
        else{
            return back()->with('fail',"Tidak terdapat akun dengan Email ".$request->email_siswa);
        }
		
	}


    public function pass_guru(Request $request)
	{
        $check_guru = DB::table('users')
        ->where('email',$request->email_guru)
        ->count();
        if ($check_guru>=1) {
            $random = Str::random(8);
            $pass = strtolower($random);
            $recipient = ['email' =>$request->email_guru,'otp'=>$pass];

            Mail::to($recipient['email'])->send(new lupa_pass($recipient));
            
            $update_otp = DB::table('users')
                ->where('email',$request->email_guru)
                ->update([
                    'password'=>Hash::make($pass),  
                ]);
                
            if ($update_otp) {
                
                return back()->with('success',"Recovery Password berhasil, password dikirimkan ke Email Pengajar".$request->email_guru);
            }
            else{
                echo "gagal";
            }
        }
        else{
            return back()->with('fail',"Tidak terdapat akun dengan Email ".$request->email_guru);
        }
		
	}



    public function pass_admin(Request $request)
	{
        $check_admin = DB::table('admin')
        ->where('email',$request->email_admin)
        ->count();
        if ($check_admin>=1) {
            $random = Str::random(8);
            $pass = strtolower($random);
            $recipient = ['email' =>$request->email_admin,'otp'=>$pass];

            Mail::to($recipient['email'])->send(new lupa_pass($recipient));
            
            $update_otp = DB::table('admin')
                ->where('email',$request->email_admin)
                ->update([
                    'password'=>Hash::make($pass),  
                ]);
                
            if ($update_otp) {
                
                return back()->with('success',"Recovery Password berhasil, password dikirimkan ke Email Admin".$request->email_admin);
            }
            else{
                echo "gagal";
            }
        }
        else{
            return back()->with('fail',"Tidak terdapat akun dengan Email ".$request->email_admin);
        }
		
	}
}

