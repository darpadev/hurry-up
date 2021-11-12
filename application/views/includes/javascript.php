<script src="<?php echo base_url() ?>assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url() ?>assets/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url() ?>assets/admin/plugins/chart.js/Chart.min.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url() ?>assets/admin/plugins/select2/js/select2.full.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() ?>assets/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url() ?>assets/admin/plugins/moment-adminlte/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url() ?>assets/admin/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url() ?>assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>assets/admin/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>assets/admin/dist/js/demo.js"></script>
<script src="<?php echo base_url();?>assets/js/selectize.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/admin/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script> -->

<script src="<?php echo base_url() ?>assets/orgchart/js/jquery.orgchart.js"></script>

<?php if ($javascript) {
	$this->load->view($javascript);
} ?>

<script>
	function getDataEmployee(employee_id){
	$('#organization').hide();
	$('#modal-detail-employee').modal({backdrop: 'static', keyboard: false});

	$.ajax({
	  type: 'GET',
	  url: "<?php echo base_url(); ?>/employee/home/getDetailEmployee",
	  data: {employee_id : employee_id},
	  cache: false,
	  success: function(data) {
	    var value = JSON.parse(data);

	    var detail = value.employee;
	    var supervisor = value.supervisor;
	    var org_unit = value.org_unit;

	    // reset        
	    $('#name').val('');
	    $('#nip').val('');
	    $('#email').val('');
	    $('#extension').val('');

	    $("#supervisor").html('');
	    $("#position").html('');
	    $("#org_unit").html('');

	    // add
	    $('#name').val(detail.name);
	    $('#nip').val(detail.nip);
	    $('#email').val(detail.email);
	    $('#extension').val(detail.extension);

	    for (let i = 0; i < supervisor.length; i++) {
	      var newSupervisor = '<input type="text" class="form-control" style="background: transparent; border: none; color: #007bff" readonly onclick="getDataEmployee('+ supervisor[i].id +')" value="' + supervisor[i].name + '">';
	      $("#supervisor").append(newSupervisor);
	    }

	    if (org_unit.length >= 1) {
	      for (let j = 0; j < org_unit.length; j++) {
	        var newPosition = '<input type="text" class="form-control" style="background: transparent; border: none;" readonly value="' + org_unit[j].position + '">';
	        var newOrgUnit = '<input type="text" class="form-control" style="background: transparent; border: none; color: #007bff" readonly onclick="getDataOrgChart(' + org_unit[j].position_id + ',' + detail.employee_id + ')" value="' + org_unit[j].org_unit + '">';
	        $("#position").append(newPosition);
	        $("#org_unit").append(newOrgUnit);
	      }
	    }
	  }
	});
	};

	function getDataOrgChart(position, employee){
		$.ajax({
		  type: 'GET',
		  url: "<?php echo base_url(); ?>/employee/home/getDataOrgChart",
		  data: {position : position, employee : employee},
		  cache: false,
		  success: function(data) {		  	
			var ee = [];
		    var value = JSON.parse(data);
		  	// console.log(value);
		  	$('#organization').empty();
		    $('#organization').fadeOut();
		    $('#organization').fadeIn();
		    
		    for (let i = 0; i < value.subordinate.length; i++) {
				var sub = {};
		    	sub.name = value.subordinate[i].name;
		    	sub.title = value.subordinate[i].position;
		    	ee.push(sub);
		    }

		    var cok = {
			  'name': value.parent.name,
			  'title': value.parent.position,
			  'children': [
			    { 'name': value.employee.name, 'title': value.employee.position,
			      'children': ee, 
			    },
			    // { 'name': 'Su Miao', 'title': 'department manager',
			    //   'children': [
			    //     { 'name': 'Pang Pang', 'title': 'senior engineer' },
			    //     { 'name': 'Hei Hei', 'title': 'senior engineer', 'collapsed': true,
			    //       'children': [
			    //         { 'name': 'Xiang Xiang', 'title': 'UE engineer', 'className': 'slide-up' },
			    //         { 'name': 'Dan Dan', 'title': 'engineer', 'className': 'slide-up' },
			    //         { 'name': 'Zai Zai', 'title': 'engineer', 'className': 'slide-up' }
			    //       ]
			    //     }
			    //   ]
			    // }
			  ]
			};

		    var datascource = data;

		    $('#organization').orgchart({
		      'data' : cok,
		      'nodeContent': 'title'
		    });
		  }
		});
	};

	$(document).ready(function() {
		// $('select').selectize({});
		$('select').select2({ theme: 'bootstrap4' });

		$('.phonebook').select2({
			placeholder: 'Cari Buku Telepon',
			allowClear: true
		});

		$("#non-select2").select2('destroy');
		
		function clock() {
			var now = new Date().toLocaleString("en-US", {timeZone: 'Asia/Jakarta'});
			var month = new Array();
			month[0] = "Januari";
			month[1] = "Februari";
			month[2] = "Maret";
			month[3] = "April";
			month[4] = "Mei";
			month[5] = "Juni";
			month[6] = "Juli";
			month[7] = "Agustus";
			month[8] = "September";
			month[9] = "Oktober";
			month[10] = "November";
			month[11] = "Desember";
			now = new Date(now);
			var date = now.getDate();
			var month2 = month[now.getMonth()];
			var year = now.getFullYear();
			var secs = ('0' + now.getSeconds().toLocaleString()).slice(-2);
			var mins = ('0' + now.getMinutes().toLocaleString()).slice(-2);
			var hr = now.getHours().toLocaleString();
			// var Time = date + " " + month2 + " " + year + " <b>|</b> " + hr + ":" + mins + ":" + secs;
			var Time = hr + ":" + mins + ":" + secs;
			document.getElementById("watch").innerHTML = Time;
			requestAnimationFrame(clock);
	    }

	    requestAnimationFrame(clock);

		$('#timepicker').datetimepicker({
	      format: 'HH:mm'
	    })

		$('#timepicker2').datetimepicker({
	      format: 'HH:mm'
	    })
	});

	$('#range-lembur').daterangepicker({
		locale:{ format:'D MMMM YYYY' },
		autoUpdateInput: true,
		autoApply: true,
	    showDropdowns: true,
	    minYear: 1901
	});

	$('#create-cuti').daterangepicker({
		locale:{ format:'D MMMM YYYY' },
		autoUpdateInput: true,
		autoApply: true,
	    showDropdowns: true,
	    minYear: 1901
	});

	$('#range-cuti').daterangepicker({
		locale:{ format:'D MMMM YYYY' },
		autoUpdateInput: true,
		autoApply: true,
	    showDropdowns: true,
	    minYear: 1901
	});

	$('#range-cuti').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('D MMMM YYYY') + ' - ' + picker.endDate.format('D MMMM YYYY'));
	});

	$('#range-cuti').on('cancel.daterangepicker', function(ev, picker) {
	  // $(this).val('');
      $(this).val(picker.startDate.format('D MMMM YYYY') + ' - ' + picker.endDate.format('D MMMM YYYY'));
	});

	$(".datepicker").daterangepicker({
		locale:{ format:'DD-MM-YYYY' },
		singleDatePicker: true,
	    showDropdowns: true,
	    minYear: 1901
	});

	var d = new Date(); // today!
	var x = 3; // go back 3 days!
	d.setDate(d.getDate() - x);
	
	$(".datepicker-timesheet").daterangepicker({
		locale:{ format:'DD-MM-YYYY' },
		minDate: new Date(d),
		singleDatePicker: true,
	    showDropdowns: true,
	    minYear: 2016
	});

	$('.logout-confirmation').on('click', function(e){
		var c = confirm('Apakah Anda yakin ingin keluar?');
		return c;
	});
</script>
