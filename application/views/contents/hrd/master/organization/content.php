      <div class="row">
        <div class="col-md-12">
            <div class="card-body">
              <form action="<?php echo base_url() ?>hrd/master/organization" method="GET">
                <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
                <div class="row">
                  <div class="col-md-4">                    
                    <div class="form-group">
                      <label>Organisasi</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-user-secret"></i>
                          </span>
                        </div>                        
                        <select class="form-control" name="org_unit">
                          <option <?php echo (isset($_GET['org_unit'])) ? 'selected': ''; ?>>Semua</option>
                          <?php foreach ($this->db->get('organizations')->result() as $value): ?>                      
                            <option <?php echo (isset($_GET['org_unit']) && $_GET['org_unit'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->org_unit ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Tipe</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-tags"></i>
                          </span>
                        </div>
                        <select class="form-control" name="type">
                          <option <?php echo (isset($_GET['type'])) ? 'selected': ''; ?>>Semua</option>
                          <?php foreach ($this->db->get('org_types')->result() as $value): ?>                      
                            <option <?php echo (isset($_GET['type']) && $_GET['type'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->type ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>                    
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Status</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-leaf"></i>
                          </span>
                        </div>
                        <select class="form-control" name="is_active">
                          <option value="1" <?php echo (isset($_GET['is_active']) && $_GET['is_active'] == true) ? 'selected': ''; ?>>Aktif</option>
                          <option value="0" <?php echo (isset($_GET['is_active']) && $_GET['is_active'] == false) ? 'selected': ''; ?>>Tidak Aktif</option>
                        </select>
                      </div>
                    </div>                    
                  </div>
                </div>

                </div>
                  <div class="float-left">
                    <a href="<?php echo base_url() ?>" class="btn btn-success create-data" data-target="#modal-add-data" data-toggle="modal"><span class="fa fa-users"></span> &nbsp;Tambah Data</a>
                  </div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
                  </div>
              </form>
              <?php $this->load->view('contents/hrd/master/organization/create') ?>
            </div>
        </div>

        <div class="col-md-12">
          <div class="card">          
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Organisasi</th>
                  <th class="center">Tipe</th>
                  <th class="center">Status</th>
                  <th style="width: 10%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->org_unit ?></td>
                  <td><?php echo $value->type ?></td>
                  <td class="center"><?php echo ($value->is_active) ? 'Aktif' : 'Tidak Aktif'; ?></td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/master/edit_organization/<?php echo $value->id ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url() ?>hrd/master/delete_organization/<?php echo $value->id ?>" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>