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
           <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Daftar Permintaan</h3>
            </div>

             <div class="card-body">
               <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">NIP</th>
                  <th class="center">Nama</th>
                  <th class="center">Organisasi</th>
                  <th style="width: auto;" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($requestor->result() as $value) {
                  ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->nip ?></td>
                  <td class=""><?php echo $value->name ?></td>
                  <td class="center">
                    <?php foreach ($CI->employees->showEmployeeOrgUnit($value->employee_id)->result() as $org):
                      echo $org->org_unit;
                    endforeach ?>
                  </td>
                  <td class="center">                    
                      <a href="<?php echo base_url() ?>employee/performance/assessment_peer_review/<?php echo $value->id.'/'.$value->assessor_peer_review_id ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
             </div>
           </div>
         </div>
       </div>