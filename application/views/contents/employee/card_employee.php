        <div class="modal fade" id="modal-detail-employee">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Detail Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <div class="box-body">

                  <div class="align-items-stretch">
                    <div class="card bg-light">
                      <div class="card-header text-muted border-bottom-0">

                      </div>
                      <div class="card-body pt-0">
                        <div class="row">
                          <div class="col-md-7">
                            <div class="form-group">
                              <label>Nama</label>
                              <input type="text" class="form-control" style="background: transparent; border: none;" readonly id="name">
                            </div>
                            <div class="form-group">
                              <label>NIP</label>
                              <input type="text" class="form-control" style="background: transparent; border: none;" readonly id="nip">
                            </div>
                            <div class="form-group">
                              <label>Email</label>
                              <input type="text" class="form-control" style="background: transparent; border: none;" readonly id="email">
                            </div>
                            <div class="form-group">
                              <label>Extensi</label>
                              <input type="text" class="form-control" style="background: transparent; border: none;" readonly id="extension">
                            </div>

                            <div class="form-group">
                              <label>Atasan</label>
                              <p id="supervisor"></p>
                            </div>

                            <div class="form-group">
                              <label>Jabatan</label>
                              <p id="position"></p>
                            </div>

                            <div class="form-group">
                              <label>Organisasi</label>
                              <p id="org_unit"></p>
                            </div>
                            
                          </div>
                          <div class="col-md-5 text-center">                        
                            <img src="<?= base_url('assets/images/contents/default.jpg') ?>" alt="" class="img-circle img-fluid">

                            <!-- <div style="padding-top: 3%;">
                              <div class="text-center">
                                <a href="#organization" class="btn btn-sm btn-info">
                                  <i class="fas fa-area-chart"></i> Lihat Hirarki Organisasi
                                </a>
                              </div>
                            </div> -->
                          </div>
                        </div>
                      </div>

                      <!-- <div class="card-footer">
                        <div class="text-right">
                          <a href="#" class="btn btn-sm bg-teal">
                            <i class="fas fa-comments"></i>
                          </a>
                          <a href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-user"></i> Lihat Hirarki Organisasi
                          </a>
                        </div>
                      </div> -->
                    </div>
                  </div> 

                  <div class="row">
                    <div class="col-md-12">                      
                      <div id="organization" class="text-center"></div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>