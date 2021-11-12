<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $(function () {
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

  $(document).ready(function(){
      var counter = 0;

      $("#add-timesheet").on("click", function (e) {
        e.preventDefault();
          var newRow = $("<p>");
          var cols = "";

          cols += ' <div class="row"> <div class="col-sm-3"> <div class="form-group"> <div class="input-group">  <input type="time" name="start[]" class="form-control" required> </div> </div> </div> <div class="col-sm-3"> <div class="form-group"> <div class="input-group"> <input type="time" name="finish[]" class="form-control datetimepicker-input" required> </div> </div> </div> <div class="col-sm-5"> <div class="form-group"> <input type="text" class="form-control" name="description[]" required /> </div> </div>  <div class="col-sm-1"> <div class="input-group-prepend"><span class="input-group-text"><a href="javascript:void(0)" class="ibtnDel"><i class="fa fa-times"></i></a></span></div> </div> </div> ';

          newRow.append(cols);
          $("#report-update").append(newRow);
          counter++;
      });

      $("#report-update").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter -= 1
      });
    }
  );
</script>