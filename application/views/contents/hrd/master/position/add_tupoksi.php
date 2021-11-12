        <div class="modal fade" id="modal-add-tupoksi">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Tupoksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>

              <div class="modal-body">
                <form action="<?php echo base_url() ?>hrd/master/store_tupoksi_position" method="POST">
                <input type="hidden" name="position_id" value="<?php echo $this->uri->segment(4) ?>">
                <div class="box-body">

                  <div class="form-group"> 
                    <div id="add-tupoksi">
                      <p>
                      <div class="input-group">

                      <div class="col-md-8">
                        <label>Tugas Pokok dan Fungsi (Tupoksi)</label> 
                        <input type="text" name="tupoksi[]" class="form-control" required>
                        &nbsp;
                      </div>

                      <div class="col-md-2">  
                        <label>Bobot</label>                                              
                        <input type="number" min="0" name="weight[]" class="form-control" required>
                      </div>

                      <div class="col-md-2">  
                        <label style="visibility: hidden;">a</label> 
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <input type="button" class="btn btn-xs btn-success" id="addrow-tupoksi" value="Tambah" />
                          </span>
                        </div>
                      </div>
                                    
                      </div>
                      </p>
                    </div>
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