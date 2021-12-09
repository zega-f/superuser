<?php 
	$all_quiz = DB::table('quiz')
	// ->join('kelas','quiz.room_id','=','kelas.id_kelas')
	// ->join('tblmapel','quiz.mapel_id','=','tblmapel.id_mapel')
	// ->select('quiz.*','kelas.room_name','tblmapel.nama as mapel_name')
	// ->where('quiz.bab_id',0)
	->get(); 
?>
@if(count($all_quiz)==0)
<div class="alert alert-info">
	Belum terdapat data
</div>
@else
<table class="table" id="quiz_table">
	<thead>
		<tr>
			<th>Nama Quiz</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($all_quiz as $quiz)
		<tr>
			<td>{{$quiz->quiz_name}}</td>
			<td>
				<a href="{{url('show_quiz/'.$quiz->quiz_id)}}" class="btn btn-sm btn-secondary ion-eye"></a>
				<a href="{{url('edit_quiz/'.$quiz->quiz_id)}}" class="btn btn-info btn-sm ion-edit"></a>
				<button class="btn btn-sm btn-danger ion-trash-b" data-toggle="tooltip" data-placement="bottom" title="Hapus materi" data-id="{{$quiz->quiz_id}}"></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$('#quiz_table').DataTable();
	})
</script>
@endif