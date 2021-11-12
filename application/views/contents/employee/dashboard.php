        <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<style>
  .center {
    text-align: center;
  }
</style>

        <div class="row">
          <div class="col-md-12">            
            <div style="padding-bottom: 0" class="alert alert-block alert-warning">
              <button type="button" class="close" data-dismiss="alert">
                <i class="fa fa-times"></i>
              </button>

              <p style="text-align: justify; margin-right: 3%">Sehubung dengan Surat Edaran <strong>No.0050/UP-R/SE/III/2020</strong> tanggal 31 Maret 2020 tentang Tindak Lanjut Pencegahan Penyebaran Corona Virus Disease (COVID-19) yang menyebabkan pegawai melakukan <strong><i>Work From Home</i></strong>, maka absensi datang dan pulang pegawai dilakukan dengan cara menekan tombol <i>Checkin</i> dan <i>Checkout</i> dibawah.</p>
            </div> 
          </div> 
        </div>

        <div class="row">
          <div class="col-md-12">

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ketersediaan Pegawai</h3>
              </div>

              <div class="card-body">
                <form action="<?php echo base_url() ?>employee/home" method="GET">
                  <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Organisasi</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fa fa-users"></i>
                            </span>
                          </div>
                          <select class="form-control" name="org_unit">
                            <option <?php echo (isset($_GET['org_unit'])) ? 'selected': ''; ?>>Semua</option>
                            <?php 
                            $organizations = $this->db->select('o.id, o.org_unit')->from('organizations as o')->order_by('o.org_unit', 'ASC')->get();
                            foreach ($organizations->result() as $org): ?>
                              <option <?php echo (isset($_GET['org_unit']) && $_GET['org_unit'] == $org->id) ? 'selected': ''; ?> value="<?php echo $org->id ?>"><?php echo $org->org_unit ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>                    
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Pegawai</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fa fa-user"></i>
                            </span>
                          </div>
                          <select class="form-control" name="employee">
                            <option <?php echo (isset($_GET['employee'])) ? 'selected': ''; ?>>Semua</option>
                            <?php 
                            $employee = $this->db->select('ep.employee_id, e.name, ep.nip')->from('employee_pt as ep')->join('employees as e', 'e.id = ep.employee_id')->order_by('ep.nip', 'ASC')->get();
                            foreach ($employee->result() as $emp): ?>
                              <option <?php echo (isset($_GET['employee']) && $_GET['employee'] == $emp->employee_id) ? 'selected': ''; ?> value="<?php echo $emp->employee_id ?>"><?php echo $emp->nip.' - '.$emp->name ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>                    
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tanggal</label>
                        <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="far fa-calendar-alt"></i>
                                </span>
                              </div>
                              <input type="text" id="range-cuti" name="date" class="form-control float-right" value="<?php if (isset($_GET['date'])) { echo $_GET['date']; } ?>">
                            </div>
                      </div>                    
                    </div>

                  </div>

                  </div>
                    <div style="text-align: right;">
                      <button type="submit" class="btn btn-info"><span class="fa fa-search"></span> &nbsp;Cari</button>
                    </div>
                </form>  

                <?php if (isset($_GET['date']) && isset($_GET['employee']) && isset($_GET['org_unit'])): ?>
                <div class="row" style="padding-top: 1%;">
                  <div class="col-md-12">
                    <div class="card" id="available">
                      <div class="card-body">
                        <table id="table" class="table display table-bordered table-striped dt-responsive nowrap">
                          <thead>
                          <tr>
                            <th class="center">Nama</th>
                            <?php foreach ($days as $day): ?>
                              <th class="center"><?= tanggal($day) ?></th>
                            <?php endforeach ?>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          foreach ($available->result() as $value) {
                          ?>
                          <tr>
                            <td><a href="" onclick="getDataEmployee(<?= $value->employee_id ?>)" data-target="#modal-detail-employee" data-toggle="modal"><?php echo $value->name ?></a></td>
                            <?php foreach ($days as $day): 
                              $check = $this->db->select('lp.status')->from('log_presences as lp')->join('presence_status as ps', 'ps.id = lp.status')->where(array('lp.employee_id' => $value->employee_id, 'lp.date' => $day))->get()->row();
                              $curr = date('l', strtotime($day));
                              if ($curr == 'Sunday' || $curr == 'Saturday') : ?>                                
                                  <td class="center" style="background: #c34f5a;">-</td>
                              <?php else:
                              if ($check && $check->status == 4): ?>
                                  <td class="center" style="background: #c34f5a;">C</td>                              
                                <?php elseif ($check && $check->status == 5): ?>
                                  <td class="center" style="background: #fff2ca;">D</td>
                                <?php else: ?>
                                  <td class="center" style="background: #66cc66;">A</td>
                                <?php endif;
                              endif;
                            endforeach ?>
                          </tr>
                          <?php } ?>
                        </table>
                      </div>
                    </div>
                  </div> 
                </div>                         
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <section class="col-md-5 connectedSortable">

            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title" style="">Presensi <i><strong>Work From Home</strong></i> <?php echo tanggal(date('Y-m-d')); ?></h3>
              </div>

              <div class="card-body">
                <?php 
                $emp = $this->db->select('employee_id')->from('employee_pt')->where('user_id', $this->session->userdata('id'))->get()->row();
                $check = $this->db->select('id, employee_id, checkin, checkout')->from('log_presences')->where(array('employee_id' => $emp->employee_id, 'date' => date('Y-m-d')))->get()->row();

                if ($check) {
                  $checkLoc = $this->db->get_where('log_remote_presences', array('lat_checkin' => NULL, 'presences_id' => $check->id))->row();
                }                
                ?>

                <div class="col-md-12">
                  <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>employee/home/checkin">
                    <div class="form-group" id="kota">
                      <label> Kota <span style="color: red;">*</span> </label>

                      <select class="kota form-control" name="city" required>
                        <option value="">Pilih kota Anda ...</option>
                        <?php foreach ($this->db->get('geo_cities')->result() as $city) { ?>
                          <option value="<?php echo $city->id ?>"><?php echo $city->city ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group" id="kondisi">
                      <label> Kondisi saat ini <span style="color: red;">*</span> </label>
                      <div style="border: 0" class="form-control">
                        <div class="icheck-primary d-inline">
                        <input class="kondisi" type="radio" id="sehat" name="condition" value="Sehat" required><label for="sehat">Sehat &nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-primary d-inline">
                        <input class="kondisi" type="radio" id="sakit" name="condition" value="Sakit" required> <label for="sakit">Sakit</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group" id="suhu">
                      <label> Suhu Badan <span style="color: red;">*</span> </label>

                      <div class="col-sm-7">
                        <input class="form-control suhu" type="number" step="0.01" name="temperature" required>
                      </div>
                    </div>

                    <div id="keterangan" class="form-group">
                      <label> Apakah Anda mengalami salah satu dari gejala di bawah ini? </label>

                      <div class="col-sm-7">
                        <input type="checkbox" name="notes[]" value="Demam di atas 37° C"> &nbsp;&nbsp;Demam di atas 37° C <br>
                        <input type="checkbox" name="notes[]" value="Batuk"> &nbsp;&nbsp;Batuk <br>
                        <input type="checkbox" name="notes[]" value="Bersin-bersin"> &nbsp;&nbsp;Bersin-bersin <br>
                        <input type="checkbox" name="notes[]" value="Sakit tenggorokan"> &nbsp;&nbsp;Sakit tenggorokan <br>
                        <input type="checkbox" name="notes[]" value="Kesulitan bernafas"> &nbsp;&nbsp;Kesulitan bernafas <br>
                        <input class="form-control" type="text" name="notes[]" placeholder="Lainnya...">
                      </div>
                    </div>

                    <div id='div_session_write'> </div>

                    <div class="form-group">
                      <!-- <label class="col-sm-5 control-label no-padding-right"></label> -->

                      <div class="col-sm-12">
                      <?php if (!$check) { ?>
                        <button class="btn btn-success checkin">Checkin</button>
                        <button class="btn btn-warning checkout" disabled>Checkout</button>
                      <?php } else { if (empty($checkLoc)) { ?>
                        <button class="btn btn-success checkin" disabled>Checkin</button>
                        <button class="btn btn-warning checkout">Checkout</button>
                      <?php } else { ?>
                        <button class="btn btn-success checkin">Checkin</button>
                        <button class="btn btn-warning checkout" disabled>Checkout</button>
                      <?php }} ?>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </section>

          <section class="col-md-7 connectedSortable">

            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Pengumuman</h3>
              </div>

              <div class="card-body">
                
              </div>
            </div>
            
            <!-- <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Kalender
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>

              </div>

              <div class="card-body pt-0">
                <div id="calendar" style="width: 100%"></div>
              </div>
            </div> -->
          </section>
        </div>

        <!-- <script>$('select').selectize({});</script> -->