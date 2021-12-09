@extends('layout.template')
@section('contens')<br>

  <style>
   /* body
   {
    margin:0;
    padding:0;
    background-color:#f1f1f1;
   } */
   /* .box
   {
    width:1270px;
    padding:20px;
    background-color:#fff;
    border:1px solid #ccc;
    border-radius:5px;
    margin-top:25px;
   } */
   #page_list li
   {
    padding:16px;
    background-color:#f9f9f9;
    border:1px dotted #ccc;
    cursor:move;
    margin-top:12px;
   }
   #page_list li.ui-state-highlight
   {
    padding:24px;
    background-color:#ffffcc;
    border:1px dotted #ccc;
    cursor:move;
    margin-top:12px;
   }
  </style>

   <h1 align="center">Sorting Table Row using JQuery Drag Drop with Ajax PHP</h1>
   <br />


   <ul class="list-unstyled" id="page_list">
  
      @foreach ($test as $item){{ $item->id }}
         <li id="{{ $item->id }}">{{ $item->sub_id }}<br>{{ $item->type }} {{ $item->type_id }}</li>
      @endforeach
   </ul>

   <input type="hidden" name="page_order_list" id="page_order_list" />
 
@endsection

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<script>
$(document).ready(function(){
   $( "#page_list" ).sortable({
      placeholder : "ui-state-highlight",
      update  : function(event, ui){
         var page_id_array = new Array();
         $('#page_list li').each(function(){
            page_id_array.push($(this).attr("id"));
         });

         $.ajax({
            url:'{{URL::to('update_test')}}',
            method:"get",
            data:{page_id_array:page_id_array},
            success:function(data)
            {
               alert(data);
            }
         });
      }
   });
});
</script>