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

          cols += ' <div class="row"> <div class="col-sm-2"> <div class="form-group"> <div class="input-group"> <input type="text" name="date_on[]" class="form-control datepicker-timesheet" required> </div> </div> </div> <div class="col-sm-2"> <div class="form-group"> <div class="input-group"> <input type="number" min="0" name="duration[]" class="form-control" required> </div> </div> </div> <div class="col-sm-4"> <div class="form-group"> <select class="form-control" name="tupoksi[]" required> <option value=""> -- Pilih Tugas Pokok -- </option> <?php foreach ($tupoksi as $value): ?> <option value="<?= $value->id ?>"><?= $value->tupoksi ?></option> <?php endforeach; ?> </select> </div> </div> <div class="col-sm-3"> <div class="form-group"> <input type="text" class="form-control" name="activity[]" required> </div> </div> <div class="col-sm-1"> <div class="input-group-prepend"><span class="input-group-text"><a href="javascript:void(0)" class="ibtnDel"><i class="fa fa-times"></i></a></span></div> </div> </div> <script>  $(document).ready(function() { var d = new Date(); var x = 3; d.setDate(d.getDate() - x); $(".datepicker-timesheet").daterangepicker({ locale:{ format:"DD-MM-YYYY" }, minDate: new Date(d), singleDatePicker: true, showDropdowns: true, minYear: 2016 }); $("select").select2({ theme: "bootstrap4" }); }); <' + '/' + 'script>';

          newRow.append(cols);
          $("#timesheet-update").append(newRow);
          counter++;
      });

      $("#timesheet-update").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter -= 1
      });

    });
</script>