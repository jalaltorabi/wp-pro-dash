<?php
// نمایش کاربران اخیر ثبت نامی در پیشخوان سایت
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget('mui_recent_users', '⭐️ آخرین کاربران ثبت نامی', function() {
        $recent_users = get_users([
            'orderby' => 'registered',
            'order'   => 'DESC',
            'number'  => 10
        ]);

        // رنگ‌ها برای نقش‌ ها
        $role_colors = [
            'administrator' => '#d63638',
            'editor'        => '#ff9900',
            'author'        => '#ff9900',
            'contributor'   => '#21759b',
            'subscriber'    => '#21759b',
        ];

        // ترجمه نقش‌ ها به فارسی ساده‌شده
        function convert_role_label($role) {
            if ($role === 'administrator') return 'مدیر';
            if (in_array($role, ['editor', 'author'])) return 'نویسنده';
            if (in_array($role, ['contributor', 'subscriber'])) return 'یوزر';
            return '—';
        }

        echo '<table class="widefat striped">';
        echo '<thead><tr><th>یوزر</th><th>نقش</th><th>عضویت</th><th>پروفایل</th></tr></thead>';
        echo '<tbody>';

        foreach ($recent_users as $user) {
            $role_slug  = !empty($user->roles) ? $user->roles[0] : 'subscriber';
            $role_label = convert_role_label($role_slug);
            $role_color = $role_colors[$role_slug] ?? '#555';

            echo '<tr>';
            echo '<td>' . esc_html($user->user_login) . '</td>';
            echo '<td><span style="color:' . $role_color . '; font-weight:bold;">' . $role_label . '</span></td>';
            echo '<td>' . date('Y-m-d H:i', strtotime($user->user_registered)) . '</td>';
            echo '<td><a class="button button-small" href="' . admin_url('user-edit.php?user_id=' . $user->ID) . '">مشاهده</a></td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    });
});
?>
