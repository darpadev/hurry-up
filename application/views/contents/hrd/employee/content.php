      <div class="row">
        <div class="card-body">
          <form action="<?php echo base_url() ?>hrd/employee" method="GET">
            <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
            <div class="row">
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
                      <option <?php echo (isset($_GET['group']) && $_GET['group'] == 4) ? 'selected': ''; ?> value="4">Pimpinan</option>
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
                        <i class="fa fa-leaf"></i>
                      </span>
                    </div>
                    <select class="form-control" name="status">
                      <!-- <option <?php echo (isset($_GET['status'])) ? 'selected': ''; ?>>Semua</option> -->
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
              <div class="float-left">
                <a href="" class="btn btn-success create-data" data-target="#modal-add-data" data-toggle="modal"><span class="fa fa-user-plus"></span> &nbsp;Tambah Pegawai</a>
                <a href="" class="btn btn-info update-position" data-target="#modal-update-position" data-toggle="modal"><span class="fa fa-suitcase"></span> &nbsp;Tambah Jabatan</a>
              </div>
              <div class="float-right">
                <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
              </div>
          </form>
          <?php $this->load->view('contents/hrd/employee/create') ?>
          <?php $this->load->view('contents/hrd/employee/position') ?>
        </div>

        <?php //if (isset($_GET['group']) || isset($_GET['status']) || isset($_GET['org_unit']) || isset($_GET['position'])): ?>
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
                  <!-- <th class="center">Status</th> -->
                  <th style="width: auto;" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                $employee_has_position = array();
                foreach ($data->result() as $value) { 
                  $employee_has_position[] = $value->nip;
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->nip ?></td>
                  <td><?php echo $value->name ?></td>
                  <td>
                    <?php 
                    $employee_position = $this->db->select('p.position')->from('employee_position as ept')
                    ->join('employee_pt as ep', 'ep.employee_id = ept.employee_id')
                    ->join('positions as p', 'p.id = ept.position_id')
                    ->where('flag', 1)
                    ->where('p.is_active', 1)
                    ->where_in('ept.employee_id', $value->employee_id)
                    ->get()->result();

                    foreach ($employee_position as $emppos) { ?>
                        <li style="list-style-type: none;"><?php echo $emppos->position ?></li>
                    <?php } ?>
                  </td>
                  <!-- <td class="center">
                    <span class="btn btn-success btn-xs"><?php echo ($value->status == 1) ? 'Aktif' : 'Tidak Aktif'; ?></span>
                  </td> -->
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/employee/show/<?php echo $value->employee_id.'/url?group='.@$_GET['group'].'&org_unit='.@$_GET['org_unit'].'&status='.@$_GET['status'].'&position='.@$_GET['position'] ?>" title="detail" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>password/reset_password/<?php echo $value->employee_id ?>" title="reset password" class="btn btn-warning btn-xs reset-confirmation"><i class="fa fa-retweet" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>hrd/employee/edit/<?php echo $value->employee_id.'/url?group='.@$_GET['group'].'&org_unit='.@$_GET['org_unit'].'&status='.@$_GET['status'].'&position='.@$_GET['position'] ?>" title="edit" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>hrd/employee/delete/<?php echo $value->employee_id ?>/<?php echo $value->user_id ?>" title="delete" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>

                <!-- row pegawai yang belum punya jabatan -->
                <?php 
                foreach ($employee_null_position->result() as $value): 
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->nip ?></td>
                  <td><?php echo $value->name ?></td>
                  <td>
                    <?php 
                    $employee_position = $this->db->select('p.position')->from('employee_position as ept')
                    ->join('employee_pt as ep', 'ep.employee_id = ept.employee_id')
                    ->join('positions as p', 'p.id = ept.position_id')
                    ->where('flag', 1)
                    ->where('p.is_active', 1)
                    ->where_in('ept.employee_id', $value->employee_id)
                    ->get()->result();

                    foreach ($employee_position as $emppos) { ?>
                        <li style="list-style-type: none;"><?php echo $emppos->position ?></li>
                    <?php } ?>
                  </td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/employee/delete/<?php echo $value->employee_id ?>/<?php echo $value->user_id ?>" title="delete" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>                  
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>          
        <?php //endif ?>
      </div>