<?php
// ویجت نمایش ۱۵ محتوای آخر منتشرشده در سایت جاری
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget('mui_latest_posts_site', '📒 آخرین مطالب منتشرشده در سایت', function() {
        $recent_posts = get_posts([
            'numberposts' => 15,
            'post_status' => 'publish',
            'post_type'   => 'post',
        ]);

        echo '<table class="widefat striped">';
        echo '<thead><tr>
                <th>عنوان مطلب</th>
                <th>تاریخ انتشار</th>
              </tr></thead><tbody>';

        foreach ($recent_posts as $post) {
            $edit_url = get_edit_post_link($post->ID);
            echo '<tr>';
            echo '<td><a href="' . esc_url($edit_url) . '" target="_blank">' . esc_html($post->post_title) . '</a></td>';
            echo '<td>' . date('Y/m/d H:i', strtotime($post->post_date)) . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    });
});
?>
