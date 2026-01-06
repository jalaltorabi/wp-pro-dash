<?php
/*
Plugin Name: ابزارهای کاربردی داشبورد وردپرس
Description: ابزار و ویجت های کاربردی مورد استفاده در پیشخوان وردپرس
Version: 1404.05.25
Author: Sakoyeaval Team
*/

if (!defined('ABSPATH')) exit;

	// ویجت آمار افزونه ها و پوسته ها
	include plugin_dir_path(__FILE__) . 'modules/stats-of-plugins-and-themes.php';

	// ویجت اطلاعات سرور + آی پی و ماژول‌ های PHP
	include plugin_dir_path(__FILE__) . 'modules/server-info.php';
	
	// نمایش کاربران اخیر ثبت نامی
	include plugin_dir_path(__FILE__) . 'modules/recent-users.php';

	// ویجت نمایش ۱۵ مطلب آخر شبکه در پیشخوان
	include plugin_dir_path(__FILE__) . 'modules/15-rercent-posts.php';
	
	// ویجت نمایش آمار پست‌ها، برگه‌ها، دسته‌ها و برچسب‌ها در سایت‌
	include plugin_dir_path(__FILE__) . 'modules/show-stats-of-content.php';

	// ویجت نمایش لاگ ورود و خروج کاربران 
	include plugin_dir_path(__FILE__) . 'modules/user-login-logout-logs-in-network.php';
	
	// ویجت بررسی سلامت افزونه ها در پیشخوان
	include plugin_dir_path(__FILE__) . 'modules/plugin-health.php';
	
	// ابرچسب شبکه نمایش در پیشخوان 
	include plugin_dir_path(__FILE__) . 'modules/cloud-tag.php';

	// ابردسته بندی های شبکه نمایش در پیشخوان
	include plugin_dir_path(__FILE__) . 'modules/cloud-cat.php';
				
	// نمایش رشد محتوای سایت ها در پیشخوان
	include plugin_dir_path(__FILE__) . 'modules/content-growth.php';
	
	// دفترچه یادداشت مختص به ادمین وردپرس هر شبکه
	include plugin_dir_path(__FILE__) . 'modules/notes-in-wpdash.php';
	
	// ویجت چک لیست انتشار محتوا در پنل پیشخوان سایت ها
	include plugin_dir_path(__FILE__) . 'modules/checklist-for-sites.php';
	
	// نمایش فایل های حجیم در بخش رسانه های هرسایت شبکه
	include plugin_dir_path(__FILE__) . 'modules/show-big-files-in-media-library-in-wpdash.php';
	
?>