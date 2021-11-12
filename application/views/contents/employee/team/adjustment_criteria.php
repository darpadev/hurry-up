<div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Pegawai</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control" readonly value="<?= $employee->name ?>">
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
                      <input type="text" class="form-control" readonly value="<?= $period_type->type.' '.$year ?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Jabatan</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tags"></i></span>
                      </div>
                      <?php 
                      $CI =& get_instance();
                      $CI->load->model('employees');
                      $post = $CI->employees->getPositionEmployee($_GET['employee']); 
                      
                      foreach ($post->result() as $pos): ?>
                        <input type="text" class="form-control" readonly value="<?= $pos->position ?>">
                      <?php endforeach ?>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Organisasi</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-secret"></i></span>
                      </div>
                      <?php 
                      $CI =& get_instance();
                      $CI->load->model('employees');
                      $orgs = $CI->employees->getPositionEmployee($_GET['employee']); 
                      
                      foreach ($orgs->result() as $org): ?>
                      <input type="text" class="form-control" readonly value="<?= $org->organization ?>">
                      <?php endforeach ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <?php $period = $this->db->select('year')->from('performance_appraisal_calendar')->group_by('year')->order_by('year', 'DESC')->get()->result(); ?>

        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <div style="float: left;">
                <button type="button" class="btn btn-success add-row"><span class="fa fa-calendar"></span> &nbsp;Tambah</button>
                <button type="button" class="btn btn-danger delete-row delete-confirmation"><span class="fa fa-trash"></span> &nbsp;Hapus</button>
              </div>

              <form action="<?= base_url('employee/team/copy_assessment_period/'.$this->uri->segment(4)) ?>" method="POST">
                <div style="float: right;">
                  <input type="hidden" name="period_type_from" value="<?= $_GET['period'] ?>">
                  <input type="hidden" name="org_unit" value="<?= $_GET['org_unit'] ?>">
                  <input type="hidden" name="employee" value="<?= $_GET['employee'] ?>">
                  <input type="hidden" name="period_to" value="<?= $year  ?>">
                  <select class="copy-period" name="period_from" id="non-select2" required>
                    <?php       
                    foreach ($period as $value): ?>
                      <option value="<?php echo $value->year ?>"><?php echo $value->year ?></option>
                    <?php endforeach ?>
                  </select>

                  <select class="copy-period" name="period_type" id="non-select2" required>
                    <?php       
                    foreach ($this->db->get('period_types')->result() as $value): ?>
                      <option value="<?php echo $value->id ?>"><?php echo $value->type ?></option>
                    <?php endforeach ?>
                  </select>

                    <button type="submit" class="btn btn-info copy-confirmation"><span class="fa fa-copy"></span> &nbsp;Salin KRA</button>
                </div>                    
              </form>
            </div>    

            <div class="card-body">
              <form action="<?= base_url('employee/team/update_criteria_specific/'.$year.'/'.$employee->id.'/'.$this->uri->segment(4).'?org_unit='.$_GET['org_unit']) ?>" method="POST">
                <input type="hidden" name="period_type" value="<?= $_GET['period'] ?>">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center"><input type="checkbox" id="checkAll"></th>
                  <th class="center" style="width: 20%">KRA</th>
                  <th class="center">KPI</th>
                  <th class="center">Kriteria Penliaian</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) { 
                ?>
                <?php if ($performance->status_criteria == 8): ?>
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
                      <div style="float: left;">
                        <a href="<?php echo base_url('employee/team/performance?employee=Semua&org_unit='.$_GET['org_unit'].'&year='.$_GET['year']) ?>" class="btn btn-default"><span class="fa fa-reply"></span> &nbsp;Kembali</a>
                      </div>
                      <div style="float: right;">
                        <button type="submit" name="save" class="btn btn-warning save-confirmation" value="save"><span class="fa fa-save"></span> &nbsp;Simpan sebagai Draf</button>
                        <button type="submit" name="save" class="btn btn-primary publish-confirmation" value="publish"><span class="fa fa-paper-plane"></span> &nbsp;Publikasikan</button>
                      </div>
                    </td>
                  </tr>
                </tfoot>

              </table>
              </form>
            </div>

          </div>
        </div>