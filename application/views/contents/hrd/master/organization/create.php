        <div class="modal fade" id="modal-add-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Organisasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url() ?>hrd/master/store_organization" method="POST">
                <div class="box-body">
                  <div class="form-group">
                    <label>Organisasi</label>
                    <input type="text" name="org_unit" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Organisasi Parent</label>
                    <select name="parent_id" class="=form-control" required>
                      <option value=""> -- Pilih Organisasi -- </option>
                      <?php foreach ($data->result() as $org): ?>                    
                      <option value="<?php echo $org->id ?>"><?php echo $org->org_unit ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tipe</label>
                    <select name="type_id" class="=form-control" required>
                      <option value=""> -- Pilih Tipe -- </option>
                      <?php foreach ($this->db->select('*')->from('org_types')->order_by('id', 'ASC')->get()->result() as $type): ?>                        
                      <option value="<?php echo $type->id ?>"><?php echo $type->type ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Kode Organisasi</label>
                    <input type="text" name="code" class="form-control" required>
                  </div>

                  <div class="form-group">
                    <label>Level</label>
                    <select name="level" class="form-control" required>                      
                      <option value="1">1 (Rektor)</option>
                      <option value="2">2 (Wakil Rektor/Dewan)</option>
                      <option value="3">3 (Fakultas/Direktorat/Kepala Unit)</option>
                      <option value="4">4 (Fungsi/Program Studi)</option>
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