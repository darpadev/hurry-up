        <div class="modal fade" id="modal-add-data">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Jabatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url() ?>hrd/master/store_position" method="POST">
                <div class="box-body">
                  <div class="form-group">
                    <label>Organisasi</label>
                    <select class="form-control" name="org_unit" required>
                      <option value=""> -- Pilih Organisasi -- </option>
                      <?php foreach ($organizations->result() as $value): ?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->org_unit ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Atasan</label>
                    <select class="form-control" name="parent_id">
                      <option value=""> -- Pilih Atasan -- </option>
                      <?php foreach ($positions->result() as $value): ?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="position" class="form-control" required>
                  </div>

                  <div class="form-group">
                    <label>Level</label>
                    <select name="level" class="form-control" required>                      
                      <option value="1">1 (Rektor)</option>
                      <option value="2">2 (Wakil Rektor/Dewan/Senat)</option>
                      <option value="3">3 (Dekan/Direktur/Kepala Unit)</option>
                      <option value="4">4 (Manajer/Kaprodi)</option>
                    </select>
                  </div>

                  <!-- <div class="form-group">
                    <label>Approver Izin Kerja</label>
                    <div id="approver-cuti">
                      <p>
                      <div class="input-group">                      
                        <select class="form-control" name="approver_cuti[]" required>
                          <option value=""> -- Pilih Approver -- </option>
                          <?php foreach ($this->db->select('id, position')->from('positions')->order_by('position', 'ASC')->get()->result() as $value): ?>
                            <option value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                          <?php endforeach ?>
                        </select>
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <input type="button" class="btn btn-xs btn-success" id="addrow" value="Tambah" />
                          </span>
                        </div>
                      </div>
                      </p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Approver Lembur (Optional)</label>                    
                    <select class="form-control" name="approver_lembur">
                      <option value=""> -- Pilih Approver -- </option>
                      <?php foreach ($this->db->select('id, position')->from('positions')->order_by('id', 'ASC')->get()->result() as $value): ?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                      <?php endforeach ?>
                    </select>
                  </div> -->
                </div>

                <div class="modal-footer">
                  <div class="float-right">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>