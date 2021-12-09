@extends('layout.template')
@section('contens')
<br>


<div class="row"><br>
    @include('rombel.jml_pendaftar')      
</div>

<div class="row" id="siswa_new">
    @include('rombel.siswa_new')      
</div>



<script type="text/javascript">
    $(".pilih_tingkat").click(function(){
        var tingkat = $(this).attr('tingkat');
        $.ajax({
            url: '{{URL::to('pilih_tingkat')}}',
            type: 'get',
            data: {tingkat:tingkat},
            success: function(data) {
                $('#siswa_new').html(data);
            }
        })
    })
</script>


@endsection