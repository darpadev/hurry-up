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
                      <input type="text" class="form-control" readonly value="<?= $calendar->year ?>">
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
                    <label>Status Penilaian</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-tags"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?php echo ($peer_review->status_assessment == 8) ? 'Draft' : 'Published' ?>">
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
            <div class="card">
              <form action="<?= base_url('employee/performance/store_assessment_peer_review') ?>" method="POST">                
                <input type="hidden" name="peer_review_id" value="<?= $this->uri->segment(4) ?>">
                <input type="hidden" name="assessor_peer_review_id" value="<?= $this->uri->segment(5) ?>">
                <div class="card-body">
                  <table id="" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th style="width: 5%" class="center">No</th>
                      <th class="center">KRA</th>
                      <th class="center">Kriteria Penilaian</th>
                      <th class="center">Nilai</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach ($u_assessment->result() as $value) {
                      ?>
                    <tr>
                      <td class="center"><?php echo $value->sequence ?></td>
                      <td style="width: 20%"><?php echo $value->kra ?></td>
                      <td class="center">
                        <textarea style="border: none; background: transparent;" readonly class="form-control" rows="10"><?php echo $value->criteria ?></textarea>
                      </td>
                      <td class="center" style="width: 10%">
                        <?php if ($value->status == 8): ?>
                          <input type="hidden" name="u_id[]" value="<?= $value->id ?>">
                          <input type="number" min="0" max="8" class="form-control" name="u_score[]" value="<?= $value->score ?>" required>
                        <?php else: ?>
                          <input type="hidden" name="criteria_peer_review_id[]" value="<?= $value->criteria_peer_review_id ?>">
                          <input type="number" min="0" max="8" class="form-control" name="score[]" value="<?= $value->score ?>" required>
                        <?php endif ?>
                      </td>
                    </tr>
                    <?php } ?>

                    <?php if(!$u_assessment->result()) : foreach ($assessment->result() as $value): ?>
                    <tr>
                      <td class="center"><?php echo $value->sequence ?></td>
                      <td style="width: 20%"><?php echo $value->kra ?></td>
                      <td class="center">
                        <textarea style="border: none; background: transparent;" readonly class="form-control" rows="10"><?php echo $value->criteria ?></textarea>
                      </td>
                      <td class="center" style="width: 10%">
                        <input type="hidden" name="criteria_peer_review_id[]" value="<?= $value->criteria_peer_review_id ?>">
                        <input type="number" min="0" max="8" class="form-control" name="score[]" required>
                      </td>
                    </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                  </table>
              </div>

              <div class="card-footer">
                <div class="float-right">
                  <button type="submit" name="submit" class="btn btn-warning save-confirmation" value="save"><span class="fa fa-save"></span> &nbsp;Simpan sebagai Draf</button>
                  <button type="submit" name="submit" class="btn btn-primary publish-confirmation" value="publish"><span class="fa fa-paper-plane"></span> &nbsp;Publikasikan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>