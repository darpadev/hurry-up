      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <?php 
            $condition = $this->db->select('pr.id')->from('peer_review as pr')->join('performance_appraisal_calendar as pac', 'pac.id = pr.pac_id')->where(array('pac.year' => $calendar->year, 'pr.employee_id' => $this->session->userdata('employee')))->get()->row();
            ?>              
              <div class="card-header">
                <?php if (!$condition): ?>
                  <a href="<?php echo base_url('employee/performance/assign_reviewer') ?>" class="btn btn-success"><span class="fa fa-users"></span> &nbsp;Pilih Rekan Penilai</a>
                <?php endif ?>

                <a href="<?php echo base_url('employee/performance/request_assessment') ?>" class="btn btn-warning"><span class="fa fa-rss"></span> &nbsp; Permintaan Penilaian 
                  <?php if (true): ?>                    
                    <span class="badge badge-danger"><?= $request ?></span>
                  <?php endif ?>
                </a>
              </div>

            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Deskripsi</th>
                  <th class="center">Tahun</th>
                  <th class="center">Periode</th>
                  <th class="center">Status Reviewer</th>
                  <th class="center">Status Penilaian</th>
                  <th style="width: auto;" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {
                  ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->description ?></td>
                  <td class="center"><?php echo $value->year ?></td>
                  <td class="center"><?php echo $value->period ?></td>
                  <td class="center"><strong><?= $value->status_reviewer ?></strong></td>
                  <td class="center"><strong><?= $value->status_assessment ?></strong></td>
                  <td class="center">
                    <?php if ($value->status_reviewer == 'Draft'): ?>                      
                      <a href="<?php echo base_url() ?>employee/performance/edit_reviewer/<?php echo $value->peer_review_id ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <?php else: ?>
                      <a href="<?php echo base_url() ?>employee/performance/detail_peer_review/<?php echo $value->peer_review_id ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>                      
                    <?php endif ?>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>