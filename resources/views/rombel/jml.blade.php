<?php
 $tingkat1=@$item->tingkat;
 $tingkat2=$tingkat;
$tingkat12 = ($tingkat==null ? $tingkat1 : $tingkat);

// $tingkat2=$tingkat;
$jml = DB::table('room_user')
    ->where('room_user.tingkat',$tingkat12)
    ->where('room_user.room_id',null)
    ->where([
                ['room_user.type',0],
                ['room_user.status',1],
            ])
    ->count();
?>
{{$jml}}