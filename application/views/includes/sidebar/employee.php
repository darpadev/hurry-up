          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'home') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>employee/home" class="nav-link <?php if ($this->uri->segment(2) == 'home') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'biodata') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>employee/biodata" class="nav-link <?php if ($this->uri->segment(2) == 'biodata') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Biodata
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'presence') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>employee/presence" class="nav-link <?php if ($this->uri->segment(2) == 'presence') { echo 'active'; } ?>">
              <i class="nav-icon fa fa-hourglass-half"></i>
              <p>
                Kehadiran
              </p>
            </a>
          </li>

          <?php if ($this->session->userdata('group') == 1 && in_array(6, $this->session->userdata('level'))): ?>
          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'overtime') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>employee/overtime" class="nav-link <?php if ($this->uri->segment(2) == 'overtime') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Lembur
              </p>
            </a>
          </li>
          <?php endif ?>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'leave') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>employee/leave" class="nav-link <?php if ($this->uri->segment(2) == 'leave') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-envelope-open"></i>
              <p>
                Izin Kerja
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'performance') { echo 'menu-open'; } ?>">
            <a href="" class="nav-link <?php if ($this->uri->segment(2) == 'performance') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-trophy"></i>
              <p>
                Indikator Kinerja
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <?php $peer_review = array('peer_review', 'edit_reviewer', 'assign_reviewer', 'assessment_peer_review', 'detail_peer_review', 'request_assessment'); ?>
                <a href="<?php echo base_url() ?>employee/performance/peer_review" class="nav-link <?php if (in_array($this->uri->segment(3), $peer_review) && $this->uri->segment(2) == 'performance') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penilaian Sejawat</p>
                </a>
              </li>
              
              <li class="nav-item">
                <?php $performances = array('performance_appraisal', 'show_performance_appraisal'); ?>
                <a href="<?php echo base_url() ?>employee/performance/performance_appraisal" class="nav-link <?php if (in_array($this->uri->segment(3), $performances) && $this->uri->segment(2) == 'performance') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penilaian Kinerja</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'business') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>employee/business" class="nav-link <?php if ($this->uri->segment(2) == 'business') { echo 'active'; } ?>">
              <i class="nav-icon fab fa-tripadvisor"></i>
              <p>
                Perjalanan Dinas
              </p>
            </a>
          </li> -->

          <!-- <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'reimbursement') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>employee/reimbursement" class="nav-link <?php if ($this->uri->segment(2) == 'reimbursement') { echo 'active'; } ?>">
              <i class="nav-icon fab fa-google-wallet"></i>
              <p>
                Pergantian Biaya
              </p>
            </a>
          </li> -->

          <!-- <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'training') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>employee/training" class="nav-link <?php if ($this->uri->segment(2) == 'training') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-award"></i>
              <p>
                Pelatihan
              </p>
            </a>
          </li> -->

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'timesheet') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>employee/timesheet" class="nav-link <?php if ($this->uri->segment(2) == 'timesheet') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
                Kegiatan Harian
              </p>
            </a>
          </li>

          <?php 
          $level = $this->session->userdata('level');
          $approver = array(1, 2, 3, 4);

          if (array_intersect($level, $approver)): ?>            
           <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'team') { echo 'menu-open'; } ?>">
            <a href="" class="nav-link <?php if ($this->uri->segment(2) == 'team') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Anggota Tim
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>            
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url() ?>employee/team/overtime" class="nav-link <?php if ($this->uri->segment(3) == 'overtime' && $this->uri->segment(2) == 'team') { echo 'active'; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lembur</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?php echo base_url() ?>employee/team/leave" class="nav-link <?php if ($this->uri->segment(3) == 'leave' && $this->uri->segment(2) == 'team') { echo 'active'; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Izin Kerja</p>
                  </a>
                </li>

                <li class="nav-item">
                  <?php $listPerformance = array('performance', 'create_criteria', 'adjustment_criteria', 'assessment'); ?>
                  <a href="<?php echo base_url() ?>employee/team/performance" class="nav-link <?php if (in_array($this->uri->segment(3), $listPerformance) && $this->uri->segment(2) == 'team') { echo 'active'; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Penilaian Kinerja</p>
                  </a>
                </li>

                <li class="nav-item">
                  <?php $listTimesheet = array('timesheet'); ?>
                  <a href="<?php echo base_url() ?>employee/team/timesheet" class="nav-link <?php if (in_array($this->uri->segment(3), $listTimesheet) && $this->uri->segment(2) == 'team') { echo 'active'; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kegiatan Harian</p>
                  </a>
                </li>
            </ul>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'approve') { echo 'menu-open'; } ?>">
            <a href="" class="nav-link <?php if ($this->uri->segment(2) == 'approve') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-check-square"></i>
              <p>
                <?php 
                $count_approval_overtimes = $this->db->select('id')->from('approval_overtimes')->where(array('flag' => 4))->where_in('approver_id', $this->session->userdata('position'))->get()->num_rows();
                $count_approval_leaves = $this->db->select('id')->from('approval_leaves')->where(array('flag' => 4))->where_in('approver_id', $this->session->userdata('position'))->get()->num_rows();

                ?>

                Persetujuan 
                <?php if ($count_approval_overtimes || $count_approval_leaves): ?>                  
                  <span class="badge badge-danger"><?php echo $count_approval_overtimes + $count_approval_leaves ?></span>
                <?php endif ?>
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>            
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url() ?>employee/approve/overtime" class="nav-link <?php if ($this->uri->segment(3) == 'overtime' && $this->uri->segment(2) == 'approve') { echo 'active'; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      Lembur

                      <?php if ($count_approval_overtimes): ?>      
                      <span class="badge badge-danger"><?php echo $count_approval_overtimes ?></span>
                      <?php endif ?>
                    </p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?php echo base_url() ?>employee/approve/leave" class="nav-link <?php if ($this->uri->segment(3) == 'leave' && $this->uri->segment(2) == 'approve') { echo 'active'; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      Izin Kerja
                      
                      <?php if ($count_approval_leaves): ?>      
                      <span class="badge badge-danger"><?php echo $count_approval_leaves ?></span>
                      <?php endif ?>
                    </p>
                  </a>
                </li>

                <!-- <li class="nav-item">
                  <a href="<?php echo base_url() ?>employee/approve/business" class="nav-link <?php if ($this->uri->segment(3) == 'business') { echo 'active'; } ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Perjalanan Dinas</p>
                  </a>
                </li> -->
            </ul>
          </li>
          <?php endif ?>