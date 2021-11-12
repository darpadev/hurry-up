        <div class="row">
          <div class="col-lg-3 col-md-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $this->db->select('status')->from('employee_pt')->where('status', 1)->get()->num_rows() ?></h3>

                <p>Pengguna Aktif</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url() ?>admin/usercontrol" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-md-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $this->db->select('id')->from('login')->where('role_id', 1)->get()->num_rows() ?></h3>

                <p><?php echo $this->db->select('role')->from('roles')->where('id', 1)->get()->row()->role ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url() ?>admin/usercontrol" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-md-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $this->db->select('id')->from('login')->where('role_id', 2)->get()->num_rows() ?></h3>

                <p><?php echo $this->db->select('role')->from('roles')->where('id', 2)->get()->row()->role ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo base_url() ?>admin/usercontrol" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-md-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $this->db->select('id')->from('login')->where('role_id', 3)->get()->num_rows() ?></h3>

                <p><?php echo $this->db->select('role')->from('roles')->where('id', 3)->get()->row()->role ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url() ?>admin/usercontrol" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        