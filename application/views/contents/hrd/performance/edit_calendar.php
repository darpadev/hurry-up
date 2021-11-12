<div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Ubah Penilaian Kinerja</h3>
              </div>
              <form action="<?php echo base_url() ?>hrd/performance/update/<?php echo $data->id ?>" method="POST">
                <div class="card-body">
                  
                  <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" class="form-control" name="description" required value="<?php echo $data->description ?>">
                  </div>
                  <div class="form-group">
                    <label>Tahun</label>
                    <input type="text" class="form-control" name="year" required value="<?php echo $data->year ?>">
                  </div>
                  <div class="form-group">
                    <label>Periode</label>
                    <input type="text" class="form-control" name="period" required value="<?php echo $data->period ?>">
                  </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a href="<?php echo base_url() ?>hrd/performance" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
            </div>
          </div>