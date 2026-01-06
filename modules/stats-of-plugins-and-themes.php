<?php
// ویجت آمار افزونه ها و پوسته ها در پیشخوان سایت
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget('mui_plugins_themes', '🧩 آمار افزونه ها و پوسته ها', function() {
        // همه افزونه‌ها
        $all_plugins = get_plugins();
        // افزونه‌های فعال در سایت جاری
        $active_plugins = get_option('active_plugins', []);
        
        // همه پوسته‌ها
        $themes = wp_get_themes();
        // پوسته فعال سایت جاری
        $active_theme = wp_get_theme();

        echo '<table class="widefat striped"><tbody>';
        echo '<tr><td>تعداد کل افزونه‌ها</td><td>' . count($all_plugins) . '</td></tr>';
        echo '<tr><td>افزونه‌های فعال</td><td>' . count($active_plugins) . '</td></tr>';
        echo '<tr><td>افزونه‌های غیرفعال</td><td>' . (count($all_plugins) - count($active_plugins)) . '</td></tr>';
        echo '<tr><td>تعداد کل پوسته‌ها</td><td>' . count($themes) . '</td></tr>';
        echo '<tr><td>پوسته فعال</td><td>' . esc_html($active_theme->get('Name')) . '</td></tr>';
        echo '</tbody></table>';
    });
});
?>
