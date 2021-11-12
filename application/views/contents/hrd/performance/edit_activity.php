<div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Ubah Detail Kalendar</h3>
              </div>
              <form action="<?php echo base_url() ?>hrd/performance/update_activity/<?php echo $data->id ?>" method="POST">
                <div class="card-body">
                <input type="hidden" name="pac_id" value="<?php echo $data->pac_id  ?>">
                  <div class="form-group">
                    <label>Kegiatan</label>
                    <select name="activity" class="form-control" required>
                      <option value="<?php echo $data->id ?>"><?php echo $data->type ?></option>
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
                      <input type="text" class="form-control datepicker" name="start" required value="<?php echo date('d-m-Y', strtotime($data->start)) ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Selesai</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control datepicker" name="finish" required value="<?php echo date('d-m-Y', strtotime($data->finish)) ?>">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a href="<?php echo base_url() ?>hrd/performance/calendar" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
            </div>
          </div>