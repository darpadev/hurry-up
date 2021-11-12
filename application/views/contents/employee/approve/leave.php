        <div class="row">
        <div class="col-md-12">
            <div class="card-body">
              <form action="<?php echo base_url() ?>employee/approve/leave" method="GET">
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
                      <label>Tanggal</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" id="range-lembur" name="date" class="form-control float-right" value="<?php if (isset($_GET['date'])) { echo $_GET['date']; } ?>">
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

        <form action="<?php echo base_url() ?>employee/approve/bulk_approval_leave" method="POST">
        <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <div class="float-left">
                <input type="submit" name="bulk" class="btn btn-success approve-confirmation" value="Terima Permohonan">
                <input type="submit" name="bulk" class="btn btn-danger reject-confirmation" value="Tolak Permohonan">          
              </div>
            </div>

            <div class="card-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center"><input type="checkbox" id="checkAll"></th>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Nama</th>
                  <th class="center">Tanggal</th>
                  <th class="center">Jenis</th>
                  <th class="center">Deskripsi</th>
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
                  $elapsed = $interval->format('%d');
                  ?>
                <tr>
                  <td class="center"><input type="checkbox" name="approval[]" value="<?php echo $value->id.','.$value->approver_id ?>"></td>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->name ?></td>
                  <td class="center"><?php echo tanggal($value->start).' - '.tanggal($value->finish) ?></td>
                  <td><?php echo $value->type ?></td>
                  <td><?php echo $value->description ?></td>
                  <td class="center"><?php echo $elapsed+1 ?> Hari</td>
                  <td class="center">
                    <label class="btn btn-xs btn-info"><?php echo $value->flag ?></label>
                  </td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>employee/approve/show_leave/<?php echo $value->id ?>/<?php echo $value->approver_id ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>

                    <?php $flag = $this->db->select('flag')->from('approval_leaves')->where(array('leave_id' => $value->id, 'approver_id' => $value->approver_id, 'flag' => 4))->get()->row();

                    isset($flag) ? $check = $flag->flag: $check = NULL;

                    if ($check == 4):
                    ?>
                      <a href="<?php echo base_url() ?>employee/approve/approve_leave/<?php echo $value->id ?>/<?php echo $value->approver_id ?>" class="btn btn-success btn-xs approve-confirmation"><i class="fa fa-check" aria-hidden="true"></i></a>
                      <a href="<?php echo base_url() ?>employee/approve/reject_leave/<?php echo $value->id ?>/<?php echo $value->approver_id ?>" class="btn btn-danger btn-xs reject-confirmation"><i class="fa fa-times" aria-hidden="true"></i></a>
                    <?php endif ?>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      </form>