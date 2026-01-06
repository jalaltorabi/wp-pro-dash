<?php
/**
 * نمایش ۲۱ فایل حجیم کتابخانه در صفحه upload.php
 * همراه با thumbnail + دکمه حذف (فقط برای ادمین)
 */

// ذخیره متای حجم فایل هنگام آپلود یا ویرایش
add_action('add_attachment', 'ravio_save_filesize_meta');
add_action('edit_attachment', 'ravio_save_filesize_meta');
function ravio_save_filesize_meta($post_id) {
    $file = get_attached_file($post_id);
    if ($file && file_exists($file)) {
        update_post_meta($post_id, '_ravio_filesize', filesize($file));
    }
}

// رندر جدول در صفحه کتابخانه رسانه
add_action('admin_footer', function () {
    $screen = get_current_screen();
    if ($screen->base !== 'upload') return;

    $all_ids = get_posts([
        'post_type'      => 'attachment',
        'posts_per_page' => 1000, // محدودیت برای عملکرد بهتر
        'post_status'    => 'inherit',
        'fields'         => 'ids',
    ]);
    if (empty($all_ids)) return;

    $sizes = [];
    foreach ($all_ids as $id) {
        $size = get_post_meta($id, '_ravio_filesize', true);
        if (!$size) {
            $file = get_attached_file($id);
            if ($file && file_exists($file)) {
                $size = filesize($file);
                update_post_meta($id, '_ravio_filesize', $size);
            }
        }
        if ($size) $sizes[$id] = $size;
    }

    if (empty($sizes)) return;

    // مرتب‌سازی و انتخاب ۲۱ فایل حجیم
    arsort($sizes);
    $top_ids = array_slice(array_keys($sizes), 0, 21);
    if (empty($top_ids)) return;

    ob_start(); ?>
    <div id="ravio-top-media" class="notice inline" style="text-align:center; padding:20px; margin-top:20px; display:none;">
        <h2 style="margin:0 0 15px;">
            <?php printf('%s فایل حجیم در این سایت (%s)', count($top_ids), esc_html(get_bloginfo('name'))); ?>
        </h2>
        <table style="margin:0 auto; border-collapse:collapse;">
            <tbody>
            <?php for ($row = 0; $row < 3; $row++): ?>
                <tr>
                    <?php for ($col = 0; $col < 7; $col++):
                        $idx = $row * 7 + $col;
                        if (!isset($top_ids[$idx])) {
                            echo '<td style="border:1px solid #e1e1e1; padding:8px; width:180px;">&nbsp;</td>';
                            continue;
                        }
                        $att_id = $top_ids[$idx];
                        $file   = get_attached_file($att_id);
                        $size   = size_format($sizes[$att_id]);
                        $url    = wp_get_attachment_url($att_id);
                        $label  = esc_html(basename($file));
                        ?>
                        <td style="border:1px solid #e1e1e1; padding:8px; vertical-align:top; width:180px;">
                            <a href="<?php echo esc_url($url); ?>" target="_blank">
                                <?php echo wp_get_attachment_image($att_id, [80, 80], true); ?><br>
                                <?php echo $label; ?>
                            </a><br>
                            <small>حجم: <?php echo $size; ?></small>
                            <?php if (current_user_can('delete_posts')): ?>
                                <br><a href="<?php echo wp_nonce_url(admin_url('upload.php?action=delete&media[]=' . $att_id), 'bulk-media'); ?>"
                                       class="button button-small" style="margin-top:5px; background:#dc3232; color:#fff;"
                                       onclick="return confirm('آیا از حذف این فایل مطمئن هستید؟');">🗑 حذف</a>
                            <?php endif; ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </div>
    <script>
        jQuery(function ($) {
            var $tbl = $('#ravio-top-media').show().detach();
            if ($('.tablenav .displaying-num').length) {
                $('.tablenav .displaying-num').first().closest('.tablenav').after($tbl);
            } else {
                $('.wrap').append($tbl);
            }
        });
    </script>
    <?php
    echo ob_get_clean();
});
?>
