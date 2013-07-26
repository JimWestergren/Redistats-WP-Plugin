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
<script>
jQuery(document).ready(function()
{

	jQuery('#redistats_api_key').focusout(function()
	{
		var api_key = jQuery('#redistats_api_key').val();

		if( !api_key.match(/^[a-f0-9]$/) )
			alert('The api key can only be with characters a-f and 0-9');
	});
	
	jQuery('#redistats_global_id').focusout(function()
	{
		var global_id = jQuery('#redistats_global_id').val();

		if( !global_id.match(/^[0-9]+$/) )
			alert('The user id must be a integer');
	});
	
	jQuery('#redistats_email').focusout(function()
	{
		var email = jQuery('#redistats_email').val();

		if( !email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/) )
			alert('The email is not valid.');
	});

	jQuery('#redistats_verification').focusout(function()
	{
		var api_key = jQuery('#redistats_verification').val();

		if( !api_key.match(/^[a-f0-9]{32}$/) )
			alert('The verification code must be a md5 value');
	});
});

</script>

<div class="wrap">
	<h2>Redistats WP Plugin</h2>
	<?php screen_icon(); ?>
	<ol>
		<li><a href="https://redistats.com/register">Register an account with Redistats</a> if you have not already done so.</li>
		<li>Select your global stat property in the <a href="https://redistats.com/dashboard">dashboard</a> (create one if you haven't).</li>
		<li>Scroll down on that page and fill in the corresponding values below:</li>
	</ol>
	<form id="form-redistats" method="post" action="options.php">
		<?php settings_fields('redistats-group'); ?>
		<?php do_settings_fields('redistats-group'); ?> 
				
		<table class="form-table">
			<tr valign="top">
				<th scope="row">API key:</th>
				<td><input type="text" name="redistats_api_key" id="redistats_api_key" value="<?php echo get_option( 'redistats_api_key' ); ?>" pattern="[0-9a-fA-F]" required></td>
			</tr>
			<tr valign="top">
				<th scope="row">Global ID:</th>
				<td><input type="text" name="redistats_global_id" id="redistats_global_id" value="<?php echo get_option( 'redistats_global_id' ); ?>" pattern="[0-9]" required></td>
			</tr>
			
			<?php if (!is_multisite()) { ?>
			<tr valign="top">
				<th scope="row">Property ID:</th>
				<td><input type="text" name="redistats_property_id" id="redistats_property_id" value="<?php echo get_option( 'redistats_property_id' ); ?>" pattern="[0-9]" required></td>
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
					Active tracking and button to view stats visible: <input type="radio" name="redistats_status" id="redistats_status" value="2" <?php echo (get_option( 'redistats_status') == 2 ? 'checked' : ''); ?>><br>
					Active tracking but button to view stats not yet visible: <input type="radio" name="redistats_status" id="redistats_status" value="1" <?php echo (get_option( 'redistats_status') == 1 ? 'checked' : ''); ?>><br>
					The plugin is deactivated: <input type="radio" name="redistats_status" id="redistats_status" value="0" <?php echo (get_option( 'redistats_status') == 0 ? 'checked' : ''); ?>><br>
				</td>
			</tr>
		</table>
		
		<?php submit_button(); ?> 
	</form>
</div>