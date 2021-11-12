          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Ubah Jabatan Pegawai</h3>
              </div>
              <form action="<?php echo base_url() ?>hrd/master/update_employee_position/<?php echo $data->id ?>" method="POST">
                <div class="card-body">
                  <div class="form-group">
                  <label>NIP</label>
                  <input type="text" class="form-control" value="<?= $data->nip ?>" readonly>
                  </div>

                  <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" value="<?= $data->name ?>" readonly>
                  </div>

                  <div class="form-group">
                  <label>Jabatan</label>
                  <input type="text" class="form-control" value="<?= $data->position ?>" readonly>
                  <input type="hidden" class="form-control" name="position_id" value="<?= $data->position_id ?>">
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Mulai</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="text" class="form-control datepicker" name="start_date" value="<?php echo date('d-m-Y', strtotime($data->start_date)) ?>" required>
                        </div>
                      </div>                    
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Sampai</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <?php if ($data->end_date): ?>
                            <input type="text" class="form-control datepicker" name="end_date" value="<?php echo date('d-m-Y', strtotime($data->end_date)) ?>">
                          <?php else : ?>
                            <input type="date" class="form-control" name="end_date">
                          <?php endif ?>
                        </div>
                      </div>                    
                    </div>
                  </div>
                  
                  <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                      <input <?php echo ($data->flag == TRUE) ? 'checked' : ''; ?> type="radio" id="radioPrimary3" name="flag" required value="1">
                      <label for="radioPrimary3">
                        Aktif &nbsp;
                      </label>
                    </div>
                    <div class="icheck-primary d-inline">
                      <input <?php echo ($data->flag == FALSE) ? 'checked' : ''; ?> type="radio" id="radioPrimary2" name="flag" required value="0">
                      <label for="radioPrimary2">
                        Tidak Aktif
                      </label>
                    </div>
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