        <div class="modal fade" id="modal-add-leave">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Approver Izin Kerja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url() ?>hrd/approver/store_leave/<?php echo $this->uri->segment(4) ?>" method="POST">
                <div class="box-body">
                  <div class="form-group">
                    <label>Approver Izin Kerja</label>
                    <div id="approver-cuti">
                      <p>
                      <div class="input-group">                      
                        <select class="form-control" name="approver_cuti[]" required>
                          <option value=""> -- Pilih Approver Izin Kerja -- </option>
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

        <div class="modal fade" id="modal-add-overtime">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Approver Lembur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url() ?>hrd/approver/store_overtime/<?php echo $this->uri->segment(4) ?>" method="POST">
                <div class="box-body">
                  <div class="form-group">
                    <label>Approver</label>
                    <select class="form-control" name="approver_lembur" required>
                      <option value=""> -- Pilih Approver Lembur -- </option>
                      <?php foreach ($this->db->select('id, position')->from('positions')->order_by('position', 'ASC')->get()->result() as $value): ?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
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