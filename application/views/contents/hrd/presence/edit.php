          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Ubah Presensi</h3>
              </div>
              <form action="<?php echo base_url() ?>hrd/presence/update/<?php echo $data->id ?>" method="POST">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Nama</label>
                        <select name="employee_pt_id" class="form-control" required disabled>
                          <option value=""> -- Pilih Pegawai -- </option>
                          <?php foreach ($this->db->select('ep.employee_id, ep.nip, e.name')->from('employee_pt as ep')->join('employees as e', 'e.id = ep.employee_id')->get()->result() as $emp): ?>
                            <option <?php echo ($emp->employee_id == $data->emp_id) ? 'selected' : '' ?> value="<?php echo $emp->employee_id ?>"><?php echo $emp->nip.' - '.$emp->name ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Tanggal</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="text" class="form-control datepicker" name="date" value="<?php echo date('d-m-Y', strtotime($data->date)) ?>" required>
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
                              <input type="text" name="checkin" class="form-control datetimepicker-input" data-target="#timepicker" data-toggle="datetimepicker" value="<?php echo date('H:i:s', strtotime($data->checkin)) ?>" required>
                            </div>
                          </div>
                          <div class="col-md-6">                          
                            <label>Jam Pulang</label>
                            <div class="input-group" id="timepicker2" data-target-input="nearest">
                              <div class="input-group-prepend" data-target="#timepicker2" data-toggle="datetimepicker">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                              </div>
                              <input type="text" name="checkout" class="form-control datetimepicker-input" data-target="#timepicker2" data-toggle="datetimepicker" value="<?php echo date('H:i:s', strtotime($data->checkout)) ?>" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                          <option value=""> -- Pilih Status -- </option>
                          <?php foreach ($this->db->get('presence_status')->result() as $stat): ?>
                            <option <?php echo ($stat->id == $data->status_id) ? 'selected' : '' ?> value="<?php echo $stat->id ?>"><?php echo $stat->status ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Keterangan (Optional)</label>
                        <textarea class="form-control" name="notes"><?php echo $data->notes ?></textarea>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Tipe</label>
                        <select name="type" class="form-control" required>
                          <option value=""> -- Pilih Tipe -- </option>
                          <?php foreach ($this->db->get('presence_types')->result() as $typ): ?>
                            <option <?php echo ($typ->id == $data->type) ? 'selected' : '' ?> value="<?php echo $typ->id ?>"><?php echo $typ->type ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                       
                      <div class="form-group clearfix">
                        <label>Kondisi Kesehatan (Optional)</label>
                        <div style="border: 0" class="form-control">
                          <div class="icheck-primary d-inline">
                          <input <?php echo ($data->condition == 'Sehat') ? 'checked' : '' ?> type="radio" id="radioPrimary1" name="condition" value="Sehat"><label for="radioPrimary1">Sehat &nbsp;&nbsp;</label>
                          </div>
                          <div class="icheck-primary d-inline">
                          <input <?php echo ($data->condition == 'Sakit') ? 'checked' : '' ?> type="radio" id="radioPrimary2" name="condition" value="Sakit"> <label for="radioPrimary2">Sakit</label>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Suhu Badan (°C)</label>
                        <input type="number" step="0.01" class="form-control" name="temperature" value="<?php echo $data->temperature ?>"/>
                      </div>

                      <div class="form-group">
                        <label>Kota Absen (Optional)</label>
                        <select name="city" class="form-control">
                          <option value=""> -- Pilih Kota -- </option>
                          <?php foreach ($this->db->get('geo_cities')->result() as $city): ?>
                            <option <?php echo ($city->id == $data->city_id) ? 'selected' : '' ?> value="<?php echo $city->id ?>"><?php echo $city->city ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>                      
                      <div class="form-group">
                        <label>Keluhan Kesehatan (Optional)</label>
                        <textarea class="form-control" name="health_records"><?php echo $data->health_records ?></textarea>
                      </div>
                    </div>
                  </div> 
                </div>

                <div class="card-footer">
                  <div class="float-right">
                    <?php if (isset($_GET['group']) && isset($_GET['nip']) && isset($_GET['type']) && isset($_GET['date'])): ?>
                      <a class="btn btn-default" href="<?php echo base_url() ?>hrd/presence<?php echo '?group='.$_GET['group'].'&nip='.$_GET['nip'].'&type='.$_GET['type'].'&date='.$_GET['date'] ?>"><span class="fa fa-reply"></span>&nbsp;&nbsp; Kembali</a>
                    <?php else : ?>
                      <a class="btn btn-default" href="<?php echo base_url() ?>hrd/presence"><span class="fa fa-reply"></span>&nbsp;&nbsp; Kembali</a>  
                    <?php endif ?>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
            </div>
          </div>