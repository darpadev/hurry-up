      <div class="row">
        <div class="col-md-5">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal"><div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Pemohon Izin Kerja</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $leave->name ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Tanggal</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo date('j F Y', strtotime($leave->start)).' s/d '.date('j F Y', strtotime($leave->finish)) ?>
                    </label>
                  </div>
                </div>
                <?php 
                  $finish = new DateTime($leave->finish);
                  $start = new DateTime($leave->start);

                  $interval = $finish->diff($start);
                  $elapsed = $interval->format('%d');
                  ?>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Durasi</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $elapsed+1 ?> Hari
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Jenis</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $leave->type ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Status</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $leave->status ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Deskripsi</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $leave->description ?>
                    </label>
                  </div>
                </div>
            </div>
              </form>

            <div class="card-footer">
              
              <?php if (isset($_GET['group']) && isset($_GET['date']) && isset($_GET['approval'])): ?>
                <a class="btn btn-primary float-right" href="<?php echo base_url() ?>hrd/leave<?php echo '?group='.$_GET['group'].'&date='.$_GET['date'].'&approval='.$_GET['approval'] ?>">Kembali</a>
              <?php else: ?>
                <a class="btn btn-primary float-right" href="<?php echo base_url() ?>hrd/leave">Kembali</a>
              <?php endif ?>
            </div>
            </div>
          </div>

        <div class="col-md-7">
          <div class="card">
            <div class="card-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Approver</th>
                  <th class="center">Status</th>
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
                  <td class="center"><?php echo date('Y-m-d H:i:s', strtotime($value->updated_at)) ?></td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>

        
      </div>