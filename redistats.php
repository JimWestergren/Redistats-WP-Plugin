<?php
/*
Plugin Name: Redistats
Plugin URI: https://redistats.com/wordpress-plugin 
Description: Web stats especially made for WordPress Multisite with a large number of blogs but also works on a single blog. No additional load on your server.
Version: 0.1
Author: TodaysWeb (Jim Westergren)
Author URI: http://www.todaysweb.com/
License: GPL2
*/

/*  Copyright 2013 TodaysWeb Ltda. (www.todaysweb.com)
	License: http://www.gnu.org/licenses/gpl-2.0.html
*/

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

if(is_multisite()) {
	$hook_prefix = 'network_';
	add_action('_network_admin_menu', 'redistats' );
	add_action('_admin_menu', 'redistats' );
} else {
	$hook_prefix = '';
	add_action('_admin_menu', 'redistats' );
}

if (is_multisite()) {
	function message_proceed_to_install() {
		echo('<div class="updated"><p>Redistats: To finish the installation enter the settings <a href="admin.php?page=redistats/settings.php">here</a>.</p></div>');
	}
	function redistats_settings() {
		add_menu_page('Redistats settings', 'Redistats', 'activate_plugins', WP_PLUGIN_DIR."/redistats/settings.php", '', 'http://staticjw.com/images/stats.png', 110);
	}
} else {
	function message_proceed_to_install() {
		echo('<div class="updated"><p>Redistats: To finish the installation enter the settings <a href="options-general.php?page=redistats/settings.php">here</a>.</p></div>');
	}
	function redistats_settings() {
		add_options_page('Redistats settings', 'Redistats', 'manage_options', WP_PLUGIN_DIR."/redistats/settings.php");
	}
}

function redistats_button() {
	if (is_multisite()) {
		$button_name = 'Stats';
	} else {
		$button_name = 'Redistats';
	}
	add_menu_page('Stats', $button_name, 'add_users', WP_PLUGIN_DIR."/redistats/view.php", '', 'http://staticjw.com/images/stats.png', 110);
}

function redistats_tracking() {
	if (is_multisite()) {
		$property_id = get_current_blog_id();
	} else {
		$property_id = get_site_option('redistats_property_id');
	}
	echo "
<script>
(function() { // Redistats, track version 1.0
	var global_id = ".get_site_option('redistats_global_id').";
	var property_id = ".$property_id.";
	var url = encodeURIComponent(window.location.href.split('#')[0]);
	var referrer = encodeURIComponent(document.referrer);
	var x = document.createElement('script'), s = document.getElementsByTagName('script')[0];
	x.src = '//redistats.com/track.js?gid='+global_id+'&pid='+property_id+'&url='+url+'&referrer='+referrer;
	s.parentNode.insertBefore(x, s);
  })();
</script>";
}

function redistats() {
	global $hook_prefix;
	if (!isset($_GET['page'])){
		$_GET['page'] = 0;
	}
	if (is_super_admin() && $_GET['page'] != 'redistats/settings.php' && get_site_option('redistats_verification') == '') {
		add_action($hook_prefix.'admin_notices', 'message_proceed_to_install');
	} else if(get_site_option('redistats_status') > 1) {
		add_action('admin_menu', 'redistats_button');
	}
	if(is_super_admin()) {
		add_action($hook_prefix.'admin_menu', 'redistats_settings');
	}	
}

if(get_site_option('redistats_status') > 0 && !is_preview()) {
	add_action('wp_footer', 'redistats_tracking');
}


?>