      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h3 class="center"><?php echo $this->db->where('id', $this->uri->segment(4))->get('positions')->row()->position ?></h3>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <a href="" class="btn btn-success create-data" data-target="#modal-add-data" data-toggle="modal"><i class="fa fa-user-plus"></i> Tambah Pegawai</a>
              <a href="" class="btn btn-primary create-data-tupoksi" data-target="#modal-add-tupoksi" data-toggle="modal"><i class="fa fa-suitcase"></i> Tambah Tupoksi</a>
              <span style="float: right;">                
                <a href="<?php echo base_url() ?>hrd/master/position" class="btn btn-info"><i class="fa fa-reply"></i> Kembali</a>
              </span>
            </div>
              <?php $this->load->view('contents/hrd/master/position/add_employee') ?>
              <?php $this->load->view('contents/hrd/master/position/add_tupoksi') ?>
          
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">NIP</th>
                  <th class="center">Nama</th>
                  <th class="center">Mulai</th>
                  <th class="center">Sampai</th>
                  <th class="center">Status</th>
                  <th style="width: 17%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->nip ?></td>
                  <td><?php echo $value->name ?></td>
                  <td class="center"><?php echo tanggal(date('Y-m-d', strtotime($value->start_date))) ?></td>
                  <td class="center"><?php echo ($value->end_date) ? tanggal(date('Y-m-d', strtotime($value->end_date))) : 'Sekarang'; ?></td>
                  <td class="center"><?php echo ($value->flag) ? 'Aktif' : 'Tidak Aktif'; ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/master/edit_employee_position/<?php echo $value->id ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit" title="Edit" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>hrd/master/remove_employee_position/<?php echo $value->id ?>" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-trash" title="Remove" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <table id="table-tupoksi" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Tugas Pokok dan Fungsi</th>
                  <th class="center">Bobot</th>
                  <th style="width: 17%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($tupoksi->result() as $value) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->tupoksi ?></td>
                  <td class="center"><?php echo $value->weight ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/master/edit_tupoksi_position/<?php echo $value->id ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit" title="Edit" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>hrd/master/remove_tupoksi_position/<?php echo $value->id ?>" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-trash" title="Delete" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>