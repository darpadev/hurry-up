<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/dist/js/pages/dashboard.js"></script>
<script>
  $(function () {
    $("#table").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    $("#table_length").remove();
    $("#table_filter").remove();
  });

  $('.delete-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menghapus data ini?');
    return c;
  });

  $(document).ready(function(){
    $('#keterangan').hide();
        $('input[name="condition"]').click(function() {
       if($('#sakit').is(':checked')) {
        $('#keterangan').fadeIn(); 
       } else {
        $('input[name=notes]').val();
        $('input[name=notes]').removeAttr('checked');
        $('#keterangan').fadeOut();
       }
    });

      if($('.checkin').is(':disabled')) {
        $('#kota').hide();
        $('select[name=city]').prop('required',false);
        
        $('#kondisi').hide();
        $('#suhu').hide();
        $('.kondisi').removeAttr('required');
        $('.suhu').removeAttr('required');
      } else {
        $('#kota').show();
        $('#kondisi').show();
      }

      var counter = 0;

      $("#add-timesheet").on("click", function (e) {
        e.preventDefault();
          var newRow = $("<p>");
          var cols = "";

          cols += ' <div class="row"> <div class="col-sm-3"> <div class="form-group"> <div class="input-group"> <input type="number" min="0" name="duration[]" class="form-control" required> </div> </div> </div> <div class="col-sm-8"> <div class="form-group"> <input type="text" class="form-control" name="activity[]" required /> </div> </div> <div class="col-sm-1"> <div class="input-group-prepend"><span class="input-group-text"><a href="javascript:void(0)" class="ibtnDel"><i class="fa fa-times"></i></a></span></div> </div> </div> ';
          // cols += ' <div class="row"> <div class="col-sm-3"> <div class="form-group"> <div class="input-group">  <input type="time" name="start[]" class="form-control" required> </div> </div> </div> <div class="col-sm-3"> <div class="form-group"> <div class="input-group"> <input type="time" name="finish[]" class="form-control datetimepicker-input" required> </div> </div> </div> <div class="col-sm-5"> <div class="form-group"> <input type="text" class="form-control" name="activity[]" required /> </div> </div>  <div class="col-sm-1"> <div class="input-group-prepend"><span class="input-group-text"><a href="javascript:void(0)" class="ibtnDel"><i class="fa fa-times"></i></a></span></div> </div> </div> ';

          newRow.append(cols);
          $("#timesheet-update").append(newRow);
          counter++;
      });

      $("#timesheet-update").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter -= 1
      });

    });

  if(geo_position_js.init()){
    geo_position_js.getCurrentPosition(success_callback,error_callback,{enableHighAccuracy:true});
  }
  else{
    alert("Functionality not available");
  }

  function success_callback(p)
  {
    jQuery('#div_session_write').load('<?php echo base_url('employee/home/sess?lat='); ?>'+p.coords.latitude.toFixed(7)+'&long='+p.coords.longitude.toFixed(7));
  }
  
  function error_callback(p)
  {
    // alert('error='+p.message);
    // alert("Harap nyalakan 'Location' pada browser Anda terlebih dahulu.");
    // $.ajax({
    //  url: '',
    //  type: 'POST',
    //  data: {},
    //  success: function(data){

    //  }
    // });
  }


</script>