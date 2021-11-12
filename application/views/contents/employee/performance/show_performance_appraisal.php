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
                      <input type="text" class="form-control" readonly value="<?= $data->year ?>">
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
                    <label>Penilai</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-secret"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= $data->assessor_name ?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
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

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Status Kriteria</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= $data->status_criteria ?>">
                    </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Status Penilaian</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= $data->status_assessment ?>">
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-12">
          <div class="card">
            <?php if ($data->status_assessment == 'Approved'): ?>              
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nilai Akhir</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-star"></i></span>
                        </div>                    
                        <input type="text" class="form-control" readonly value="<?= $data->final_score ?>">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Hasil Secara Umum</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-comment"></i></span>
                        </div>                    
                        <input type="text" class="form-control" readonly value="<?= $data->result ?>">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif ?>

            <?php if ($data->status_criteria == 'Published'): ?>
              <div class="card-footer">
                <div class="float-left">
                  <strong>Apakah Anda menyetujui kriteria penilaian kinerja ini?</strong>
                </div>

                <div class="float-right">
                  <form method="POST" action="<?= base_url('employee/approve/approval_criteria_performance') ?>">
                    <input type="hidden" name="performance" value="<?= $this->uri->segment(4) ?>">

                    <button type="submit" name="approval" value="approve" class="btn btn-success approve-confirmation"><span class="fa fa-check"></span> &nbsp;Terima</button>
                    <button type="submit" name="approval" value="reject" class="btn btn-danger reject-confirmation"><span class="fa fa-times"></span> &nbsp;Tolak</button>
                  </form>
                </div>
              </div>              
            <?php endif ?>

            <?php if ($data->status_assessment == 'Published'): ?>
              <div class="card-footer">
                <div class="float-left">
                  <strong>Apakah Anda menyetujui penilaian kinerja ini?</strong>
                </div>

                <div class="float-right">
                  <form method="POST" action="<?= base_url('employee/approve/approval_assessment') ?>">
                    <input type="hidden" name="performance" value="<?= $this->uri->segment(4) ?>">
                    
                    <button type="submit" name="approval" value="approve" class="btn btn-success approve-confirmation"><span class="fa fa-check"></span> &nbsp;Terima</button>
                    <button type="submit" name="approval" value="reject" class="btn btn-danger reject-confirmation"><span class="fa fa-times"></span> &nbsp;Tolak</button>
                  </form>
                </div>
              </div>              
            <?php endif ?>
          </div>
        </div>

        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <strong>Kriteria Penilaian Kinerja Spesifik</strong>
            </div>

            <div class="card-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">KRA</th>
                  <th class="center">KPI</th>
                  <?php if ($data->status_criteria == 'Approved'): ?>
                    <th class="center">Penilaian</th>
                    <th class="center">Komentar</th>
                  <?php elseif ($data->status_criteria == 'Published'): ?>                    
                    <th class="center">Kriteria Penilaian</th>
                  <?php endif ?>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($specific->result() as $value) { 
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->kra ?></td>
                  <td><?php echo $value->kpi ?></td>
                  <?php if ($data->status_criteria == 'Approved'): ?>
                    <td class="center"><?= $value->score ?></td>
                    <td><?= $value->comment ?></td>
                  <?php elseif ($data->status_criteria == 'Published'): ?>
                    <td><textarea class="form-control" style="border: none; background: transparent;" rows="10"><?= $value->criteria ?></textarea></td>
                  <?php endif ?>
                </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <?php if ($standard->result()): if ($standard->result()[0]->standard_id != NULL): ?>
          <div class="col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <strong>Kriteria Penilaian Kinerja Standar</strong>
              </div>

              <div class="card-body">
                <table id="" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 5%" class="center">No</th>
                    <th class="center">KRA</th>
                    <th class="center">KPI</th>
                    <th class="center">Penilaian</th>
                    <th class="center">Komentar</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $no = 1;
                  foreach ($standard->result() as $value) { 
                  ?>
                  <tr>
                    <td class="center"><?php echo $no++ ?></td>
                    <td><?php echo $value->kra ?></td>
                    <td><?php echo $value->kpi ?></td>
                    <td class="center"><?= (isset($value->score)) ? $value->score : '-' ?></td>
                    <td><?= (isset($value->comment)) ? $value->comment : null ?></td>
                  </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <strong>Rekomendasi Atasan</strong>
              </div>

              <div class="card-body">
                <textarea class="form-control" rows="5" readonly><?= $data->recommendation ?></textarea>
              </div>
            </div>
          </div>
        <?php endif; endif ?>