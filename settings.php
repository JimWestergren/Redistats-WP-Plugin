<?php
/*  Copyright 2013 TodaysWeb Ltda. (www.todaysweb.com)
	License: http://www.gnu.org/licenses/gpl-2.0.html
*/
?>
<div class="wrap">
<?php screen_icon('options-general'); ?>
<h2>Redistats</h2>
	<?php
	
	// Block if it is not admin
	if(!is_super_admin()) {
		echo "<h3 style=\"color:red\">Error: Only admins can reach this page.</h3>";
		die();
	}
	
	// Encourage multisite to have the correct settings
	if ( is_plugin_active_for_network( 'redistats/redistats.php' ) ) {
		$network_activated = '<strong>Yes</strong>';
	} else {
		$network_activated = '<strong>No</strong> (change this <a href="/wp-admin/network/plugins.php">here</a>)';	
	}
	define('REDISTATS_VERIFICATION_SALT', 'sdfdd_!dfggjdFGjsfhk736786suhcSDFSDG', true);
	
	// Validation of post data
	if (isset($_POST['update_redistats_settings'])) {
		$_POST['redistats_email'] = strtolower(trim($_POST['redistats_email']));
		if (!preg_match('/^[a-f0-9]{32}$/', $_POST['redistats_verification'])) {
			echo '<div id="message" class="error"><p><strong>Verification code is wrong.</strong></p></div>';
		} else if (!is_numeric($_POST['redistats_global_id'])) {
			echo '<div id="message" class="error"><p><strong>Global ID is not a number.</strong></p></div>';
		} else if (!is_multisite() && !is_numeric($_POST['redistats_property_id'])) {
			echo '<div id="message" class="error"><p><strong>Property ID is not a number.</strong></p></div>';
		} else if (is_multisite() && $_POST['redistats_property_id'] != '') {
			echo '<div id="message" class="error"><p><strong>Property ID must be empty in case of multisite.</strong></p></div>';
		} else if (!is_email($_POST['redistats_email'])) {
			echo '<div id="message" class="error"><p><strong>Invalid email.</strong></p></div>';
		} else if (!is_numeric($_POST['redistats_status'])) {
			echo '<div id="message" class="error"><p><strong>Status is not a number.</strong></p></div>';
		} else if ($_POST['redistats_verification'] != md5($_POST['redistats_global_id'].$_POST['redistats_email'].$_POST['redistats_api_key'].REDISTATS_VERIFICATION_SALT)){
			echo '<div id="message" class="error"><p><strong>Verification code does not correspond to the values. Either the code or the values are wrong.</strong></p></div>';
		} else {
			// Ok, all good. Let's insert/update the database.
			if (get_site_option('redistats_api_key') != '') {
				update_site_option('redistats_api_key', $_POST['redistats_api_key']);
				update_site_option('redistats_global_id', $_POST['redistats_global_id']);
				update_site_option('redistats_property_id', $_POST['redistats_property_id']);
				update_site_option('redistats_email', $_POST['redistats_email']);
				update_site_option('redistats_verification', $_POST['redistats_verification']);
				update_site_option('redistats_status', $_POST['redistats_status']);			
			} else {
				add_site_option('redistats_api_key', $_POST['redistats_api_key']);
				add_site_option('redistats_global_id', $_POST['redistats_global_id']);
				add_site_option('redistats_property_id', $_POST['redistats_property_id']);
				add_site_option('redistats_email', $_POST['redistats_email']);
				add_site_option('redistats_verification', $_POST['redistats_verification']);
				add_site_option('redistats_status', $_POST['redistats_status']);						
			}
			echo '<div id="message" class="updated fade"><p><strong>Redistats settings saved</strong></p></div>';
		}
	}
	?>
	<p>Notice: These settings will be saved in one place using site_option and the settings are the same for all blogs on this installation (Multisite). Stats data are stored on Redistats.com servers.</p>
	<ol>
		<li><a href="https://redistats.com/register">Register an account with Redistats</a> if you have not already done so.</li>
		<li>Select your global stat property in the <a href="https://redistats.com/dashboard">dashboard</a> (create one if you haven't). If you are using multisite then you should not mix with other stat properties but have a seperate global stat property for this installation.</li>
		<li>Scroll down on that page and fill in the corresponding values below:</li>
	</ol>
		<form method="post" action="">
			
		<table class="form-table">
			<?php if (is_multisite()) { ?>
			<tr valign="top">
				<th scope="row">Plugin is network activated (multisite):</th>
				<td><?php echo $network_activated; ?></td>
			</tr>
			<?php } ?>
			<tr valign="top">
				<th scope="row">Redistats API key:</th>
				<td><input type="text" name="redistats_api_key" value="<?php echo get_site_option( 'redistats_api_key' ); ?>" pattern="[0-9a-fA-F]{20,}$" required></td>
			</tr>
			<tr valign="top">
				<th scope="row">Global ID:</th>
				<td><input type="text" name="redistats_global_id" value="<?php echo get_site_option( 'redistats_global_id' ); ?>" pattern="[0-9]{1,}$" required></td>
			</tr>
			
			<?php if (!is_multisite()) { ?>
			<tr valign="top">
				<th scope="row">Property ID (choose a number not already used):</th>
				<td><input type="text" name="redistats_property_id" value="<?php echo get_site_option( 'redistats_property_id' ); ?>" pattern="[0-9]{1,}$" required></td>
			</tr>
			<?php } else { ?>
				<input type="hidden" name="redistats_property_id" value="">
			<?php } ?>
			<tr valign="top">
				<th scope="row">Redistats account email:</th>
				<td><input type="email" name="redistats_email" value="<?php echo get_site_option( 'redistats_email'); ?>" required></td>
			</tr>
			<tr valign="top">
				<th scope="row">Verification code:</th>
				<td><input type="text" name="redistats_verification" value="<?php echo get_site_option( 'redistats_verification'); ?>" pattern="[0-9a-fA-F]{32}" required></td>
			</tr>
			<tr valign="top">
				<th scope="row">Status:</th>
				<td>
					<input type="radio" name="redistats_status" value="2" <?php echo (get_site_option( 'redistats_status') == 2 ? 'checked' : ''); ?>> Active tracking and button to view stats visible.<br>
					<?php if (is_multisite()) { ?><input type="radio" name="redistats_status" value="1" <?php echo (get_site_option( 'redistats_status') == 1 ? 'checked' : ''); ?>> Active tracking but button to view stats on the admin of all blogs not yet visible. (can be seen on redistats.com meanwhile)<br><?php } ?>	
					<input type="radio" name="redistats_status" value="0" <?php echo (get_site_option( 'redistats_status') == 0 ? 'checked' : ''); ?>> The plugin is deactivated.<br>
				</td>
			</tr>
		</table>
		
		<input type="submit" class="button-primary" name="update_redistats_settings" value="Save Settings">
	</form>
	
	<?php if (is_numeric(get_site_option('redistats_global_id'))) {
		// Add some useful info if already installed
		echo "<p style=\"margin-top:30px;font-size:20px;\">Your stats can also be viewed on Redistats <a href=\"https://redistats.com/dashboard?gid=".get_site_option('redistats_global_id')."\">here</a> (global stats <a href=\"https://redistats.com/dashboard?gid=".get_site_option('redistats_global_id')."&pid=0\">here</a>)</p>";
		echo "<p style=\"margin-top:10px;font-size:18px;\">For feedback and support please contact: support@redistats.com</p>";
	} ?>
</div>