<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use DB;


class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $artikel = DB::table('artikel')
        ->join('kategori_artikel', 'kategori_artikel.id', '=', 'artikel.kategori')
        ->where('sorotan','0')
    	->get();

        $sorotan = DB::table('artikel')
        ->join('kategori_artikel', 'kategori_artikel.id', '=', 'artikel.kategori')
        ->where('sorotan','1')
        ->get();


        $kategori = DB::table('kategori_artikel')
    	->get();

        return view('artikel.index',compact('artikel','kategori','sorotan'));
    }

    public function create(Request $request)
    {
        return view('artikel.create');
    }


    public function store(Request $request)
    {
    	$id_artikel = Str::random(8);
    	$directory = "public/artikel/";
    	$file_array = array();

    	$store_materi = DB::table('artikel')
    	->insert([
    		
    		'judul'=>$request->judul,
            'kategori'=>$request->kategori,
            'intro'=>$request->intro,
            'id_artikel' =>$id_artikel,
    	]);

    	$json_content = array(
            'id_artikel' => $id_artikel,
            'judul'=>$request->judul,
            'kategori'=>$request->kategori,
            'intro'=>$request->intro,
            'konten' => $request->konten,
        );

        $text = json_encode($json_content);

        $myfile = fopen($directory.$id_artikel.'.json', "w");
        fwrite($myfile, $text);
		
     	return redirect('artikel');
    }



    public function edit_artikel($id)
    {
        $this_materi = DB::table('artikel')
        ->join('kategori_artikel','kategori_artikel.id','=','artikel.kategori')
    	->where('artikel.id_artikel',$id)
    	->first();

		return view('artikel.edit_artikel',compact('this_materi'));

    }


    public function update_artikel(Request $request, $id_artikel)
    {
    	// $id_artikel = Str::random(8);
    	$directory = "public/artikel/";
    	$file_array = array();

    	$store = DB::table('artikel')
        ->where('id_artikel',$id_artikel)
    	->update([
    		
    		'judul'=>$request->judul,
            'kategori'=>$request->kategori,
            'intro' =>$request->intro,
    	]);

    	$json_content = array(
            'id_artikel' => $id_artikel,
            'judul'=>$request->judul,
            'kategori'=>$request->kategori,
            'intro'=>$request->intro,
            'konten' => $request->konten,
            'intro' =>$request->intro,
        );

        $text = json_encode($json_content);

        $myfile = fopen($directory.$id_artikel.'.json', "w");
        fwrite($myfile, $text);
		
     	return redirect('artikel');
    }



    public function view_artikel($id)
    {
        $this_materi = DB::table('artikel')
        ->join('kategori_artikel','kategori_artikel.id','=','artikel.kategori')
    	->where('artikel.id_artikel',$id)
    	->first();

		return view('artikel.view_artikel',compact('this_materi'));

    }


    public function artikel_unpublish(Request $request)
    {
        $non_aktif = DB::table('artikel')
        ->where(
            'id_artikel',$request->id_artikel,
        )
        ->update([
            'status'=>'0',
        ]);
    }

    public function artikel_publish(Request $request)
    {
        $aktif = DB::table('artikel')
        ->where(
            'id_artikel',$request->id_artikel,
        )
        ->update([
            'status'=>'1',
        ]);
    }
    


    public function delete_artikel(Request $request)
    {
        $delete_artikel = \DB::table('artikel')
        ->where(
            'id_artikel',$request->id_artikel)->delete();
        
        if (File::exists('public/artikel/'.$request->id_artikel.'.json')) {
            File::delete('public/artikel/'.$request->id_artikel.'.json');
        }

        $artikel = DB::table('artikel')
        ->join('kategori_artikel', 'kategori_artikel.id', '=', 'artikel.kategori')
    	->get();
        return view('artikel.tabel_artikel', compact('artikel'));

    }


    public function kategori_store(Request $request)
    {
    	$store_kategori = DB::table('kategori_artikel')
    	->insert([

    		'name'=>$request->name,
    	]);
        return back();
    }

    public function kategori_update(Request $request)
    {
    	$update_kategori = DB::table('kategori_artikel')
        ->where(
            'id',$request->id,
        )
    	->update([

    		'name'=>$request->name,
    	]);

        return back();
    }


    public function delete_kategori(Request $request)
    {
        $delete_kategori = \DB::table('kategori_artikel')
        ->where(
            'id',$request->id_kategori)->delete();

            $kategori = DB::table('kategori_artikel')
            ->get();
       
        return view('artikel.data_kategori', compact('kategori'));

    }


    public function notif(Request $request)
    {
        // $notif = DB::table('room_user')
        // ->where('status',0)
        // ->count();

        $notif = DB::table('room_user')
                        ->join('users','room_user.user_id','=','users.partner_id')
                        ->leftjoin('room_user_mapel','room_user_mapel.user_id','=','room_user.user_id')
                        ->select('users.partner_id','users.name','room_user.status','room_user.id','room_user.bukti_pembayaran','room_user.user_id','room_user.tingkat','room_user.type','room_user_mapel.register_id','room_user.register_id as id_register')
                        ->where('room_user.status',0)
                        ->orwhere('room_user_mapel.verify',0)
                        ->groupBy('room_user_mapel.register_id')
                        // ->limit(5)
                        ->get();

                        $notif_kursus = DB::table('room_user')
                        ->join('users','room_user.user_id','=','users.partner_id')
                        // ->select('users.partner_id','users.name','room_user.status','room_user.id','room_user.bukti_pembayaran','room_user.user_id','room_user.tingkat','room_user.type','room_user_mapel.register_id','room_user.register_id as id_register')
                        ->where('room_user.status',1)
                        // ->orwhere('room_user_mapel.verify',0)
                        // ->groupBy('room_user_mapel.register_id')
                        // ->limit(5)
                        ->get();

        $testi = DB::table('testimoni')
        // ->where('status',0)
        ->count();
        
        return view('layout.notif', compact('notif','testi','notif_kursus'));
        // echo $notif;
    }




    public function artikelAddSorotan(Request $request)
    {
        $id_artikel = $request->id_artikel;
        $artikelAddSorotan = DB::table('artikel')
        ->where([
            ['id_artikel',$request->id_artikel],
        ])
        ->update([
            'sorotan'=>1,
        ]);

        $artikel = DB::table('artikel')
        ->get(); 
    }


    public function artikelRemoveSorotan(Request $request)
    {
        $id_artikel = $request->id_artikel;
        $artikelAddSorotan = DB::table('artikel')
        ->where([
            ['id_artikel',$request->id_artikel],
        ])
        ->update([
            'sorotan'=>0,
        ]);

        $artikel = DB::table('artikel')
        ->get(); 
    }

    public function artikel_sorotan(Request $request)
    {
        $id_artikel = $request->id_artikel;
        $sorotan = DB::table('artikel')
        ->join('kategori_artikel', 'kategori_artikel.id', '=', 'artikel.kategori')
        ->where('sorotan',1)
        ->get();

        return view('artikel.tabel_sorotan',compact('sorotan'));
    }

    public function artikel_default(Request $request)
    {
        $id_artikel = $request->id_artikel;
        $artikel = DB::table('artikel')
        ->join('kategori_artikel', 'kategori_artikel.id', '=', 'artikel.kategori')
        ->where('sorotan',0)
        ->get();
       
        return view('artikel.tabel_artikel',compact('artikel'));
    }


    




}
