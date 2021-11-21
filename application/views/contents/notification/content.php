<?php if ($this->session->userdata('role') == MY_Controller::HRD) : ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="font-weight-bold">Absensi</h5>
            <br>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 1%; white-space: nowrap;">No.</th>
                        <th class="text-center">NIP</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Kehadiran Terakhir</th>
                        <th class="text-center">Tidak Hadir</th>
                        <th class="text-center">Status Pegawai</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($absence as $value) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?= $value['nip'] ?></td>
                            <td><?= $value['name'] ?></td>
                            <td class="text-center"><?= $value['date'] ?></td>
                            <td class="text-center"><?= $value['day'] ?> Hari</td>
                            <td class="text-center">
                                <?php if ($value['status'] != 3) : ?>
                                    <span class="btn btn-success btn-sm">Aktif</span>
                                <?php else : ?>
                                    <span class="btn btn-danger btn-sm">Tidak Aktif</span>
                                <?php endif ?>
                            </td>
                            <td class="text-center">
                                <a href="<?=
                                            base_url() .
                                                'hrd/presence?nip=' .
                                                $value['nip'] .
                                                '&group=Semua&type=Semua&date=' .
                                                date('j+F+Y', strtotime($value['date'])) .
                                                '+-+' .
                                                date('j+F+Y', strtotime($value['date'])) .
                                                '#presence'
                                            ?>" class="btn btn-info btn-xs">
                                    <span class="fa fa-clock"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif ?>
<?php if ($this->session->userdata('role') == MY_Controller::HRD or $this->session->userdata('role') == MY_Controller::EMPLOYEE) : ?>
    <div class="card">
        <div class="card-body">
            <h5 class="font-weight-bold">Pengangkatan Karyawan</h5>
            <br>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 1%; white-space: nowrap;">No.</th>
                        <th class="text-center">NIP</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">TMT Kerja</th>
                        <th class="text-center">Lama Bekerja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($employee_promotion as $promote) : ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <?php if ($this->session->userdata('role') == MY_Controller::HRD) : ?>
                                <td class="text-center"><a href="<?= base_url() . 'hrd/employment/show/' . $promote['id'] ?>"><?= $promote['nip'] ?></a></td>
                                <td><a href="<?= base_url() . 'hrd/employment/show/' . $promote['id'] ?>"><?= $promote['name'] ?></a></td>
                            <?php elseif ($this->session->userdata('role') == MY_Controller::EMPLOYEE) : ?>
                                <td class="text-center"><?= $promote['nip'] ?></td>
                                <td class="text-center"><?= $promote['name'] ?></td>
                            <?php endif ?>
                            <?php
                            $year = date('Y', strtotime($promote['join_date']));
                            $month = date('n', strtotime($promote['join_date']));
                            $day = date('j', strtotime($promote['join_date']));
                            ?>
                            <td class="text-center"><?= strftime("%d %B %Y", mktime(0, 0, 0, $month, $day, $year)) ?></td>
                            <td class="text-center"><?= date_diff(date_create($promote['join_date']), date_create(date('Y-m-d')))->format('%Y tahun %M bulan %D hari') ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif ?>