<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index()
    {
        $cms = DB::table('cms')
        ->where('type','info')
        ->first();

        $progam = DB::table('cms')
        ->where('type','progam')
        ->get();

        $promosi = DB::table('cms')
        ->where('type','promosi')
        ->get();

        $testimoni = DB::table('testimoni')
        ->join('users','users.partner_id','=','testimoni.user_id')
        ->select('testimoni.*', 'users.name')
        ->orderBy('testimoni.publish_status','desc')
        ->orderBy('testimoni.created_at','asc')
        ->get();

       
        return view('setting.index',compact('cms','progam','promosi','testimoni'));
    
    }



    public function store(Request $request)
    {
        if($request->file('logo') == "") {
            $store = DB::table('cms')
            ->where('id',$request->id)
            ->update([
                'name'              => $request->name,
                'footer_alamat'     => $request->alamat,
                'footer_whatsapp'   => $request->whatsapp,
                'footer_email'      => $request->email,
                'footer_youtube'    => $request->youtube,
                'footer_website'    => $request->website,
                'rekening'          => $request->rekening,
                'an'                => $request->an,
                'deskripsi'         =>  $request->deskripsi,
            ]);
        } else { 

        $destination= "public/gambar/";
        $this->validate($request, [
            'logo'     => 'required|image|mimes:png,jpg,jpeg',
        ]);

    
        //upload image
        $image = $request->file('logo');
        $name =  date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destination,$name);

        // Storage::disk('local')->delete('public/gambar/'.$request->logo);
    

        $store = DB::table('cms')
        ->where('id',$request->id)
        ->update([
            'logo'              => $name,
            'name'              => $request->name,
            'footer_alamat'     => $request->alamat,
            'footer_whatsapp'   => $request->whatsapp,
            'footer_email'      => $request->email,
            'footer_youtube'    => $request->youtube,
            'footer_website'    => $request->website,
            'rekening'          => $request->rekening,
            'an'                => $request->an,
            'deskripsi'         =>  $request->deskripsi, 
        ]);
        }
        
        if($store){
            return back()->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            return back()->with(['sucess' => 'Data Berhasil Disimpan!']);
        }
    
    
    }


    public function faq_index()
    {
        $faq = DB::table('faq_category')
        ->get();

        return view('setting.faq_index',compact('faq'));
    
    }



    public function store_faq(Request $request)
    {
        $category_id = Str::random(8);
        $store = DB::table('faq_category')
        ->insert([
            'category_id'=>$category_id,
            'category'=>$request->name,
        ]);

        return back();
    }


    public function add_question(Request $request)
    {
        $store = DB::table('faq_question')
        ->insert([
            'faq_category'=>$request->category_id,
            'question'=>$request->question,
            'answer'=>$request->answer,
        ]);

        return back();
    }


    public function del_faq(Request $request, $category_id)
    {
        $del_category = \DB::table('faq_category')
        ->where(
            'category_id',$category_id)->delete();

        $del_question = \DB::table('faq_question')
        ->where(
            'faq_category',$category_id)->delete();

        return back();
    }


    
    public function update_faq(Request $request)
    {
        $store = DB::table('faq_category')
        ->where('category_id',$request->id)
        ->update([
            'category'    => $request->category,
        ]);

        return back();
    }

    public function update_answer(Request $request)
    {
        $store = DB::table('faq_question')
        ->where('faq_category',$request->id)
        ->update([
            'question'    => $request->question,
            'answer'    => $request->answer,
        ]);

        return back();
    }


    public function del_answer(Request $request, $category_id)
    {
        $del_question = \DB::table('faq_question')
        ->where(
            'faq_category',$category_id)->delete();

        return back();
    }


    public function progam_store(Request $request)
    {
        $destination= "public/gambar/";
        $this->validate($request, [
            'logo'     => 'required|image|mimes:png,jpg,jpeg',
        ]);

    
        //upload image
        $image = $request->file('logo');
        $name =  date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destination,$name);

        $store = DB::table('cms')
        ->where('id',$request->id)
        ->insert([
            'logo'         => $name,
            'type'         => 'progam',
            'name'         => $request->name,
            'deskripsi'    =>  $request->deskripsi, 
            'link'         =>  $request->link, 
        ]);
        
        
        if($store){
            return back()->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            return back()->with(['sucess' => 'Data Berhasil Disimpan!']);
        }
    
    }




    public function progam_update(Request $request)
    {
        if($request->file('logo') == "") {
            $store = DB::table('cms')
            ->where('id',$request->id)
            ->update([
                'type'         => 'progam',
                'name'         => $request->name,
                'deskripsi'    =>  $request->deskripsi, 
                'link'         =>  $request->link, 
            ]);
        } else { 

        $destination= "public/gambar/";
        $this->validate($request, [
            'logo'     => 'required|image|mimes:png,jpg,jpeg',
        ]);

    
        //upload image
        $image = $request->file('logo');
        $name =  date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destination,$name);


        $store = DB::table('cms')
        ->where('id',$request->id)
        ->insert([
            'logo'         => $name,
            'type'         => 'progam',
            'name'         => $request->name,
            'deskripsi'    =>  $request->deskripsi, 
            'link'         =>  $request->link, 
        ]);
        
        }
        if($store){
            return back()->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            return back()->with(['sucess' => 'Data Berhasil Disimpan!']);
        }
    
    }



    public function promosi_store(Request $request)
    {
        $destination= "public/gambar/";
        $this->validate($request, [
            'logo'     => 'required|image|mimes:png,jpg,jpeg',
        ]);

    
        //upload image
        $image = $request->file('logo');
        $name =  date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destination,$name);

        $store = DB::table('cms')
        ->where('id',$request->id)
        ->insert([
            'logo'         => $name,
            'type'         => 'promosi',
            'name'         => $request->name,
            'deskripsi'    =>  $request->deskripsi, 
            'link'         =>  $request->link, 
        ]);
        
        
        if($store){
            return back()->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            return back()->with(['sucess' => 'Data Berhasil Disimpan!']);
        }
    
    }




    public function promosi_update(Request $request)
    {
        if($request->file('logo') == "") {
            $store = DB::table('cms')
            ->where('id',$request->id)
            ->update([
                'type'         => 'promosi',
                'name'         => $request->name,
                'deskripsi'    =>  $request->deskripsi, 
                'link'         =>  $request->link, 
            ]);
        } else { 

        $destination= "public/gambar/";
        $this->validate($request, [
            'logo'     => 'required|image|mimes:png,jpg,jpeg',
        ]);

    
        //upload image
        $image = $request->file('logo');
        $name =  date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destination,$name);


        $store = DB::table('cms')
        ->where('id',$request->id)
        ->insert([
            'logo'         => $name,
            'type'         => 'promosi',
            'name'         => $request->name,
            'deskripsi'    =>  $request->deskripsi, 
            'link'         =>  $request->link, 
        ]);
        
        }
        if($store){
            return back()->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            return back()->with(['sucess' => 'Data Berhasil Disimpan!']);
        }
    
    }


    public function del_promosi(Request $request, $id)
    {
        $del_promosi = \DB::table('cms')
        ->where(
            'id',$id)->delete();

        return back();

    }


    public function feedback(Request $request)
    {
        return view('setting.feedback');
    }


    public function feedback_kursus(Request $request)
    {   
        $room = \DB::table('room_user')
        ->where(
            'user_id',$request->user)->first();
        $kelas=$room->room_id;
        $type=$room->type;
        $feedback_id = Str::random(8);
        
            $store = DB::table('testimoni')
            ->insert([
                'type'         => $type,
                'feedback_id'  => $feedback_id,
                'star'         => '5',
                'status'       => '1',
                'anonymous'    => 'off',
                'testimoni'         => $request->feedback,
                'user_id'    =>  $request->user, 
                'room_id'         =>  $kelas, 
            ]);
        // return back();
        return redirect('setting_cms/#feedback');
        // $testimoni = DB::table('testimoni')
        // ->join('users','users.partner_id','=','testimoni.user_id')
        // ->select('testimoni.*', 'users.name')
        // ->orderBy('testimoni.status','desc')
        // ->get();

        // $cms = DB::table('cms')
        // ->where('type','info')
        // ->first();

        // $progam = DB::table('cms')
        // ->where('type','progam')
        // ->get();

        // $promosi = DB::table('cms')
        // ->where('type','promosi')
        // ->get();

        // return view('setting.feedback',compact('testimoni','cms','progam','promosi'));
    }



    
    public function checklist_testi(Request $request)
    {
        $store = DB::table('testimoni')
            ->where('id',$request->val)
            ->update([
                'publish_status' => $request->apply,
            ]);
        
        if($store){
            return back();
        // }else{
        //     return back()->with(['sucess' => 'Data Berhasil Disimpan!']);
        }
    }

    public function checklist_read_testi(Request $request)
    {
        $store = DB::table('testimoni')
            ->where('id',$request->val)
            ->update([
                'read_status' => $request->apply,
         ]);
        
        if($store){
            return back();
        // }else{
        //     return back()->with(['sucess' => 'Data Berhasil Disimpan!']);
        }
    }



  


    
}
