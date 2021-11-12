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

    $('.criteria').summernote()
  });

  $(document).ready(function(){
      var counter = 0;

      $("#addrow").on("click", function (e) {
        e.preventDefault();
          var newRow = $("<p>");
          var cols = "";

          cols += '<div class="row"> <div class="col-md-2"> <input type="text" class="form-control" name="kra[]"> </div> <div class="col-md-4"> <input type="text" class="form-control" name="kpi[]"> </div> <div class="col-md-5"> <textarea class="form-control" name="criteria[]"></textarea> </div> <div class="col-md-1"> <div class="input-group-prepend"><span class="input-group-text"><a href="javascript:void(0)" class="ibtnDel"><i class="fa fa-times"></i></a></span></div> </div> </div>';

          newRow.append(cols);
          $("#create-assessment-standar").append(newRow);
          counter++;
          console.log(counter);
      });

      $("#create-assessment-standar").on("click", ".ibtnDel", function (event) {
          $(this).closest("p").remove();       
          counter -= 1
      });

      <?php if (isset($_GET['year'])) { ?>      
        $(".add-row").click(function(){
            var markup = '<tr> <td class="center"><input type="checkbox" name="id[]"><input type="hidden" name="year" value="<?= $_GET['year'] ?>"></td> <td> <input type="text" name="kra[]" class="form-control" required> </td> <td> <input type="text" class="form-control" name="kpi[]" required> </td> <td> <textarea class="form-control" rows="5" name="criteria[]" required></textarea> </td> </tr>';
            $("table tbody").append(markup);
        });

        // Find and remove selected table rows
        $(".delete-row").click(function(){
            $("table tbody").find('input[name="id[]"]').each(function(){
              if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });

        $(".add-row-peer-review").click(function(){
            var markup = '<tr> <td class="center"><input type="checkbox" name="id[]"><input type="hidden" name="year" value="<?= $_GET['year'] ?>"></td> <td> <input type="text" name="kra[]" class="form-control" required> </td> <td> <textarea class="form-control" rows="5" name="criteria[]" required></textarea> </td> <td> <input type="number" min="0" class="form-control" name="sequence[]" required> </td> </tr>';
            $("table tbody").append(markup);
        });

        // Find and remove selected table rows
        $(".delete-row-peer-review").click(function(){
            $("table tbody").find('input[name="id[]"]').each(function(){
              if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });
      <?php } ?>
    }
  );

  $('.create-data').on('click', function () {
      $('#modal-add-data').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.create-data-assessment-standard').on('click', function () {
      $('#modal-add-data-assessment-standard').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.create-data-assessment-specific').on('click', function () {
      $('#modal-add-data-assessment-specific').modal({backdrop: 'static', keyboard: false}) 
    });

  $('.delete-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin ingin menghapus data ini?');
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
    var c = confirm('Apakah Anda yakin ingin menyetujui data ini?');
    return c;
  });

  $('.reject-confirmation').on('click', function(e){
    var c = confirm('Apakah Anda yakin tidak ingin menyetujui data ini?');
    return c;
  });
  
$(document).ready(function(){

  // Check/Uncheck ALl
  $('#checkAll').change(function(){
    if($(this).is(':checked')){
      $('input[name="id[]"]').prop('checked',true);
    }else{
      $('input[name="id[]"]').each(function(){
         $(this).prop('checked',false);
      });
    }
  });

  // Checkbox click
  $('input[name="id[]"]').click(function(){
    var total_checkboxes = $('input[name="id[]"]').length;
    var total_checkboxes_checked = $('input[name="id[]"]:checked').length;

    if(total_checkboxes_checked == total_checkboxes){
       $('#checkAll').prop('checked',true);
    }else{
       $('#checkAll').prop('checked',false);
    }
  });
});
</script>