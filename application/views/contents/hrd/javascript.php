<!-- Sparkline -->
<!-- <script src="<?php echo base_url() ?>assets/admin/plugins/sparklines/sparkline.js"></script> -->
<!-- JQVMap -->
<!-- <script src="<?php echo base_url() ?>assets/admin/plugins/jqvmap/jquery.vmap.min.js"></script> -->
<!-- <script src="<?php echo base_url() ?>assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/dist/js/pages/dashboard.js"></script>

<script>
	$(document).ready(function(){
		var nomorRegistrasiChartData = {
			labels  : [''],
			datasets: [
				{
					label               : 'Nomor Induk Dosen Nasional',
					backgroundColor     : 'rgba(124,181,236,0.9)',
					borderColor         : 'rgba(124,181,236,0.9)',
					pointRadius          : false,
					pointColor          : '#3b8bba',
					pointStrokeColor    : 'rgba(60,141,188,1)',
					pointHighlightFill  : '#fff',
					pointHighlightStroke: 'rgba(60,141,188,1)',
					data                : [
							<?= $this->db->select('ep.employee_id')->from('employee_pt as ep')
                              ->where('ep.nidn is not null', null)
                              ->where('ep.group_id', 2)
                              ->get()->num_rows();
                              ?>
					]
				},
			]
		}

		var jabatanFungsionalChartData = {
			labels  : [''],
			datasets: [
				<?php 
				$backgroundColor = array(
					'rgba(153,123,222,0.9)',
					'rgba(124,181,236,0.9)',
					'rgba(67,67,72,0.9)',
					'rgba(144,237,125,0.9)',
					'rgba(210, 214, 222, 1)'
				);

				$index = 0;

				foreach ($functional->result() as $funct): ?>
					{
						label               : '<?= $funct->position ?>',
						backgroundColor     : '<?= $backgroundColor[$index] ?>',
						borderColor         : '<?= $backgroundColor[$index] ?>',
						pointRadius          : false,
						pointColor          : '#3b8bba',
						pointStrokeColor    : 'rgba(60,141,188,1)',
						pointHighlightFill  : '#fff',
						pointHighlightStroke: 'rgba(60,141,188,1)',
						data                : [<?= $funct->total ?>]
					},					
				<?php $index++; endforeach ?>
			]
		}

		var jenjangPendidikanChartData = {
			labels  : [''],
			datasets: [

				<?php 
				$backgroundColor = array(
					'rgba(153,123,222,0.9)',
					'rgba(124,181,236,0.9)',
					'rgba(67,67,72,0.9)',
					'rgba(144,237,125,0.9)',
					'rgba(210, 214, 222, 1)',
					'rgba(122, 153, 223, 1)'
				);
				$index = 0;

				foreach ($lecture_education->result() as $edu): 
					if ($edu->latest_education != '') :
				?>
					{
						label               : '<?= $edu->latest_education ?>',
						backgroundColor     : '<?= $backgroundColor[$index] ?>',
						borderColor         : '<?= $backgroundColor[$index] ?>',
						pointRadius          : false,
						pointColor          : '#3b8bba',
						pointStrokeColor    : 'rgba(60,141,188,1)',
						pointHighlightFill  : '#fff',
						pointHighlightStroke: 'rgba(60,141,188,1)',
						data                : [<?= $edu->total ?>]
					},
				<?php $index++; endif; endforeach; ?>
			]
		}

		var areaChartOptions = {
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

		var nomorRegistrasiChartCanvas = $('#nomorRegistrasiChart').get(0).getContext('2d')
	    var nomorRegistrasiChartData = jQuery.extend(true, {}, nomorRegistrasiChartData)

		var jabatanFungsionalChartCanvas = $('#jabatanFungsionalChart').get(0).getContext('2d')
	    var jabatanFungsionalChartData = jQuery.extend(true, {}, jabatanFungsionalChartData)

		var jenjangPendidikanChartCanvas = $('#jenjangPendidikanChart').get(0).getContext('2d')
	    var jenjangPendidikanChartData = jQuery.extend(true, {}, jenjangPendidikanChartData)

	    var barChartOptions = {
	      responsive              : true,
	      maintainAspectRatio     : false,
	      datasetFill             : false
	    }

	    var barChart = new Chart(nomorRegistrasiChartCanvas, {
	      type: 'bar', 
	      data: nomorRegistrasiChartData,
	      options: barChartOptions
	    })

	    var barChart = new Chart(jabatanFungsionalChartCanvas, {
	      type: 'bar', 
	      data: jabatanFungsionalChartData,
	      options: barChartOptions
	    })

	    var barChart = new Chart(jenjangPendidikanChartCanvas, {
	      type: 'bar', 
	      data: jenjangPendidikanChartData,
	      options: barChartOptions
	    })
	});
</script>
