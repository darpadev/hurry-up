<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $(function () {
    $("#users").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#table').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $('.reset-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda ingin setel ulang kata sandi?');
    return c;
  });

  $('.delete-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menghapus data ini?');
    return c;
  });

  $('.reset-password').on('click', function(e){
    $('input[name=password]').removeAttr('disabled');
    $('input[name=confirm]').removeAttr('disabled');
    $('#submit-password').removeAttr('disabled');
  });
</script>