      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              Grup Pengguna
          </div>
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Grup</th>
                  <th class="center">Waktu Absen</th>
                  <th style="width: 10%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->name ?></td>
                  <td><?php echo $value->due_time ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/master/edit_group/<?php echo $value->id ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>