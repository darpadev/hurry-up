      <div class="row">
        <div class="col-md-5">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal">
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Nomor Penugasan</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $overtime->no_assignment ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Pemohon Lembur</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $overtime->requestor ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Nama Pegawai</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $overtime->name ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Tanggal</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo date('j F Y', strtotime($overtime->overtime_date)) ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Lembur</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo date('H:i:s', strtotime($overtime->start)).' s/d '.date('H:i:s', strtotime($overtime->finish)) ?>
                    </label>
                  </div>
                </div>
                <?php 
                  $finish = new DateTime($overtime->finish);
                  $start = new DateTime($overtime->start);

                  $interval = $finish->diff($start);
                  $elapsed = $interval->format('%H:%I:%S');
                  ?>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Durasi</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $elapsed ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Tempat</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $overtime->place ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Status</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $overtime->status ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Deskripsi</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $overtime->description ?>
                    </label>
                  </div>
                </div>
              </form>
            </div>

            <div class="card-footer">
              <?php if (isset($_GET['date'])): ?>
                <a class="btn btn-primary float-right" href="<?php echo base_url() ?>employee/approve/overtime<?php echo '?date='.$_GET['date']//.'&approval='.$_GET['approval'] ?>">Kembali</a>              
              <?php else: ?>
                <a class="btn btn-primary float-left" href="<?php echo base_url() ?>employee/approve/overtime">Kembali</a>              
              <?php endif ?>
            </div>

          </div>
        </div>
        
        <div class="col-md-7">

          <?php if ($report->row()): ?>
            <div class="card">
              <div class="card-header">
                <h3>Laporan Detail Pekerjaan</h3>
              </div>

              <div class="card-body">         
                <table id="" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 5%" class="center">No</th>
                    <th class="center">Mulai</th>
                    <th class="center">Selesai</th>
                    <th class="center">Kegiatan</th>
                    <th class="center">Durasi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $no = 1;
                  $duration = array();
                  foreach ($report->result() as $value) {
                  
                  $finish = new DateTime($value->finish);
                  $start = new DateTime($value->start);

                  $interval = $finish->diff($start);
                  $elapsed = $interval->format('%H:%I:%S');
                  array_push($duration, $elapsed);
                  ?>
                  <tr>
                    <td class="center"><?php echo $no++ ?></td>
                    <td class="center"><?php echo $value->start ?></td>
                    <td class="center"><?php echo $value->finish ?></td>
                    <td><?php echo $value->description ?></td>
                    <td class="center"><?php echo $elapsed ?></td>
                  </tr>
                  <?php } ?>
                </tbody>

                <?php 
                function AddPlayTime($times) {
                    // loop throught all the times
                    $all_seconds = null;
                    foreach ($times as $time) {
                        list($hour, $minute, $second) = explode(':', $time);
                        $all_seconds += $hour * 3600;
                        $all_seconds += $minute * 60; 
                        $all_seconds += $second;

                    }

                    $total_minutes = floor($all_seconds/60); $seconds = $all_seconds % 60;  $hours = floor($total_minutes / 60); $minutes = $total_minutes % 60;

                    // returns the time already formatted
                    return sprintf('%02d:%02d:%02d', $hours, $minutes,$seconds);
                }
                ?>

                <tfoot>
                  <td colspan="4" style="text-align: right;"><strong>Total Lembur</strong></td>
                  <td class="center"><strong><?php echo AddPlayTime($duration) ?></strong></td>
                </tfoot>
                </table>    
              </div>
            </div>    
          <?php endif ?>

          <div class="card">
            <div class="card-header">
              <h3>Persetujuan Lembur</h3>  
            </div>

            <div class="card-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Pemberi Persetujuan</th>
                  <th class="center">Status</th>
                  <th class="center">Tipe</th>
                  <th style="width: 30%" class="center">Perubahan</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->approver ?></td>
                  <td class="center"><span class="btn btn-info btn-xs"><?php echo $value->status ?></span></td>
                  <td><?php echo $value->overtime_type ?></td>
                  <td class="center"><?php echo date('Y-m-d H:i:s', strtotime($value->updated_at)) ?></td>
                </tr>
                <?php } ?>
              </table>
            </div>

            <?php 
            $status_approval_approver = $this->db->select('id')->from('approval_overtimes')->where(array('overtime_id' => $overtime->id, 'approver_id' => $this->uri->segment(5)))->where_in('flag', array(4))->get()->row();

            if ($status_approval_approver): ?>
              <div class="card-footer">
                <div class="float-right">
                  <a href="<?php echo base_url() ?>employee/approve/approve_overtime/<?php echo $overtime->id ?>/<?php echo $this->uri->segment(5) ?>" class="btn btn-success approve-confirmation"><i class="fa fa-check" aria-hidden="true"></i> Terima</a>
                  <a href="<?php echo base_url() ?>employee/approve/reject_overtime/<?php echo $overtime->id ?>/<?php echo $this->uri->segment(5) ?>" class="btn btn-danger reject-confirmation"><i class="fa fa-times" aria-hidden="true"></i> Tolak</a>                
                </div>
              </div>              
            <?php endif ?>
          </div>

        </div>
        </div>
      </div>