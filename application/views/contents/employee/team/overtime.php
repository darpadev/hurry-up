      <div class="row">
        <div class="col-md-12">
            <div class="card-body">
              <form action="<?php echo base_url() ?>employee/team/overtime" method="GET">
                <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
                <div class="row">
                  <div class="col-md-6">
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
                  <div class="col-md-6">
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

                <div class="row">
                  <div class="col-md-6">                    
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
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Approval</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-tags"></i>
                          </span>
                        </div>
                        <select class="form-control" name="approval">
                          <option <?php echo (isset($_GET['approval'])) ? 'selected': ''; ?>>Semua</option>
                          <?php foreach ($this->db->get('approval_status')->result() as $value): ?>
                            <option <?php echo (isset($_GET['approval']) && $_GET['approval'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->status ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>                    
                  </div>
                </div>

                </div>
                  <?php if (array_intersect($level, array(4))): ?>
                    <div class="float-left">
                      <a href="<?php echo base_url() ?>" class="btn btn-success create-data" data-target="#modal-add-data" data-toggle="modal"><span class="fa fa-envelope"></span> &nbsp;Ajukan Lembur</a>
                    </div>                    
                  <?php endif ?>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
                  </div>
              </form>

              <?php if (array_intersect($level, array(4))): ?>
              <?php $this->load->view('contents/employee/team/assign_overtime') ?>         
              <?php endif ?>
            </div>
        </div>
      </div>

      <?php if (isset($_GET['date']) || isset($_GET['approval']) || isset($_GET['employee'])): ?>
        <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">No. Penugasan</th>
                  <th class="center">Nama</th>
                  <th class="center">Tanggal</th>
                  <th class="center">Lembur</th>
                  <th class="center">Durasi</th>
                  <th style="width: auto;" class="center">Status</th>
                  <th style="width: auto;" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {

                  $finish = new DateTime($value->finish);
                  $start = new DateTime($value->start);

                  $interval = $finish->diff($start);
                  $elapsed = $interval->format('%H:%I:%S');

                  switch ($value->status) {
                    case 'Approved':
                      $color = 'btn-success';
                      break;
                    
                    case 'Rejected':
                      $color = 'btn-danger';
                      break;
                    
                    case 'Waiting for Approval':
                      $color = 'btn-primary';
                      break;
                    
                    case 'Cancelled':
                      $color = 'btn-secondary';
                      break;
                    
                    case 'Reported':
                      $color = 'btn-warning';
                      break;

                    default:
                      $color = 'btn-info';
                      break;
                  }
                  ?>
                <tr style="<?php echo ($value->status == 'Approved') ? 'background: #f37272;' : ''; ?>">
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->no_assignment ?></td>
                  <td><?php echo $value->name ?></td>
                  <td><?php echo date('j F Y', strtotime($value->overtime_date)) ?></td>
                  <td class="center"><?php echo date('H:i:s', strtotime($value->start)).' s/d '.date('H:i:s', strtotime($value->finish)) ?></td>
                  <td class="center"><?php echo $elapsed ?></td>
                  <td class="center">
                    <label class="btn btn-xs <?php echo $color ?>"><?php echo $value->status ?></label>
                  </td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>employee/team/show_overtime/<?php echo $value->id.'?date='.$_GET['date'].'&approval='.$_GET['approval'].'&employee='.$_GET['employee'] ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>

                    <?php if (date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', strtotime($value->overtime_date.' '.$value->start)) && $value->status != 'Rejected' && $value->status != 'Cancelled'): ?>
                      <a href="<?php echo base_url() ?>employee/overtime/cancel/<?php echo $value->id ?> ?>" class="btn btn-danger btn-xs cancel-confirmation"><i class="fa fa-times" aria-hidden="true"></i></a>
                    <?php endif ?>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php endif ?>

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
                <canvas id="annualMemberChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
                <canvas id="annualOrgChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>