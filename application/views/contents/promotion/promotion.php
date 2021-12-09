<div class="col-md-12">
    <div class="row">
        <div class="col-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <table class="w-100">
                        <tr>
                            <th class="align-baseline">Nama</th>
                            <td class="align-baseline">:</td>
                            <td><?= $employee->name ?></td>
                        </tr>
                        <tr>
                            <th class="align-baseline">NIP</th>
                            <td class="align-baseline">:</td>
                            <td><?= $employee->nip ?></td>
                        </tr>
                        <tr>
                            <th class="align-baseline">TMT</th>
                            <td class="align-baseline">:</td>
                            <td><?= date('d F Y', strtotime($employee->join_date)) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <?php if ($approval->message === NULL) : ?>
                        <form action="<?= base_url() ?>promotion/store/" method="post">
                            <input type="hidden" name="employee_id" value="<?= $this->uri->segment(3) ?>">
                            <div class="mb-3">
                                <div class="text-center">
                                    <h5 class="font-weight-bold">Dasar Pertimbangan Pengangkatan Pegawai Tetap</h5>
                                </div>
                                <hr>
                                <div id="reason" class="mb-3">
                                    <input type="text" name="reason[]" class="reason-field form-control" placeholder="Dasar Pertimbangan" required>
                                </div>
                                <div class="text-right">
                                    <a href="" id="delete" class="btn btn-danger btn-sm">Hapus</a>
                                    <a href="" id="add" class="btn btn-success btn-sm">Tambah</a>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <h6 class="font-weight-bold text-center">Penilaian Kinerja <?= date('Y', strtotime($employee->join_date)) ?></h6>
                                        <input type="number" name="rating[]" class="form-control w-25 mx-auto" min="0" max="10" step="0.1" required>
                                    </div>
                                    <div class="col">
                                        <h6 class="font-weight-bold text-center">Penilaian Kinerja <?= date('Y', strtotime($employee->join_date . '+ 1 year')) ?></h6>
                                        <input type="number" name="rating[]" class="form-control w-25 mx-auto" min="0" max="10" step="0.1" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn btn-primary mx-auto">Kirim</button>
                            </div>
                        </form>
                    <?php else : ?>
                        <div class="mb-3">
                            <div class="text-center">
                                <h5 class="font-weight-bold">Dasar Pertimbangan Pengangkatan Pegawai Tetap</h5>
                            </div>
                            <hr class="border-primary">
                            <div class="mb-3">
                                <?php $review = explode('|', $approval->message) ?>
                                <ol>
                                    <?= $review[0] ?>
                                </ol>
                            </div>
                            
                            <hr class="border-primary">
                            
                            <div class="mb-3 d-flex justify-content-around">
                                <div>
                                    <h5 class="font-weight-bold">Penilaian Kinerja <?= date('Y', strtotime($employee->join_date)) ?></h5>
                                    <p class="m-0 font-weight-bold text-center" style="font-size: 24px;"><?= $review[1] ?></p>
                                </div>
                                <span class="border-right border-primary"></span>
                                <div>
                                    <h5 class="font-weight-bold">Penilaian Kinerja <?= date('Y', strtotime($employee->join_date . '+ 1 year')) ?></h5>
                                    <p class="m-0 font-weight-bold text-center" style="font-size: 24px;"><?= $review[2] ?></p>
                                </div>
                            </div>

                            <hr class="border-primary">

                            <div class="mb-3">
                                <p class="m-0"><span class="badge badge-warning text-dark" style="font-size: 14px">Penilai</span><?= " " . $approval->assessor_name ?></p>
                            </div>

                            <?php if ($approval->manager !== NULL) : ?>
                                <div class="mb-3">
                                    <p class="m-0"><span class="badge badge-primary" style="font-size: 14px">Keputusan Manajer</span><?= " " . $approval->manager ?></p>
                                </div>
                            <?php endif ?>
                            
                            <?php if ($approval->director !== NULL) : ?>
                                <div class="mb-3">
                                    <p class="m-0"><span class="badge badge-primary" style="font-size: 14px">Keputusan Direktur</span><?= " " . $approval->director ?></p>
                                </div>

                                <hr class="border-primary">

                                <?php if ($this->session->userdata('role') == MY_Controller::HRD) : ?>
                                    <?php if ($status_update === NULL) : ?>
                                        <div class="text-right">
                                            <a href="<?= base_url() . "hrd/employment/show/" . $this->uri->segment(3) ?>" class="btn btn-success">Perbaharui Status</a>
                                        </div>
                                    <?php elseif ($status_update !== NULL And in_array(51, $this->session->userdata('position'))) : ?>
                                        <div class="mb-3">
                                            <p class=""><span class="badge badge-warning text-dark" style="font-size: 14px">Status diubah oleh</span><?= " " . $status_update->assessor_name ?></p>
                                            <p class="font-weight-bold"><?= $status_update->status_name . ' ' . $status_update->active_name ?></p>
                                        </div>
                                        <div class="text-right">
                                            <form action="<?= base_url() . "hrd/employment/approve_status" ?>" method="post">
                                                <input type="hidden" name="employee_id" value="<?= $this->uri->segment(3) ?>">
                                                <input type="hidden" name="status" value="<?= $status_update->status ?>">
                                                <input type="hidden" name="active_status" value="<?= $status_update->active_status ?>">
                                                <input type="hidden" name="effective_date" value="<?= $status_update->effective_date ?>">
                                                <button class="btn btn-info">Approve Perubahan Status</button>
                                            </form>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php endif ?>

                            <?php if ($approval->manager === NULL Or $approval->director === NULL) : ?>

                                <?php if ($approval->manager !== NULL ) : ?>
                                    <hr class="border-primary">
                                <?php endif ?>

                                <form action="<?= base_url() ?>promotion/update" method="post">
                                    <input type="hidden" name="employee_id" value="<?= $this->uri->segment(3) ?>">
                                    <div class="radio align-items-center">
                                        <div class="form-check mt-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text rounded mr-2" style="padding: 15px;">
                                                        <input class="form-check" type="radio" name="promotion" value="Tetap">
                                                    </div>
                                                </div>
                                                <label class="form-check-label align-self-center">Diangkat Menjadi Pegawai Tetap</label>
                                            </div>
                                            <input type="text" class="description form-control mt-2" style="display: none;" placeholder="Keterangan">
                                        </div>
                                        <div class="form-check mt-2">
                                            <div class="d-flex">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text rounded mr-2" style="padding: 15px;">
                                                            <input class="form-check" type="radio" name="promotion" value="Kontrak">
                                                        </div>
                                                    </div>
                                                    <div class="d-inline-flex align-items-center">
                                                        <label class="form-check-label mr-3">Kontrak Diperpanjang</label>
                                                        <div id="duration" style="display: none;">
                                                            <select name="duration" class="form-control align-self-center">
                                                                <option value="+ 6 months">6 Bulan</option>
                                                                <option value="+ 12 months">12 Bulan</option>
                                                                <option value="+ 24 months">24 Bulan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" class="description form-control mt-2" style="display: none;" placeholder="Keterangan">
                                        </div>
                                        <div class="form-check mt-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text rounded mr-2" style="padding: 15px;">
                                                        <input class="form-check" type="radio" name="promotion" value="None">
                                                    </div>
                                                </div>
                                                <label class="form-check-label align-self-center">Tidak Diangkat dan Tidak Diperpanjang</label>
                                            </div>
                                            <input type="text" class="description form-control mt-2" style="display: none;" placeholder="Keterangan">
                                        </div>
                                    </div>
                                    <div class="text-right mt-3">
                                        <button class="btn btn-primary">Kirim</button>
                                    </div>
                                </form>
                            <?php endif ?>
                        <?php endif ?>
                        </div>
                </div>
            </div>
        </div>
    </div>