          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Ubah Hari Libur</h3>
              </div>
              <form action="<?php echo base_url() ?>hrd/holiday/update/<?php echo $data->id ?>" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Tanggal</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control datepicker" name="day_off" value="<?php echo date('d-m-Y', strtotime($data->day_off)) ?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="description" required value="<?php echo $data->description ?>">
                  </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a href="<?php echo base_url() ?>hrd/holiday" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
            </div>
          </div>