<?php
/*
Plugin Name: Redistats WP Plugin
Plugin URI: https://redistats.com/wordpress-plugin 
Description: A brief description of the Plugin.
Version: 0.1
Author: TodaysWeb Ltda. (Nestor Otondo, Jim Westergren)
Author URI: http://www.todaysweb.com/
License: GPL2
*/

/*  Copyright 2013 TodaysWeb Ltda. (www.todaysweb.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

	Full license: http://www.gnu.org/licenses/gpl-2.0.html
*/

define('VERIFICATION_SALT', 'sdfdd_!dfggjdFGjsfhk736786suhcSDFSDG', true);

if(!class_exists('Redistats')) {
	class Redistats {
		public function __construct() {
			// register actions
			add_action('admin_init', array(&$this, 'admin_init'));
			add_action('admin_menu', array(&$this, 'add_menu'));
		}

		public static function activate() {
			// Do nothing
		}
		
		public static function deactivate() {
			// Do nothing
		}
		
		public function admin_init() {
			$this->init_settings();
		}
		
		public function init_settings() {
			register_setting('redistats-group', 'redistats_api_key');
			register_setting('redistats-group', 'redistats_user_id');
			register_setting('redistats-group', 'redistats_email', 'is_email');
			register_setting('redistats-group', 'redistats_status');
			register_setting('redistats-group', 'redistats_verification');
			
			add_settings_section('redistats-section', 'Redistats Settings',	array(&$this, 'section_callback'), 'redistats');
			
			add_settings_field('redistats_api_key', 'API Key:', array(&$this, 'field_callback'), 'redistats', 'redistats-section', array('field' => 'redistats_api_key'));
			
			add_settings_field('redistats_user_id', 'User ID:', array(&$this, 'field_callback'), 'redistats', 'redistats-section',	array('field' => 'redistats_user_id'));
			
			add_settings_field('redistats_email', 'E-Mail:', array(&$this, 'field_callback'), 'redistats',	'redistats-section',array('field' => 'redistats_email'));
			
			add_settings_field('redistats_status', 'Status: ', array(&$this, 'field_callback'), 'redistats', 'redistats-section',array('field' => 'redistats_status'));
			
			add_settings_field('redistats_verification', 'Verification code: ', array(&$this, 'field_callback'), 'redistats', 'redistats-section',array('field' => 'redistats_verification'));
			
		}
		
		public function section_callback() {
			echo 'Settings for the Redistats plugin.';
		}
		
		public function field_callback($args) {
			$field = $args['field'];
			$value = get_option($field);
			echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
		}
		
		public function add_menu() {
			if(is_super_admin()) {
				add_options_page('Redistats Settings', 'Redistats', 'manage_options', 'redistats', array(&$this, 'plugin_settings_page'));
			}
		}
		
		public function plugin_settings_page() { 
			if(!current_user_can('manage_options')) {
				wp_die( __( 'You do not have sufficient permissions to access this page.'));
			}
			include(sprintf("%s/settings.php", dirname(__FILE__)));
		}
	}
}

function redistats_show_message($message, $errormsg = false) {
	if($errormsg) {
		echo '<div id="message" class="error">';
	} else {
		echo '<div id="message" class="updated fade"><strong>'.$message.'</strong></div>';
	}
}

function show_no_valid_messages() {
	redistats_show_message('Your parameters are incorrect. Please check it.', true);
}

if(class_exists('Redistats')) { 
	
	require (ABSPATH.WPINC.'/pluggable.php');
		
	wp_get_current_user();
		
	register_activation_hook(__FILE__, array('Redistats', 'activate'));
	register_deactivation_hook(__FILE__, array('Redistats', 'deactivate'));
	
	$redistats = new Redistats();
		
	if (isset($redistats)) {
			
		function register_redistats_admin() {
			add_menu_page('Redistats admin', 'Redistats', 'add_users', 'redistats/redistats-view.php', '', plugins_url('redistats/images/icon.png'), 110);
		}
			
		add_action('admin_menu', 'register_redistats_admin');
		
		if (get_option('redistats_verification') != md5(get_option('redistats_user_id').get_option('redistats_email').get_option('redistats_api_key').VERIFICATION_SALT)) {
			add_action('admin_notices', 'show_no_valid_messages');
		} else {
			function your_redistats() {
				echo "
					<script>
					(function() { 
					    var redistats_uid = " . get_option( 'redistats_user_id' ) . "; 
					    var redistats_pid = " . get_current_blog_id() . "; 
					    var x = document.createElement('script'), s = document.getElementsByTagName('script')[0]; 
					    x.src = 'http://redistats.com/track.js?uid='+redistats_uid+'&pid='+redistats_pid+'&title='+document.title+'&referrer='+document.referrer; 
					    s.parentNode.insertBefore(x, s); 
					})(); 
					</script>
				";
			}
				
			if(get_option('redistats_status')) {
				add_action('wp_footer', 'your_redistats');
			}
		}
	}
}

?>