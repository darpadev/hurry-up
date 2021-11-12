<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- datepikcer -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function () {
    $("#table").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    $("#period").datepicker( {
        format: "MM yyyy",
        startView: "months", 
        minViewMode: "months",
        autoclose: true
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