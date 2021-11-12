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
    $(".table").DataTable({
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

  // Usage  : Modal - Create New Employee
  const input_status        = $(':input[name="status"]');
  const input_act_status    = $(':input[name="active_status"]');
  const input_eff_date      = $(':input[name="effective_date"]');
  const status_duration     = $(':input[name="contract_duration"]');
  const range_duration      = $(':input[name="range_duration"]');
  const reset_contract_duration_option = `
    <option value="" disabled selected> -- Pilih Durasi Kontrak -- </option>
    <option value="6 Bulan">6 Bulan</option>
    <option value="1 Tahun">1 Tahun</option>
    <option value="2 Tahun">2 Tahun</option>
    <option value="By Calendar">By Calendar</option>
  `;
  const reset_range_duration_option = `
    <option value="" disabled selected> -- Pilih Durasi -- </option>
    <option value="3 Tahun">3 Tahun</option>
    <option value="4 Tahun">4 Tahun</option>
    <option value="By Calendar">By Calendar</option>
  `;
  
  let reset_active_status_option = '';

  $(':input[name="active_status"] option').each(function(index, element){
    if(index == 0){
      reset_active_status_option += `<option value="${element.value}" disabled selected>${element.text}</option>`;
    }else{
      reset_active_status_option += `<option value="${element.value}">${element.text}</option>`;
    }
  })

  // Check if status has changed
  input_status.change(function(){
    
    if(input_status.val() != 3){
      $(':input[name="active_status"]').html(reset_active_status_option);
      $(':input[name="active_status"]').prop('disabled', false);
    }else{
      $(':input[name="active_status"]').prop('disabled', true);
      $(':input[name="active_status"]').html(
        '<option value="" disabled selected> -- Tidak Tersedia -- </option>'
      );
    }

    if(input_status.val() == 2){
      $('#effective_date').html('Akhir Masa Kontrak');
      $('#contract_duration').show();
    }else{
      $('#effective_date').html('Efektif per Tanggal');
      $(':input[name="contract_duration"]').html(reset_contract_duration_option)
      $('#contract_duration').hide();
    }

    // Clear effective date field
    input_eff_date.val("");
    input_eff_date.prop('disabled', false);
    input_eff_date.prop('readonly', false);
  });

  input_act_status.change(function(){
    // Clear effective date field
    input_eff_date.val("");
    input_eff_date.prop('disabled', false);
    input_eff_date.prop('readonly', false);

    if(input_act_status.val() == 3){
      $('#range_duration').show();
    }else{
      $('#range_duration').hide();
      range_duration.html(reset_range_duration_option);
    }

    if (input_status.val() != 3){
      if(input_act_status.val() == 1){
        if (input_status.val() != 2){
          $('#effective_date').html('Efektif per Tanggal');
        }
      }else{
        $('#effective_date').html('Berlaku sampai dengan');
      }
    }
  });

  // Check if contract duration is changed
  status_duration.change(function(){
    input_eff_date.val("");
    input_eff_date.prop('readonly', false);

    if(status_duration.val() != 'By Calendar'){
      input_eff_date.prop('readonly', true);

      const new_date = $(':input[name="join_date"]').val().split('-');
      let calc_date = new Date(new_date[0], new_date[1], new_date[2]);

      if(status_duration.val() == '6 Bulan'){
        calc_date.setMonth(calc_date.getMonth() + 6);
      }else if(status_duration.val() == '1 Tahun'){
        calc_date.setFullYear(calc_date.getFullYear() + 1);
      }else if(status_duration.val() == '2 Tahun'){
        calc_date.setFullYear(calc_date.getFullYear() + 2);  
      }

      let month = '' + calc_date.getMonth();
      let day = '' + calc_date.getDate();

      if(month.length < 2){
        month = '0' + month;
      }

      if(day.length < 2){
        day = '0' + day;
      }

      const parseDate = calc_date.getFullYear() + '-' + month + '-' + day;

      input_eff_date.val(parseDate);
    }
  });

  // Check if range duration is changed
  range_duration.change(function(){
    input_eff_date.val("");
    input_eff_date.prop('readonly', false);

    if(range_duration.val() != 'By Calendar'){
      input_eff_date.prop('readonly', true);

      const new_date = $(':input[name="join_date"]').val().split('-');
      let calc_date = new Date(new_date[0], new_date[1], new_date[2]);

      if(range_duration.val() == '3 Tahun'){
        calc_date.setFullYear(calc_date.getFullYear() + 3);
      }else if(range_duration.val() == '4 Tahun'){
        calc_date.setFullYear(calc_date.getFullYear() + 4);  
      }

      let month = '' + calc_date.getMonth();
      let day = '' + calc_date.getDate();

      if(month.length < 2){
        month = '0' + month;
      }

      if(day.length < 2){
        day = '0' + day;
      }

      const parseDate = calc_date.getFullYear() + '-' + month + '-' + day;

      input_eff_date.val(parseDate);
    }
  });
</script>