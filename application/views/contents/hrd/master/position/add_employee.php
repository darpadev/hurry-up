        <div class="modal fade" id="modal-add-data">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>

              <div class="modal-body">
                <form action="<?php echo base_url() ?>hrd/master/store_employee_position" method="POST">
                <input type="hidden" name="position_id[]" value="<?php echo $this->uri->segment(4) ?>">
                <div class="box-body">

                  <div class="form-group"> 
                    <div id="add-pegawai">
                      <p>
                      <div class="input-group">

                      <div class="col-md-6">
                        <label>Pegawai</label> 
                        <select class="form-control" name="employee_id[]" required>
                          <option value=""> -- Pilih Pegawai -- </option>
                          <?php foreach ($this->db->select('ep.employee_id, e.name, ep.nip')->from('employee_pt as ep')->join('employees as e', 'e.id = ep.employee_id')->where('ep.status', 1)->order_by('ep.nip', 'ASC')->get()->result() as $value): ?>
                            <option value="<?php echo $value->employee_id ?>"><?php echo $value->nip.' - '.$value->name ?></option>
                          <?php endforeach ?>
                        </select> &nbsp;
                      </div>

                      <div class="col-md-4">  
                        <label>Mulai</label>                      
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="text" class="form-control datepicker" name="start_date[]" required>
                        </div>
                      </div>

                      <div class="col-md-2">  
                        <label style="visibility: hidden;">a</label> 
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <input type="button" class="btn btn-xs btn-success" id="addrow" value="Tambah" />
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