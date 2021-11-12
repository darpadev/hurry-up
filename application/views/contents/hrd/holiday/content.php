      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <a href="" class="btn btn-success create-data" data-target="#modal-add-data" data-toggle="modal"><span class="fa fa-calendar"></span>&nbsp;&nbsp; Tambah Data</a>
              </div>
              <?php $this->load->view('contents/hrd/holiday/create') ?>
          
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Tanggal</th>
                  <th class="center">Deskripsi</th>
                  <th class="center">Dibuat Oleh</th>
                  <th style="width: 10%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo date('j F Y', strtotime($value->day_off)) ?></td>
                  <td><?php echo $value->description ?></td>
                  <td><?php echo $value->created ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/holiday/edit/<?php echo $value->id ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>hrd/holiday/delete/<?php echo $value->id ?>" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>