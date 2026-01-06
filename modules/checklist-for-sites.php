<?php
// مدیریت چک‌لیست انتشار از منوی تنظیمات
add_action('admin_menu', function () {
    add_submenu_page(
        'options-general.php',
        'مدیریت چک‌لیست انتشار',
        'چک‌لیست انتشار',
        'manage_options',
        'mui-publish-checklist',
        function () {
            if ( isset($_POST['mui_checklist_items']) && current_user_can('manage_options') ) {
                check_admin_referer('save_checklist_items');
                // دریافت و پاک‌سازی ورودی
                $text  = wp_kses_post( $_POST['mui_checklist_items'] );
                $lines = array_filter( array_map('trim', explode("\n", $text)) );
                update_option('mui_publish_checklist_items', $lines);
                echo '<div class="notice notice-success"><p>لیست با موفقیت ذخیره شد ✅</p></div>';
            }

            $items = get_option('mui_publish_checklist_items', [
                'عنوان جذاب و مرتبط انتخاب شده',
                'دسته‌بندی مناسب انتخاب شده',
                'برچسب‌های مرتبط اضافه شده',
                'تصویر شاخص تعیین شده',
                'طول پست حداقل ۳۰۰ کلمه هست',
                'آدرس URL بهینه است',
                'کلمه کلیدی اصلی مشخص شده',
                'متای توضیحات سئو نوشته شده',
                'لینک داخلی و خارجی وجود دارد',
                'پست ذخیره یا پیش‌نمایش شده است'
            ]);

            echo '<div class="wrap"><h1>مدیریت چک‌لیست قبل از انتشار</h1>';
            echo '<form method="post">';
            wp_nonce_field('save_checklist_items');

            wp_editor(
                implode("\n", $items),          // محتوای اولیه
                'mui_checklist_items',          // شناسه (ID)
                [
                    'textarea_name' => 'mui_checklist_items',
                    'textarea_rows' => 10,
                    'media_buttons' => false,
                    'teeny'         => true,
                    'quicktags'     => true,
                ]
            );

            echo '<p><input type="submit" class="button button-primary" value="ذخیره چک‌ لیست"></p>';
            echo '</form></div>';
        }
    );
});

// نمایش چک‌لیست در پیشخوان سایت
add_action('wp_dashboard_setup', function () {
    wp_add_dashboard_widget(
        'mui_publish_checklist_widget',
        '📋 چک‌ لیست قبل از انتشار پست',
        function () {
            $items = get_option('mui_publish_checklist_items', []);
            if ( empty($items) ) {
                echo '<p>چک‌لیستی ثبت نشده است.</p>';
                return;
            }
            echo '<ul style="padding-right:20px; line-height:1.9; font-size:14px;">';
            foreach ( $items as $item ) {
                echo '<li>✅ ' . esc_html($item) . '</li>';
            }
            echo '</ul>';
        }
    );
});
?>
