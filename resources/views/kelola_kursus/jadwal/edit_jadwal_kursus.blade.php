
<?php
$edit_jadwal = \DB::table('video_conference')
->join('atur_jam', 'video_conference.jam', '=', 'atur_jam.nama')
->where('video_conference.id',$data->id)
->first();
?>


<form action="{{ url('update_jadwal_kursus')}}" method="POST">
@csrf
<div class="card-body">
    <div class="form-group">
    
        <?php
            $pengajar = DB::table('users')
            ->where('partner_type',1)
             ->get();
        ?>

        <label>Title</label>
        <input type="text" name="title" value="{{ $data->title }}" class="form-control" required><br>
        <input type="hidden" name="meet_id" value="{{ $data->meet_id }}" class="form-control" required><br>

        <label>URL</label>
        <input type="text" name="url" value="{{ $data->url }}" class="form-control" required><br>

          <label>Pengajar</label>
          <input type="hidden" name="id_jadwal" id="guru1" value="{{ $data->id }}">
          <select name="pengajar_name" guru="hari1" class="form-control guru1" required>
              <option value="">-Pilih Pengajar-</option>
              @foreach($pengajar as $row)
                  <option value="{{ $row->partner_id }}"{{ ($row->partner_id == $edit_jadwal->owner_id ? "selected" : null) }}>{{ $row->name }}</option>
              @endforeach
          </select><br>

          <label>Tanggal</label>
          <input type="date" name="tanggal" value="{{ $data->tanggal }}" id="tanggal1" class="form-control" required><br>
        

          <?php $jam = DB::table('atur_jam')->get();?>
          <label>Jam</label>
          <select name="jam" id="jam1" class="form-control jam1" required>
              <option value="0">-Pilih jam-</option>
                @foreach($jam as $row2)
                    <option value="{{ $row2->id }}"{{ ($row2->id == $edit_jadwal->jam ? "selected" : null) }}>Jam Ke-{{ucfirst($row2->nama)}} | {{$row2->start}} - {{$row2->end}}</option>
                @endforeach 
          </select><br>
      </div>
  </div>
  <button type="submit" class="btn btn-success float-right">Simpan</button>
</form>


