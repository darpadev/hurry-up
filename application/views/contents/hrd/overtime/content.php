      <div class="row">
        <div class="col-md-12">
            <div class="card-body">
              <form action="<?php echo base_url() ?>hrd/overtime/overtime" method="GET">
                <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
                <div class="row">

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Pegawai</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-users"></i>
                          </span>
                        </div>
                        <select class="form-control" name="employee">
                          <option <?php echo (isset($_GET['approval'])) ? 'selected': ''; ?>>Semua</option>
                          <?php foreach ($this->db->select('ep.employee_id, e.name')->from('employee_pt as ep')->join('employees as e', 'e.id = ep.employee_id')->order_by('ep.nip', 'ASC')->get()->result() as $value): ?>                         
                            <option <?php echo (isset($_GET['employee']) && $_GET['employee'] == $value->employee_id) ? 'selected': ''; ?> value="<?php echo $value->employee_id ?>"><?php echo $value->name ?></option>
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
                        <input type="text" id="range-lembur" name="date" class="form-control float-right" value="<?php if (isset($_GET['date'])) { echo $_GET['date']; } ?>">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
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
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
                  </div>
              </form>
            </div>
        </div>

        <?php if (isset($_GET['date']) || isset($_GET['approval'])): ?>
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
                  <th class="center">Jam</th>
                  <th class="center">Durasi</th>
                  <th class="center">Approval</th>
                  <th style="width: 10%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) { 
                ?>
                <tr style="<?php echo ($value->status == 'Approved') ? 'background: #f37272;' : ''; ?>">
                  <td class="center"><?php echo $no++ ?></td>
                  <td class="center"><?php echo $value->no_assignment ?></td>
                  <td><?php echo $value->name ?></td>
                  <td class="center"><?php echo date('j F Y', strtotime($value->overtime_date)) ?></td>
                  <td class="center"><?php echo date('H:i:s', strtotime($value->start)).' - '.date('H:i:s', strtotime($value->finish)) ?></td>
                  <?php 
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
                  <td class="center"><?php echo $elapsed ?></td>
                  <td class="center"><span class="btn <?php echo $color ?> btn-xs"><?php echo $value->status ?></span></td>
                  <td class="center">
                    <?php $dates = str_replace(' ', '+', $_GET['date']); ?>
                    <a href="<?php echo base_url() ?>hrd/overtime/show/<?php echo $value->id.'/url?date='.$dates.'&approval='.$_GET['approval'] ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>          
        <?php endif ?>
      </div>