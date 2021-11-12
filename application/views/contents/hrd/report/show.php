      <div class="row">

        <div class="col-md-5">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal">
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Nama</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $overtime->name ?>
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
                  <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Deskripsi</label>
                  <div class="col-sm-8">
                    <label style="border: 0; color: black;" class="form-control">
                      <?php echo $overtime->description ?>
                    </label>
                  </div>
                </div>
              </form>

              <a class="btn btn-primary float-left" href="<?php echo base_url() ?>hrd/overtime<?php echo '?date='.$_GET['date'].'&approval='.$_GET['approval'] ?>">Kembali</a>
            </div>
            </div>
          </div>
        <div class="col-7">
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
      </div>