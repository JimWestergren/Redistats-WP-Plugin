<?php
/*
Plugin Name: Redistats - Multisite stats
Plugin URI: https://redistats.com/wordpress-plugin 
Description: Web stats especially made for WordPress Multisite with a large number of blogs but also works on a single blog. No additional load on your server.
Version: 0.3
Author: TodaysWeb (Jim Westergren)
Author URI: http://www.todaysweb.com/
License: GPL2
*/

/*  Copyright 2013 TodaysWeb Ltda. (www.todaysweb.com)
	License: http://www.gnu.org/licenses/gpl-2.0.html
*/

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/* We have to use different hooks and functions with multisite.
The redistats function is calling actions to the admin_menu hook but does not work if the function itself is also called in the same hook. The solution is to use an earlier hook but any hook more earlier than _admin_menu which is just before triggers internal permission error in WordPress. We had to use trial and error to find this out. */
if(is_multisite()) {
	$hook_prefix = 'network_';
	add_action('_network_admin_menu', 'redistats' );
	// We also have to use _admin_menu for the stat button of the normal users
	add_action('_admin_menu', 'redistats' ); 
	
	// Admin message, shown if plugin activated but settings not entered
	function redistats_message_install() {
		echo('<div class="updated"><p>Redistats: To finish the installation enter the settings <a href="admin.php?page=redistats/settings.php">here</a>.</p></div>');
	}
	
	// Button to the redistats settings
	function redistats_settings() {
		add_menu_page('Redistats settings', 'Redistats', 'activate_plugins', WP_PLUGIN_DIR."/redistats/settings.php", '', plugins_url('redistats/icon.png'), 110);
	}
} else {
	$hook_prefix = '';
	add_action('_admin_menu', 'redistats' );
	
	// Admin message, shown if plugin activated but settings not entered
	function redistats_message_install() {
		echo('<div class="updated"><p>Redistats: To finish the installation enter the settings <a href="options-general.php?page=redistats/settings.php">here</a>.</p></div>');
	}
	
	// Link added to redistats settings in the options
	function redistats_settings() {
		add_options_page('Redistats settings', 'Redistats', 'manage_options', WP_PLUGIN_DIR."/redistats/settings.php");
	}
}

// This is the button in the admin to view the stats
function redistats_button() {
	if (is_multisite()) {
		// No branding for the users
		$button_name = 'Stats';
	} else {
		$button_name = 'Redistats';
	}
	add_menu_page('Stats', $button_name, 'add_users', WP_PLUGIN_DIR.'/redistats/view.php', '', plugins_url('redistats/icon.png'), 110);
}

// Function for outputting the tracking script
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

// This is the main function that gets called in the hooks at the top
function redistats() {
	global $hook_prefix;
	
	// Just to prevent notice error in PHP
	if (!isset($_GET['page'])){
		$_GET['page'] = 0;
	}
	
	// Display admin message with a link to the settings for installation of not done already
	if (is_super_admin() && $_GET['page'] != 'redistats/settings.php' && get_site_option('redistats_verification') == '') {
		add_action($hook_prefix.'admin_notices', 'redistats_message_install');
		
	// Show a button to view the stats if it has this status
	} else if(get_site_option('redistats_status') > 1) {
		add_action('admin_menu', 'redistats_button');
	}
	
	// Show a button/link to the settings for the super admin
	if(is_super_admin()) {
		add_action($hook_prefix.'admin_menu', 'redistats_settings');
	}	
}

// Output the tracking script in the footer of all blogs
if(get_site_option('redistats_status') > 0 && !is_preview() && !isset($_GET['preview'])) {
	add_action('wp_footer', 'redistats_tracking');
}


?>