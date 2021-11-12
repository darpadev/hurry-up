          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Ubah Pegawai</h3>
              </div>
              <form action="<?php echo base_url() ?>employee/biodata/update/<?php echo $data->id ?>/<?php echo $data->employee_id ?>" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $data->name ?>" disabled required>
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $data->email ?>"  required>
                      </div>
                      <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="sid" class="form-control" value="<?php echo $data->sid ?>" >
                      </div>
                      <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="text" class="form-control datepicker" name="birthday" value="<?php echo date('d-m-Y', strtotime($data->birthday)) ?>" >
                        </div>
                      </div>
                      <div class="form-group clearfix">
                        <label>Jenis Kelamin</label>
                        <div style="border: 0" class="form-control">
                          <div class="icheck-primary d-inline">
                          <input <?php echo ($data->sex == 'Laki-laki') ? 'checked' : ''; ?> type="radio" id="radioPrimary1" name="sex" value="Laki-laki"><label for="radioPrimary1">Laki-laki &nbsp;&nbsp;</label>
                          </div>
                          <div class="icheck-primary d-inline">
                          <input <?php echo ($data->sex == 'Perempuan') ? 'checked' : ''; ?> type="radio" id="radioPrimary2" name="sex" value="Perempuan"> <label for="radioPrimary2">Perempuan</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>No. Handphone</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $data->phone ?>" >
                      </div>
                      <div class="form-group">
                        <label>Agama</label>
                        <input type="text" name="religion" class="form-control" value="<?php echo $data->religion ?>">
                      </div>
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control"><?php echo $data->address ?></textarea>
                      </div>
                      <div class="form-group">
                        <label>Provinsi</label>
                        <select name="province_id" class="form-control" id="province_id">
                          <option value=""> -- Pilih Provinsi -- </option>
                          <?php foreach ($provinces->result() as $prov): ?>
                            <option <?php echo ($data->province_id == $prov->id) ? 'selected' : ''; ?> value="<?php echo $prov->id ?>"><?php echo $prov->province ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Kota/Kabupaten</label>
                        <select name="city_id" class="form-control" id="city_id">
                          <option value=""> -- Pilih Kota/Kabupaten -- </option>
                          <?php foreach ($cities->result() as $city): ?>
                            <option <?php echo ($data->city_id == $city->id) ? 'selected' : ''; ?> data-chained="<?php echo $city->province_id ?>" value="<?php echo $city->id ?>"><?php echo $city->city ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Kecamatan</label>
                        <select name="district_id" class="form-control" id="district_id">
                          <option value=""> -- Pilih Kecamatan -- </option>
                          <?php foreach ($districts->result() as $dist): ?>
                            <option <?php echo ($data->district_id == $dist->id) ? 'selected' : ''; ?> data-chained="<?php echo $dist->city_id ?>" value="<?php echo $dist->id ?>"><?php echo $dist->district ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Kode Pos</label>
                        <input type="text" name="postal_code" class="form-control" value="<?php echo $data->postal_code ?>" >
                      </div>
                      <div class="form-group">
                        <label>NPWP</label>
                        <input type="text" name="npwp" class="form-control" value="<?php echo $data->npwp ?>" >
                      </div>
                      <div class="form-group">
                        <label>Status Perkawinan</label>
                        <select class="form-control" name="marital_status">
                          <option value=""> -- Pilih Status Perkawinan -- </option>
                          <option <?php echo ($data->marital_status == 'Lajang') ? 'selected' : ''; ?> value="Lajang">Lajang</option>
                          <option <?php echo ($data->marital_status == 'Menikah') ? 'selected' : ''; ?> value="Menikah">Menikah</option>
                        </select>
                      </div>
                  </div>

                  </div>
                </div>

                <div class="card-footer">
                  <div class="float-right">
                    <a href="<?php echo base_url() ?>/employee/biodata" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
            </div>
          </div>