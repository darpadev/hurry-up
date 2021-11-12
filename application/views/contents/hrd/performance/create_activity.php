        <div class="modal fade" id="modal-add-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Kegiatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url() ?>hrd/performance/store_activity" method="POST">
                  <input type="hidden" name="pac_id" value="<?= $this->uri->segment(4)  ?>">
                <div class="box-body">

                  <div class="form-group">
                    <label>Kegiatan</label>
                    <select name="activity" class="form-control" required>
                      <option value=""> -- Pilih Aktivitas Penilaian -- </option>
                    <?php foreach ($this->db->get('performance_activity_types')->result() as $value): ?>
                      <option value="<?= $value->id ?>"><?= $value->type  ?></option>
                    <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Mulai</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control datepicker" name="start" required>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label>Selesai</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control datepicker" name="finish" required>
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