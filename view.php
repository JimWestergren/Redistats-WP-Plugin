<?php
/*  Copyright 2013 TodaysWeb Ltda. (www.todaysweb.com)
	License: http://www.gnu.org/licenses/gpl-2.0.html
*/
define('REDISTATS_VERIFICATION_SALT', 'sdfdd_!dfggjdFGjsfhk736786suhcSDFSDG', true);

if (get_site_option('redistats_verification') != md5(get_site_option('redistats_global_id').get_site_option('redistats_email').get_site_option('redistats_api_key').REDISTATS_VERIFICATION_SALT)) {

	echo "<h3 style=\"color:red\">Error in the stats settings.</h3>";
	
} else { 

	if (is_multisite()) {
		$property_id = get_current_blog_id();
	} else {
		$property_id = get_site_option('redistats_property_id');
	}

	$iframe_url = "https://redistats.com/stats?gid=".get_site_option( 'redistats_global_id' )."&pid=".$property_id."&hash=".md5(get_site_option('redistats_global_id').$property_id.get_site_option( 'redistats_api_key'));
	
	echo "<iframe src=\"".$iframe_url."\" style=\"width:100%;height:4000px;\" frameborder=\"0\" seamless></iframe>";
}
?>