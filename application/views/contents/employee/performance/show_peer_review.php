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
            <div class="card">
              <div class="card-body">
                <table id="" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 5%" class="center">No</th>
                      <th style="width: 20%" class="center">KRA</th>
                      <th class="center">Kriteria Penilaian</th>
                      <th style="width: 10%" class="center">Nilai Keseluruhan</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($assessment->result() as $value): ?>
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