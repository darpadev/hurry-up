          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'home') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/home" class="nav-link <?php if ($this->uri->segment(2) == 'home') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'master') { echo 'menu-open'; } ?>">
            <a href="" class="nav-link <?php if ($this->uri->segment(2) == 'master') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Master
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/master/organization" class="nav-link <?php if ($this->uri->segment(3) == 'organization' || $this->uri->segment(3) == 'edit_organization') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Organisasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/master/position" class="nav-link <?php if ($this->uri->segment(3) == 'position' || $this->uri->segment(3) == 'edit_position' || $this->uri->segment(2) == 'approver') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jabatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/master/group" class="nav-link <?php if ($this->uri->segment(3) == 'group' || $this->uri->segment(3) == 'edit_group') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Grup</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'presence') { echo 'menu-open'; } ?>">
            <a href="" class="nav-link <?php if ($this->uri->segment(2) == 'presence') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-hourglass-half"></i>
              <p>
                Kehadiran
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/presence" class="nav-link <?php if ($this->uri->segment(2) == 'presence' && $this->uri->segment(3) != 'absence') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Presensi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/presence/absence" class="nav-link <?php if ($this->uri->segment(3) == 'absence') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Absensi</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'overtime') { echo 'menu-open'; } ?>">
            <a href="" class="nav-link <?php if ($this->uri->segment(2) == 'overtime') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Lembur
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/overtime/overtime" class="nav-link <?php if ($this->uri->segment(3) == 'overtime' || $this->uri->segment(3) == 'show_overtime') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daftar Lembur</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/overtime/incentive" class="nav-link <?php if ($this->uri->segment(3) == 'incentive' || $this->uri->segment(3) == 'show_incentive' || $this->uri->segment(2) == 'approver') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Insentif Lembur</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'performance') { echo 'menu-open'; } ?>">
            <a href="" class="nav-link <?php if ($this->uri->segment(2) == 'performance') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-trophy"></i>
              <p>
                Penilaian Kinerja
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/performance/calendar" class="nav-link <?php if ($this->uri->segment(3) == 'calendar' || $this->uri->segment(3) == 'detail_calendar') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kalender Penilaian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/performance/assessment" class="nav-link <?php if ($this->uri->segment(3) == 'assessment' || $this->uri->segment(3) == 'detail_assessment') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kinerja Pegawai</p>
                </a>
              </li>
              <li class="nav-item">                
                <?php $peer_review = array('peer_review', 'detail_peer_review'); ?>
                <a href="<?php echo base_url() ?>hrd/performance/peer_review" class="nav-link <?php if (in_array($this->uri->segment(3), $peer_review) && $this->uri->segment(2) == 'performance') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kinerja Sejawat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/performance/assessment_standard" class="nav-link <?php if ($this->uri->segment(3) == 'assessment_standard') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kriteria Kinerja Standar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/performance/assessment_peer_review" class="nav-link <?php if ($this->uri->segment(3) == 'assessment_peer_review') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kriteria Kinerja Sejawat</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'employee') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/employee" class="nav-link <?php if ($this->uri->segment(2) == 'employee') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Pegawai
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'employment') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/employment" class="nav-link <?php if ($this->uri->segment(2) == 'employment') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Kepegawaian
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'leave') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/leave" class="nav-link <?php if ($this->uri->segment(2) == 'leave') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-envelope-open"></i>
              <p>
                Izin Kerja
              </p>
            </a>
          </li>

          <!-- <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'business') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/business" class="nav-link <?php if ($this->uri->segment(2) == 'business') { echo 'active'; } ?>">
              <i class="nav-icon fab fa-tripadvisor"></i>
              <p>
                Perjalanan Dinas
              </p>
            </a>
          </li> -->

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'payroll') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/payroll" class="nav-link <?php if ($this->uri->segment(2) == 'payroll') { echo 'active'; } ?>">
              <i class="nav-icon fab fa-paypal"></i>
              <p>
                Penggajian
              </p>
            </a>
          </li>

          <!-- <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'reimburse') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/reimburse" class="nav-link <?php if ($this->uri->segment(2) == 'reimburse') { echo 'active'; } ?>">
              <i class="nav-icon fab fa-google-wallet"></i>
              <p>
                Pergantian Biaya
              </p>
            </a>
          </li> -->

          <!-- <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'training') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/training" class="nav-link <?php if ($this->uri->segment(2) == 'training') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-award"></i>
              <p>
                Pelatihan
              </p>
            </a>
          </li> -->

          <!-- <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'annoucmenet') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/annoucmenet" class="nav-link <?php if ($this->uri->segment(2) == 'annoucmenet') { echo 'active'; } ?>">
              <i class="nav-icon fa fa-list-alt"></i>
              <p>
                Pengumuman
              </p>
            </a>
          </li> -->

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'timesheet') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/timesheet" class="nav-link <?php if ($this->uri->segment(2) == 'timesheet') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
                Kegiatan Harian
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'holiday') { echo 'menu-open'; } ?>">
            <a href="<?php echo base_url() ?>hrd/holiday" class="nav-link <?php if ($this->uri->segment(2) == 'holiday') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Hari Libur
              </p>
            </a>
          </li>



          <li class="nav-item has-treeview <?php if ($this->uri->segment(2) == 'report') { echo 'menu-open'; } ?>">
            <a href="" class="nav-link <?php if ($this->uri->segment(2) == 'report') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Laporan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/report/employee" class="nav-link <?php if ($this->uri->segment(3) == 'employee') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pegawai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/report/presence" class="nav-link <?php if ($this->uri->segment(3) == 'presence') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kehadiran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/report/overtime" class="nav-link <?php if ($this->uri->segment(3) == 'overtime') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lembur</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/report/leave" class="nav-link <?php if ($this->uri->segment(3) == 'leave') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Izin Kerja</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>hrd/report/performance" class="nav-link <?php if ($this->uri->segment(3) == 'performance') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kinerja Pegawai</p>
                </a>
              </li>
            </ul>
          </li>