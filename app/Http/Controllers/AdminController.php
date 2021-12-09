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

class AdminController extends Controller
{
    //CEK LOGIN
    function __construct()
    {
        $this->middleware('admin');
    }

    // DATA ADMIN
    // route:data_admin
    public function index()
    {
        $admin = DB::table('admin')->get();
    	return view('admin.admin',compact('admin'));
    }

    //TAMBAH ADMIN
    // route:add_admin
    //view: admin.admin(form modal)
    public function admin_store(Request $request)
    {
        $store = DB::table('admin')
        ->insert([
            'email'     =>  $request->email,
            'password'  =>  Hash::make('12345678'),
            'name'      => $request->admin_name,
            'admin_id'  => Str::random(6),           
        ]);

        if ($store) {
            Session::flash('add_admin', 'Berhasil Menambahkan Admin');
            return redirect()->route('data_admin');
        }
    }


    //RESET PASSWORD
    // route:pass_admin
    // view:admin.tabel_admin
    public function reset_password(Request $request, $id)
    {
	    DB::table('admin')->where('id',$request->id)->update([
		    'password' => Hash::make('12341234'), //default password
	    ]);
        
	    return back();
    }


    //BUTTON NON AKTIF
    // route:admin_non_aktif
    // view:admin.tabel_admin
    public function admin_non_aktif(Request $request)
    {
        $non_aktif = DB::table('admin')
        ->where(
            'id',$request->id_admin,
        )
        ->update([
            'status'=>'0',
        ]);
    }

    // BUTTON AKTIF
    // route:admin_active
     // view:admin.tabel_admin
    public function admin_aktif(Request $request)
    {
        $aktif = DB::table('admin')
        ->where(
            'id',$request->id_admin,
        )
        ->update([
            'status'=>'1',
        ]);
    }
    

    //BUTTON DELETE ADMIN
    // route:del_admin
   // view:admin.tabel_admin
    public function delete_admin(Request $request)
    {
        $del_admin = \DB::table('admin')
        ->where(
            'id',$request->id_admin)->delete();

        $admin = DB::table('admin')->get();
        Session::flash('del_admin', 'Berhasil Menghapus Admin');
        return view('admin.tabel_admin', compact('admin'));
    }


    //PROFILE ADMIN TER-LOGIN
    // route:profile/{id}  (id_admin)
    public function profile_admin($id)
    {
        $profile = DB::table('admin')
        ->where('admin_id',$id)
        ->get();
    	return view('admin.profile',compact('profile'));
    }


    //GANTI PASSWORD ADMIN TER-LOGIN
    // route:change_password
    // view:admin.profile
    public function changePassword(Request $request){

        //password lama
    	$password_old = $request->password_old;
        $pass = Hash::make($password_old);
            
        
        $cek = DB::table('admin')->where('admin_id',$request->id)->first();
        // $verify_password lama
        if (!(Hash::check($password_old,$cek->password))) {
            return redirect()->back()->with("error","Kata sandi Anda saat ini tidak cocok dengan kata sandi yang Anda berikan. Silakan coba lagi.");
        }
       
        if(strcmp($request->password_old, $request->new_password) == 0) {
            //password baru
            return redirect()->back()->with("error","Kata Sandi Baru tidak boleh sama dengan kata sandi Anda saat ini. Silakan pilih kata sandi yang berbeda.");
        }

        if(!(strcmp($request->new_password, $request->new_password_confirm)) == 0) {
            //konfirmasi password baru
            return redirect()->back()->with("error","Kata Sandi Baru harus sama dengan kata sandi Anda yang telah dikonfirmasi. Silakan ketik ulang kata sandi baru.");
        }
        
        DB::table('admin')->where('admin_id',$request->id)->update([
            'password' => Hash::make($request->new_password),  
        ]);

        return redirect()->back()->with("success","Password berhasil diubah !"); 
    }


    // UPDATE PROFILE TER-LOGIN
    // route:update_profil/{id}
    // view:admin.profile
    public function update_profil(Request $request, $id)
    {
        // update data admin Ter-Login
	    DB::table('admin')->where('id',$request->id)->update([
		    'name' => $request->name,
		    'email' => $request->email,
	    ]);
        
        Session::flash('update_profil', 'Berhasil MengUpdate Profil Admin');
	    return back();
    }

}
