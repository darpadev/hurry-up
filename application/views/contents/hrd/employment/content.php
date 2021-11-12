      <div class="row">
        <div class="card-body">
          <form action="<?php echo base_url() ?>hrd/employment" method="GET">
            <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
            <div class="row">
              <div class="col-md-6 col-lg-6">                    
                <div class="form-group">
                  <label>Grup</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-secret"></i></span>
                    </div>
                    <select class="form-control" name="f_group">
                      <option <?php echo (isset($_GET['f_group'])) ? 'selected': ''; ?>>Semua</option>
                      <option <?php echo (isset($_GET['f_group']) && $_GET['f_group'] == 1) ? 'selected': ''; ?> value="1">Tenaga Kependidikan</option>
                      <option <?php echo (isset($_GET['f_group']) && $_GET['f_group'] == 2) ? 'selected': ''; ?> value="2">Dosen</option>
                      <option <?php echo (isset($_GET['f_group']) && $_GET['f_group'] == 3) ? 'selected': ''; ?> value="3">Tenaga Lepas</option>
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
                    <select class="form-control" name="f_status">
                      <option <?php echo (isset($_GET['f_status'])) ? 'selected': ''; ?>>Semua</option>
                      <?php foreach ($status as $value): ?>
                        <option <?php echo (isset($_GET['f_status']) && $_GET['f_status'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->status ?></option>
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
                    <select class="form-control" name="f_org_unit">
                      <option>Semua</option>
                      <?php foreach ($this->db->get('organizations')->result() as $value): ?>
                        <option <?php echo (isset($_GET['f_org_unit']) && $_GET['f_org_unit'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->org_unit ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>                    
              </div>
              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label>Status Aktif</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-check-double"></i>
                      </span>
                    </div>
                    <select class="form-control" name="f_active_status" <?php echo (isset($_GET['f_status']) && $_GET['f_status'] == 3) ? 'disabled': ''; ?>>
                      <option <?php echo (isset($_GET['f_active_status'])) ? 'selected': ''; ?>>Semua</option>
                      <?php foreach ($active_status as $value): ?>
                        <option <?php echo (isset($_GET['f_active_status']) && $_GET['f_active_status'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->status ?></option>
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
                    <select class="form-control" name="f_position">
                      <option <?php echo (isset($_GET['position'])) ? 'selected': ''; ?>>Semua</option>
                      <?php foreach ($this->db->get('positions')->result() as $value): ?>
                        <option <?php echo (isset($_GET['f_position']) && $_GET['f_position'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
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
          <?php $this->load->view('contents/hrd/employment/create') ?>
        </div>

        <?php // if (isset($_GET['group']) || isset($_GET['status']) || isset($_GET['org_unit']) || isset($_GET['position'])): ?>
        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">                
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 5%" class="text-center">No</th>
                    <th class="text-center">NIP</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jabatan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Informasi Tanggal</th>
                    <th style="width: auto;" class="text-center"></th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($data->result() as $value) { 
                    ?>
                    <tr>
                      <td class="text-center"><?php echo $no++ ?></td>
                      <td class="text-center"><?php echo $value->nip ?></td>
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
                      <td class="text-center">
                        <span class="badge badge-sm badge-<?= $value->status == 'Resign' ? 'danger' : ($value->status == 'Tetap' ? 'primary' : 'warning') ?>">
                          <?= $value->status ?>
                        </span>
                        <?php 
                          if($value->active_status){
                            echo "<span class='badge badge-sm badge-primary'>$value->active_status</span>";
                          }
                        ?>
                        <?php if ($value->status == 'Kontrak' And $value->effective_date < date('Y-m-d')) : ?>
                          <span class="badge badge-sm badge-danger">Renewal</span>
                        <?php endif ?>
                      </td>
                      <!-- <td class="text-center"><?= date('d F Y', strtotime($value->effective_date)) ?></td> -->
                      
                      <?php if ($value->effective_date != NULL) : ?>
                        <?php 
                          $year = date('Y', strtotime($value->effective_date));
                          $month = date('n', strtotime($value->effective_date));
                          $day = date('j', strtotime($value->effective_date));
                        ?>
                        <td class="text-center">
                          <?php if ($value->status != 'Resign') : ?>
                            <?php if ($value->active_status == 'Aktif') : ?>
                              <?php if ($value->status == 'Tetap') : echo 'Efektif per Tanggal' ?>
                              <?php elseif ($value->status == 'Kontrak') : echo 'Tanggal Berakhir Kontrak' ?>
                              <?php endif ?>
                            <?php else : echo 'Berlaku Sampai Dengan' ?>
                            <?php endif ?>
                          <?php else : echo 'Efektif per Tanggal' ?>
                          <?php endif ?>
                          <br>
                          <?= strftime("%d %B %Y", mktime(0,0,0,$month, $day, $year)) ?>
                        </td>
                      <?php else : ?>
                        <td></td>
                      <?php endif ?>
                      <td class="text-center">
                        <a href="<?php echo base_url() ?>hrd/employment/show/<?php echo $value->employee_id.'/url?group='.@$_GET['group'].'&org_unit='.@$_GET['org_unit'].'&status='.@$_GET['status'].'&position='.@$_GET['position'] ?>" title="detail" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url() ?>password/reset_password/<?php echo $value->employee_id ?>" title="reset password" class="btn btn-warning btn-xs reset-confirmation"><i class="fa fa-retweet" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url() ?>hrd/employment/edit/<?php echo $value->employee_id.'/url?group='.@$_GET['group'].'&org_unit='.@$_GET['org_unit'].'&status='.@$_GET['status'].'&position='.@$_GET['position'] ?>" title="edit" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url() ?>hrd/employment/delete/<?php echo $value->employee_id ?>/<?php echo $value->user_id ?>" title="delete" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-trash" aria-hidden="true"></i></a>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <?php // endif ?>
        
        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-body">
              <h3>Belum Memiliki Jabatan</h3>
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 5%;" class="text-center">No.</th>
                      <th class="text-center">NIP</th>
                      <th class="text-center">Nama</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- row pegawai yang belum punya jabatan -->
                    <?php $no = 1 ?>
                    <?php foreach ($employee_null_position->result() as $value): ?>
                      <tr>
                        <td class="text-center"><?php echo $no++ ?></td>
                        <td class="text-center"><?php echo $value->nip ?></td>
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
                          <a href="<?php echo base_url() ?>hrd/employment/delete/<?php echo $value->employee_id ?>/<?php echo $value->user_id ?>" title="delete" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                      </tr>                  
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>