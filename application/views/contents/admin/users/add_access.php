    <div class="row">
        <div class="col-md-8">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Data Pengguna</h3>
              </div>
              <table class="table">
                <tr>
                  <th class="center">Nama</th>
                  <th class="center">Peran</th>
                  <th style="width: 10%"></th>
                </tr>
                <?php
                foreach ($users->result() as $user) {
                ?>
                <tr>
                  <td><?php echo $user->name ?></td>
                  <td class="center"><?php echo $user->role ?></td>
                  <td class="center"><a href="<?php echo base_url() ?>admin/usercontrol/delete_user_role/<?php echo $user->login_id ?>" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-times"></i></a></td>
                </tr>
                <?php } ?>
              </table>
            </div>
        </div>

        <div class="col-md-4">
          <div class="card card-olive">
            <div class="card-header">
              <h3 class="card-title">Tambah Peran</h3>
            </div>
            <form method="POST" action="<?php echo base_url() ?>admin/usercontrol/store_user_role/<?php echo $this->uri->segment(4) ?>">
              <div class="card-body">
                <div class="form-group">                
                  <label>Peran</label>
                  <select class="form-control" name="role_id" required>
                    <?php foreach($role->result() as $role) { ?>
                      <option value="<?php echo $role->id ?>"><?php echo $role->role ?></option>
                    <?php } ?>
                  </select>
                </div>                
              </div>
              <div class="card-footer">
                <div class="form-group">
                  <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Tambah</button>
                    <a href="<?php echo base_url() ?>admin/usercontrol" class="text-right btn btn-default">Kembali</a>
                </div>
              </div>
              </form>

          </div>
        </div>
    </div>