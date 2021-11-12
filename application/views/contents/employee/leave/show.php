      <div class="row">

        <div class="col-md-5 col-lg-5">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal">
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Nama</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php if ($leave): ?>
                        <?php echo $leave->name ?>                        
                      <?php endif ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Izin Kerja</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php if ($leave): ?>
                      <?php echo date('j F Y', strtotime($leave->start)).' s/d '.date('j F Y', strtotime($leave->finish)) ?>
                      <?php endif ?>
                    </label>
                  </div>
                </div>
                <?php
                if ($leave) {
                  $finish = new DateTime($leave->finish);
                  $start = new DateTime($leave->start);

                  $interval = $finish->diff($start);
                  $elapsed = $interval->format('%d');
                }
                  ?>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Durasi</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php if ($leave): ?>
                        <?php echo $elapsed+1 ?> Hari                  
                      <?php endif ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Tempat</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php if ($leave): ?>
                        <?php echo $leave->type ?>                        
                      <?php endif ?>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Deskripsi</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php if ($leave): ?>
                        <?php echo $leave->description ?>                        
                      <?php endif ?>
                    </label>
                  </div>
                </div>
              </form>
            </div>

            <div class="card-footer">              
              <?php if (isset($_GET['date']) && isset($_GET['approval'])): ?>
                <a class="btn btn-primary float-right" href="<?php echo base_url() ?>employee/leave<?php echo '?date='.$_GET['date'].'&approval='.$_GET['approval'] ?>">Kembali</a>
              <?php else: ?>                
                <a class="btn btn-primary float-right" href="<?php echo base_url() ?>employee/leave">Kembali</a>
              <?php endif ?>
            </div>
            </div>
          </div>

        <div class="col-md-7 col-lg-7">
          <div class="card">
            <div class="card-header">
              <h3>Persetujuan Izin Kerja</h3>
            </div>

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
      </div>