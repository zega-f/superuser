@extends('muatan.layout')
@section('content')
<div class="container rounded border" style="background-color: white; padding: 20px; max-width: 900px;">
	<a href="{{url('artikel')}}" class="mb-3 link-secondary"><i class="ion-arrow-left-c"></i> Back</a>
	<h5 class="mb-3" style="text-align:">
		{{$this_materi->judul}}
	</h5>
	<?php  
		$materi_file = file_get_contents("public/artikel/".$this_materi->id_artikel.'.json');
        $string = json_decode($materi_file,true);

        if (!$materi_file) {
        	echo "404";
        }
    ?>
    <div id="konten" style="font-size: 14px;">
    	<?php
	    echo $string['konten'];
		?>
		
    </div>
</div>
@endsection