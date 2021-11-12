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

  $(document).ready(function(){
      var counter = 0;

      $("#addrow").on("click", function (e) {
        e.preventDefault();
          var newRow = $("<p>");
          var cols = "";

          cols += '<div class="input-group"><select class="form-control" name="employee_id[]" required><option value=""> -- Pilih Pegawai -- </option><?php foreach ($employee->result() as $emp): ?> <option value="<?php echo $emp->employee_id ?>"><?php echo $emp->nip." - ".$emp->name ?></option> <?php endforeach ?></select><div class="input-group-prepend"><span class="input-group-text"><input type="button" class="ibtnDel btn btn-xs btn-danger" value="Hapus"></span></div></div>';

          newRow.append(cols);
          $("#assign-overtime").append(newRow);
          counter++;
          console.log(counter);
      });

      $("#assign-overtime").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter -= 1
      });
    }
  );

  $('.create-data').on('click', function () {
      $('#modal-add-data').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.delete-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menghapus data ini?');
    return c;
  });

  $('.approve-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menyetujui data ini?');
    return c;
  });

  $('.reject-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin tidak ingin menyetujui data ini?');
    return c;
  });
</script>

<script type="text/javascript">
$(document).ready(function(){

  // Check/Uncheck ALl
  $('#checkAll').change(function(){
    if($(this).is(':checked')){
      $('input[name="approval[]"]').prop('checked',true);
    }else{
      $('input[name="approval[]"]').each(function(){
         $(this).prop('checked',false);
      });
    }
  });

  // Checkbox click
  $('input[name="approval[]"]').click(function(){
    var total_checkboxes = $('input[name="approval[]"]').length;
    var total_checkboxes_checked = $('input[name="approval[]"]:checked').length;

    if(total_checkboxes_checked == total_checkboxes){
       $('#checkAll').prop('checked',true);
    }else{
       $('#checkAll').prop('checked',false);
    }
  });
});
</script>