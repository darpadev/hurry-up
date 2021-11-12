<div class="row">
  <div class="col-md-7">
    <div class="">
      <div class="">
        <div style="padding-left: 10%; padding-right: 0%">
          
        <div class="form-group row">
          <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">NIP</label>
          <div class="col-sm-8">
            <label class="form-control">
              <?php echo $data->nip ?>
            </label>
          </div>
        </div>
        <div class="form-group row">
          <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Nama</label>
          <div class="col-sm-8">
            <label class="form-control">
              <?php echo $data->name ?>
            </label>
          </div>
        </div>
        <div class="form-group row">
          <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Organisasi</label>
          <div class="col-sm-8">
            <?php 
            $CI =& get_instance();
            $CI->load->model('employees');
            $orgs = $CI->employees->showEmployeeOrgUnit($data->employee_id); 
            foreach ($orgs->result() as $org): ?>
              <label class="form-control">
              <?= $org->org_unit ?>
              </label>
            <?php endforeach ?>
          </div>
        </div>
        <div class="form-group row">
          <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Jabatan</label>
          <div class="col-sm-8">
            <?php 
            foreach ($orgs->result() as $org): ?>
              <label class="form-control">
              <?= $org->position ?>
              </label>
            <?php endforeach ?>
          </div>
        </div>
        <div class="form-group row">
          <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Level</label>
          <div class="col-sm-8">
            <label class="form-control">
              <?php echo $data->bracket ?>
            </label>
          </div>
        </div>
        <div class="form-group row">
          <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Gaji Pokok</label>
          <div class="col-sm-8">
            <label class="form-control">
              <?php echo 'Rp. '.number_format($data->basic_salary) ?>
            </label>
          </div>
        </div>
        <div class="form-group row">
          <label style="font-weight: 400" for="inputName" class="col-sm-4 col-form-label">Upah per jam</label>
          <div class="col-sm-8">
            <label class="form-control">
              <?php echo 'Rp. '.number_format($data->basic_salary / 173) ?>
            </label>
          </div>
        </div>

        </div>
      </div>
    </div>
  </div>

  <div class="col-md-5">    
    <div class="card card-warning">
      <div class="card-header">
        <strong>Perhitungan Insentif Lembur:</strong>
      </div>

      <div class="card-body">
        Formula Perhitungan:
        <ul>
          <li>Upah per jam = Gaji Pokok * 1/173</li>
        </ul>
        Hari Kerja:
        <ul>
          <li>Jam pertama = 1,5x upah per jam</li>
          <li>Jam kedua dst. = 2x upah per jam</li>
        </ul>
        Hari Libur/Tanggal Merah:
        <ul>
          <li>Jam pertama s/d ketujuh = 2x upah per jam</li>
          <li>Jam kedelapan = 3x upah per jam</li>
          <li>Jam kesembilan dst. = 4x upah per jam</li>
        </ul>
        Maksimal jam lembur setiap bulan adalah 40 jam, apabila melebihi diharuskan membuat justifikasi dengan maksimal 60 jam.
      </div>
    </div>
  </div>
</div>

<?php if (isset($_GET['period'])): ?>
<div class="row">
  <div class="col-md-12">
  <div class="card">
        <div class="card-header">
          <h4>Detail Pekerjaan Lembur</h4>
        </div>

        <div class="card-body">     
          <table id="" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width: 5%" class="center">No</th>
              <th class="center">No. Penugasan</th>
              <th class="center">Kegiatan</th>
              <th class="center">Tanggal</th>
              <th class="center">Durasi Sebenarnya</th>
              <th class="center">Durasi Diterima</th>
              <th class="center">Jumlah Insentif</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1;
            $total_incentive = 0;
            foreach ($overtime->result() as $value) {              
            ?>
            <tr style="<?php echo ($value->day_type == 1) ? 'background: #f37272;' : ''; ?>">
              <td class="center"><?php echo $no++ ?></td>
              <td class="center"><?php echo $value->no_assignment ?></td>
              <td><?php echo $value->description ?></td>
              <td class="center"><?php echo date('j F Y', strtotime($value->overtime_date)) ?></td>
              <td class="center"><?php echo $value->actual_duration ?></td>
              <td class="center"><?php echo $value->paid_hours ?></td>
              <td><?php echo 'Rp. '.number_format($value->paid_overtime) ?></td>
            </tr>
            <?php 
            $total_incentive = $total_incentive + $value->paid_overtime;
            }
            ?>
          </tbody>    

          <tfoot>
            <td colspan="6" style="text-align: right;"><strong>Total Insentif</strong></td>
            <td><strong><?php echo 'Rp. '.number_format($total_incentive) ?></strong></td>
          </tfoot>
          </table>    
        </div>

        <div class="card-footer">          
            <a style="float: right;" href="<?php echo base_url() ?>hrd/overtime/incentive?period=<?php echo $_GET['period'].'&employee='.$_GET['employee'].'&org_unit='.$_GET['org_unit'] ?>" class="btn btn-primary">Kembali</a>
        </div>
      </div> 
    </div> 
</div>
<?php endif ?>