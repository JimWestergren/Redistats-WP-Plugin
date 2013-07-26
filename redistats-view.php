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
?>
<div class="wrapp">
	<h2>
		<img alt="" src="<?=plugins_url('redistats/images/logo.png');?>" style="margin-right: 10px; vertical-align: middle;" /> 
	</h2>
	
	<div id="redistats-iframe" style="height: 540px; position: absolute; width: 100%;">	
	<table style="width: 100%; height: 100%">
        <tr>
            <td valign="top" align="left" height="100%">
            
		<iframe id="myFrame" src="http://redistats.com/results?uid=<?=get_option( 'redistats_global_id' );?>&pid=<?=get_current_blog_id();?>&hash=<?=md5( get_option( 'redistats_global_id' ) . get_current_blog_id() . get_option( 'redistats_api_key' ));?>" style="height: 100%; width: 100%;">Browser not compatible.</iframe>
		
			</td>
		</tr>
	</table>
	</div>
</div>