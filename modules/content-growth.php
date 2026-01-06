<?php
// ویجت رشد محتوای سایت در ۴ هفته اخیر با نام‌های فارسی
add_action('wp_dashboard_setup', function () {
    wp_add_dashboard_widget('mui_content_growth_widget', '📈 رشد محتوای سایت (۴ هفته اخیر)', function () {
        $now = current_time('timestamp');

        $labels = ['هفته اول', 'هفته دوم', 'هفته سوم', 'هفته چهارم'];
        $data   = [];

        // حلقه ۴ هفته اخیر
        for ($i = 3; $i >= 0; $i--) {
            $start = date('Y-m-d H:i:s', strtotime("-" . (7 * ($i + 1)) . " days", $now));
            $end   = date('Y-m-d H:i:s', strtotime("-" . (7 * $i) . " days", $now));

            $query = new WP_Query([
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'date_query'     => [
                    ['after' => $start, 'before' => $end, 'inclusive' => true]
                ],
                'fields'         => 'ids',
                'no_found_rows'  => true,
                'posts_per_page' => -1
            ]);

            $data[] = count($query->posts);
        }

        // جدول آماری
        echo '<table class="widefat striped" style="margin-bottom: 20px">';
        echo '<thead><tr>
                <th>هفته</th>
                <th>تعداد پست‌ها</th>
              </tr></thead><tbody>';
        foreach ($labels as $index => $label) {
            echo '<tr>';
            echo '<td><center>' . esc_html($label) . '</center></td>';
            echo '<td><center>' . intval($data[$index]) . '</center></td>';
            echo '</tr>';
        }
        echo '</tbody></table>';

        // نمودار
        echo '<canvas id="mui_content_growth_chart" height="200"></canvas>';
        $chart_src = plugin_dir_url(__FILE__) . '../assets/js/chart.min.js';
        echo '<script src="' . esc_url($chart_src) . '"></script>';
        echo '<script>
            const ctx = document.getElementById("mui_content_growth_chart").getContext("2d");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ' . json_encode($labels, JSON_UNESCAPED_UNICODE) . ',
                    datasets: [{
                        label: "تعداد پست‌ها",
                        data: ' . json_encode($data) . ',
                        backgroundColor: [
                            "rgba(54, 162, 235, 0.7)",
                            "rgba(255, 99, 132, 0.7)",
                            "rgba(255, 206, 86, 0.7)",
                            "rgba(75, 192, 192, 0.7)"
                        ],
                        borderRadius: 6
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        </script>';
    });
});
?>
