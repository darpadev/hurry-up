<script src="<?php echo base_url() ?>assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
	$(document).ready(function() {
		bsCustomFileInput.init();

		$('select[name=time_format]').on('change', function(){
			var time = moment().format($(this).val());
			$('.ex-time-format').text(time);
		});
		
		$('select[name=date_format]').on('change', function(){
			var date = moment().format($(this).val());
			$('.ex-date-format').text(date);
		});
	});

	function mailForm() {
		document.getElementById("mailForm").reset();
	}

	function profileForm() {
		document.getElementById("profileForm").reset();
	}

	$('.confirm-update').submit(function(){
		var c = confirm('Apakah Anda yakin ingin mengubah data ini?');
		return c;
	});

	$('.edit-mail').on('click', function(e){
		$('input[name=host]').removeAttr('disabled');
		$('input[name=email]').removeAttr('disabled');
		$('input[name=port]').removeAttr('disabled');
		$('input[name=driver]').removeAttr('disabled');
		$('input[name=password]').removeAttr('disabled');
		$('input[name=encryption]').removeAttr('disabled');
		$('input[name=name]').removeAttr('disabled');
		$('#submit-mail').removeAttr('disabled');

		$('.edit-mail').fadeOut();
		$('.cancel-mail').fadeIn();
	});

	$('.cancel-mail').on('click', function(e){
		$('input[name=host]').attr('disabled', true);
		$('input[name=email]').attr('disabled', true);
		$('input[name=port]').attr('disabled', true);
		$('input[name=driver]').attr('disabled', true);
		$('input[name=password]').attr('disabled', true);
		$('input[name=encryption]').attr('disabled', true);
		$('input[name=name]').attr('disabled', true);

		$('#submit-mail').attr('disabled', true);

		$('.cancel-mail').fadeOut();
		$('.edit-mail').fadeIn();
	});

	$('.edit-profile').on('click', function(e){
		$('input[name=company]').removeAttr('disabled');
		$('input[name=email]').removeAttr('disabled');
		$('input[name=phone]').removeAttr('disabled');
		$('textarea[name=address]').removeAttr('disabled');
		$('input[name=logo]').removeAttr('disabled');
		$('input[name=website]').removeAttr('disabled');
		$('#submit-profile').removeAttr('disabled');

		$('.edit-profile').fadeOut();
		$('.cancel-profile').fadeIn();
	});

	$('.cancel-profile').on('click', function(e){
		$('input[name=company]').attr('disabled', true);
		$('input[name=email]').attr('disabled', true);
		$('input[name=phone]').attr('disabled', true);
		$('textarea[name=address]').attr('disabled', true);
		$('input[name=logo]').attr('disabled', true);
		$('input[name=website]').attr('disabled', true);
		$('#submit-profile').attr('disabled', true);

		$('.cancel-profile').fadeOut();
		$('.edit-profile').fadeIn();
	});
</script>