      <div class="row">
        <div class="col-md-12">
            <div class="card-body">
              <form action="<?php echo base_url() ?>employee/team/performance" method="GET">
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
                          <?php 
                          foreach ($employee->result() as $emp): 
                          if ($emp->employee_id != $this->session->userdata('employee')):
                          ?>
                            <option <?php echo (isset($_GET['employee']) && $_GET['employee'] == $emp->employee_id) ? 'selected': ''; ?> value="<?php echo $emp->employee_id ?>"><?php echo $emp->nip.' - '.$emp->name ?></option>
                          <?php endif; endforeach ?>
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
                          <?php foreach ($organizations->result() as $org): ?>
                            <option <?php echo (isset($_GET['org_unit']) && $_GET['org_unit'] == $org->id) ? 'selected': ''; ?> value="<?php echo $org->id ?>"><?php echo $org->org_unit ?></option>
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
                          <?php 
                          $years = $this->db->select('year')->from('performance_appraisal_calendar')->group_by('year')->order_by('year', 'DESC')->get();
                          foreach ($years->result() as $value): ?>
                            <option <?php echo (isset($_GET['year']) && $_GET['year'] == $value->year) ? 'selected': ''; ?> value="<?php echo $value->year ?>"><?php echo $value->year ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>                    
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Periode</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-tags"></i>
                          </span>
                        </div>
                        <select class="form-control" name="period">
                          <?php foreach ($this->db->get('period_types')->result() as $per): ?>
                            <option <?php echo (isset($_GET['period']) && $_GET['period'] == $per->id) ? 'selected': ''; ?> value="<?php echo $per->id ?>"><?php echo $per->type ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>                    
                  </div>
                </div>

                </div>
                  <div class="float-left">
                    <?php if (isset($_GET['org_unit']) && isset($_GET['year'])): ?>                      
                      <a href="<?php echo base_url('employee/team/create_criteria/'.$_GET['year'].'/'.$_GET['org_unit'].'/'.$_GET['period']) ?>" class="btn btn-success"><span class="fa fa-tasks"></span> &nbsp;Buat Kriteria Penliaian</a>
                    <?php endif ?>
                  </div>

                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
                  </div>
              </form>
            </div>
        </div>
      </div>

      <?php if (isset($_GET['employee']) && isset($_GET['org_unit']) && isset($_GET['year'])): ?>
        <div class="row">
          <div class="col-md-12">
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
                    <th class="center">Periode</th>
                    <!-- <th style="width: auto;" class="center">Status Kriteria</th> -->
                    <th style="width: auto;" class="center">Status Penilaian</th>
                    <th style="width: auto;" class="center"></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $diff = array();
                  $no = 1;
                  foreach ($data->result() as $value) {
                    if (in_array($value->employee_id, $filter)) {
                    if ($value->employee_id != $this->session->userdata('employee')) {

                    $diff[] = $value->employee_id;
                    ?>
                  <tr style="<?php echo ($value->status_criteria) ? '' : 'background: #f37272;'; ?>">
                    <td class="center"><?php echo $no++ ?></td>
                    <td><?php echo $value->nip ?></td>
                    <td><?php echo $value->name ?></td>
                    <?php 
                    $CI =& get_instance();
                    $CI->load->model('employees');
                    $post = $CI->employees->getPositionEmployee($value->employee_id); 
                    ?>
                    <td>
                      <?php foreach ($post->result() as $pos): ?>
                        <?= $pos->position ?>
                      <?php endforeach ?>
                    </td>
                    <td class="center">
                      <?php echo ($value->year) ? $value->year : '-' ?>                    
                    </td>
                    <td class="center">
                      <?php echo ($value->type) ? $value->type : '-' ?>                    
                    </td>
                    <!-- <td class="center">
                      <?php if ($value->status_criteria): ?>
                        <?php echo $value->status_criteria ?>                       
                      <?php else: ?>
                        -
                      <?php endif ?>
                    </td> -->
                    <td class="center">
                      <?php if ($value->status_assessment): ?>
                        <?php echo $value->status_assessment ?>                       
                      <?php else: ?>
                        -
                      <?php endif ?>
                    </td>
                    <td class="center">
                      <?php if ($value->status_criteria != 'Approved'): ?>                        
                        <a href="<?php echo base_url() ?>employee/team/adjustment_criteria/<?php echo $value->id.'?org_unit='.$_GET['org_unit'].'&employee='.$value->employee_id.'&year='.$_GET['year'].'&period='.$_GET['period'] ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                      <?php else: ?>
                        <a href="<?php echo base_url() ?>employee/team/assessment/<?php echo $value->id.'?org_unit='.$_GET['org_unit'].'&employee='.$value->employee_id.'&year='.$_GET['year'].'&period='.$_GET['period'] ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                      <?php endif ?>
                    </td>
                  </tr>
                  <?php 
                      }
                    }
                  } 
                  ?>

                  <?php foreach ($data2->result() as $value2) { 

                  if (!in_array($value2->employee_id, $diff)) {?>
                  <tr style="background: #f37272;">
                    <td class="center"><?php echo $no++ ?></td>
                    <td><?php echo $value2->nip ?></td>
                    <td><?php echo $value2->name ?></td>
                    <?php 
                    $CI =& get_instance();
                    $CI->load->model('employees');
                    $post = $CI->employees->getPositionEmployee($value2->employee_id); 
                    ?>
                    <td>
                      <?php foreach ($post->result() as $pos): ?>
                        <?= $pos->position ?>
                      <?php endforeach ?>
                    </td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                  </tr>
                  <?php }} ?>

                </table>
              </div>
            </div>
          </div>
        </div>
      <?php endif ?>