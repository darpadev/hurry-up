<div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Profil Perusahaan</h3>
              </div>

              <form id="profileForm" class="confirm-update" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/setting/update_profile/<?php echo $profile->id ?>" method="POST" role="form">
                <div class="card-body">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="company" value="<?php echo $profile->name ?>" required disabled>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $profile->email ?>" required disabled>
                  </div>
                  <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $profile->phone ?>" required disabled>
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" name="address" required disabled><?php echo $profile->address ?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Website</label>
                    <input type="text" class="form-control" name="website" value="<?php echo $profile->website ?>" required disabled>
                  </div>
                  <div class="form-group">
                    <label>Logo</label>
                    <input style="border: 0" type="file" name="logo" class="form-control" accept="image/*" disabled>
                  </div>
                  <div class="form-group">
                    <?php if ($profile->logo): ?>
                      <img style="max-width: 135px; height: auto;" src="<?php echo base_url() ?>assets/images/contents/<?php echo $profile->logo ?>">
                    <?php endif ?>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="submit-profile" disabled>Kirim</button>
                  <a href="javascript:void(0);" class="btn btn-info edit-profile">Ubah</a>
                  <a href="javascript:void(0);" class="hidden text-right btn btn-default cancel-profile" onclick="profileForm()">Batal</a>
                </div>
              </form>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Pengaturan Email</h3>
              </div>
              <form id="mailForm" class="confirm-update" method="POST" action="<?php echo base_url() ?>admin/setting/update_mail/<?php echo $mail->id ?>" role="form">
                <div class="card-body">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $mail->name ?>" required disabled>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $mail->email ?>" required disabled>
                  </div>
                  <div class="form-group">
                    <label>Driver</label>
                    <input type="text" class="form-control" name="driver" value="<?php echo $mail->driver ?>" required disabled>
                  </div>
                  <div class="form-group">
                    <label>Host</label>
                    <input type="text" class="form-control" name="host" value="<?php echo $mail->host ?>" required disabled>
                  </div>
                  <div class="form-group">
                    <label>Port</label>
                    <input type="text" class="form-control" name="port" value="<?php echo $mail->port ?>" required disabled>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" value="<?php echo $mail->password ?>" required disabled>
                  </div>
                  <div class="form-group">
                    <label>Encryption</label>
                    <input type="text" class="form-control" name="encryption" value="<?php echo $mail->encryption ?>" required disabled>
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="submit-mail" disabled>Kirim</button>
                  <a href="javascript:void(0);" class="btn btn-info edit-mail">Ubah</a>
                  <a href="javascript:void(0);" class="hidden text-right btn btn-default cancel-mail" onclick="mailForm()">Batal</a>
                </div>
              </form>

            </div>
          </div>
        </div>