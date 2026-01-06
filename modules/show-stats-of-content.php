<?php
// ویجت نمایش آمار پست‌ها، برگه‌ها، دسته‌ها و برچسب‌ها در سایت جاری (بدون ستون پیش‌نویس)
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget('mui_content_stats_site', '📚 آمار محتوای سایت', function() {
        // شمارش پست‌ها
        $post_counts = wp_count_posts('post');
        $post_publish = $post_counts->publish ?? 0;

        // شمارش برگه‌ها
        $page_counts = wp_count_posts('page');
        $page_publish = $page_counts->publish ?? 0;

        // شمارش دسته‌ها و برچسب‌ها
        $cat_count = wp_count_terms('category', ['hide_empty' => false]);
        $tag_count = wp_count_terms('post_tag', ['hide_empty' => false]);

        echo '<div style="margin-bottom:10px;">';
        echo '<strong>پست‌ها:</strong> ' . $post_publish . ' | ';
        echo '<strong>برگه‌ها:</strong> ' . $page_publish . ' | ';
        echo '<strong>دسته‌بندی‌ها:</strong> ' . $cat_count . ' | ';
        echo '<strong>برچسب‌ها:</strong> ' . $tag_count;
        echo '</div>';

        // جدول خلاصه (بدون پیش‌نویس)
        echo '<table class="widefat striped">';
        echo '<thead><tr>
                <th>نوع محتوا</th>
                <th>منتشرشده</th>
              </tr></thead><tbody>';

        echo '<tr><td>پست‌ها</td><td><center>' . $post_publish . '</center></td></tr>';
        echo '<tr><td>برگه‌ها</td><td><center>' . $page_publish . '</center></td></tr>';
        echo '<tr><td>دسته‌بندی‌ها</td><td><center>' . $cat_count . '</center></td></tr>';
        echo '<tr><td>برچسب‌ها</td><td><center>' . $tag_count . '</center></td></tr>';

        echo '</tbody></table>';
    });
});
?>
