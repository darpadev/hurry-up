<script>
    const reason = $('#reason');
    const add_reason = $('#add');
    const delete_reason = $('#delete');

    // Disable "Enter" input to prevent accidental input
    $(':input[name="reason[]"]').keypress(function(event) {
        if (event.keyCode == 13 || event.which == 13){
            reason.append(`
                <input type="text" name="reason[]" class="form-control mt-2" placeholder="Dasar Pertimbangan" required>
            `);

            event.preventDefault();
            return false;
        }
    })
    
    $(add_reason).click(function(event) {
        reason.append(`
            <input type="text" name="reason[]" class="form-control mt-2" placeholder="Dasar Pertimbangan" required>
        `);

        event.preventDefault();
    });

    $(delete_reason).click(function(event) {
        if (reason.children().length > 1) reason.children().last().remove();
        event.preventDefault();
    })

    const promotion = $(':radio');
    const description = $('.description');

    promotion.each(function(index) {
        if (index == 1){
            $(promotion[index]).change(function() {
                if (this.checked) {
                    $('#duration').fadeIn();
                    $('#duration select').prop('required', true);
                    $('#duration select').prop('disabled', false);

                    $(description).fadeOut();
                    $(description).attr('name', null);
                    $(description).val('');
                    $(description[index]).fadeIn();
                    $(description[index]).attr('name', 'description');
                }
            });
        } else {
            $(promotion[index]).change(function() {
                if (this.checked) {
                    $('#duration').fadeOut();
                    $('#duration select').prop('required', false);
                    $('#duration select').prop('disabled', true);
                    
                    $(description).fadeOut();
                    $(description).attr('name', null);
                    $(description).val('');
                    $(description[index]).fadeIn();
                    $(description[index]).attr('name', 'description');
                }
            });
        }
    });
</script>