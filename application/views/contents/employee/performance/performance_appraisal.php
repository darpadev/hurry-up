      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Deskripsi</th>
                  <th class="center">Tahun</th>
                  <th class="center">Periode</th>
                  <th class="center">Status Kriteria</th>
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
                  <td><?php echo $value->period ?></td>
                  <td class="center"><strong><?php echo $value->status_criteria ?></strong></td>
                  <td class="center"><strong><?php echo ($value->status_assessment) ? $value->status_assessment : '-' ?></strong></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>employee/performance/show_performance_appraisal/<?php echo $value->performance_id ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>