          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Ubah Tupoksi <strong><?= $position->position ?></strong></h3>
              </div>
              <form action="<?php echo base_url() ?>hrd/master/update_tupoksi_position/<?php echo $data->id ?>" method="POST">
                <div class="card-body">
                  <div class="form-group">
                  <label>Jabatan</label>
                  <input type="hidden" class="form-control" name="position_id" value="<?= $data->position_id ?>">
                  <input type="text" class="form-control" value="<?= $position->position ?>" readonly>
                  </div>

                  <div class="form-group">
                  <label>Tupoksi</label>
                  <input type="text" class="form-control" name="tupoksi" value="<?= $data->tupoksi ?>" required>
                  </div>

                  <div class="form-group">
                  <label>Bobot</label>
                  <input type="number" min="0" class="form-control" name="weight" value="<?= $data->weight ?>" required>
                  </div>

                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a href="<?php echo base_url() ?>hrd/master/show_position/<?= $data->position_id ?>" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
            </div>
          </div>