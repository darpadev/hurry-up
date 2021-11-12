        <div class="modal fade" id="modal-add-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Kalendar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url() ?>hrd/performance/store_calendar" method="POST">
                <div class="box-body">

                  <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" name="description" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Tahun</label>
                    <input type="number" name="year" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Periode</label>
                    <input type="text" name="period" class="form-control" required>
                  </div>

                </div>

                <div class="modal-footer">
                  <div class="float-right">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>