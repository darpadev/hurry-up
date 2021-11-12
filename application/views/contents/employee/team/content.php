      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <form action="<?php echo base_url() ?>employee/team" method="GET">
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
                      <label>Jabatan</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-tags"></i>
                          </span>
                        </div>
                        <select class="form-control" name="position">
                          <option <?php echo (isset($_GET['position'])) ? 'selected': ''; ?>>Semua</option>
                          <?php foreach ($positions->result() as $position): ?>
                            <option <?php echo (isset($_GET['position']) && $_GET['position'] == $position->id) ? 'selected': ''; ?> value="<?php echo $position->id ?>"><?php echo $position->position ?></option>
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

      <?php if (isset($_GET['employee']) || isset($_GET['position'])): ?>
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
                  <th class="center">Jabatan</th>
                  <th style="width: auto;" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {
                  ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td class="center"><?php echo $value->nip ?></td>
                  <td><?php echo $value->name ?></td>
                  <td>  
                    <?php 
                    $employee_position = $this->db->select('*')->from('employee_position as ept')
                    ->join('employee_pt as ep', 'ep.employee_id = ept.employee_id')
                    ->join('positions as p', 'p.id = ept.position_id')
                    ->where('flag', 1)
                    ->where_in('ept.employee_id', $value->employee_id)
                    ->get()->result();

                    foreach ($employee_position as $emppos) { ?>
                        <li style="list-style-type: none;"><?php echo $emppos->position ?></li>
                    <?php } ?>
                  </td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>employee/team/show/<?php echo $value->employee_id ?><?php echo '?employee='.$_GET['employee'].'&position='.$_GET['position'] ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php endif ?>