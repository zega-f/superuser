
<?php
    $edit_jadwal = \DB::table('jadwal_kelas')
    ->join('atur_jam', 'jadwal_kelas.jam', '=', 'atur_jam.nama')
    ->where('jadwal_kelas.id',$data->id)
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

              <label>Pengajar</label>
              <input type="hidden" name="id_jadwal" value="{{ $data->id }}">
              <select name="pengajar_name" guru="hari1" class="form-control guru" required>
                  <option value="">-Pilih Pengajar-</option>
                  @foreach($pengajar as $row)
                      <option value="{{ $row->partner_id }}"{{ ($row->partner_id == $edit_jadwal->pengajar ? "selected" : null) }}>{{ $row->name }}</option>
                  @endforeach
              </select><br>

        
              <?php $hari = DB::table('tblhari')->get();?>
              <label>Hari</label>
              <select name="hari" id="hari1" class="form-control" required>
                  <option value="">-Pilih Hari-</option>
                    @foreach($hari as $row1)
                  <option value="{{ $row1->id }}"{{ ($row1->id == $edit_jadwal->hari ? "selected" : null) }}>{{ ucfirst($row1->namahari) }}</option>
                  @endforeach
              </select><br>

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
      <button type="submit" class="btn btn-success">Simpan</button>
</form>


