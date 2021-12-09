<?php
$idbab=$bab->id;
$item = DB::table('sub_bab')
->join('bab','bab.id','=','sub_bab.bab_id')
->join('quiz','quiz.quiz_id','=','sub_bab.type_id')
->select('sub_bab.*','quiz.quiz_name','bab.mapel')
->where('sub_bab.bab_id',$idbab)
->where('sub_bab.sub_id',$sub->sub_id)
->orderBy('sub_id','asc')
->first();

?>

{{-- @foreach ($sub_bab as $item) --}}
<table class="table table-striped quiz_box{{$item->type_id}}" id="quiz_box{{$item->type_id}}">
    {{-- {{ $item->quiz_id }} --}}
    <tr>
        <td>
            {{-- {{ $item->type_id }} --}}
        <ol style="list-style-type: square;"><li><b>{{ ucfirst($item->type) }}</b> - {{ $item->quiz_name}}</li></ol>
        </td>
        <td class="float-right">
            {{-- <a href="{{url('unpublish_quiz/'.$item->type_id) }}" class="btn btn-sm btn-info ion-eye"></a> --}}
            <a href="#" id="preview_quiz{{$item->type_id}}" class="btn btn-sm btn-info ion-eye" data-id_quiz="{{$item->id}}" data-toggle="modal" data-target="#modal-preview_quiz{{$item->type_id}}"  data-toggle="tooltip" data-placement="right" title="Lihat Quiz"></a>
            <a href="{{url('edit_quiz_kursus/'.$item->type_id)}}" class="btn btn-primary btn-sm ion-edit" data-toggle="tooltip" data-placement="right" title="Edit Quiz"></a>
            <button class="btn btn-sm btn-danger ion-trash-a hapus" data-toggle="tooltip" data-placement="bottom" title="Hapus Quiz" data-id="{{$item->type_id}}" data-bab="{{$item->bab_id}}" data-kelas="{{$item->room_id}}" data-mapel="{{$item->mapel}}"></button>
        </td>
    </tr>
</table>

<div class="modal fade" id="modal-preview_quiz{{$item->type_id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title"><small><b>Quiz</b>
                <strong style="color: white;">
                    {{ $nm_kursus->room_name }}
                    
                </strong>
                </small></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
    
            <div class="modal-body">
                @include('kelola_kursus.quiz.preview_quiz') 
            </div>
        </div>
    </div>
</div>


{{-- @endforeach --}}


<script src="{{url ('public/ckeditor/ckeditor.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
	$('.hapus').click(function(){
		var quiz_id = $(this).data('id');
        var bab = $(this).data('bab');
        var kelas = $(this).data('kelas');
        var mapel = $(this).data('mapel');
		if (confirm('Apakah Anda yakin ingin menghapus Quiz ini? Menghapus Quiz akan menghapus semua Pertanyaan dan file pendukung')) {
			$('#prog_modal').css({
				'display':'grid',
				'place-items':'center',
			});
            toastr.success('Berhasil Menghapus Quiz')
            $('#prog_modal'+quiz_id).show();
            $('.quiz_box'+quiz_id).remove();
            $('#prog_modal'+quiz_id).hide();
			$.ajax({
				type : 'get',
				url : '{{URL::to('delete_quiz')}}',
				data : {quiz_id:quiz_id,bab:bab,kelas:kelas,mapel:mapel},
				success:function(data)
				{
					
					// $('#materi_box').html(data);
                    toastr.success('Berhasil Menghapus Quiz')
                    $('.quiz_box'+quiz_id).remove();
                    // $('#prog_modal'+id_materi).hide();
				}
			})
		}
	})
	
</script>