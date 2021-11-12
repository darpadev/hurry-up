<div class="modal fade" id="modal-add-data">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>

      <form action="<?php echo base_url() ?>hrd/employment/store" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="box-body">
          <div class="row">
            <div class="col-md-6 col-lg-6">
              <h4>Data Pribadi Pegawai</h4>
            </div>
            <div class="col-md-6 col-lg-6">
              <h4>Data Pegawai Perusahaan</h4>
            </div>
          </div>

          <div class="row">                    
            <div class="col-md-6 col-lg-6">
              <div class="form-group">
                <label>Nama Lengkap <i style="color: red;">*</i></label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="form-group">
                <label>NIK</label>
                <input type="text" name="sid" class="form-control">
              </div>
              <div class="form-group">
                <label>Tanggal Lahir</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="date" class="form-control" name="birthday">
                </div>
              </div>
                      
              <div class="form-group clearfix">
                <label>Jenis Kelamin</label>
                <div style="border: 0" class="form-control">
                  <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary1" name="sex" value="Laki-laki"><label for="radioPrimary1">Laki-laki &nbsp;&nbsp;</label>
                  </div>
                  <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary2" name="sex" value="Perempuan"> <label for="radioPrimary2">Perempuan</label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>No. Handphone</label>
                <input type="text" name="phone" class="form-control">
              </div>
              <div class="form-group">
                <label>Agama</label>
                <input type="text" name="religion" class="form-control">
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <label>Provinsi</label>
                <select name="province_id" class="form-control" id="province_id" required>
                  <option value=""> -- Pilih Provinsi -- </option>
                  <?php foreach ($provinces->result() as $prov): ?>
                    <option value="<?php echo $prov->id ?>"><?php echo $prov->province ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Kota/Kabupaten</label>
                <select name="city_id" class="form-control" id="city_id" required>
                  <option value=""> -- Pilih Kota/Kabupaten -- </option>
                  <?php foreach ($cities->result() as $city): ?>
                    <option data-chained="<?php echo $city->province_id ?>" value="<?php echo $city->id ?>"><?php echo $city->city ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Kecamatan</label>
                <select name="district_id" class="form-control" id="district_id" required>
                  <option value=""> -- Pilih Kecamatan -- </option>
                  <?php foreach ($districts->result() as $dist): ?>
                    <option data-chained="<?php echo $dist->city_id ?>" value="<?php echo $dist->id ?>"><?php echo $dist->district ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Kode Pos</label>
                <input type="text" name="postal_code" class="form-control">
              </div>
              <div class="form-group">
                <label>NPWP</label>
                <input type="text" name="npwp" class="form-control">
              </div>                      
              <div class="form-group">
                <label>Status Perkawinan</label>
                <select class="form-control" name="marital_status">
                  <option value=""> -- Pilih Status Perkawinan -- </option>
                  <option value="Lajang">Lajang</option>
                  <option value="Menikah">Menikah</option>
                </select>
              </div>
            </div>

            <div class="col-md-6 col-lg-6">
              <div class="form-group">
                <label>NIP <i style="color: red;">*</i></label>
                <input type="text" name="nip" class="form-control" required>
              </div>
              <div class="form-group">
                <label>NIDN</label>
                <input type="text" name="nidn" class="form-control">
              </div>
              <div class="form-group">
                <label>NITK</label>
                <input type="text" name="nitk" class="form-control">
              </div>
              <div class="form-group">
                <label>NIDK</label>
                <input type="text" name="nidk" class="form-control">
              </div>
              <div class="form-group">
                <label>Email <i style="color: red;">*</i></label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="form-group">
                <label>TMT Kerja</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="date" class="form-control" name="join_date">
                </div>
              </div>
              <div class="form-group">
                <label>Grup <i style="color: red;">*</i></label>
                <select class="form-control" name="group_id" required>
                  <option value=""> -- Pilih Grup -- </option>
                  <?php foreach ($this->db->get('user_group')->result() as $grp): ?>
                    <option value="<?php echo $grp->id ?>"><?php echo $grp->name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Organisasi <i style="color: red;">*</i></label>
                <select name="org_unit" class="form-control" id="departement_id" required>
                  <option value=""> -- Pilih Organisasi -- </option>
                  <?php foreach ($organizations->result() as $dep): ?>
                    <option value="<?php echo $dep->id ?>"><?php echo $dep->org_unit ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Jabatan <i style="color: red;">*</i></label>
                <select name="position_id" class="form-control" id="position_id" required>
                  <option value=""> -- Pilih Jabatan -- </option>
                  <?php foreach ($positions->result() as $post): ?>
                    <option data-chained="<?php echo $post->org_unit ?>" value="<?php echo $post->id ?>"><?php echo $post->position ?></option>
                  <?php endforeach ?>
                </select>
              </div>       
              <div class="form-group">
                <label>Jabatan Fungsional</label>
                <select name="functional_position_id" class="form-control">
                  <option value="1"> -- Pilih Jabatan Fungsional -- </option>
                  <?php foreach ($this->db->get('functional_position')->result() as $funct): ?>
                    <option value="<?php echo $funct->id ?>"><?php echo $funct->position ?></option>
                  <?php endforeach ?>
                </select>
              </div>        
              <div class="form-group">
                <label>Status Perjanjian Kerja <i style="color: red;">*</i></label>
                <select name="status" class="form-control" required>
                  <option value="" selected disabled> -- Pilih Status -- </option>
                  <?php foreach ($this->db->get('employment_statuses')->result() as $empstat): ?>
                    <option value="<?php echo $empstat->id ?>"><?php echo $empstat->status ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Status Aktif <i style="color: red;">*</i></label>
                <select name="active_status" class="form-control" required>
                  <option value="" selected disabled> -- Pilih Status -- </option>
                  <?php foreach ($this->db->get('employment_active_statuses')->result() as $empstat) : ?>
                    <option value="<?php echo $empstat->id ?>"><?php echo $empstat->status ?></option>
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
                <label id="effective_date">Efektif per Tanggal<i style="color: red;">*</i>
                </label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="date" class="form-control" name="effective_date" required>
                </div>
              </div>
              <div class="form-group">
                <label>Status Kontrak</label>
                <select name="work_agreement_status" class="form-control">
                  <option value="" selected disabled></option>
                  <option value="PKWT">PKWT - Perjanjian Kerja Waktu Tertentu</option>
                  <option value="PKWTT">PKWTT - Perjanjian Kerja Waktu Tidak Tertentu</option>
                </select>
              </div>
              <div class="form-group">
                <label>Dokumen Kontrak</label>
                <input type="file" name="work_agreement_file" class="form-control" style="border: 0;" accept=".pdf" required>
              </div>
              <div class="form-group">
                <label>RFID</label>
                <input type="text" name="rfid" class="form-control">
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

                  <div class="input-group">
                    <div class="col-md-3">
                      <label>Jenjang</label>
                      <select class="form-control" name="educations[]" required>
                        <option value=""> -- Pilih Pendidikan -- </option>
                          <option value="SMA/SMK/MA">SMA/SMK/MA</option>
                          <option value="Diploma Satu (D1)">Diploma Satu (D1)</option>
                          <option value="Diploma Dua (D2)">Diploma Dua (D2)</option>
                          <option value="Diploma Tiga (D3)">Diploma Tiga (D3)</option>
                          <option value="Diploma Empat (D4)">Diploma Empat (D4)</option>
                          <option value="Sarjana (S1)">Sarjana (S1)</option>
                          <option value="Master (S2)">Master (S2)</option>
                          <option value="Doktor (S3)">Doktor (S3)</option>
                      </select>                              
                    </div>

                    <div class="col-md-4">
                      <label>Institusi</label>
                      <input type="text" name="institutions[]" class="form-control">                              
                    </div>

                    <div class="col-md-3">
                      <label>Tanggal Lulus</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="date" class="form-control" name="graduates[]">
                      </div>
                              
                    </div>

                    <div class="col-md-2">
                      <label>Aksi</label>
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="button" class="btn btn-xs btn-success" id="addrow" value="Tambah" />
                        </span>
                      </div>                             
                    </div>
                  </div>                            

                  </p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <div class="float-right">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
      </div>
      </form>

    </div>
  </div>
</div>