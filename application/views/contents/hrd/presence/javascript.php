<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- FullCalendar -->
<!-- <script src="<?php echo base_url() ?>assets/admin/plugins/moment/min/moment.min.js"></script> -->
<!-- <script src="<?php echo base_url() ?>assets/admin/plugins/fullcalendar/dist/fullcalendar.js"></script> -->
<script>
  $('#wfh').hide();

  $('#type').on('change', function() {
    if (this.value == 2) {
      $('#wfh').show();
    } else {
      $('#wfh').hide();
      $('input[name="condition"]').prop('checked', false);
      $('input[name="temperature"]').val('');      
      $('#city').val('').trigger('change');
      $('textarea[name="health_records"]').val('');
    }
  });

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
</script>