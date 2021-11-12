      <div class="row">
        <div class="card-body">
          <form action="<?php echo base_url() ?>employee/presence#presence" method="GET">
            <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
            <div class="row">
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
              <?php if (isset($_GET['date']) || isset($_GET['status'])): ?>
              <div class="float-left">
                <!-- <a href="<?php echo base_url() ?>employee/presence/report?type=<?php echo $_GET['type'].'&date='.$_GET['date'] ?>" class="btn btn-success"><span class="fa fa-download"></span>&nbsp;&nbsp; Unduh Presensi</a> -->
              </div>
              <?php endif ?>
              <div class="float-right">
                <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
              </div>
          </form>

        </div>

        <?php if (isset($_GET['date']) || isset($_GET['status'])): ?>
        <div class="col-md-12">
          <div class="card" id="presence">
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: auto" class="center"></th>
                  <th class="center">Tanggal</th>
                  <th class="center">Masuk</th>
                  <th class="center">Pulang</th>
                  <th class="center">Durasi</th>
                  <th class="center">Status</th>
                  <th class="center">Catatan</th>
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
                <tr <?php if (($dt3 == "saturday") || ($dt3 == "sunday") || in_array($value->date, $param_holiday)) echo 'style="background-color: red; color: white;"' ?>>
                  <td class="center"><?php echo $no++ ?></td>
                  <td class="center"><?php echo tanggal($value->date) ?></td>
                  <td class="center"><?php echo date('H:i:s', strtotime($value->checkin)) ?></td>
                  <td class="center"><?php echo ($value->checkout) ? date('H:i:s', strtotime($value->checkout)) : '-' ; ?></td>
                  <td class="center"><?php echo ($value->duration) ? $value->duration : '-'; ?></td>
                  <td class="center"><?php echo $value->status ?></td>
                  <td class="center"><?php echo $value->notes ?></td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>          
        <?php endif ?>
      </div>