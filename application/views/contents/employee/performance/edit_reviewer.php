       <div class="row">
       <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-body">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>NIP</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= $data->nip ?>">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tahun</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= date('Y') ?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Nama</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= $data->name ?>">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Organisasi</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                      </div>
                      <?php 
                      $CI =& get_instance();
                      $CI->load->model('employees');
                      $employee_position = $CI->employees->showEmployeeOrgUnit($data->employee_id)->result();

                      foreach ($employee_position as $emppos) { ?>
                        <input type="text" class="form-control" readonly value="<?= $emppos->org_unit ?>">
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>         
       </div>

      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="<?php echo base_url('employee/performance/store_reviewer') ?>">
            <div class="card">
              <div class="card-body">
                <?php $no = 1; foreach ($reviewer->result() as $assessor): ?>
                  <div class="form-group">
                    <label>Penilai <?= $no ?></label>
                    <input type="hidden" name="u_id[]" value="<?= $assessor->id ?>">
                    <select class="form-control" name="u_assessor[]" required>
                      <option value=""> -- Pilih Penilai -- </option>
                      <?php foreach ($coworkers->result() as $value): ?>
                        <option <?php echo ($value->employee_id == $assessor->employee_id) ? 'selected' : ''; ?> value="<?= $value->employee_id ?>"><?= $value->nip.' - '.$value->name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                <?php $no++; endforeach ?>
              </div>

              <div class="card-footer">
                <div class="float-right">
                  <button type="submit" name="save" class="btn btn-warning save-confirmation" value="save"><span class="fa fa-save"></span> &nbsp;Simpan sebagai Draf</button>
                  <button type="submit" name="save" class="btn btn-primary publish-confirmation" value="publish"><span class="fa fa-paper-plane"></span> &nbsp;Publikasikan</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>