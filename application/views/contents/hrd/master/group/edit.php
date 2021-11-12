          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ubah Grup</h3>
              </div>
              <form action="<?php echo base_url() ?>hrd/master/update_group/<?php echo $data->id ?>" method="POST">
                <div class="card-body">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Grup</label>
                      <input type="text" name="name" class="form-control" required value="<?php echo $data->name ?>">
                    </div>
                    <div class="bootstrap-timepicker">
                      <div class="form-group">
                        <label>Waktu Absen</label>
                        <div class="input-group date" id="timepicker" data-target-input="nearest">
                          <input type="text" name="due_time" class="form-control datetimepicker-input" data-target="#timepicker" data-toggle="datetimepicker" required value="<?php echo $data->due_time ?>" />
                          <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-clock"></i></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a href="<?php echo base_url() ?>hrd/master/group" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
            </div>
          </div>