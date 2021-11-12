      <div class="row">
        <div class="card-body">
          <form action="<?php echo base_url() ?>hrd/presence#presence" method="GET">
            <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
            <div class="row">
              <div class="col-md-6">                    
                <div class="form-group">
                  <label>Pegawai</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="form-control" name="nip">
                      <option <?php echo (isset($_GET['nip'])) ? 'selected': ''; ?>>Semua</option>
                      <?php foreach ($this->db->select('ep.nip, e.name')->from('employee_pt as ep')->join('employees as e', 'e.id = ep.employee_id')->get()->result() as $emp): ?>
                        <option <?php echo (isset($_GET['nip']) && $_GET['nip'] == $emp->nip) ? 'selected': ''; ?> value="<?php echo $emp->nip ?>"><?php echo $emp->name ?></option>                        
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6">                    
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

              <div class="col-md-6">                    
                <div class="form-group">
                  <label>Tipe</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-leaf"></i></span>
                    </div>
                    <select class="form-control" name="type">
                      <option <?php echo (isset($_GET['type'])) ? 'selected': ''; ?>>Semua</option>
                      <?php foreach ($this->db->get('presence_types')->result() as $typ): ?>
                        <option <?php echo (isset($_GET['type']) && $_GET['type'] == $typ->id) ? 'selected': ''; ?> value="<?php echo $typ->id ?>"><?php echo $typ->type ?></option>                        
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
              <div class="float-left">
                <a href="" class="btn btn-success create-data" data-target="#modal-add-data" data-toggle="modal"><span class="fa fa-calendar"></span>&nbsp;&nbsp; Tambah Data</a>
              </div>
              <div class="float-right">
                <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
              </div>
          </form>
          <?php $this->load->view('contents/hrd/presence/create') ?>
        </div>

        <?php if (isset($_GET['date']) || isset($_GET['status']) || isset($_GET['group']) || isset($_GET['nip'])): ?>
        <div class="col-md-12">
          <div class="card" id="presence">
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: auto" class="center"></th>
                  <th class="center">NIP</th>
                  <th class="center">Nama</th>
                  <th class="center">Tanggal</th>
                  <th class="center">Masuk</th>
                  <th class="center">Pulang</th>
                  <th class="center">Durasi</th>
                  <th class="center">Status</th>
                  <th class="center">Kondisi</th>
                  <th class="center">Suhu (°C)</th>
                  <th style="width: auto;" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) { 
                    $dt = $value->date;
                    $dt1 = strtotime($dt);
                    $dt2 = date("l", $dt1);
                    $dt3 = strtolower($dt2);

                    $param_holiday = array();
                    foreach ($this->db->select('day_off')->from('holiday')->get()->result() as $holiday) {
                      if ($value->date == $holiday->day_off) {
                        array_push($param_holiday, $holiday->day_off);
                      }
                    }
                ?>
                <tr <?php if (($dt3 == "saturday") || ($dt3 == "sunday") || in_array($value->date, $param_holiday)) echo 'style="background-color: red; color: white;";' ?>>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->nip ?></td>
                  <td><?php echo $value->name ?></td>
                  <td><?php echo $value->date ?></td>
                  <td><?php echo date('H:i:s', strtotime($value->checkin)) ?></td>
                  <td><?php echo date('H:i:s', strtotime($value->checkout)) ?></td>
                  <td><?php echo $value->duration ?></td>
                  <td><?php echo $value->status ?></td>
                  <td><?php echo $value->condition ?></td>
                  <td><?php echo $value->temperature ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/presence/show/<?php echo $value->id.'/url?group='.$_GET['group'].'&nip='.$_GET['nip'].'&type='.$_GET['type'].'&date='.$_GET['date'] ?>" title="detail" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>hrd/presence/edit/<?php echo $value->id.'/url?group='.$_GET['group'].'&nip='.$_GET['nip'].'&type='.$_GET['type'].'&date='.$_GET['date'] ?>" title="edit" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>hrd/presence/delete/<?php echo $value->id ?>/<?php echo $value->id ?>" title="delete" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>          
        <?php endif ?>
      </div>