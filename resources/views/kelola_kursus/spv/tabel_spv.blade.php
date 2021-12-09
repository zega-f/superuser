<table class="table table-striped">
    <thead>
        <tr align="center">
        <th>#</th>
        <th>Nama</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody>
        <?php $num = 1;?> 
    @foreach ($spv as $data1)
        <tr>
            <td align="center">{{ $num++ }}</td>
            
            <td>{{ $data1->name }}</td>
           
            <td align="center">
                <button class="btn btn-danger btn-xs btn_hapus" id="{{ $data1->id }}" room_id="{{$data1->room_id}}" data-toggle="tooltip" data-placement="bottom" title="Hapus Penanggung Jawab Quiz" ><i class="fa fa-solid fa-trash"></i></button>
            </td>
           
        </tr>

    @endforeach
    </tbody>
</table>

    

<script type="text/javascript">
    $(".btn_hapus").click(function(){
        var id = $(this).attr('id');
        var room_id = $(this).attr('room_id');
        var status = confirm('Yakin ingin menghapus?');
        if(status){
            $.ajax({
                url: '{{URL::to('del_spv')}}',
                type: 'get',
                data: {id:id,room_id:room_id},
                success: function(data){
                    $('#spv').html(data);
                }
            })
        }
    })
</script>


