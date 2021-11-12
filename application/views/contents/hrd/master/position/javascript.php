<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $(document).ready(function(){
      var counter = 0;
      var counter_tupoksi = 0;

      $("#addrow").on("click", function () {
          var newRow = $("<p>");
          var cols = "";
          var date = new Date();
          var day = date.getDate();
          var month = date.getMonth() + 1;
          var year = date.getFullYear();

          if (month < 10) month = "0" + month;
          if (day < 10) day = "0" + day;

          var today = year + "-" + month + "-" + day;
          console.log(today)

          cols += '<div class="form-group"><div class="input-group"><div class="col-md-6"><select class="form-control" name="employee_id[]" required><option value=""> -- Pilih Pegawai -- </option><?php foreach ($this->db->select('ep.employee_id, e.name, ep.nip')->from('employee_pt as ep')->join('employees as e', 'e.id = ep.employee_id')->where('ep.status', 1)->order_by('ep.nip', 'ASC')->get()->result() as $value): ?><option value="<?php echo $value->employee_id ?>"><?php echo $value->nip.' - '.$value->name ?></option><?php endforeach ?></select>&nbsp;</div><div class="col-md-4"> <div class="input-group"><div class="input-group-prepend"> <span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div><input type="text" class="form-control datepicker" name="start_date[]" value="'+today+'" required> </div> </div><div class="col-md-2"><div class="input-group-prepend"><span class="input-group-text"><input type="button" class="ibtnDel btn btn-xs btn-danger" value="Hapus"></span></div></div></div></div> <script>$(".datepicker").daterangepicker({ locale:{ format:"DD-MM-YYYY" }, singleDatePicker: true, showDropdowns: true, minYear: 2016 }); $(document).ready(function() { $("select").select2({ theme: "bootstrap4" }); });<' + '/' + 'script>';

          newRow.append(cols);
          $("#add-pegawai").append(newRow);
          counter++;
      });

      $("#add-pegawai").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter -= 1
      });

      $("#addrow-tupoksi").on("click", function () {
          var newRow = $("<p>");
          var cols = "";

          cols += '<div class="form-group"><div class="input-group"><div class="col-md-8"> <input type="text" name="tupoksi[]" class="form-control" required> &nbsp;</div><div class="col-md-2"> <input type="number" min="0" name="weight[]" class="form-control" required> </div><div class="col-md-2"><div class="input-group-prepend"><span class="input-group-text"><input type="button" class="ibtnDel btn btn-xs btn-danger" value="Hapus"></span></div></div></div></div>';

          newRow.append(cols);
          $("#add-tupoksi").append(newRow);
          counter_tupoksi++;
      });

      $("#add-tupoksi").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter_tupoksi -= 1
      });
    });

  $(function () {
    $("#table").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    $("#table-tupoksi").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  $('.create-data').on('click', function () {
      $('#modal-add-data').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.create-data-tupoksi').on('click', function () {
      $('#modal-add-tupoksi').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.delete-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menghapus data ini?');
    return c;
  });
</script>