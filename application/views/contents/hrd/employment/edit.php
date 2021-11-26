<div class="col-md-12">
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">Ubah Pegawai</h3>
    </div>
    <form action="<?php echo base_url() ?>hrd/employment/update/<?php echo $data->employee_id ?>" method="POST" enctype="multipart/form-data">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Nama Lengkap <i style="color: red;">*</i></label>
              <input type="text" name="name" class="form-control" value="<?php echo $data->name ?>" required>
            </div>
            <div class="form-group">
              <label>NIK</label>
              <input type="text" name="sid" class="form-control" value="<?php echo $data->sid ?>">
            </div>
            <div class="form-group">
              <label>Tanggal Lahir</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="text" class="form-control datepicker" name="birthday" value="<?php echo date('d-m-Y', strtotime($data->birthday)) ?>">
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
              <input type="text" name="phone" class="form-control" value="<?php echo $data->phone ?>">
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
                <?php foreach ($provinces->result() as $prov) : ?>
                  <option <?php echo ($data->province_id == $prov->id) ? 'selected' : ''; ?> value="<?php echo $prov->id ?>"><?php echo $prov->province ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Kota/Kabupaten</label>
              <select name="city_id" class="form-control" id="city_id">
                <option value=""> -- Pilih Kota/Kabupaten -- </option>
                <?php foreach ($cities->result() as $city) : ?>
                  <option <?php echo ($data->city_id == $city->id) ? 'selected' : ''; ?> data-chained="<?php echo $city->province_id ?>" value="<?php echo $city->id ?>"><?php echo $city->city ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Kecamatan</label>
              <select name="district_id" class="form-control" id="district_id">
                <option value=""> -- Pilih Kecamatan -- </option>
                <?php foreach ($districts->result() as $dist) : ?>
                  <option <?php echo ($data->district_id == $dist->id) ? 'selected' : ''; ?> data-chained="<?php echo $dist->city_id ?>" value="<?php echo $dist->id ?>"><?php echo $dist->district ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Kode Pos</label>
              <input type="text" name="postal_code" class="form-control" value="<?php echo $data->postal_code ?>">
            </div>
            <div class="form-group">
              <label>NPWP</label>
              <input type="text" name="npwp" class="form-control" value="<?php echo $data->npwp ?>">
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

          <div class="col-md-6">
            <div class="form-group">
              <label>NIP <i style="color: red;">*</i></label>
              <input type="text" name="nip" class="form-control" value="<?php echo $data->nip ?>" required>
            </div>
            <div class="form-group">
              <label>NIDN</label>
              <input type="text" name="nidn" class="form-control" value="<?php echo $data->nidn ?>">
            </div>
            <div class="form-group">
              <label>NITK</label>
              <input type="text" name="nitk" class="form-control" value="<?php echo $data->nitk ?>">
            </div>
            <div class="form-group">
              <label>NIDK</label>
              <input type="text" name="nidk" class="form-control" value="<?php echo $data->nitk ?>">
            </div>
            <div class="form-group">
              <label>Email <i style="color: red;">*</i></label>
              <input type="email" name="email" class="form-control" value="<?php echo $data->email ?>" required>
            </div>
            <div class="form-group">
              <label>TMT Kerja</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="date" class="form-control" name="join_date" value="<?= $data->join_date ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Grup <i style="color: red;">*</i></label>
              <select class="form-control" name="group_id" required>
                <option value=""> -- Pilih Grup -- </option>
                <?php foreach ($this->db->get('user_group')->result() as $grp) : ?>
                  <option <?php echo ($data->group_id == $grp->id) ? 'selected' : ''; ?> value="<?php echo $grp->id ?>"><?php echo $grp->name ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Organisasi <i style="color: red;">*</i></label>
              <input type="hidden" name="employee_position_id" class="form-control" value="<?php echo $employee_position->ept_id ?>">
              <select name="org_unit" class="form-control" id="departement_id" required>
                <option value=""> -- Pilih Organisasi -- </option>
                <?php foreach ($organizations->result() as $dep) : ?>
                  <option <?php echo ($employee_position->id == $dep->id) ? 'selected' : ''; ?> value="<?php echo $dep->id ?>"><?php echo $dep->org_unit ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Jabatan <i style="color: red;">*</i></label>
              <select name="position_id" class="form-control" id="position_id" required>
                <option value=""> -- Pilih Jabatan -- </option>
                <?php foreach ($positions->result() as $post) : ?>
                  <option <?php echo ($employee_position->position_id == $post->id) ? 'selected' : ''; ?> data-chained="<?php echo $post->org_unit ?>" value="<?php echo $post->id ?>"><?php echo $post->position ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Jabatan Fungsional</label>
              <select name="functional_position_id" class="form-control">
                <?php foreach ($this->db->get('functional_position')->result() as $funct) : ?>
                  <option <?php echo ($data->functional_position_id == $funct->id) ? 'selected' : ''; ?> value="<?php echo $funct->id ?>"><?php echo $funct->position ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Status Perjanjian Kerja <i style="color: red;">*</i></label>
              <select name="status" class="form-control" required>
                <option value=""> -- Pilih Status -- </option>
                <?php foreach ($this->db->get('employment_statuses')->result() as $empstat) : ?>
                  <option <?php echo ($data->status == $empstat->status) ? 'selected' : ''; ?> value="<?php echo $empstat->id ?>"><?php echo $empstat->status ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Status Aktif <i style="color: red;">*</i></label>
              <select name="active_status" class="form-control" required <?php $data->status == MY_Controller::RESIGN ? 'disabled' : '' ?>>
                <option value=""> -- Pilih Status -- </option>
                <?php foreach ($this->db->get('employment_active_statuses')->result() as $empstat) : ?>
                  <option <?php echo ($data->active_status == $empstat->status) ? 'selected' : ''; ?> value="<?php echo $empstat->id ?>"><?php echo $empstat->status ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div id="contract_duration" class="form_group" style="display: none;">
              <label>Durasi Kontrak</label>
              <select name="contract_duration" class="form-control">
                <option value="" disabled selected> -- Pilih Durasi Kontrak</option>
                <option value="6 Bulan">6 Bulan</option>
                <option value="1 Tahun">1 Tahun</option>
                <option value="2 Tahun">2 Tahun</option>
                <option value="By Calendar">By Calendar</option>
              </select>
            </div>
            <div id="range_duration" class="form-group" style="display: none;">
              <label>Durasi Tugas Belajar</label>
              <select name="range_duration" class="form-control">
                <option value="" disabled selected> -- Pilih Durasi -- </option>
                <option value="3 Tahun">3 Tahun</option>
                <option value="4 Tahun">4 Tahun</option>
                <option value="By Calendar">By Calendar</option>
              </select>
            </div>
            <div class="form-group">
              <label id="effective_date">
                <?php
                if ($data->status == 'Kontrak') {
                  echo 'Akhir Masa Kontrak';
                } else if ($data->status == 'Tetap' and $data->active_status != 'Aktif') {
                  echo 'Berlaku Sampai Dengan';
                } else {
                  echo 'Efektif per Tanggal';
                }
                ?><i style="color: red;">*</i>
              </label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="date" class="form-control" name="effective_date" value="<?= $data->effective_date ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label>Status Kontrak</label>
              <select name="work_agreement_status" class="form-control">
                <option <?= $data->work_agreement_status == 'PKWT' ? 'selected' : '' ?> value="PKWT">PKWT - Perjanjian Kerja Waktu Tertentu</option>
                <option <?= $data->work_agreement_status == 'PKWTT' ? 'selected' : '' ?> value="PKWTT">PKWTT - Perjanjian Kerja Waktu Tidak Tertentu</option>
              </select>
            </div>
            <div class="form-group">
              <label>Dokumen Kontrak</label>
              <input type="file" name="work_agreement_file" class="form-control" style="border: 0;" accept=".pdf">
            </div>
            <?php if ($agreement != NULL) : ?>
              <div class="form-group">
                <a href="<?= base_url() ?>/hrd/employement/agreement" target="_blank"><?= $agreement->name ?></a>
              </div>
            <?php endif ?>
            <div class="form-group">
              <label>RFID</label>
              <input type="text" name="rfid" class="form-control" value="<?php echo $data->rfid ?>">
            </div>
            <div class="form-group">
              <label>Foto</label>
              <input style="border: 0;" type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
              <img style="max-width: 250px; height: auto;" class="form-control" src="<?php echo base_url() ?>assets/images/contents/default.JPG">
            </div>
          </div>
        </div>

        <div class="row" style="padding-top: 2%;">
          <div class="col-md-12 col-lg-12">
            <h4 class="center">Data Pendidikan Pegawai</h4>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-lg-12">
            <div class="form-group">
              <div id="add-education">
                <p>

                  <?php if (isset($educations)) : $i = 0; ?>
                    <?php foreach ($educations->result() as $edu) : ?>
                      <input type="hidden" name="u_education_id[]" class="form-control" value="<?php echo $edu->id ?>">
                <div class="input-group">
                  <div class="col-md-3">
                    <?php if ($i == 0) : ?>
                      <label>Jenjang</label>
                    <?php endif ?>
                    <select class="form-control" name="u_educations[]" required>
                      <option value=""> -- Pilih Pendidikan -- </option>
                      <option <?php echo ($edu->level == 'SMA/SMK/MA') ? 'selected' : ''; ?> value="SMA/SMK/MA">SMA/SMK/MA</option>
                      <option <?php echo ($edu->level == 'Diploma Satu (D1)') ? 'selected' : ''; ?> value="Diploma Satu (D1)">Diploma Satu (D1)</option>
                      <option <?php echo ($edu->level == 'Diploma Dua (D2)') ? 'selected' : ''; ?> value="Diploma Dua (D2)">Diploma Dua (D2)</option>
                      <option <?php echo ($edu->level == 'Diploma Tiga (D3)') ? 'selected' : ''; ?> value="Diploma Tiga (D3)">Diploma Tiga (D3)</option>
                      <option <?php echo ($edu->level == 'Diploma Empat (D4)') ? 'selected' : ''; ?> value="Diploma Empat (D4)">Diploma Empat (D4)</option>
                      <option <?php echo ($edu->level == 'Sarjana (S1)') ? 'selected' : ''; ?> value="Sarjana (S1)">Sarjana (S1)</option>
                      <option <?php echo ($edu->level == 'Master (S2)') ? 'selected' : ''; ?> value="Master (S2)">Master (S2)</option>
                      <option <?php echo ($edu->level == 'Doktor (S3)') ? 'selected' : ''; ?> value="Doktor (S3)">Doktor (S3)</option>
                    </select>
                  </div>

                  <div class="col-md-4">

                    <?php if ($i == 0) : ?>
                      <label>Institusi</label>
                    <?php endif ?>
                    <input type="text" name="u_institutions[]" class="form-control" value="<?php echo $edu->institution ?>">
                  </div>

                  <div class="col-md-3">
                    <?php if ($i == 0) : ?>
                      <label>Tanggal Lulus</label>
                    <?php endif ?>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control datepicker" name="u_graduates[]" value="<?php echo date('d-m-Y', strtotime($edu->graduate)) ?>">
                    </div>

                  </div>

                  <div class="col-md-2">
                    <?php if ($i == 0) : ?>
                      <label>Aksi</label>
                    <?php endif ?>
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <a href="<?php echo base_url() ?>hrd/employee/delete_education/<?php echo $edu->id ?>" class="btn btn-danger btn-xs delete-confirmation">Hapus</a>
                      </span>
                    </div>
                  </div>
                </div>
              <?php $i++;
                      echo '<br>';
                    endforeach ?>
            <?php endif ?>
            </p>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <a href="" onclick="event.preventDefault()" id="addrow">+ Tambah Riwayat Pendidikan</a>
          </div>
        </div>
      </div>

      <div class="card-footer">
        <div class="float-right">
          <a href="<?php echo base_url() ?>hrd/employment/show/<?php echo $data->employee_id ?>" class="btn btn-default">Kembali</a>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
      </div>
    </form>
  </div>
</div>