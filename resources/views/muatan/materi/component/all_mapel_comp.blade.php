@if(count($this_class_mapel)==0)
	<option value="" selected="">Tidak terdapat mapel untuk kelas ini :(</option>
@else
	@if($type=='edit')
	<option value="{{$this_materi->mapel}}" selected="">{{$this_materi->nama}}</option>
	@elseif($type=='common' && type=='xhr')
	<option value="" selected="">Pilih Mata Pelajaran</option>
	@endif
	@foreach($this_class_mapel as $mapel)
		<option value="{{$mapel->mapel}}">{{$mapel->nama}}</option>
	@endforeach
@endif