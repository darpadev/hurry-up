        <div class="modal fade" id="modal-add-data">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Buat Kegiatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url() ?>employee/timesheet/store" method="POST">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                                              
                          <div id="timesheet-update">
                            <p>
                              <div class="row">
                                <div class="col-sm-2">
                                  <div class="form-group">
                                    <label>Tanggal</label>
                                    <div class="input-group">
                                      <input type="text" name="date_on[]" class="form-control datepicker-timesheet" required>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-sm-2">       
                                  <div class="form-group">
                                    <label>Durasi (Menit)</label>
                                    <div class="input-group">
                                      <input type="number" min="0" name="duration[]" class="form-control" required>
                                    </div>
                                  </div>                   
                                </div>

                                <div class="col-sm-4">              
                                  <div class="form-group">
                                    <label>Tupoksi</label>
                                    <select class="form-control" name="tupoksi[]" required>
                                      <option value=""> -- Pilih Tugas Pokok -- </option>
                                      <?php foreach ($tupoksi as $value): ?>
                                        <option value="<?= $value->id ?>"><?= $value->tupoksi ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>                  
                                </div>

                                <div class="col-sm-4">              
                                  <div class="form-group">
                                    <label>Kegiatan</label>
                                    <input type="text" class="form-control" name="activity[]" required>
                                  </div>                  
                                </div>             
                              </div> 
                            </p>
                          </div>

                          <div class="form-group">
                            <div style="text-align: right;">                          
                              <a href="" id="add-timesheet">+ Tambah Kegiatan</a>  
                            </div>               
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