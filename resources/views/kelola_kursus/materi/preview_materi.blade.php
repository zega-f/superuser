<?php
$title = 'Preview materi';

    	$this_materi = DB::table('coba_materi')
    	->where('id_materi',$item->type_id)
    	->first();

    	$this_materi_lampiran = DB::table('coba_materi_lampiran')
    	->where([
    		['materi_id',$item->type_id]
    	])
    	->get();
?>

<div class="container rounded border" style="background-color: white; padding: 20px; max-width: 900px;">
	{{-- <a href="{{url('/')}}" class="mb-3 link-secondary"><i class="ion-arrow-left-c"></i> Back</a> --}}
	<h5 class="mb-3" style="text-align:">
		{{$this_materi->judul}}
	</h5>
	<?php  
		$materi_file = file_get_contents("public/muatan/materi/".$this_materi->id_materi.'.json');
        $string = json_decode($materi_file,true);

        if (!$materi_file) {
        	echo "404";
        }
    ?>
    <div id="konten" style="font-size: 14px;">
    	<?php
	    echo $string['konten'];
		?>
		@if(count($this_materi_lampiran)>0)
		Lampiran
		<ul>
			@foreach($this_materi_lampiran as $lampiran)
				<li><a href="{{url('public/muatan/materi/lampiran/'.$lampiran->attachment_name)}}">{{$lampiran->attachment_original_name}}</a></li>
			@endforeach
		</ul>
		@endif
    </div>
</div>