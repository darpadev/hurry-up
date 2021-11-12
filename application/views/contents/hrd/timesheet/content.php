      <div class="row">
        <div class="col-md-12">
            <div class="card-body">
              <form action="<?php echo base_url() ?>hrd/timesheet" method="GET">
                <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Pegawai</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-user"></i>
                          </span>
                        </div>
                        <select class="form-control" name="employee">
                          <option <?php echo (isset($_GET['employee'])) ? 'selected': ''; ?>>Semua</option>
                          <?php 
                          $employee = $this->db->select('ep.employee_id, e.name, ep.nip')->from('employee_pt as ep')->join('employees as e', 'e.id = ep.employee_id')->order_by('ep.nip', 'ASC')->get();
                          foreach ($employee->result() as $emp): ?>
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
                        <input type="text" id="range-cuti" name="date" class="form-control float-right" value="<?php if (isset($_GET['date'])) { echo $_GET['date']; } ?>">
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

      <?php if (isset($_GET['date']) || isset($_GET['employee'])): ?>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-success">
            <div class="card-header">
              Kegiatan Harian
            </div>
          
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Nama</th>
                  <th class="center">Tanggal</th>
                  <th class="center">Durasi (Menit)</th>
                  <th class="center">Tupoksi</th>
                  <th class="center">Kegiatan</th>
                  <th class="center">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->name ?></td>
                  <td class="center"><?php echo tanggal($value->date_on) ?></td>
                  <td class="center"><?php echo $value->duration ?></td>
                  <td><?php echo $value->tupoksi ?></td>
                  <td><?php echo $value->activity ?></td>
                  <td class="center"><label class="btn btn-xs btn-primary"><?php echo $value->status ?></label></td>
                </tr>
                <?php } ?>
              </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php endif ?>