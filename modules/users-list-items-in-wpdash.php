<?php
// افزودن ستون‌ها در لیست کاربران
add_filter('manage_users_columns', function($columns) {
    $columns['user_id'] = 'آیدی';
    $columns['account_status'] = 'وضعیت';
    return $columns;
});

// مقداردهی به ستون‌های جدید
add_filter('manage_users_custom_column', function($value, $column_name, $user_id) {
    if ($column_name === 'user_id') {
        return '<strong>' . intval($user_id) . '</strong>';
    }

    if ($column_name === 'account_status') {
        $user = get_userdata($user_id);

        if (empty($user->roles)) {
            return '<span style="color:red; font-weight:bold;">❌ غیرفعال</span>';
        } else {
            return '<span style="color:green; font-weight:bold;">✅ فعال</span>';
        }
    }

    return $value;
}, 10, 3);
?>
