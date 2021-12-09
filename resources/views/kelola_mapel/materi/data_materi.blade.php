<?php
    $idbab=$bab->id;
    $item = DB::table('sub_bab')
    ->join('bab','bab.id','=','sub_bab.bab_id')
    ->join('coba_materi','coba_materi.id_materi','=','sub_bab.type_id')
    ->select('sub_bab.*','coba_materi.judul as materi','bab.mapel','coba_materi.id_kelas')
    ->where('sub_bab.sub_id',$sub->sub_id)
    ->where('sub_bab.bab_id',$sub->bab_id)
    ->where('bab.room_id',$sub->room_id)
    ->where('bab.mapel',$sub->mapel)
    ->orderBy('sub_id','asc')
    ->first();
   
?>

<table class="table table-striped materi_box{{$item->type_id}}" id="materi_box{{$item->type_id}}">
    <tr>
        
        <td>
            <ol style="list-style-type: square;"><li><b>{{ ucfirst($item->type) }}</b> - {{ $item->materi}}</li></ol>
        </td>

        <td class="float-right">
            <a href="#" id="preview_materi{{$item->type_id}}" class="btn btn-sm btn-info ion-eye" data-id_materi="{{$item->id}}" data-toggle="modal" data-target="#modal-preview_materi{{$item->type_id}}" data-toggle="tooltip" title="Lihat Materi"></a>

            <a href="{{url('edit_materi/'.$item->type_id.'/'.$item->room_id.'/'.$item->bab_id)}}" class="btn btn-primary btn-sm ion-edit" data-toggle="tooltip" title="Edit Materi"></a>

            <button class="btn btn-sm btn-danger ion-trash-b" data-toggle="tooltip" data-placement="bottom" title="Hapus materi" data-id="{{$item->type_id}}" data-bab="{{$item->bab_id}}" data-kelas="{{$item->room_id}}" data-mapel="{{$item->mapel}}"></button>  
        </td>
    </tr>
</table>



<div class="modal fade" id="modal-preview_materi{{$item->type_id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title"><small><b>Materi</b>
                <strong style="color: white;">
                    {{ $nm_mapel->nama}} {{ $nm_kelas->nama }}
                </strong>
                </small></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('kelola_mapel.materi.preview_materi') 
            </div>
        </div>
    </div>
</div>



 


<script src="{{url ('public/ckeditor/ckeditor.js')}}"></script>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript">
	$('.ion-trash-b').click(function(){
		var id_materi = $(this).data('id');
        var bab = $(this).data('bab');
        var kelas = $(this).data('kelas');
        var mapel = $(this).data('mapel');
		if (confirm('Apakah Anda yakin ingin menghapus materi ini? Menghapus materi akan menghapus semua lampiran dan file pendukung')) {
			$('#prog_modal'+id_materi).css({
				'display':'grid',
				'place-items':'center',
			});
            toastr.success('Berhasil Menghapus Masteri')
            // $('#prog_modal'+id_materi).show();
            $('.materi_box'+id_materi).remove();
            // $('#prog_modal'+id_materi).hide();
			$.ajax({
				type : 'get',
				url : '{{URL::to('delete_materi')}}',
				data : {id_materi:id_materi,bab:bab,kelas:kelas,mapel:mapel},
				success:function(data)
				{
                    toastr.success('Berhasil Menghapus Masteri')
					// $('#materi_box').html(data);
                    $('.materi_box'+id_materi).remove();
                    // toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
                    // $('#prog_modal'+id_materi).hide();
				}
			})
		}
	})
	
</script>



