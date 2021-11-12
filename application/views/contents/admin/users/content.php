      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Role</th>
                  <th class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($role->result() as $data) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $data->role ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>admin/usercontrol/edit_role/<?php echo $data->id ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <table id="users" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Nama</th>
                  <th class="center">Status</th>
                  <th class="center">Login</th>
                  <th class="center">Jam</th>
                  <th style="width: 13%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($users->result() as $data) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $data->name ?></td>
                  <td class="center"><?php echo $data->status ?></td>
                  <td class="center"><?php echo date('j F Y', strtotime($data->last_login)) ?></td>
                  <td class="center"><?php echo date('H:i', strtotime($data->last_login)) ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>admin/usercontrol/add_user_role/<?php echo $data->id ?>" class="btn btn-success btn-xs"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>admin/usercontrol/reset_password/<?php echo $data->id ?>" class="btn btn-danger btn-xs reset-confirmation"><i class="fa fa-retweet" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>