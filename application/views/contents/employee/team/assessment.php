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

        <div class="col-md-12">
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
          </div>
        </div>

        <?php 
        $check_status = array('Approved', 'Published');
        if (in_array($data->status_assessment, $check_status)): ?>
          <form method="POST" action="<?= base_url('employee/team/store_assessment') ?>">
          <input type="hidden" name="performance_id" value="<?= $this->uri->segment(4) ?>">
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
                  <input type="hidden" name="specific_id[]" value="<?= $value->id ?>">
                  <tr>
                    <td class="center"><?php echo $no++ ?></td>
                    <td><?php echo $value->kra ?></td>
                    <td><?php echo $value->kpi ?></td>
                    <td class="center"><?php echo $value->score ?></td>
                    <td><?php echo $value->comment ?></td>
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
                  <input type="hidden" name="standard_id[]" value="<?= $value->standard_id ?>">
                  <tr>
                    <td class="center"><?php echo $no++ ?></td>
                    <td><?php echo $value->kra ?></td>
                    <td><?php echo $value->kpi ?></td>
                    <td class="center"><?php echo $value->score ?></td>
                    <td><?php echo $value->comment ?></td>
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
                <textarea class="form-control" rows="5" readonly style="border: none;"><?= $data->recommendation ?></textarea>
              </div>
              <?php if ($data->status_assessment != 'Approved'): ?>
                <div class="card-footer">
                  <div style="float: left;">
                    <a href="<?php echo base_url('employee/team/performance?employee=Semua&org_unit='.$_GET['org_unit'].'&year='.$_GET['year'].'&period='.$_GET['period']) ?>" class="btn btn-default"><span class="fa fa-reply"></span> &nbsp;Kembali</a>
                  </div>
                  <div style="float: right;">
                    <button type="submit" name="submit" class="btn btn-warning save-confirmation" value="save"><span class="fa fa-save"></span> &nbsp;Simpan sebagai Draf</button>
                    <button type="submit" name="submit" class="btn btn-primary publish-confirmation" value="publish"><span class="fa fa-paper-plane"></span> &nbsp;Publikasikan</button>
                  </div>
                </div>
              <?php endif ?>
            </div>
          </div>
          </form>  
        <?php endif ?>

        <?php 
        $check_status = array('Draft', NULL, 'Rejected');
        if (in_array($data->status_assessment, $check_status)): ?>
        <form method="POST" action="<?= base_url('employee/team/store_assessment') ?>">
          <input type="hidden" name="performance_id" value="<?= $this->uri->segment(4) ?>">
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
                <input type="hidden" name="specific_id[]" value="<?= $value->id ?>">
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->kra ?></td>
                  <td><?php echo $value->kpi ?></td>
                  <?php if ($data->status_criteria == 'Approved'): ?>
                    <td class="center">
                      <input type="number" class="form-control" min="0" max="8" name="specific_score[]" value="<?= $value->score ?>" required>
                    </td>
                    <td>                      
                      <input type="text" class="form-control" name="specific_comment[]" value="<?= $value->comment ?>" required>
                    </td>
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
                <input type="hidden" name="standard_id[]" value="<?= $value->standard_id ?>">
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->kra ?></td>
                  <td><?php echo $value->kpi ?></td>
                  <?php if (isset($value->score) && isset($value->comment)): ?>                    
                    <td class="center"><input type="number" class="form-control" min="0" max="8" name="standard_score[]" value="<?= $value->score ?>" required></td>
                    <td><input type="text" class="form-control" name="standard_comment[]" value="<?= $value->comment ?>" required></td>
                  <?php else: ?>
                    <td class="center"><input type="number" class="form-control" min="0" max="8" name="standard_score[]" value="" required></td>
                    <td><input type="text" class="form-control" name="standard_comment[]" value="" required></td>
                  <?php endif ?>
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
              <textarea class="form-control" rows="5" name="recommendation" required><?= $data->recommendation ?></textarea>
            </div>

            <div class="card-footer">
              <div style="float: left;">
                <a href="<?php echo base_url('employee/team/performance?employee=Semua&org_unit='.$_GET['org_unit'].'&year='.$_GET['year'].'&period='.$_GET['period']) ?>" class="btn btn-default"><span class="fa fa-reply"></span> &nbsp;Kembali</a>
              </div>
              <div style="float: right;">
                <button type="submit" name="submit" class="btn btn-warning save-confirmation" value="save"><span class="fa fa-save"></span> &nbsp;Simpan sebagai Draf</button>
                <button type="submit" name="submit" class="btn btn-primary publish-confirmation" value="publish"><span class="fa fa-paper-plane"></span> &nbsp;Publikasikan</button>
              </div>
            </div>
          </div>
        </div>
        </form>          
        <?php endif ?>