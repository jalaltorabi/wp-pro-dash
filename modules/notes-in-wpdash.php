<?php
// ویجت دفترچه یادداشت برای هر سایت
add_action('wp_dashboard_setup', function () {
    wp_add_dashboard_widget(
        'mui_site_notes_widget',
        '📝 دفترچه یادداشت سایت',
        'mui_site_notes_widget_render'
    );
});

// نمایش فرم یادداشت
function mui_site_notes_widget_render() {
    $note = get_option('mui_site_note_text', '');
    ?>
<?php
wp_editor(
    $note,
    'mui_site_note', // این ID در AJAX استفاده می‌شه
    [
        'textarea_name' => 'mui_site_note',
        'textarea_rows' => 10,
        'media_buttons' => false,
    ]
);
?>
    <p><button class="button button-primary" id="mui-save-note">ذخیره یادداشت</button>
       <span id="mui-note-status" style="margin-right:10px; color:green;"></span></p>

    <script>
    jQuery(function($){
        $('#mui-save-note').on('click', function(){
            var noteText = tinyMCE.get('mui_site_note') ? tinyMCE.get('mui_site_note').getContent() : $('#mui_site_note').val();
            $('#mui-note-status').text('در حال ذخیره...');
            $.post(ajaxurl, {
                action: 'mui_save_site_note',
                note: noteText,
                _ajax_nonce: '<?php echo wp_create_nonce("mui_save_note"); ?>'
            }, function(res){
                $('#mui-note-status').text(res.success ? 'ذخیره شد ✅' : 'خطا در ذخیره ❌');
            });
        });
    });
    </script>
    <?php
}

// هندل AJAX برای ذخیره یادداشت
add_action('wp_ajax_mui_save_site_note', function () {
    check_ajax_referer('mui_save_note');

    if (!current_user_can('edit_dashboard')) {
        wp_send_json_error('دسترسی ندارید.');
    }

    $note = wp_kses_post($_POST['note'] ?? '');
    update_option('mui_site_note_text', $note);
    wp_send_json_success();
});
?>