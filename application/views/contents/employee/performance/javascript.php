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

  $('.cancel-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin membatalkan data ini?');
    return c;
  });

  $('.copy-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menyalin KRA periode ini?');
    return c;
  });

  $('.save-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menyimpan data ini?');
    return c;
  });

  $('.publish-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin mempublikasikan data ini?');
    return c;
  });

  $('.approve-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menyetujui penilaian ini?');
    return c;
  });

  $('.reject-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menolak penilaian ini?');
    return c;
  });
</script>