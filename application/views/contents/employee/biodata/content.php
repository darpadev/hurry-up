<div class="row">
  <div class="col-md-3">
    <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="<?php echo base_url() ?>assets/images/contents/default.jpg"
                   alt="User profile picture">
            </div>
            <br>
            <h3 class="profile-username text-center" style="font-size: 16px;"><strong><?php echo $data->name ?></strong></h3>

            <p class="text-muted text-center">NIP. <?php echo $data->nip ?></p>

            <?php if (@$data->nidn): ?>             
              <p class="text-muted text-center">NIDN. <?php echo $data->nidn ?></p>
            <?php endif ?>

            <?php if (@$data->nitk): ?>             
              <p class="text-muted text-center">NITK. <?php echo $data->nitk ?></p>
            <?php endif ?>

            <?php if (@$data->nidk): ?>             
              <p class="text-muted text-center">NIDK. <?php echo $data->nidk ?></p>
            <?php endif ?>

            <a href="javascript:void(0);" class="btn btn-primary btn-block"><b><?php echo $data->status ?></b></a>
          </div>
        </div>
  </div>

  <div class="col-md-9">
    <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link active" href="#employee" data-toggle="tab">Data Pegawai</a></li>
          <li class="nav-item"><a class="nav-link" href="#personal" data-toggle="tab">Data Pribadi</a></li>
          <li class="nav-item"><a class="nav-link" href="#position_history" data-toggle="tab">Riwayat Jabatan</a></li>
        </ul>
      </div>

      <div class="card-body">
        <div class="tab-content">

          <div class="active tab-pane" id="employee">
            <form class="form-horizontal">

              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo $data->email ?>
                              </label>
                            </div>
              </div>
              
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Organisasi</label>
                            <div class="col-sm-9">
                                <?php foreach ($organizations->result() as $org): ?>
                              <label style="border: 0; color: black;" class="form-control">
                                  <?php echo $org->org_unit ?>
                              </label>
                                <?php endforeach ?>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Jabatan</label>
                            <div class="col-sm-9">
                                <?php foreach ($organizations->result() as $org): ?>
                              <label style="border: 0; color: black;" class="form-control">
                                  <?php echo $org->position ?>
                              </label>
                                <?php endforeach ?>
                            </div>
              </div>

              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Jabatan Fungsional</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo (@$data->functional_position) ? $data->functional_position : '-'; ?>
                              </label>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">No. Ekstensi</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo (@$data->extension) ? $data->extension : '-'; ?>
                              </label>
                            </div>
              </div>

              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">TMT Kerja</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo tanggal($data->join_date) ?>
                              </label>
                            </div>
              </div>
            </form>           

            <div class="card-header">
              <h4 class="center">Data Izin Kerja</h4>
            </div>

            <div class="card-body" id="leave">              
              <form class="form-horizontal" action="#leave" method="GET">
                <div class="form-group row">
                  <label style="font-weight: 400" for="inputName" class="col-sm-2 col-form-label">Periode</label>
                  <div class="col-sm-6">                  
                    <select class="form-control" name="period" required>
                      <?php foreach ($period as $join): ?>
                        <option <?php echo (isset($_GET['period']) && $join['start'].' - '.$join['end'] == $_GET['period']) ? 'selected' : '' ?> value="<?php echo $join['start'].' - '.$join['end'] ?>"><?php echo tanggal($join['start']).' - '.tanggal($join['end']) ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-success"><span class="fa fa-search"></span> &nbsp;&nbsp;Cari</button>
                  </div>
                </div>
              </form>

            <?php if (isset($_GET['period'])): ?>
              <table id="table" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                            <th style="width: 5%" class="center">No</th>
                            <th class="center">Mulai</th>
                            <th class="center">Selesai</th>
                            <th class="center">Jenis</th>
                            <th class="center">Approval</th>
                            <th class="center">Durasi</th>
                            <th style="width: auto;" class="center"></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $no = 1;
                      foreach ($leaves->result() as $value) { 
                      ?>
                        <tr <?php if ($value->type == 'Cuti' && $value->status == 'Approved') { ?> style="background: #A0A0A0;" <?php } ?> >
                            <td class="center"><?php echo $no++ ?></td>
                            <td class="center"><?php echo tanggal($value->start) ?></td>
                            <td class="center"><?php echo tanggal($value->finish) ?></td>
                            <td class="center"><?php echo $value->type ?></td>
                            <td class="center"><span class="btn <?php echo ($value->status == 'Pending') ? 'btn-primary' : ($value->status == 'Approved' ? 'btn-success' : ($value->status == 'Rejected' ? 'btn-danger' : ($value->status == 'Processed' ? 'btn-warning' : ''))) ?> btn-xs"><?php echo $value->status ?></span></td>
                            <?php 
                              $awal = new DateTime($value->start);
                              $akhir = new DateTime($value->finish);
                              $interval = $awal->diff($akhir);
                              $elapsed = $interval->format('%d') + 1;
                            ?>
                            <td class="center"><?php echo $elapsed ?></td>
                            <td class="center">
                              <a href="<?php echo base_url() ?>employee/leave/show/<?php echo $value->id ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th style="text-align: right;" colspan="5">Jumlah Izin Kerja Approved</th>
                        <th style="background-color: #dff0d8;" colspan="2" class="center"><?php echo $count_leave ?> Hari </th>
                      </tr>
                    </tfoot>
                  </table>
            <?php endif ?>
            </div>
          </div>

          <div class="tab-pane" id="personal">
            <form class="form-horizontal">
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">NIK</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo $data->sid ?>
                              </label>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo tanggal($data->birthday) ?>
                              </label>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">No. Handphone</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo $data->phone ?>
                              </label>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo $data->address ?>
                              </label>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Provinsi</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo $data->province ?>
                              </label>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Kota/Kabupaten</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo $data->city ?>
                              </label>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Kecamatan</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo $data->district ?>
                              </label>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Kode Pos</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo $data->postal_code ?>
                              </label>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">NPWP</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo $data->npwp ?>
                              </label>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Riwayat Pendidikan</label>
                            <div class="col-sm-9">
                                <?php foreach ($educations->result() as $edu): ?>
                              <label style="border: 0; color: black;" class="form-control">
                                  <?php echo $edu->level.' - '.$edu->institution ?>
                              </label>
                                <?php endforeach ?>
                            </div>
              </div>
              <div class="form-group row">
                <label style="font-weight: 400" for="inputName" class="col-sm-3 col-form-label">Status Perkawinan</label>
                            <div class="col-sm-9">
                              <label style="border: 0; color: black;" class="form-control">
                                <?php echo $data->marital_status ?>
                              </label>
                            </div>
              </div>
            </form>
          </div>

          <div class="tab-pane" id="position_history">
            <form class="form-horizontal">
              <table id="" class="table table-bordered table-striped">
              <thead>
                  <tr>
                    <th style="width: 5%" class="center">No</th>
                    <th class="center">Jabatan</th>
                    <th class="center">Mulai</th>
                    <th class="center">Sampai</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($position_history->result() as $value): ?>
                    <tr>
                      <td class="center"><?php echo $no++ ?></td>
              <td><?php echo $value->position ?></td>
              <td class="center"><?php echo tanggal(date('Y-m-d', strtotime($value->start_date))) ?></td>
              <td class="center"><?php echo ($value->end_date) ? tanggal(date('Y-m-d', strtotime($value->end_date))) : 'Sekarang'; ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
            </table>
            </form>
          </div>
        </div>
      </div>

      <!-- <div class="card-footer">
        <div class="float-right"> 
          <?php if (isset($_GET['group']) && isset($_GET['status']) && isset($_GET['departement']) && isset($_GET['position'])): ?>
            <a class="btn btn-default" href="<?php echo base_url() ?>employee/biodata<?php echo '?group='.$_GET['group'].'&status='.$_GET['status'].'&departement='.$_GET['departement'].'&position='.$_GET['position'] ?>"><span class="fa fa-reply"></span>&nbsp;&nbsp; Kembali</a>
          <?php else : ?>
            <a class="btn btn-default" href="<?php echo base_url() ?>employee/biodata"><span class="fa fa-reply"></span>&nbsp;&nbsp; Kembali</a>  
          <?php endif ?>
              
              <a class="btn btn-primary" href="<?php echo base_url() ?>employee/biodata/edit/<?php echo $data->id ?>"><span class="fa fa-edit"></span>&nbsp;&nbsp; Ubah</a>
        </div>
      </div> -->
    </div>
  </div>
</div>