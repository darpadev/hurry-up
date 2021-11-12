        <div class="row">
          <div class="col-lg-3 col-md-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $this->db->select('employee_id')->from('employee_pt')->where('status', 1)->get()->num_rows() ?></h3>

                <p>Jumlah Pegawai Aktif</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url() ?>hrd/employment" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $this->db->select('employee_id')->from('employee_pt')->where(array('status' => 1, 'group_id' => 1))->get()->num_rows() ?></h3>

                <p>Jumlah Tenaga Kependidikan</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url() ?>hrd/employment" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $this->db->select('employee_id')->from('employee_pt')->where(array('status' => 1, 'group_id' => 2))->get()->num_rows() ?></h3>

                <p>Jumlah Dosen</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo base_url() ?>hrd/employment" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $this->db->select('employee_id')->from('employee_pt')->where(array('status' => 1, 'group_id' => 3))->get()->num_rows() ?></h3>

                <p>Jumlah Aslab & Security</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url() ?>hrd/employment" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <table id="table" class="table table-bordered table-striped">
              <tr>
                <th>Kode PT</th>
                <td><?= $company->code_pt ?></td>
              </tr>
              <tr>
                <th>Status PT</th>
                <td><?= $company->status ?></td>
              </tr>
              <tr>
                <th>Akteditasi</th>
                <td><?= $company->accreditation ?></td>
              </tr>
              <tr>
                <th>Tanggal Berdiri</th>
                <td><?= tanggal($company->create_date) ?></td>
              </tr>
              <tr>
                <th>Nomor SK PT</th>
                <td><?= $company->sk_number_pt ?></td>
              </tr>
              <tr>
                <th>Tanggal SK PT</th>
                <td><?= tanggal($company->date_sk_number) ?></td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td><?= $company->address ?></td>
              </tr>
              <tr>
                <th>Telepon</th>
                <td><?= $company->phone ?></td>
              </tr>
              <tr>
                <th>Faxmile</th>
                <td><?= $company->fax ?></td>
              </tr>
              <tr>
                <th>Email</th>
                <td><?= $company->email ?></td>
              </tr>
            </table>
          </div>

          <section class="col-md-6 connectedSortable">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pegawai Terbaru</h3>

                <div class="card-tools">
                  <!-- <span class="badge badge-danger">8 Pegawai Baru</span> -->
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i> -->
                  <!-- </button> -->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <ul class="users-list clearfix">
                  <?php foreach ($employees->result() as $value): ?>
                    <li>
                      <img style="width: 80px; height: auto;" src="<?php echo base_url() ?>assets/images/contents/default.jpg" alt="User Image">
                      <a class="users-list-name" href="#"><?php echo $value->name ?></a>
                      <span class="users-list-date"><?php echo date('j F Y', strtotime($value->join_date)) ?></span>
                    </li>
                  <?php endforeach ?>
                </ul>
                <!-- /.users-list -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
                <a href="<?php echo base_url() ?>hrd/employee">Lihat Semua Pegawai</a>
              </div>
              <!-- /.card-footer -->
            </div>
          </section>
        </div>

        <!-- chart -->

        <div class="row">

          <div class="col-md-12">            
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Data Dosen</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">

                  <table style="margin-left: 35%;">
                   <tr>
                      <td>
                         <table width="100%">
                            <tr>
                               <td width="100px"><img src="<?php echo base_url('assets/images/contents/man.png') ?>" style="width: inherit;"></td>
                               <td rowspan="2"> = 
                                <?= $this->db->select('e.id')->from('employees as e')->join('employee_pt as ep', 'e.id = ep.employee_id')->where(array('e.sex' => 'Laki-laki', 'ep.group_id' => 2))->get()->num_rows(); ?>                                  
                                </td>
                            </tr>
                            <tr>
                               <td style="text-align: center; padding-top: 10px;">Laki - Laki</td>
                            </tr>
                         </table>
                      </td>
                      <td width="50px"></td>
                      <td>
                         <table width="100%">
                            <tr>
                               <td width="100px"><img src="<?php echo base_url('assets/images/contents/woman.png') ?>" style="width: inherit;"></td>
                               <td rowspan="2"> = 
                                <?= $this->db->select('e.id')->from('employees as e')->join('employee_pt as ep', 'e.id = ep.employee_id')->where(array('e.sex' => 'Perempuan', 'ep.group_id' => 2))->get()->num_rows(); ?>
                               </td>
                            </tr>
                            <tr>
                               <td style="text-align: center; padding-top: 10px;">Perempuan</td>
                            </tr>
                         </table>
                      </td>
                   </tr>
                </table>

                <br>

                <div class="row">                  
                  <div class="col-md-4">                  
                    <div class="chart">
                      <canvas id="nomorRegistrasiChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>

                  <div class="col-md-4">                  
                    <div class="chart">
                      <canvas id="jabatanFungsionalChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>

                  <div class="col-md-4">                  
                    <div class="chart">
                      <canvas id="jenjangPendidikanChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>  
                </div>

                <div class="row">
                  <ul class="nav nav-pills" style="margin-left: 30%">
                    <li class="nav-item"><a class="nav-link active" href="#registrasi" data-toggle="tab">Daftar Nomor Registrasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jabatan" data-toggle="tab">Daftar Jabatan Fungsional</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pendidikan" data-toggle="tab">Daftar Jenjang Pendidikan</a></li>
                  </ul>
                </div>
                
                <br>

                <div class="row">
                  <div class="col-md-12">                    
                    <div class="tab-content">

                      <div class="active tab-pane" id="registrasi">                      
                        <table id="" class="table table-bordered table-striped">
                          <tr style="background-color: #8c7eba;color: white;">
                            <th class="center">No</th>
                            <th class="center">Nomor Registrasi</th>
                            <th class="center">Jumlah</th>
                          </tr>
                          <tr>
                            <td class="center">1</td>
                            <td class="center">NIDN</td>
                            <td class="center">
                              <?= $this->db->select('ep.employee_id')->from('employee_pt as ep')
                              ->where('ep.nidn is not null', null)
                              ->where('ep.group_id', 2)
                              ->get()->num_rows();
                              ?>
                            </td>
                          </tr>
                        </table>
                      </div>

                      <div class="tab-pane" id="jabatan">                      
                        <table class="table table-bordered table-striped">
                          <tr style="background-color: #8c7eba;color: white;">
                            <th class="center">No</th>
                            <th class="center">Jabatan Fungsional</th>
                            <th class="center">Jumlah</th>
                          </tr>
                          <?php 
                          $no = 1;
                          foreach ($functional->result() as $funct): ?>
                            <tr>
                              <td class="center"><?= $no++ ?></td>
                              <td class="center"><?= $funct->position ?></td>
                              <td class="center"><?= $funct->total ?></td>
                            </tr>
                          <?php endforeach ?>
                        </table>
                      </div>

                      <div class="tab-pane" id="pendidikan">                      
                        <table id="" class="table table-bordered table-striped">
                          <tr style="background-color: #8c7eba;color: white;">
                            <th class="center">No</th>
                            <th class="center">Jenjang Pendidikan</th>
                            <th class="center">Jumlah</th>
                          </tr>

                          <?php 
                          $no = 1;
                          foreach ($lecture_education->result() as $edu): 
                          if ($edu->latest_education != '') :
                          ?>
                            <tr>
                              <td class="center"><?= $no++ ?></td>
                              <td class="center"><?= $edu->latest_education ?></td>
                              <td class="center"><?= $edu->total ?></td>
                            </tr>                            
                          <?php endif; endforeach; ?>
                        </table>
                      </div>

                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

        </div>

        <!-- <div class="row">
          

          <section class="col-lg-5 connectedSortable">

            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Kalender
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>

              </div>

              <div class="card-body pt-0">
                <div id="calendar" style="width: 100%"></div>
              </div>
            </div>
          </section>
        </div> -->

        <div class="row">
          <div class="col-md-12">       
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.268450649364!2d106.7872223147692!3d-6.22829499549147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTMnNDEuOSJTIDEwNsKwNDcnMjEuOSJF!5e0!3m2!1sid!2sid!4v1626896382484!5m2!1sid!2sid" style="border:0; width: 100%; height: 490px;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>