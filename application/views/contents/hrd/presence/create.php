        <div class="modal fade" id="modal-add-data">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Presensi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url() ?>hrd/presence/store" method="POST">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Nama</label>
                        <select name="employee_id" class="form-control" required>
                          <option value=""> -- Pilih Pegawai -- </option>
                          <?php foreach ($this->db->select('ep.employee_id, e.name')->from('employee_pt as ep')->join('employees as e', 'e.id = ep.employee_id')->get()->result() as $emp): ?>
                            <option value="<?php echo $emp->employee_id ?>"><?php echo $emp->name ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Tanggal</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="text" class="form-control datepicker" name="date" required>
                        </div>
                      </div>
                      <div class="form-group">                        
                        <div class="row">
                          <div class="col-md-6">
                            <label>Jam Masuk</label>
                            <div class="input-group" id="timepicker" data-target-input="nearest">
                              <div class="input-group-prepend" data-target="#timepicker" data-toggle="datetimepicker">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                              </div>
                              <input type="text" name="checkin" class="form-control datetimepicker-input" data-target="#timepicker" data-toggle="datetimepicker" required>
                            </div>
                          </div>
                          <div class="col-md-6">                          
                            <label>Jam Pulang</label>
                            <div class="input-group" id="timepicker2" data-target-input="nearest">
                              <div class="input-group-prepend" data-target="#timepicker2" data-toggle="datetimepicker">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                              </div>
                              <input type="text" name="checkout" class="form-control datetimepicker-input" data-target="#timepicker2" data-toggle="datetimepicker" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                          <option value=""> -- Pilih Status -- </option>
                          <?php foreach ($this->db->get('presence_status')->result() as $stat): ?>
                            <option value="<?php echo $stat->id ?>"><?php echo $stat->status ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="notes"></textarea>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Tipe</label>
                        <select name="type" id="type" class="form-control" required>
                          <option value=""> -- Pilih Tipe -- </option>
                          <?php foreach ($this->db->get('presence_types')->result() as $typ): ?>
                            <option value="<?php echo $typ->id ?>"><?php echo $typ->type ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>

                      <div id="wfh">
                        <div class="form-group clearfix">
                          <label>Kondisi Kesehatan</label>
                          <div style="border: 0" class="form-control">
                            <div class="icheck-primary d-inline">
                            <input type="radio" id="radioPrimary1" name="condition" value="Sehat"><label for="radioPrimary1">Sehat &nbsp;&nbsp;</label>
                            </div>
                            <div class="icheck-primary d-inline">
                            <input type="radio" id="radioPrimary2" name="condition" value="Sakit"> <label for="radioPrimary2">Sakit</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Suhu Badan (°C)</label>
                          <input type="number" step="0.01" class="form-control" name="temperature"/>
                        </div>
                        <div class="form-group">
                          <label>Kota Absen</label>
                          <select name="city" id="city" class="form-control">
                            <option value=""> -- Pilih Kota -- </option>
                            <?php foreach ($this->db->get('geo_cities')->result() as $city): ?>
                              <option value="<?php echo $city->id ?>"><?php echo $city->city ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>                      
                        <div class="form-group">
                          <label>Keluhan Kesehatan (Optional)</label>
                          <textarea class="form-control" name="health_records"></textarea>
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