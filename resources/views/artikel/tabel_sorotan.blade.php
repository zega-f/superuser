<table id="example3" class="table table-striped">
    <thead class="bg-dark" style="color:white; font-size:15px;">
        <tr align="center">
        <th>#</th>
        <th>Judul</th>
        <th>Kategori</th>
        <th>Status</th>
        <th>Aksi</th>
        </tr> 
    </thead>

    <tbody style="font-size: 14px;">
    <?php $num = 1; ?> 
    @foreach ($sorotan as $data)
        <tr>
            <td align="center">{{ $num++ }}</td>
            <td>{{ $data->judul }}</td>
            <td>{{ $data->name }}</td>
            <td align="center">
            {{-- @if($data->status=='1')
                <a href="#" class="btn btn-success btn-sm aktif" id="aktif{{$data->id_artikel}}" data-id="{{$data->id_artikel}}" style="display: inline;">Publish</a>
                <a href="#" class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id_artikel}}" data-id="{{$data->id_artikel}}" style="display: none;">Unpublish</a>

            @elseif($data->status=='0')
                <a href="#" class="btn btn-warning btn-sm non_aktif" id="non_aktif{{$data->id_artikel}}" data-id="{{$data->id_artikel}}" style="display: inline;">Unpublish</a>
                <a href="#" class="btn btn-success btn-sm aktif" id="aktif{{$data->id_artikel}}" style="display: none;" data-id="{{$data->id_artikel}}">Publish</a>
            @endif --}}

            <button class="btn btn bg-maroon btn-sm un_sorotan" id="un_sorotan{{$data->id_artikel}}" data-idartikel="{{$data->id_artikel}}" data-toggle="tooltip" data-placement="right" title="Hapus Artikel dari Sorotan"  style="padding:5px !important; font-size:12px !important;">Un-Sorotan</button>

           
            </td>
            <td align="center">
                <a href="{{ url('view_artikel/'.$data->id_artikel) }}" class="btn btn-sm btn-info fas fa-eye" data-toggle="tooltip" data-placement="right" title="Lihat Artikel"  style="padding:5px !important; font-size:12px !important;"></a>
                <a href="{{ url('edit_artikel/'.$data->id_artikel) }}" class="btn btn-sm btn-primary fas fa-pencil-alt" data-toggle="tooltip" data-placement="right" title="Edit Artikel"></a>
                <button class="btn btn-xs btn-danger fas fa-trash btn_hapus" id="{{$data->id_artikel}}" data-toggle="tooltip" data-placement="right" title="Hapus Artikel"  style="padding:5px !important; font-size:12px !important;"></button>
            </td>
           
        </tr>
    @endforeach
    </tbody>
</table>



<script type="text/javascript">
    $('#example3').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
      </script>

    <script type="text/javascript">
        $('.aktif').click(function(){
            var id_artikel = $(this).data('id');
            $.ajax({
                type : 'get',
              url : '{{URL::to('artikel_unpublish')}}',
                data: {id_artikel:id_artikel},
                success:function(data)
                {
                    $('#aktif'+id_artikel).hide();
                    $('#non_aktif'+id_artikel).show();
                }
            });
        });
    
        $('.non_aktif').click(function(){
            var id_artikel = $(this).data('id');
            $.ajax({
                type : 'get',
              url : '{{URL::to('artikel_publish')}}',
                data: {id_artikel:id_artikel},
                success:function(data)
                {
                    $('#aktif'+id_artikel).show();
                    $('#non_aktif'+id_artikel).hide();
                }
            });
        });
    
    </script>
    
    
    <script type="text/javascript">
        $(".btn_hapus").click(function(){
                var id_artikel = $(this).attr('id');
                var status = confirm('Yakin ingin menghapus?');
                if(status){
                    $.ajax({
                        url: '{{URL::to('del_artikel')}}',
                        type: 'get',
                        data: {id_artikel:id_artikel},
                        success: function(data){
                            $('#artikel').html(data);
                        }
                    })
                }
            })
    </script>
    
    
    <script type="text/javascript">
        $('.un_sorotan').click(function(){
            var id_artikel = $(this).data('idartikel');
            console.log(id_artikel);
            $.ajax({
                type : 'get',
                url : '{{URL::to('artikel_remove_sorotan')}}',
                data: {id_artikel:id_artikel},
                success:function(data)
                {
                    $.ajax({
                        type : 'get',
                        url : '{{URL::to('artikel_sorotan')}}',
                        data: {id_artikel:id_artikel},
                        success:function(data)
                        {
                          $('#sorotan').html(data);
                        }
                      });
    
                    $('#row'+id_artikel).css('display','none');
                    $.ajax({
                    type : 'get',
                    url : '{{URL::to('artikel_default')}}',
                    data: {id_artikel:id_artikel},
                    success:function(data)
                    {
                      $('#artikel').html(data);
                    }
                  });
                }
            });
        })
    </script>