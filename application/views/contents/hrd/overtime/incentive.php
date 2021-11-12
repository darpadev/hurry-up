      <div class="row">
        <div class="col-md-12">
            <div class="card-body">
              <form action="<?php echo base_url() ?>hrd/overtime/incentive" method="GET">
                <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
                <div class="row">

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Pegawai</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-users"></i>
                          </span>
                        </div>
                        <select class="form-control" name="employee">
                          <option <?php echo (isset($_GET['approval'])) ? 'selected': ''; ?>>Semua</option>
                          <?php foreach ($this->db->select('ep.employee_id, ep.nip, e.name')->from('employee_pt as ep')->join('employees as e', 'e.id = ep.employee_id')->order_by('ep.nip', 'ASC')->get()->result() as $value): ?>                         
                            <option <?php echo (isset($_GET['employee']) && $_GET['employee'] == $value->employee_id) ? 'selected': ''; ?> value="<?php echo $value->employee_id ?>"><?php echo $value->nip.' - '.$value->name ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>                    
                  </div>

                  <div class="col-md-4">                    
                    <div class="form-group">
                      <label>Periode</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" id="period" name="period" class="form-control" value="<?php if (isset($_GET['period'])) { echo $_GET['period']; } else { echo date('F').' '.date('Y'); } ?>">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Organisasi</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-tags"></i>
                          </span>
                        </div>
                        <select class="form-control" name="org_unit">
                          <option <?php echo (isset($_GET['org_unit'])) ? 'selected': ''; ?>>Semua</option>
                          <?php foreach ($organizations->result() as $value): ?>                         
                            <option <?php echo (isset($_GET['org_unit']) && $_GET['org_unit'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->org_unit ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>                    
                  </div>
                </div>

                </div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
                  </div>
              </form>
            </div>
        </div>

        <?php if (isset($_GET['employee']) || isset($_GET['period']) || isset($_GET['org_unit'])): ?>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">NIP</th>
                  <th class="center">Nama</th>
                  <th class="center">Organisasi</th>
                  <th class="center">Level</th>
                  <th class="center">Total Jam</th>
                  <th class="center">Total Insentif</th>
                  <th style="width: 10%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                $total_incentive = 0;
                foreach ($data->result() as $value) { 
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->nip ?></td>
                  <td><?php echo $value->name ?></td>
                  <?php 
                  $CI =& get_instance();
                  $CI->load->model('employees');
                  $orgs = $CI->employees->showEmployeeOrgUnit($value->employee_id); 
                  ?>
                  <td>
                    <?php foreach ($orgs->result() as $org): ?>
                      <?= $org->org_unit ?>
                    <?php endforeach ?>
                  </td>
                  <td class="center"><?php echo $value->bracket ?></td>
                  <td class="center"><?php echo $value->paid_hours ?></td>
                  <td>Rp. <?php echo number_format($value->incentive) ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/overtime/show_incentive/<?php echo $value->employee_id.'?period='.$_GET['period'].'&employee='.$_GET['employee'].'&org_unit='.$_GET['org_unit'] ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php 
                $total_incentive = $total_incentive + $value->incentive;
                } ?>
              </tbody>

              <tfoot>                
                <td colspan="6" style="text-align: right;"><strong>Total Insentif</strong></td>
                <td><strong><?php echo 'Rp. '.number_format($total_incentive) ?></strong></td>
                <td></td>
              </tfoot>

              </table>
            </div>
          </div>
        </div>          
        <?php endif ?>
      </div>