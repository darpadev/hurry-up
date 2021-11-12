        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Periode</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= $period_type->type.' '.$year ?>">
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
                      <input type="text" class="form-control" readonly value="<?= $organizations->org_unit ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

       <!--  <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div style="text-align: right;">                          
                <a href="" id="add-employee-criteria"><strong>+ Tambah Kriteria Penilaian Pegawai</strong></a>  
              </div>               
            </div>            
          </div>
        </div> -->

        <?php $period = $this->db->select('year')->from('performance_appraisal_calendar')->group_by('year')->order_by('year', 'DESC')->get()->result(); ?>

        <div id="employee">
          <p>
            <div class="col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <div style="float: left;">
                    <button type="button" class="btn btn-success add-row"><span class="fa fa-calendar"></span> &nbsp;Tambah</button>
                    <button type="button" class="btn btn-danger delete-row delete-confirmation"><span class="fa fa-trash"></span> &nbsp;Hapus</button>
                  </div>

                  <form action="<?= base_url('employee/team/copy_assessment_period') ?>" method="POST">
                    <div style="float: right;">
                      <input type="hidden" name="period_type_from" value="<?= $this->uri->segment(6) ?>">
                      <input type="hidden" name="org_unit" value="<?= $this->uri->segment(5) ?>">
                      <input type="hidden" name="employee" id="employee_id2">
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

                <form action="<?= base_url('employee/team/store_criteria_specific/'.$year.'?org_unit='.$this->uri->segment(5)) ?>" method="POST">
                <input type="hidden" name="period_type" value="<?= $this->uri->segment(6) ?>">
                <div class="card-header">
                  <div class="row">                  
                    <div class="col-md-1">
                      <label>Pegawai</label>
                    </div>

                    <div class="col-md-11">
                      <select name="employee" class="form-control" id="employee_id" required>
                        <?php
                        $diff = array();
                        foreach ($data->result() as $emp) { 
                          $diff[] = $emp->employee_id;                          
                        }

                        foreach ($subordinates as $value):
                          if (!in_array($value->employee_id, $diff)) :
                        ?>
                          <option value="<?php echo $value->employee_id ?>"><?php echo $value->nip.' - '.$value->name ?></option>
                        <?php endif; endforeach ?>
                      </select>                  
                    </div>
                  </div>
                </div>      

                <div class="card-body">
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
                    
                    </tbody>

                    <tfoot>
                      <tr>
                        <td colspan="6">
                          <div style="float: left;">
                            <a href="<?php echo base_url('employee/team/performance?employee=Semua&org_unit='.$this->uri->segment(5).'&year='.$this->uri->segment(4).'&period='.$this->uri->segment(6)) ?>" class="btn btn-default"><span class="fa fa-reply"></span> &nbsp;Kembali</a>
                          </div>
                          <div style="float: right;">
                            <button type="submit" name="save" class="btn btn-warning save-confirmation" value="save"><span class="fa fa-save"></span> &nbsp;Simpan sebagai Draf</button>
                            <button type="submit" name="save" class="btn btn-primary publish-confirmation" value="publish"><span class="fa fa-paper-plane"></span> &nbsp;Publikasikan</button>
                          </div>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                </form>

              </div>
            </div> 
          </p>
        </div>