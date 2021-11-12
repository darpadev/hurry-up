      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 style="text-align: center;">Data Presensi</h3>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url() ?>hrd/report/presence" method="POST">
                <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Grup</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-secret"></i></span>
                        </div>
                        <select class="form-control" name="group">
                          <option <?php echo (isset($_POST['group'])) ? 'selected': ''; ?>>Semua</option>
                          <option <?php echo (isset($_POST['group']) && $_POST['group'] == 1) ? 'selected': ''; ?> value="1">Tenaga Kependidikan</option>
                          <option <?php echo (isset($_POST['group']) && $_POST['group'] == 2) ? 'selected': ''; ?> value="2">Dosen</option>
                          <option <?php echo (isset($_POST['group']) && $_POST['group'] == 3) ? 'selected': ''; ?> value="3">Tenaga Lepas</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Tempat</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                        </div>
                        <select class="form-control" name="type">
                          <option <?php echo (isset($_POST['type'])) ? 'selected': ''; ?>>Semua</option>
                          <option <?php echo (isset($_POST['type']) && $_POST['type'] == 1) ? 'selected': ''; ?> value="1">Work From Office</option>
                          <option <?php echo (isset($_POST['type']) && $_POST['type'] == 2) ? 'selected': ''; ?> value="2">Work From Home</option>
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
                        <input type="text" id="range-cuti" name="date" class="form-control float-right" value="<?php if (isset($_POST['date'])) { echo $_POST['date']; } ?>">
                      </div>
                    </div>                   
                  </div>
                </div>

                </div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-download"></span> Unduh</button>
                  </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 style="text-align: center;">Data Pribadi Pegawai</h3>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url() ?>hrd/report/employee" method="POST">
                <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Grup</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-secret"></i></span>
                        </div>
                        <select class="form-control" name="group">
                          <option <?php echo (isset($_POST['group'])) ? 'selected': ''; ?>>Semua</option>
                          <option <?php echo (isset($_POST['group']) && $_POST['group'] == 1) ? 'selected': ''; ?> value="1">Tenaga Kependidikan</option>
                          <option <?php echo (isset($_POST['group']) && $_POST['group'] == 2) ? 'selected': ''; ?> value="2">Dosen</option>
                          <option <?php echo (isset($_POST['group']) && $_POST['group'] == 3) ? 'selected': ''; ?> value="3">Tenaga Lepas</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Status Pegawai</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-tags"></i>
                          </span>
                        </div>
                        <select class="form-control" name="status">
                          <option <?php echo (isset($_POST['status'])) ? 'selected': ''; ?>>Semua</option> 
                          <?php foreach ($this->db->get('employee_status')->result() as $stat): ?>
                            <option <?php echo (isset($_POST['status']) && $_POST['status'] == $stat->id) ? 'selected': ''; ?> value="<?php echo $stat->id ?>"><?php echo $stat->status ?></option>   
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>                    
                  </div>
                </div>

                </div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-download"></span> Unduh</button>
                  </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 style="text-align: center;">Data Pegawai Perusahaan</h3>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url() ?>hrd/report/employee_pt" method="POST">
                <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Grup</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <select class="form-control" name="group">
                          <option <?php echo (isset($_POST['group'])) ? 'selected': ''; ?>>Semua</option>
                          <option <?php echo (isset($_POST['group']) && $_POST['group'] == 1) ? 'selected': ''; ?> value="1">Tenaga Kependidikan</option>
                          <option <?php echo (isset($_POST['group']) && $_POST['group'] == 2) ? 'selected': ''; ?> value="2">Dosen</option>
                          <option <?php echo (isset($_POST['group']) && $_POST['group'] == 3) ? 'selected': ''; ?> value="3">Tenaga Lepas</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Status Pegawai</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-tags"></i>
                          </span>
                        </div>
                        <select class="form-control" name="status">
                          <option <?php echo (isset($_POST['status'])) ? 'selected': ''; ?>>Semua</option>                          
                          <?php foreach ($this->db->get('employee_status')->result() as $stat): ?>
                            <option <?php echo (isset($_POST['status']) && $_POST['status'] == $stat->id) ? 'selected': ''; ?> value="<?php echo $stat->id ?>"><?php echo $stat->status ?></option>   
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>                    
                  </div>
                </div>

                </div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-download"></span> Unduh</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>