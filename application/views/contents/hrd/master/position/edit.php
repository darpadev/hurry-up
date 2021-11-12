          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ubah Jabatan</h3>
              </div>
              <form action="<?php echo base_url() ?>hrd/master/update_position/<?php echo $data->id ?>" method="POST">
                <div class="card-body">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Organisasi</label>
                      <select name="org_unit" class="form-control" required>
                        <?php foreach ($organizations->result() as $value): ?>
                          <option <?php echo ($value->id == $data->org_unit) ? 'selected' : ''; ?> value="<?php echo $value->id ?>"><?php echo $value->org_unit ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Atasan</label>
                      <select name="parent_id" class="form-control" required>
                        <?php foreach ($positions->result() as $value): ?>
                          <option <?php echo ($value->id == $data->parent_id) ? 'selected' : ''; ?> value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Jabatan</label>
                      <input type="text" name="position" class="form-control" required value="<?php echo $data->position ?>">
                    </div>
                    <div class="form-group">
                      <label>Level</label>
                      <select name="level" class="form-control" required>                      
                        <option value="1" <?php echo ($data->level == 1) ? 'selected' : ''; ?>>1 (Rektor)</option>
                        <option value="2" <?php echo ($data->level == 2) ? 'selected' : ''; ?>>2 (Wakil Rektor/Dewan/Senat)</option>
                        <option value="3" <?php echo ($data->level == 3) ? 'selected' : ''; ?>>3 (Dekan/Direktur/Kepala Unit)</option>
                        <option value="4" <?php echo ($data->level == 4) ? 'selected' : ''; ?>>4 (Manajer/Kaprodi)</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                      <div style="border: 0" class="form-control">
                        <div class="icheck-primary d-inline">
                        <input <?php echo ($data->is_active == TRUE) ? 'checked' : ''; ?> type="radio" id="radioPrimary1" name="is_active" value="TRUE"><label for="radioPrimary1">Aktif &nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-primary d-inline">
                        <input <?php echo ($data->is_active == FALSE) ? 'checked' : ''; ?> type="radio" id="radioPrimary2" name="is_active" value="FALSE"> <label for="radioPrimary2">Tidak Aktif</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-footer">
                  <div class="float-right">
                    <a href="<?php echo base_url() ?>hrd/master/position" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
            </div>
          </div>