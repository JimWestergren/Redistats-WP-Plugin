<?php
/*  Copyright 2013 TodaysWeb Ltda. (www.todaysweb.com, email: support@redistats.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

	Full license: http://www.gnu.org/licenses/gpl-2.0.html
*/
if (is_multisite()) {
	$property_id = get_current_blog_id();
} else {
	$property_id = get_option('redistats_property_id');
}

$iframe_url = "https://redistats.com/stats?gid=".get_option( 'redistats_global_id' )."&pid=".$property_id."&hash=".md5(get_option('redistats_global_id').$property_id.get_option( 'redistats_api_key'));
?>
<iframe src="<?php echo $iframe_url ?>" style="width:100%;height:4000px;" frameborder="0" seamless></iframe>
