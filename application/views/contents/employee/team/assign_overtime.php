        <div class="modal fade" id="modal-add-data">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Buat Lembur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url() ?>employee/approve/create_overtime" method="POST">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Pegawai Lembur</label>
                        <div id="assign-overtime">
                          <p>                          
                          <select class="form-control" name="employee_id[]" required>
                            <option value=""> -- Pilih Pegawai -- </option>
                            <?php foreach ($employee->result() as $emp): ?>
                              <option value="<?php echo $emp->employee_id ?>"><?php echo $emp->nip.' - '.$emp->name ?></option>
                            <?php endforeach ?>
                          </select>
                          </p>
                        </div>
                      </div>

                      <div class="form-group">
                        <div style="text-align: right;">                          
                          <a href="" id="addrow">+ Tambah Pegawai</a>  
                        </div>               
                      </div>
                      
                      <div class="form-group">
                        <label>Tanggal</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="text" class="form-control datepicker" name="overtime_date" required>
                        </div>
                      </div>
                      <div class="form-group">                        
                        <div class="row">
                          <div class="col-md-6">
                            <label>Mulai</label>
                            <div class="input-group" id="timepicker" data-target-input="nearest">
                              <div class="input-group-prepend" data-target="#timepicker" data-toggle="datetimepicker">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                              </div>
                              <input type="text" name="start" class="form-control datetimepicker-input" data-target="#timepicker" data-toggle="datetimepicker" required>
                            </div>
                          </div>
                          <div class="col-md-6">                          
                            <label>Selesai</label>
                            <div class="input-group" id="timepicker2" data-target-input="nearest">
                              <div class="input-group-prepend" data-target="#timepicker2" data-toggle="datetimepicker">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                              </div>
                              <input type="text" name="finish" class="form-control datetimepicker-input" data-target="#timepicker2" data-toggle="datetimepicker" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Tempat</label>
                        <input type="text" class="form-control" name="place" required>
                      </div>
                      <div class="form-group">
                        <label>Detail Tugas Lembur</label>
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