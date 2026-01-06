<?php
// ویجت ابر دسته‌بندی در پیشخوان سایت
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget('mui_local_category_cloud', '📂 ابر دسته‌بندی سایت', function() {
        $cats = get_terms([
            'taxonomy'   => 'category',
            'orderby'    => 'count',
            'order'      => 'DESC',
            'number'     => 10,
            'hide_empty' => true,
        ]);

        if (empty($cats)) {
            echo '<p>هیچ دسته‌بندی فعالی در این سایت وجود ندارد.</p>';
            return;
        }

        echo '<div style="line-height:2; font-size:13px;">';
        foreach ($cats as $cat) {
            echo '<a href="' . esc_url(get_term_link($cat)) . '" target="_blank" style="
                display:inline-block;
                margin:5px 6px;
                padding:6px 12px;
                font-size:12px;
                text-decoration:none;
                background:#f1f1f1;
                border-radius:20px;
                color:#333;
                border:1px solid #ddd;
                transition:all 0.2s ease-in-out;
            " onmouseover="this.style.background=\'#e2e8f0\'" onmouseout="this.style.background=\'#f1f1f1\'">
                ' . esc_html($cat->name) . '
            </a>';
        }
        echo '</div>';
    });
});
?>
