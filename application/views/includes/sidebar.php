  <aside class="main-sidebar bg-white elevation-4">
    <a href="<?php echo base_url() ?>" class="brand-link">
      <img src="<?php echo base_url() ?>assets/images/contents/icon-UP.png" alt="" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $this->db->select('name')->from('company')->get()->row()->name; ?></span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url() ?>assets/images/contents/default.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="" class="d-block"><?php echo $this->authorization->getUser($this->session->userdata('employee'))->name; ?></a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">          
          <li class="nav-header"> <strong>MENU <?php echo strtoupper($this->db->select('role')->from('roles')->where('id', $this->session->userdata('role'))->get()->row()->role) ?> </strong> </li>

          <!-- Menu Administrator -->
          <?php if ($this->session->userdata('role') == 1) : ?> 
          <?php $this->load->view('includes/sidebar/admin'); ?>

          <!-- Menu HRD -->
          <?php elseif ($this->session->userdata('role') == 2) : ?>
          <?php $this->load->view('includes/sidebar/hrd'); ?>          

          <!-- Menu Pegawai -->
          <?php else : ?>
          <?php $this->load->view('includes/sidebar/employee'); ?>
          
          <?php endif; ?>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(1) == 'password') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>password" class="nav-link <?php if ($this->uri->segment(1) == 'password') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-unlock"></i>
              <p>
                Ganti Password
              </p>
            </a>
          </li>

          <?php if($this->authorization->countRole($this->session->userdata('id'))->num_rows() > 1){ ?>
          <li class="nav-item <?php if ($this->uri->segment(1) == 'role') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>role" class="nav-link <?php if ($this->uri->segment(1) == 'role') { echo 'active'; } ?>">
              <i class="nav-icon fa fa-retweet"></i>
              <p>
                Ganti Peran
              </p>
            </a>
          </li>
          <?php } ?>
        </ul>
      </nav>
    </div>
  </aside>