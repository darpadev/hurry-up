        <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="float-left">
                <a href="" class="btn btn-success create-data" data-target="#modal-add-data" data-toggle="modal"><span class="fa fa-calendar"></span> &nbsp;Tambah Kalendar</a>
              </div>

              <?php $this->load->view('contents/hrd/performance/create_calendar') ?>
            </div>

            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Deskripsi</th>
                  <th class="center">Tahun</th>
                  <th class="center">Periode</th>
                  <th style="width: auto;" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {
                  ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->description ?></td>
                  <td class="center"><?php echo $value->year ?></td>
                  <td><?php echo $value->period ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/performance/detail_calendar/<?php echo $value->id ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>hrd/performance/edit_calendar/<?php echo $value->id ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>hrd/performance/delete_calendar/<?php echo $value->id ?>" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>