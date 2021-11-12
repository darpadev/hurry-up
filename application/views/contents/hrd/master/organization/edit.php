          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ubah Organisasi</h3>
              </div>
              <form action="<?php echo base_url() ?>hrd/master/update_organization/<?php echo $data->id ?>" method="POST">
                <div class="card-body">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Organisasi</label>
                      <input type="text" name="org_unit" class="form-control" required value="<?php echo $data->org_unit ?>">
                    </div>
                    <div class="form-group">
                      <label>Organisasi Parent</label>
                      <select name="parent_id" class="=form-control" required>
                        <option value=""> -- Pilih Organisasi -- </option>
                        <?php foreach ($org_unit->result() as $org): ?>
                          <option <?php echo ($org->id == $data->parent_id) ? 'selected' : ''; ?> value="<?php echo $org->id ?>"><?php echo $org->org_unit ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Tipe</label>
                      <select name="type_id" class="=form-control" required>              
                        <?php foreach ($this->db->select('*')->from('org_types')->order_by('id', 'ASC')->get()->result() as $type): ?>                        
                        <option <?php echo ($type->id == $data->type_id) ? 'selected' : ''; ?> value="<?php echo $type->id ?>"><?php echo $type->type ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Kode Organisasi</label>
                      <input type="text" name="code" class="form-control" required value="<?php echo $data->code ?>">
                    </div>

                    <div class="form-group">
                      <label>Level</label>
                      <select name="level" class="form-control" required>                      
                        <option value="1" <?php echo ($data->level == 1) ? 'selected' : ''; ?>>1 (Rektor)</option>
                        <option value="2" <?php echo ($data->level == 2) ? 'selected' : ''; ?>>2 (Wakil Rektor/Dewan)</option>
                        <option value="3" <?php echo ($data->level == 3) ? 'selected' : ''; ?>>3 (Fakultas/Direktorat/Kepala Unit)</option>
                        <option value="4" <?php echo ($data->level == 4) ? 'selected' : ''; ?>>4 (Fungsi/Program Studi)</option>
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
                    <a href="<?php echo base_url() ?>hrd/master/organization" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
            </div>
          </div>