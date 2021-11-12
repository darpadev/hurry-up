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
        <div class="col-md-6 col-lg-6">
          <div class="card">
            <!-- <div class="card-header"> -->
              <a href="" class="btn btn-success create-leave" data-target="#modal-add-leave" data-toggle="modal">Tambah Approver Izin Kerja</a>
              <!-- </div> -->
              <?php $this->load->view('contents/hrd/approver/create') ?>
          </div>
            <div class="card-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Approver</th>
                  <th style="width: 17%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($leaves->result() as $value) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->parent ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/approver/delete_leave/<?php echo $value->id ?>" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>

          <div class="col-md-6 col-lg-6">
          <div class="card">
            <!-- <div class="card-header"> -->
              <a href="" class="btn btn-success create-overtime" data-target="#modal-add-overtime" data-toggle="modal">Tambah Approver Lembur</a>
              <!-- </div> -->
              <?php $this->load->view('contents/hrd/approver/create') ?>
          </div>
            <div class="card-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Approver</th>
                  <th style="width: 17%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($overtimes->result() as $value) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->parent ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/approver/delete_overtime/<?php echo $value->id ?>" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-12">
          <a href="<?php echo base_url() ?>hrd/master/position" class="btn btn-info">Kembali</a>
        </div>
      </div>