      <div class="row">
        <div class="card-body">
          <form action="<?php echo base_url() ?>hrd/performance/assessment" method="GET">
            <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
            <div class="row">
              <div class="col-md-6 col-lg-6">                    
                <div class="form-group">
                  <label>Pegawai</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
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

              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label>Tahun</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-calendar"></i>
                      </span>
                    </div>
                    <select class="form-control" name="year">
                      <?php foreach ($this->db->select('year')->from('performance_appraisal_calendar')->group_by('year')->order_by('year', 'DESC')->get()->result() as $value): ?>
                        <option <?php echo (isset($_GET['year']) && $_GET['year'] == $value->year) ? 'selected': ''; ?> value="<?php echo $value->year ?>"><?php echo $value->year ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>                    
              </div>

              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label>Organisasi</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-fax"></i>
                      </span>
                    </div>
                    <select class="form-control" name="org_unit">
                      <option <?php echo (isset($_GET['org_unit'])) ? 'selected': ''; ?>>Semua</option>
                      <?php foreach ($this->db->get('organizations')->result() as $value): ?>
                        <option <?php echo (isset($_GET['org_unit']) && $_GET['org_unit'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->org_unit ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>                    
              </div>

              <!-- <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label>Status</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-cube"></i>
                      </span>
                    </div>
                    <select class="form-control" name="status">
                      <option <?php echo (isset($_GET['status'])) ? 'selected': ''; ?>>Semua</option>
                      <option value="8" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Draft') ? 'selected': ''; ?>>Draft</option>
                      <option value="9" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Published') ? 'selected': ''; ?>>Published</option>
                      <option value="2" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Approved') ? 'selected': ''; ?>>Approved</option>
                    </select>
                  </div>
                </div>                    
              </div> -->

              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label>Periode</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fab fa-firefox"></i>
                      </span>
                    </div>
                    <select class="form-control" name="period">
                      <?php foreach ($this->db->get('period_types')->result() as $value): ?>
                        <option <?php echo (isset($_GET['period']) && $_GET['period'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->type ?></option>
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

        <?php if (isset($_GET['period']) && isset($_GET['year']) && isset($_GET['employee']) && isset($_GET['org_unit'])): ?>
        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">NIP</th>
                  <th class="center">Nama</th>
                  <th class="center">Organisasi</th>
                  <th class="center">Tahun</th>
                  <th class="center">Status Kriteria</th>
                  <th class="center">Status Penilaian</th>
                  <th style="width: auto;" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) { 
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->nip ?></td>
                  <td><?php echo $value->name ?></td>
                  <td>
                    <?php 
                    $CI =& get_instance();
                    $CI->load->model('employees');
                    $employee_position = $CI->employees->showEmployeeOrgUnit($value->employee_id)->result();

                    foreach ($employee_position as $emppos) { ?>
                        <li style="list-style-type: none;"><?php echo $emppos->org_unit ?></li>
                    <?php } ?>
                  </td>
                  <td class="center"><?= $value->year ?></span>
                  <td class="center"><?= $value->status_criteria ?></td>
                  <td class="center"><?= ($value->status_assessment) ? $value->status_assessment : '-' ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/performance/detail_assessment/<?php echo $value->id.'/'.$value->year ?>" title="detail" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>          
        <?php endif ?>
      </div>