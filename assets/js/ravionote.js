jQuery(document).ready(function($) {
    $('#ravionote_save').on('click', function() {
        var note = $('#ravionote_text').val();
        var message = $('#ravionote_message');

        $.post(RavionoteAjax.ajax_url, {
            action: 'ravionote_save',
            nonce: RavionoteAjax.nonce,
            note: note
        }, function(response) {
            if (response.success) {
                message.fadeIn().delay(1500).fadeOut();
            }
        });
    });
});
