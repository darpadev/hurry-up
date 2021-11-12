      <div class="row">
        <div class="col-md-12">
            <div class="card-body">
              <form action="<?php echo base_url() ?>hrd/report/overtime" method="GET">
                <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Anggota</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-user"></i>
                          </span>
                        </div>
                        <select class="form-control" name="employee">
                          <option <?php echo (isset($_GET['employee'])) ? 'selected': ''; ?>>Semua</option>
                          <?php foreach ($employee->result() as $emp): ?>
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

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Organisasi</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-user-secret"></i>
                          </span>
                        </div>
                        <select class="form-control" name="org_unit">
                          <option <?php echo (isset($_GET['org_unit'])) ? 'selected': ''; ?>>Semua</option>
                          <?php foreach ($organizations->result() as $org): ?>
                            <option <?php echo (isset($_GET['org_unit']) && $_GET['org_unit'] == $org->id) ? 'selected': ''; ?> value="<?php echo $org->id ?>"><?php echo $org->org_unit ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>                    
                  </div>
                </div>

                </div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
                  </div>
              </form>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-header">
              <strong>Laporan Anggota</strong>
            </div>
             
            <div class="card-body">              
              <div class="chart">
                <canvas id="memberChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-header">
              <strong>Laporan Organisasi</strong>
            </div>
             
            <div class="card-body">              
              <div class="chart">
                <canvas id="orgChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card card-danger">
            <div class="card-header">
              <strong>Laporan Tahunan Anggota</strong>
            </div>

            <div class="card-body">
              <div class="center" style="margin-bottom: 2%">
                <select id="annualEmp" required style="width: 15% !important; display: inline-block !important;">
                  <option <?php echo (date('Y') == '2016') ? 'selected' : '' ?> value="2016">2016</option>
                  <option <?php echo (date('Y') == '2017') ? 'selected' : '' ?> value="2017">2017</option>
                  <option <?php echo (date('Y') == '2018') ? 'selected' : '' ?> value="2018">2018</option>
                  <option <?php echo (date('Y') == '2019') ? 'selected' : '' ?> value="2019">2019</option>
                  <option <?php echo (date('Y') == '2020') ? 'selected' : '' ?> value="2020">2020</option>
                  <option <?php echo (date('Y') == '2021') ? 'selected' : '' ?> value="2021">2021</option>
                </select>                 
              </div>    

              <div class="chart">
                <canvas id="annualMemberChart" style="min-height: 1000px; height: 1000px; max-height: 1000px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card card-danger">
            <div class="card-header">
              <strong>Laporan Tahunan Organisasi</strong>
            </div>
             
            <div class="card-body">  
              <div class="center" style="margin-bottom: 2%">
                <select id="annualOrg" required style="width: 15% !important; display: inline-block !important;">
                  <option <?php echo (date('Y') == '2016') ? 'selected' : '' ?> value="2016">2016</option>
                  <option <?php echo (date('Y') == '2017') ? 'selected' : '' ?> value="2017">2017</option>
                  <option <?php echo (date('Y') == '2018') ? 'selected' : '' ?> value="2018">2018</option>
                  <option <?php echo (date('Y') == '2019') ? 'selected' : '' ?> value="2019">2019</option>
                  <option <?php echo (date('Y') == '2020') ? 'selected' : '' ?> value="2020">2020</option>
                  <option <?php echo (date('Y') == '2021') ? 'selected' : '' ?> value="2021">2021</option>
                </select>                 
              </div>    

              <div class="chart">
                <canvas id="annualOrgChart" style="min-height: 1000px; height: 1000px; max-height: 1000px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>