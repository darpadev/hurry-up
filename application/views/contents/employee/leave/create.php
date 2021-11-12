        <div class="modal fade" id="modal-add-data">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Buat Izin Kerja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url() ?>employee/leave/store" method="POST">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Tanggal</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" id="create-cuti" name="date" class="form-control float-right">
                        </div>
                      </div>
                      <?php 
                      $diff = abs(strtotime(date('Y-m-d')) - strtotime($param_leave->join_date));
                      $years = floor($diff / (365*60*60*24)); ?>
                      <div class="form-group">
                        <label>Jenis</label>
                        <select class="form-control" name="type" required>
                          <option value=""> -- Pilih Jenis Izin -- </option>
                            <?php if ($years == 0): ?>
                              <?php foreach ($this->db->get('leave_types')->result() as $typ): ?>
                              <?php if ($typ->id != 1): ?>
                                <option value="<?php echo $typ->id ?>"><?php echo $typ->type ?></option>                              
                              <?php endif ?>
                              <?php endforeach ?>
                            <?php else: ?>                              
                            <?php foreach ($this->db->get('leave_types')->result() as $typ): ?>
                              <option value="<?php echo $typ->id ?>"><?php echo $typ->type ?></option>  
                            <?php endforeach ?>
                            <?php endif ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Keperluan</label>
                        <textarea class="form-control" name="description"></textarea>
                      </div>
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