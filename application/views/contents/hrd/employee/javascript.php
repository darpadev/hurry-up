<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $(document).ready(function(){
      var counter = 0;

      $("#addrow").on("click", function () {
          var newRow = $("<p>");
          var cols = "";

          cols += '<div class="input-group"> <div class="col-md-3"> <select class="form-control" name="educations[]" required> <option value=""> -- Pilih Pendidikan -- </option> <option value="SMA/SMK/MA">SMA/SMK/MA</option> <option value="Diploma Satu (D1)">Diploma Satu (D1)</option> <option value="Diploma Dua (D2)">Diploma Dua (D2)</option> <option value="Diploma Tiga (D3)">Diploma Tiga (D3)</option> <option value="Diploma Empat (D4)">Diploma Empat (D4)</option> <option value="Sarjana (S1)">Sarjana (S1)</option> <option value="Master (S2)">Master (S2)</option> <option value="Doktor (S3)">Doktor (S3)</option> </select> </div><div class="col-md-4"> <input type="text" name="institutions[]" class="form-control"> </div><div class="col-md-3"> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="far fa-calendar-alt"></i></span> </div> <input type="text" class="form-control datepicker" name="graduates[]"> </div> </div><div class="col-md-2"> <div class="input-group-prepend"> <span class="input-group-text"> <input type="button" class="ibtnDel btn btn-xs btn-danger" value="Hapus"> </span> </div> </div> </div> <script>$(".datepicker").daterangepicker({ locale:{ format:"DD-MM-YYYY" }, singleDatePicker: true, showDropdowns: true, minYear: 2016 }); $(document).ready(function() { $("select").select2({ theme: "bootstrap4" }); });<' + '/' + 'script>';

          newRow.append(cols);
          $("#add-education").append(newRow);
          counter++;
      });

      $("#add-education").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter -= 1
      });

      var counter_position = 0;

      $("#addrow-position").on("click", function () {
          var newRow = $("<p>");
          var cols = "";
          var date = new Date();
          var day = date.getDate();
          var month = date.getMonth() + 1;
          var year = date.getFullYear();

          if (month < 10) month = "0" + month;
          if (day < 10) day = "0" + day;

          var today = day + "-" + month + "-" + year;

          <?php if (isset($positions)) { ?>

          cols += '<div class="form-group"><div class="input-group"><div class="col-md-4"><select class="form-control" name="employee_id[]" required><option value=""> -- Pilih Pegawai -- </option><?php foreach ($this->db->select('ep.employee_id, e.name, ep.nip')->from('employee_pt as ep')->join('employees as e', 'e.id = ep.employee_id')->where('ep.status', 1)->order_by('ep.nip', 'ASC')->get()->result() as $value): ?><option value="<?php echo $value->employee_id ?>"><?php echo $value->nip.' - '.$value->name ?></option><?php endforeach ?></select>&nbsp;</div> <div class="col-md-4"> <select class="form-control" name="position_id[]" required> <option value=""> -- Pilih Jabatan -- </option> <?php foreach ($positions->result() as $value): ?> <option value="<?php echo $value->id ?>"><?php echo $value->position ?></option> <?php endforeach ?> </select> &nbsp; </div> <div class="col-md-2"> <div class="input-group"><div class="input-group-prepend"> <span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div><input type="text" class="form-control datepicker" name="start_date[]" value="'+today+'" required> </div> </div><div class="col-md-2"><div class="input-group-prepend"><span class="input-group-text"><input type="button" class="ibtnDel btn btn-xs btn-danger" value="Hapus"></span></div></div></div></div> <script>$(".datepicker").daterangepicker({ locale:{ format:"DD-MM-YYYY" }, singleDatePicker: true, showDropdowns: true, minYear: 2016 }); $(document).ready(function() { $("select").select2({ theme: "bootstrap4" }); });<' + '/' + 'script>';
          <?php } ?>

          newRow.append(cols);
          $("#add-pegawai").append(newRow);
          counter_position++;
      });

      $("#add-pegawai").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter_position -= 1
      });
    }
  );

  $("#position_id").chained("#departement_id");

  $("#city_id").chained("#province_id");
  $("#district_id").chained("#city_id");

  $('select').select2({
      theme: 'bootstrap4'
    });

  $(function () {
    $("#table").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  $('.create-data').on('click', function () {
      $('#modal-add-data').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.update-position').on('click', function () {
      $('#modal-update-position').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.reset-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda ingin setel ulang kata sandi?');
    return c;
  });

  $('.delete-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menghapus data ini?');
    return c;
  });
</script>