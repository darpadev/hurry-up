<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- FullCalendar -->
<!-- <script src="<?php echo base_url() ?>assets/admin/plugins/moment/min/moment.min.js"></script> -->
<!-- <script src="<?php echo base_url() ?>assets/admin/plugins/fullcalendar/dist/fullcalendar.js"></script> -->
<script>
    $(function () {
        $(".table").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>