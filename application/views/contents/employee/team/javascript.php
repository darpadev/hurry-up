<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  function random_rgba() {
      var o = Math.round, r = Math.random, s = 255;
      return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
  }
  
  $(document).ready(function(){
    $("#table").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  <?php if ($this->uri->segment(3) == 'overtime'): ?>
  $(document).ready(function(){
    <?php if (isset($emp_report)) : ?>
      var empBarChartData = {
        labels  : <?= json_encode($emp_report) ?>,
        datasets: [
          {
            label               : 'Jumlah Lembur',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            // pointRadius          : false,
            // pointColor          : '#3b8bba',
            // pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : <?= json_encode($sum_emp_report) ?>
          },
        ]
      }

      var orgBarChartData = {
        labels  : <?= json_encode($org_report) ?>,
        datasets: [
          {
            label               : 'Jumlah Lembur',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            // pointRadius          : false,
            // pointColor          : '#3b8bba',
            // pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : <?= json_encode($sum_org_report) ?>
          },
        ]
      }
      
      var empChartCanvas = $('#memberChart').get(0).getContext('2d')
      var orgChartCanvas = $('#orgChart').get(0).getContext('2d')
      var empChartData = jQuery.extend(true, {}, empBarChartData)
      var orgChartData = jQuery.extend(true, {}, orgBarChartData)
      var tempEmp = empBarChartData.datasets[0]
      var tempOrg = orgBarChartData.datasets[0]
      empChartData.datasets[0] = tempEmp
      orgChartData.datasets[0] = tempOrg

      var allChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines : {
              display : false,
            }
          }],
          yAxes: [{
            gridLines : {
              display : false,
            }
          }]
        }
      }

      var chartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
      }

      var empChart = new Chart(empChartCanvas, {
        type: 'bar', 
        data: empChartData,
        options: chartOptions
      })

      var orgChart = new Chart(orgChartCanvas, {
        type: 'bar', 
        data: orgChartData,
        options: chartOptions
      })

      var data = {year: '<?= date('Y') ?>'}
      annualEmpOvertimeReport(data)
      annualOrgOvertimeReport(data)

      function annualEmpOvertimeReport(data)
      {
        $.ajax({
            type: 'GET',
            url: "<?php echo base_url() ?>employee/team/ajaxAnnualEmpOvertimeReport",
            data: data,
            success: function(data) {
              var value = JSON.parse(data);
              var datasets = [];

              for (var i = 0; i < value[0].label.length; i++) {
                var color = random_rgba();

                var result = Object.keys(value[1][i]).map((key) => value[1][i][key]);

                datasets.push({
                  label               : value[0].label[i],
                  backgroundColor     : color,
                  borderColor         : color,
                  data                : result
                });
              }

              console.log(datasets);

              var empLineChartData = {
                labels  : ['Januari', 'Februari', 'Maret' , 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],                
                datasets: datasets
              }            

              var lineEmpChartCanvas = $('#annualMemberChart').get(0).getContext('2d')
              var lineEmpChartOptions = jQuery.extend(true, {}, allChartOptions)
              var lineEmpChartData = jQuery.extend(true, {}, empLineChartData)

              for (var i = 0; i < value[0].label.length; i++) {
                lineEmpChartData.datasets[i].fill = false;
              }

              var empAnnualChart = new Chart(lineEmpChartCanvas, {
                type: 'line', 
                data: lineEmpChartData,
                options: chartOptions
              })
            }
        });
      }
      
      function annualOrgOvertimeReport(data)
      {
        $.ajax({
            type: 'GET',
            url: "<?php echo base_url() ?>employee/team/ajaxAnnualOrgOvertimeReport",
            data: data,
            success: function(data) {
              var value = JSON.parse(data);
              console.log(value);
              var datasets = [];

              for (var i = 0; i < value[0].label.length; i++) {
                var color = random_rgba();

                var result = Object.keys(value[1][i]).map((key) => value[1][i][key]);

                datasets.push({
                  label               : value[0].label[i],
                  backgroundColor     : color,
                  borderColor         : color,
                  data                : result
                });
              }

              console.log(datasets);

              var empLineChartData = {
                labels  : ['Januari', 'Februari', 'Maret' , 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],                
                datasets: datasets
              }            

              var lineEmpChartCanvas = $('#annualOrgChart').get(0).getContext('2d')
              var lineEmpChartOptions = jQuery.extend(true, {}, allChartOptions)
              var lineEmpChartData = jQuery.extend(true, {}, empLineChartData)

              for (var i = 0; i < value[0].label.length; i++) {
                lineEmpChartData.datasets[i].fill = false;
              }

              var empAnnualChart = new Chart(lineEmpChartCanvas, {
                type: 'line', 
                data: lineEmpChartData,
                options: chartOptions
              })
            }
        });
      }

      $('#annualEmp').change(function(){
        empYear = $('#annualEmp option:selected').val();

        var data = {year: empYear}        
        annualEmpOvertimeReport(data)
      });

      $('#annualOrg').change(function(){
        orgYear = $('#annualOrg option:selected').val();

        var data = {year: orgYear}        
        annualOrgOvertimeReport(data)
      });
    <?php endif ?>

    var counter = 0;

    $("#addrow").on("click", function (e) {
      e.preventDefault();
        var newRow = $("<p>");
        var cols = "";

        cols += '<div class="input-group"><select class="form-control" name="employee_id[]" required><option value=""> -- Pilih Pegawai -- </option><?php foreach ($employee->result() as $emp): ?> <option value="<?php echo $emp->employee_id ?>"><?php echo $emp->nip." - ".$emp->name ?></option> <?php endforeach ?></select><div class="input-group-prepend"><span class="input-group-text"><input type="button" class="ibtnDel btn btn-xs btn-danger" value="Hapus"></span></div></div>';

        newRow.append(cols);
        $("#assign-overtime").append(newRow);
        counter++;
    });

    $("#assign-overtime").on("click", ".ibtnDel", function (event) {
        $(this).closest("p").remove();       
        counter -= 1
    });
  });
  <?php endif ?>
  
  // add criteria specific
  <?php if ($this->uri->segment(3) == 'create_criteria') : ?>
  <?php $period = $this->db->select('year')->from('performance_appraisal_calendar')->group_by('year')->order_by('year', 'DESC')->get()->result(); ?>
  $(document).ready(function(){
    $('#employee_id').change(function(){      
      var employee_id = $('#employee_id option:selected').val();
      $('#employee_id2').val(employee_id);
    });

    var employee_id = $('#employee_id option:selected').val();
    $('#employee_id2').val(employee_id);

      var counter_employee = 0;

      $("#add-employee-criteria").on("click", function (e) {
        e.preventDefault();
          var newRowEmployee = $("<p>");
          var colsEmployee = "";

          colsEmployee += ' <?php $period = $this->db->select('year')->from('performance_appraisal_calendar')->group_by('year')->order_by('year', 'DESC')->get()->result(); ?> <div class="col-md-12 col-lg-12"> <div class="card"> <div class="card-header"> <div class="row"> <div class="col-md-1"> <label>Pegawai</label> </div> <div class="col-md-10"> <select name="employee[]" class="form-control" required> <?php foreach ($subordinates as $value): ?> <option value="<?php echo $value->employee_id ?>"><?php echo $value->nip.' - '.$value->name ?></option> <?php endforeach ?> </select> </div> <div class="col-md-1"> <a href="javascript:void(0)" class="btn btn-secondary ibtnDel"><span class="fa fa-times"></span> &nbsp;Batal</a> </div> </div> </div> <div class="card-header"> <div style="float: left;"> <button type="button" class="btn btn-success add-row"><span class="fa fa-calendar"></span> &nbsp;Tambah</button> <button type="button" class="btn btn-danger delete-row delete-confirmation"><span class="fa fa-trash"></span> &nbsp;Hapus</button> </div> <div style="float: right;"> <input type="hidden" name="period_to" value="<?= $year ?>"> <select class="copy-period" name="period_from" id="non-select2" required> <?php foreach ($period as $value): ?> <option <?php echo (isset($year) && $year == $value->year) ? 'selected': ''; ?> value="<?php echo $value->year ?>"><?php echo $value->year ?></option> <?php endforeach ?> </select> <button type="submit" class="btn btn-info copy-confirmation"><span class="fa fa-copy"></span> &nbsp;Salin KRA</button> </div> </div> <div class="card-body"> <table id="" class="table table-bordered table-striped"> <thead> <tr> <th style="width: 5%" class="center"><input type="checkbox" id="checkAll"></th> <th class="center" style="width: 20%">KRA</th> <th class="center">KPI</th> <th class="center">Kriteria Penliaian</th> </tr> </thead> <tbody> </tbody> </table> </div> </div> </div> ';

          newRowEmployee.append(colsEmployee);
          $("#employee").append(colsEmployee);
          counter_employee++;
      });

      $("#employee").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter_specific -= 1
      });
    });
  <?php endif ?>

  // adjust criteria specific
  $(document).ready(function(){
    <?php if (isset($year)) { ?>      
      $(".add-row").click(function(){
          var markup = '<tr> <td class="center"><input type="checkbox" name="id[]"><input type="hidden" name="year" value="<?= $year ?>"></td> <td> <input type="text" name="kra[]" class="form-control" required> </td> <td> <input type="text" class="form-control" name="kpi[]" required> </td> <td> <textarea class="form-control" name="criteria[]" rows="10" required></textarea> </td> </tr>';
          $("table tbody").append(markup);
      });

      // Find and remove selected table rows
      $(".delete-row").click(function(){
          $("table tbody").find('input[name="id[]"]').each(function(){
            if($(this).is(":checked")){
                  $(this).parents("tr").remove();
              }
          });
      });
    <?php } ?>

    // Check/Uncheck ALl
    $('#checkAll').change(function(){
      if($(this).is(':checked')){
        $('input[name="id[]"]').prop('checked',true);
      }else{
        $('input[name="id[]"]').each(function(){
           $(this).prop('checked',false);
        });
      }
    });
  });

  // Checkbox click
  $('input[name="id[]"]').click(function(){
    var total_checkboxes = $('input[name="id[]"]').length;
    var total_checkboxes_checked = $('input[name="id[]"]:checked').length;

    if(total_checkboxes_checked == total_checkboxes){
       $('#checkAll').prop('checked',true);
    }else{
       $('#checkAll').prop('checked',false);
    }
  });

  $('.create-data').on('click', function () {
      $('#modal-add-data').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.delete-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menghapus data ini?');
    return c;
  });

  $('.cancel-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin membatalkan data ini?');
    return c;
  });

  $('.copy-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menyalin KRA periode ini?');
    return c;
  });

  $('.save-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menyimpan data ini?');
    return c;
  });

  $('.publish-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin mempublikasikan data ini?');
    return c;
  });

  $('.approve-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menyetujui data ini?');
    return c;
  });

  $('.reject-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menolak data ini?');
    return c;
  });
</script>