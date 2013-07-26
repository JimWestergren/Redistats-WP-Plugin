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
<script type="text/javascript">

jQuery(document).ready(function()
{

	jQuery('#redistats_api_key').focusout(function()
	{
		var api_key = jQuery('#redistats_api_key').val();

		if( !api_key.match(/^[a-f0-9]{32}$/) )
			alert('The api key must be a md5 value');
	});
	
	jQuery('#redistats_user_id').focusout(function()
	{
		var user_id = jQuery('#redistats_user_id').val();

		if( !user_id.match(/^[0-9]+$/) )
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
			alert('The api key must be a md5 value');
	});
});

</script>

<div class="wrap">
	<h2>Redistats Plugin</h2>
	<br />
	<p>
		<strong>Instructions:</strong>
		<br />
		Nullam et turpis lectus. Vivamus tincidunt risus tempor leo tempus volutpat. Aliquam feugiat ullamcorper mauris, a pulvinar felis cursus in. Maecenas at consequat magna. Duis eget laoreet tellus. Donec vel nibh vitae erat pulvinar viverra. Suspendisse potenti. Vivamus ac neque quis sapien malesuada facilisis. Donec cursus, lectus ac iaculis dignissim, nulla justo congue purus, semper laoreet enim risus quis nulla. Vestibulum eget ante a est eleifend faucibus at et nisl. Nunc facilisis dignissim ligula ut tempor.
	</p>
	<br />
	<form id="form-redistats" method="post" action="options.php">
		<?php @settings_fields( 'redistats-group' ); ?>
		
		<?php @do_settings_fields( 'redistats-group' ); ?> 
		
		<?php //do_settings_sections( 'redistats' ); ?>
		
		<table class="form-table">
			<tr valign="top">
				<th scope="row">API Key:</th>
				<td>
					<input type="text" name="redistats_api_key" id="redistats_api_key" value="<?php echo get_option( 'redistats_api_key' ); ?>" required />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">User ID:</th>
				<td>
					<input type="text" name="redistats_user_id" id="redistats_user_id" value="<?php echo get_option( 'redistats_user_id' ); ?>" required />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">E-Mail:</th>
				<td>
					<input type="text" name="redistats_email" id="redistats_email" value="<?php echo get_option( 'redistats_email'); ?>" required />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Status:</th>
				<td>
					Active: <input type="radio" name="redistats_status" id="redistats_status" value="1" <?php echo (get_option( 'redistats_status') ? 'checked' : ''); ?> />
					Deactive: <input type="radio" name="redistats_status" id="redistats_status" value="0" <?php echo (!get_option( 'redistats_status') ? 'checked' : ''); ?> />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Verification code:</th>
				<td>
					<input type="text" name="redistats_verification" id="redistats_verification" value="<?php echo get_option( 'redistats_verification'); ?>" required />
				</td>
			</tr>
		</table>
		
		<?php @submit_button(); ?> 
	</form>
</div>