<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  function random_rgba() {
      var o = Math.round, r = Math.random, s = 255;
      return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
  }

  $(function () {
    <?php if ($this->uri->segment(3) == 'overtime') : ?>
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
            url: "<?php echo base_url() ?>hrd/report/ajaxAnnualEmpOvertimeReport",
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
            url: "<?php echo base_url() ?>hrd/report/ajaxAnnualOrgOvertimeReport",
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

    $("#table").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  $('.create-data').on('click', function () {
      $('#modal-add-data').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.delete-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menghapus data ini?');
    return c;
  });
</script>