<?php
// ویجت اطلاعات سرور + آی پی و ماژول‌ های PHP (نسخه مخصوص پیشخوان سایت)
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget('mui_server_info', '🌏 اطلاعات سرور و آی پی', function() {
        global $wpdb;

        $web_server   = $_SERVER['SERVER_SOFTWARE'] ?? 'نا مشخص';
        $mysql_ver    = $wpdb->db_version();
        $hostname     = gethostname();
        $server_ip    = $_SERVER['SERVER_ADDR'] ?? gethostbyname($hostname);
        $admin_ip     = $_SERVER['REMOTE_ADDR'] ?? 'نا مشخص';
        $domain       = site_url(); // تغییر داده شد
        $ns           = gethostbynamel(parse_url($domain, PHP_URL_HOST));
        $current_time = date('Y-m-d H:i:s');

        // helper for on/off/1/0 values
        function status_icon($val) {
            $val = strtolower(trim($val));
            return ($val === 'on' || $val === '1') ? '✅' : (($val === 'off' || $val === '0') ? '❌' : $val);
        }

        echo '<table class="widefat striped"><tbody>';
        echo '<tr><td>نسخه PHP</td><td>' . phpversion() . '</td></tr>';
        echo '<tr><td>نسخه وردپرس</td><td>' . get_bloginfo('version') . '</td></tr>';
        echo '<tr><td>سیستم عامل سرور</td><td>' . PHP_OS . '</td></tr>';
        echo '<tr><td>نوع وب‌ سرور</td><td>' . esc_html($web_server) . '</td></tr>';
        echo '<tr><td>نسخه MySQL / MariaDB</td><td>' . esc_html($mysql_ver) . '</td></tr>';
        echo '<tr><td>نام هاست / IP سرور</td><td>' . esc_html($hostname . ' / ' . $server_ip) . '</td></tr>';
        echo '<tr><td>دامنه سایت</td><td>' . esc_html($domain) . '</td></tr>';
        echo '<tr><td>نیم‌ سرورها</td><td>' . (is_array($ns) ? implode(' / ', $ns) : 'نامشخص') . '</td></tr>';
        echo '<tr><td>زمان فعلی سرور</td><td>' . $current_time . '</td></tr>';

        // ماژول‌ ها و تنظیمات خاص PHP
        $modules = [
            'memory_limit',
            'max_execution_time',
            'allow_url_fopen',
            'display_errors',
            'file_uploads',
            'max_input_time',
            'max_input_vars',
            'post_max_size',
            'session.gc_maxlifetime',
            'session.save_path',
            'upload_max_filesize',
            'zlib.output_compression'
        ];

        foreach ($modules as $mod) {
            $val = ini_get($mod);
            $display = status_icon($val);
            echo '<tr><td>ماژول ' . $mod . '</td><td>' . $display . '</td></tr>';
        }

        echo '</tbody></table>';
    });
});
?>
