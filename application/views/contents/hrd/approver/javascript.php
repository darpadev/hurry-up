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

          cols += '<div class="input-group"><select class="form-control" name="approver_cuti[]" required><option value=""> -- Pilih Approver -- </option><?php foreach ($this->db->select('id, position')->from('positions')->order_by('position', 'ASC')->get()->result() as $value): ?><option value="<?php echo $value->id ?>"><?php echo $value->position ?></option><?php endforeach ?></select><div class="input-group-prepend"><span class="input-group-text"><input type="button" class="ibtnDel btn btn-xs btn-danger" value="Hapus"></span></div></div>';

          newRow.append(cols);
          $("#approver-cuti").append(newRow);
          counter++;
          console.log(counter);
      });

      $("#approver-cuti").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter -= 1
      });
    });

  $(function () {
    $("#leave").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#overtime").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  $('.create-leave').on('click', function () {
      $('#modal-add-leave').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.create-overtime').on('click', function () {
      $('#modal-add-overtime').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.delete-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menghapus data ini?');
    return c;
  });
</script>