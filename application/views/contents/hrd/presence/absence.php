      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <!-- <div class="card-header">
              <h3 class="card-title">Absensi Pegawai</h3>
            </div> -->
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">NIP</th>
                  <th class="center">Nama</th>
                  <th class="center">Kehadiran Terakhir</th>
                  <th class="center">Tidak Hadir</th>
                  <th class="center">Status Pegawai</th>
                  <td></td>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($notif as $value) {
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value['nip'] ?></td>
                  <td><?php echo $value['name'] ?></td>
                  <td class="center"><?php echo $value['date'] ?></td>
                  <td class="center"><?php echo $value['day'] ?> Hari</td>
                  <td class="center">
                    <?php if ($value['status'] == 1): ?>
                        <span class="btn btn-success btn-xs">Aktif</span>
                    <?php else : ?>
                        <span class="btn btn-danger btn-xs">Tidak aktif</span>
                    <?php endif ?>    
                  </td>
                  <td class="center">
                    <a href="<?php echo base_url() ?>hrd/presence<?php echo '?nip='.$value['nip'].'&group=Semua&type=Semua'.'&date='.date('j+F+Y', strtotime($value['date'])).'+-+'.date('j+F+Y', strtotime($value['date'])) ?>#presence" class="btn btn-info btn-xs"><span class="fa fa-clock"></span></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>