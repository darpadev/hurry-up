      <div class="row">
        <div class="col-md-12">
            <div class="card-body">
              <form action="<?php echo base_url() ?>employee/timesheet" method="GET">
                <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
                <div class="row">
                  <div class="col-md-12">                    
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
                  <div class="float-left">
                    <a href="" class="btn btn-success create-data" data-target="#modal-add-data" data-toggle="modal"><span class="fa fa-suitcase"></span> &nbsp;Tambah Kegiatan</a>
                  </div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
                  </div>
              </form>

              <?php $this->load->view('contents/employee/timesheet/create') ?>
            </div>
        </div>
      </div>

      <?php if (isset($_GET['date'])): ?>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-header">
              Kegiatan Harian
            </div>
          
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Tanggal</th>
                  <th class="center">Durasi</th>
                  <th class="center">Tupoksi</th>
                  <th class="center">Kegiatan</th>
                  <th class="center">Status </th>
                  <th class="center">Saran</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {

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
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td class="center"><?php echo tanggal($value->date_on) ?></td>
                  <td class="center"><?php echo $value->duration ?></td>
                  <td><?php echo $value->tupoksi ?></td>
                  <td><?php echo $value->activity ?></td>
                  <td class="center">
                      
                    <label style="margin-bottom: 0 !important;" class="btn btn-xs <?= $color ?>">
                      <?php echo $value->status ?>                        
                    </label>

                    <?php if ($value->status == 'Rejected'): ?>
                      <a class="btn btn-xs btn-primary" href="<?= base_url('employee/timesheet/edit/'.$value->id) ?>">
                        <i class="fa fa-edit"></i>
                      </a>
                    <?php endif ?>

                  </td>
                  <?php if ($value->feedback): ?>
                    <td><?= $value->feedback ?></td>
                  <?php else: ?>                  
                    <td class="center">-</td>
                  <?php endif ?>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php endif ?>