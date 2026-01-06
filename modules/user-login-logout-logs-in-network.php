<?php
// ثبت لاگ ورود کاربر
add_action('wp_login', function($user_login, $user) {
    $logs = get_user_meta($user->ID, 'mui_login_logs', true) ?: [];
    $logs[] = [
        'event' => 'ورود',
        'time'  => current_time('mysql'),
        'ip'    => $_SERVER['REMOTE_ADDR'] ?? 'نامشخص'
    ];
    $logs = array_slice($logs, -10); // فقط ۱۰ لاگ آخر
    update_user_meta($user->ID, 'mui_login_logs', $logs);
}, 10, 2);

// ثبت لاگ خروج
add_action('wp_logout', function() {
    $user = wp_get_current_user();
    if (!$user || !$user->ID) return;
    $logs = get_user_meta($user->ID, 'mui_login_logs', true) ?: [];
    $logs[] = [
        'event' => 'خروج',
        'time'  => current_time('mysql'),
        'ip'    => $_SERVER['REMOTE_ADDR'] ?? 'نامشخص'
    ];
    $logs = array_slice($logs, -10);
    update_user_meta($user->ID, 'mui_login_logs', $logs);
});

// ویجت لاگ ورود و خروج کاربران در پیشخوان سایت
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget('mui_login_logs_site', '📍 لاگ ورود و خروج کاربران', function() {
        $users = get_users(['number' => 5, 'orderby' => 'registered', 'order' => 'DESC']);

        echo '<table class="widefat striped">';
        echo '<thead><tr><th>کاربر</th><th>نقش</th><th>رویداد</th><th>زمان</th><th>IP</th></tr></thead><tbody>';

        foreach ($users as $user) {
            $logs = get_user_meta($user->ID, 'mui_login_logs', true);
            $role = !empty($user->roles[0]) ? $user->roles[0] : '—';
            if (!$logs) continue;

            foreach (array_reverse($logs) as $log) {
                echo '<tr>';
                echo '<td>' . esc_html($user->display_name) . '</td>';
                echo '<td>' . esc_html($role) . '</td>';
                echo '<td>' . esc_html($log['event']) . '</td>';
                echo '<td>' . esc_html($log['time']) . '</td>';
                echo '<td>' . esc_html($log['ip']) . '</td>';
                echo '</tr>';
            }
        }

        echo '</tbody></table>';
    });
});
?>
