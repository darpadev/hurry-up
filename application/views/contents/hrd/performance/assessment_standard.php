      <div class="row">
        <div class="card-body">
          <form action="<?php echo base_url() ?>hrd/performance/assessment_standard" method="GET">
            <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <div class="form-group">
                  <label>Tahun</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-calendar"></i>
                      </span>
                    </div>
                    <select class="form-control" name="year">
                      <?php 
                      $period = $this->db->select('year')->from('performance_appraisal_calendar')->group_by('year')->order_by('year', 'DESC')->get()->result();

                      foreach ($period as $value): ?>
                        <option <?php echo (isset($_GET['year']) && $_GET['year'] == $value->year) ? 'selected': ''; ?> value="<?php echo $value->year ?>"><?php echo $value->year ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>                    
              </div>

            </div>

            </div>
              <!-- <a href="" class="btn btn-info create-data-assessment-standard" data-target="#modal-add-data-assessment-standard" data-toggle="modal"><span class="fa fa-flag"></span>&nbsp;&nbsp; Buat Kriteria Penilaian</a> -->

              <?php if (isset($_GET['year']) && $data->row()): ?>
                <div class="float-left">
                  Status: <strong><?= strtoupper($data->row()->criteria_status) ?></strong>
                </div>
              <?php endif ?>

              <div class="float-right">
                <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
              </div>
          </form>
        </div>

        <?php if (isset($_GET['year'])): ?>
        <div class="col-md-12 col-lg-12">
          <div class="card">
            <?php if (true): // check tanggal penginputan kalender ?>
              <div class="card-header">
                <div style="float: left;">
                  <button type="button" class="btn btn-success add-row"><span class="fa fa-calendar"></span> &nbsp;Tambah</button>
                  <button type="button" class="btn btn-danger delete-row delete-confirmation"><span class="fa fa-trash"></span> &nbsp;Hapus</button>
                </div>

                <div style="float: right;">
                  <form method="POST" action="<?php echo base_url() ?>hrd/performance/copy_assessment_period">
                  <input type="hidden" name="period_to" value="<?= $_GET['year']  ?>">
                  <select class="copy-period" name="period_from" id="non-select2" required>
                    <?php                       
                    foreach ($period as $value): ?>
                      <option <?php echo (isset($_GET['year']) && $_GET['year'] == $value->year) ? 'selected': ''; ?> value="<?php echo $value->year ?>"><?php echo $value->year ?></option>
                    <?php endforeach ?>
                  </select>

                    <button type="submit" class="btn btn-info copy-confirmation"><span class="fa fa-copy"></span> &nbsp;Salin KRA</button>
                  </form>
                </div>
              </div>              
            <?php endif ?>

            <form method="POST" action="<?php echo base_url() ?>hrd/performance/store_assessment_standard">
            <input type="hidden" name="year" value="<?= $_GET['year'] ?>">
            <div class="card-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center"><input type="checkbox" id="checkAll"></th>
                  <th class="center" style="width: 20%">KRA</th>
                  <th class="center">KPI</th>
                  <th class="center">Kriteria Penilaian</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) { 
                ?>
                <?php if ($value->status == 8): ?>
                  <input type="hidden" name="check_id[]" value="<?= $value->id ?>">
                  <tr>
                    <td class="center"><input type="checkbox" name="id[]" value="<?php echo $value->id ?>"></td>
                    <td>                    
                      <input type="hidden" class="form-control" name="u_id[]" value="<?php echo $value->id ?>" required>
                      <input type="text" class="form-control" name="u_kra[]" value="<?php echo $value->kra ?>" required>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="u_kpi[]" value="<?php echo $value->kpi ?>" required>
                    </td>
                    <td>
                      <textarea class="form-control" name="u_criteria[]" rows="10" required><?php echo $value->criteria ?></textarea>
                    </td>
                  </tr>                  
                <?php else: ?>
                  <tr>
                    <td class="center"><input type="checkbox" name="id[]" value="<?php echo $value->id ?>"></td>
                    <td>
                      <input type="hidden" class="form-control" name="u_id[]" value="<?php echo $value->id ?>" required>
                      <input style="border: none; background: transparent;" name="u_kra[]" type="text" class="form-control" value="<?php echo $value->kra ?>" readonly>
                    </td>
                    <td>
                      <input style="border: none; background: transparent;" name="u_kpi[]" type="text" class="form-control"  value="<?php echo $value->kpi ?>" readonly>
                    </td>
                    <td>
                      <textarea style="border: none; background: transparent;" name="u_criteria[]" class="form-control" rows="10" readonly><?php echo $value->criteria ?></textarea>
                    </td>
                  </tr>
                <?php endif ?>
                <?php } ?>
              </tbody>

              <tfoot>
                <tr>
                  <td colspan="6">
                    <?php if ($data->row() && $data->row()->criteria_status != 'Published'): ?>
                      <div style="float: right;">
                        <button type="submit" name="save" class="btn btn-warning save-confirmation" value="save"><span class="fa fa-save"></span> &nbsp;Simpan sebagai Draf</button>
                        <button type="submit" name="save" class="btn btn-primary publish-confirmation" value="publish"><span class="fa fa-paper-plane"></span> &nbsp;Publikasikan</button>
                      </div>
                    <?php endif ?>

                    <?php if (!$data->row()): ?>
                      <div style="float: right;">
                        <button type="submit" name="save" class="btn btn-warning save-confirmation" value="save"><span class="fa fa-save"></span> &nbsp;Simpan sebagai Draf</button>
                        <button type="submit" name="save" class="btn btn-primary publish-confirmation" value="publish"><span class="fa fa-paper-plane"></span> &nbsp;Publikasikan</button>
                      </div>
                    <?php endif ?>
                  </td>
                </tr>
              </tfoot>
              </table>
            </div>
            </form>

          </div>
        </div>          
        <?php endif ?>
      </div>