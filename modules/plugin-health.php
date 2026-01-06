<?php
// ویجت بررسی سلامت افزونه ها در پیشخوان سایت + لیست افزونه‌های فعال/غیرفعال
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget('mui_plugin_health_widget', '🧩 بررسی سلامت افزونه‌ها در سایت', function() {
        $all_plugins    = get_plugins();
        $active_plugins = get_option('active_plugins', []);
        
        $active_list   = [];
        $inactive_list = [];

        foreach ($all_plugins as $slug => $plugin) {
            if (in_array($slug, $active_plugins)) {
                $active_list[] = $plugin['Name'];
            } else {
                $inactive_list[] = $plugin['Name'];
            }
        }

        // هشدارها
        $warnings = [];
        if (count($inactive_list) > 10) {
            $warnings[] = '⚠ افزونه‌های غیرفعال زیاد';
        }

        // بررسی افزونه‌های حیاتی
        $important_plugins = [
            'woocommerce/woocommerce.php',
            'elementor/elementor.php',
            'seo-by-rank-math/rank-math.php'
        ];

        foreach ($important_plugins as $slug) {
            if (isset($all_plugins[$slug])) {
                $plugin    = $all_plugins[$slug];
                $file_path = WP_PLUGIN_DIR . '/' . $slug;
                if (file_exists($file_path)) {
                    $last_updated = filemtime($file_path);
                    $days_old     = floor((time() - $last_updated) / (60 * 60 * 24));
                    if ($days_old > 90) {
                        $warnings[] = '🔺 ' . esc_html($plugin['Name']) . ' بیش از ۹۰ روز آپدیت نشده';
                    }
                }
            }
        }

        echo '<table class="widefat striped">';
        echo '<thead><tr>
                <th style="width:33%;">فعال (' . count($active_list) . ')</th>
                <th style="width:33%;">غیرفعال (' . count($inactive_list) . ')</th>
                <th style="width:34%;">هشدار</th>
              </tr></thead><tbody>';

        // محاسبه بیشترین ردیف لازم
        $max_rows = max(count($active_list), count($inactive_list), count($warnings));

        for ($i = 0; $i < $max_rows; $i++) {
            echo '<tr>';
            echo '<td>' . ($active_list[$i]   ?? '—') . '</td>';
            echo '<td>' . ($inactive_list[$i] ?? '—') . '</td>';
            echo '<td>' . ($warnings[$i]      ?? '—') . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    });
});
?>
