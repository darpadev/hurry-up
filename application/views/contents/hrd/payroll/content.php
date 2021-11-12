      <div class="row">
        <div class="card-body">
          <form action="<?php echo base_url() ?>hrd/payroll" method="GET">
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
                  <label>Perjanjian Kerja</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-hourglass"></i>
                      </span>
                    </div>
                    <select class="form-control" name="work_agreement_status">
                      <option <?php echo (isset($_GET['work_agreement_status'])) ? 'selected': ''; ?>>Semua</option>
                      <option <?php echo (isset($_GET['work_agreement_status']) && $_GET['work_agreement_status'] == 'PWT') ? 'selected': ''; ?> value="PWT">PWT</option>
                      <option <?php echo (isset($_GET['work_agreement_status']) && $_GET['work_agreement_status'] == 'PKWTT') ? 'selected': ''; ?> value="PKWTT">PKWTT</option>
                    </select>
                  </div>
                </div>                    
              </div>
              <div class="col-md-6 col-lg-6">                    
                <div class="form-group">
                  <label>Grup</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-secret"></i></span>
                    </div>
                    <select class="form-control" name="group">
                      <option <?php echo (isset($_GET['group'])) ? 'selected': ''; ?>>Semua</option>
                      <option <?php echo (isset($_GET['group']) && $_GET['group'] == 1) ? 'selected': ''; ?> value="1">Tenaga Kependidikan</option>
                      <option <?php echo (isset($_GET['group']) && $_GET['group'] == 2) ? 'selected': ''; ?> value="2">Dosen</option>
                      <option <?php echo (isset($_GET['group']) && $_GET['group'] == 3) ? 'selected': ''; ?> value="3">Tenaga Lepas</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label>Status</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-check"></i>
                      </span>
                    </div>
                    <select class="form-control" name="status">
                      <option <?php echo (isset($_GET['status'])) ? 'selected': ''; ?>>Semua</option>
                      <?php foreach ($this->db->get('employee_status')->result() as $value): ?>
                        <option <?php echo (isset($_GET['status']) && $_GET['status'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->status ?></option>
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

              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label>Jabatan</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-cube"></i>
                      </span>
                    </div>
                    <select class="form-control" name="position">
                      <option <?php echo (isset($_GET['position'])) ? 'selected': ''; ?>>Semua</option>
                      <?php foreach ($this->db->get('positions')->result() as $value): ?>
                        <option <?php echo (isset($_GET['position']) && $_GET['position'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
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

        <?php if (isset($_GET['status']) || isset($_GET['position']) || isset($_GET['group']) || isset($_GET['employee']) || isset($_GET['org_unit']) || isset($_GET['work_agreement_status'])): ?>
        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">NIP</th>
                  <th class="center">Nama</th>
                  <th class="center">Jabatan</th>
                  <th class="center">Status</th>
                  <th class="center">Gaji Pokok</th>
                  <th style="width: auto;" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) { 
                ?>
                <tr <?php echo ($value->status != 1) ? 'style="background: #f37272;"' : ''; ?>>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->nip ?></td>
                  <td><?php echo $value->name ?></td>
                  <td>
                    <?php 
                    $employee_position = $this->db->select('p.position')->from('employee_position as ept')
                    ->join('employee_pt as ep', 'ep.employee_id = ept.employee_id')
                    ->join('positions as p', 'p.id = ept.position_id')
                    ->where('flag', 1)
                    ->where_in('ept.employee_id', $value->employee_id)
                    ->get()->result();

                    foreach ($employee_position as $emppos) { ?>
                        <li style="list-style-type: none;"><?php echo $emppos->position ?></li>
                    <?php } ?>
                  </td>
                  <td class="center"><?= $value->work_agreement_status ?></span>
                  <td><?= 'Rp. '.number_format($value->basic_salary) ?></span>
                  </td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/payroll/show/<?php echo $value->employee_id.'/url?group='.$_GET['group'].'&org_unit='.$_GET['org_unit'].'&employee='.$_GET['employee'].'&work_agreement_status='.$_GET['work_agreement_status'].'&position='.$_GET['position'].'&status='.$_GET['status'] ?>" title="detail" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>          
        <?php endif ?>
      </div>