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
                    <label>Nilai Akhir</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-rss"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= $final_score->final_score ?>">
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
              <h3 class="card-title">Hasil Penilaian Rata-rata</h3>
            </div>

            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th style="width: 5%" class="center">No</th>
                      <th style="width: 20%" class="center">KRA</th>
                      <th class="center">Kriteria Penilaian</th>
                      <th style="width: 10%" class="center">Nilai Keseluruhan</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($average->result() as $value): ?>
                    <tr>
                      <td class="center"><?php echo $value->sequence ?></td>
                      <td><?php echo $value->kra ?></td>
                      <td class="center">
                        <textarea style="border: none; background: transparent;" readonly class="form-control" rows="10"><?php echo $value->criteria ?></textarea>
                      </td>
                      <td class="center"><?php echo $value->score ?></td>
                    </tr>
                  <?php endforeach ?>
                  </tbody>
              </table>   
            </div>
           </div>
         </div>
       </div>

      <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Hasil Penilaian Semua Reviewer</h3>
            </div>

              <div class="card-body">
                <?php $no = 1; foreach ($reviewer->result() as $assessor): ?>
                <div style="padding-bottom: 2%;">
                  <div class="form-group">
                    <label>Penilai <?= $no ?> : <strong style="color: red"><?= $assessor->name ?></strong></label>
                  </div>

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
                    foreach ($assessment->result() as $value) {
                      if ($value->assessor_peer_review_id == $assessor->id) {
                      ?>
                    <tr>
                      <td class="center"><?php echo $value->sequence ?></td>
                      <td><?php echo $value->kra ?></td>
                      <td class="center">
                        <textarea style="border: none; background: transparent;" readonly class="form-control" rows="10"><?php echo $value->criteria ?></textarea>
                      </td>
                      <td class="center"><?php echo $value->score ?></td>
                    </tr>
                    <?php }
                    } ?>
                    </tbody>
                  </table>
                </div>
                <?php $no++; endforeach ?>
              </div>
            </div>
        </div>
      </div>