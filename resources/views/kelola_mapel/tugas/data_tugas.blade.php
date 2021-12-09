<?php
$idbab=$bab->id;
$item = DB::table('sub_bab')
->join('bab','bab.id','=','sub_bab.bab_id')
->join('coba_tugas','coba_tugas.id_tugas','=','sub_bab.type_id')
->select('sub_bab.*','coba_tugas.judul as tugas','bab.mapel')
->where('sub_bab.sub_id',$sub->sub_id)
->where('sub_bab.bab_id',$sub->bab_id)
->where('bab.room_id',$sub->room_id)
->where('bab.mapel',$sub->mapel)
->orderBy('sub_id','asc')
->first();

?>

{{-- @foreach ($sub_bab as $item) --}}
<table class="table table-striped tugas_box{{$item->type_id}}" id="tugas_box{{$item->type_id}}">
    <tr>
        {{-- {{ $item->type_id }} --}}
        <td>
            {{-- {{ $item->type_id }} {{ $item->sub_id }} --}}
        <ol style="list-style-type: square;"><li><b>{{ ucfirst($item->type) }}</b> - {{ $item->tugas}}</li></ol>
        </td>
        <td class="float-right">
            <a href="#" id="preview_tugas{{$item->type_id}}" class="btn btn-sm btn-info ion-eye" data-id_materi="{{$item->id}}" data-toggle="modal" data-target="#modal-preview_tugas{{$item->type_id}}" data-toggle="tooltip" title="Lihat Tugas"></a>
            <a href="{{url('edit_tugas/'.$item->type_id.'/'.$item->room_id.'/'.$item->bab_id)}}" class="btn btn-primary btn-sm ion-edit" data-toggle="tooltip" title="Edit Tugas"></a>
            <button class="btn btn-sm btn-danger ion-trash-a" data-toggle="tooltip" data-placement="bottom" title="Hapus Tugas" data-id="{{$item->type_id}}" data-bab="{{$item->bab_id}}" data-kelas="{{$item->room_id}}" data-mapel="{{$item->mapel}}"></button>
        </td>
    </tr>
</table>

<div class="modal fade" id="modal-preview_tugas{{$item->type_id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title"><small><b>Tugas</b>
                <strong style="color: white;">
                
                    {{ $nm_mapel->nama}} {{ $nm_kelas->nama }}
                </strong>
                </small></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
    
            <div class="modal-body">
                @include('kelola_mapel.tugas.preview_tugas') 
            </div>
        </div>
    </div>
</div>


{{-- @endforeach --}}


<script src="{{url ('public/ckeditor/ckeditor.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
	$('.ion-trash-a').click(function(){
		var id_tugas = $(this).data('id');
        var bab = $(this).data('bab');
        var kelas = $(this).data('kelas');
        var mapel = $(this).data('mapel');
		if (confirm('Apakah Anda yakin ingin menghapus tugas ini? Menghapus tugas akan menghapus semua lampiran dan file pendukung')) {
			$('#prog_modal').css({
				'display':'grid',
				'place-items':'center',
			});
            toastr.success('Berhasil Menghapus Tugas')
            $('#prog_modal'+id_tugas).show();
            $('.tugas_box'+id_tugas).remove();
            $('#prog_modal'+id_tugas).hide();
			$.ajax({
				type : 'get',
				url : '{{URL::to('delete_tugas')}}',
				data : {id_tugas:id_tugas,bab:bab,kelas:kelas,mapel:mapel},
				success:function(data)
				{
					toastr.success('Berhasil Menghapus Tugas')
					// $('#materi_box').html(data);
                    $('.tugas_box'+id_tugas).remove();
                    // $('#prog_modal'+id_materi).hide();
				}
			})
		}
	})
	
</script>
