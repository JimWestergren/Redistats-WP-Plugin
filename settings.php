<?php
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
?>
<div class="wrap">
<?php screen_icon(); ?>
<h2>Redistats</h2>
	
	<ol>
		<li><a href="https://redistats.com/register">Register an account with Redistats</a> if you have not already done so.</li>
		<li>Select your global stat property in the <a href="https://redistats.com/dashboard">dashboard</a> (create one if you haven't).</li>
		<li>Scroll down on that page and fill in the corresponding values below:</li>
	</ol>
	<form id="form-redistats" method="post" action="options.php">
		<?php settings_fields('redistats-group'); ?>
		<?php do_settings_fields('redistats-group', 'redistats-section'); ?> 
				
		<table class="form-table">
			<tr valign="top">
				<th scope="row">API key:</th>
				<td><input type="text" name="redistats_api_key" id="redistats_api_key" value="<?php echo get_option( 'redistats_api_key' ); ?>" pattern="[0-9a-fA-F]{20,}$" required></td>
			</tr>
			<tr valign="top">
				<th scope="row">Global ID:</th>
				<td><input type="text" name="redistats_global_id" id="redistats_global_id" value="<?php echo get_option( 'redistats_global_id' ); ?>" pattern="[0-9]{1,}$" required></td>
			</tr>
			
			<?php if (!is_multisite()) { ?>
			<tr valign="top">
				<th scope="row">Property ID:</th>
				<td><input type="text" name="redistats_property_id" id="redistats_property_id" value="<?php echo get_option( 'redistats_property_id' ); ?>" pattern="[0-9]{1,}$" required></td>
			</tr>
			<?php } else { ?>
				<input type="hidden" name="redistats_property_id" id="redistats_property_id" value="">
			<?php } ?>
			<tr valign="top">
				<th scope="row">Email:</th>
				<td><input type="email" name="redistats_email" id="redistats_email" value="<?php echo get_option( 'redistats_email'); ?>" required></td>
			</tr>
			<tr valign="top">
				<th scope="row">Verification code:</th>
				<td><input type="text" name="redistats_verification" id="redistats_verification" value="<?php echo get_option( 'redistats_verification'); ?>" pattern="[0-9a-fA-F]{32}" required></td>
			</tr>
			<tr valign="top">
				<th scope="row">Status:</th>
				<td>
					<input type="radio" name="redistats_status" id="redistats_status" value="2" <?php echo (get_option( 'redistats_status') == 2 ? 'checked' : ''); ?>> Active tracking and button to view stats visible.<br>
					<?php if (is_multisite()) { ?><input type="radio" name="redistats_status" id="redistats_status" value="1" <?php echo (get_option( 'redistats_status') == 1 ? 'checked' : ''); ?>> Active tracking but button to view stats not yet visible.<br><?php } ?>	
					<input type="radio" name="redistats_status" id="redistats_status" value="0" <?php echo (get_option( 'redistats_status') == 0 ? 'checked' : ''); ?>> The plugin is deactivated.<br>
				</td>
			</tr>
		</table>
		
		<?php submit_button(); ?> 
	</form>
</div>