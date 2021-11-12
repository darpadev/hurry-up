          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'home') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>admin/home" class="nav-link <?php if ($this->uri->segment(2) == 'home') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item <?php if ($this->uri->segment(2) == 'usercontrol') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>admin/usercontrol" class="nav-link <?php if ($this->uri->segment(2) == 'usercontrol') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Hak Akses
              </p>
            </a>
          </li>
          <li class="nav-item <?php if ($this->uri->segment(2) == 'approval') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>admin/approval" class="nav-link <?php if ($this->uri->segment(2) == 'approval') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-check-square"></i>
              <p>
                Alur Persetujuan
              </p>
            </a>
          </li>
          <li class="nav-item <?php if ($this->uri->segment(2) == 'menu') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>admin/menu" class="nav-link <?php if ($this->uri->segment(2) == 'menu') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Menu Pengguna
              </p>
            </a>
          </li>
          <li class="nav-item <?php if ($this->uri->segment(2) == 'setting') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>admin/setting" class="nav-link <?php if ($this->uri->segment(2) == 'setting') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Pengaturan
              </p>
            </a>
          </li>