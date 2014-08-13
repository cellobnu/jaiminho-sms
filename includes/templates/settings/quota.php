<div class="wrap">
	<h2 class="nav-tab-wrapper">
		<a href="?page=jaiminho-sms/setting" class="nav-tab<?php if($_GET['tab'] == '') { echo " nav-tab-active";} ?>"><?php _e('General', 'wp-sms'); ?></a>
		<a href="?page=jaiminho-sms/setting&tab=web-service" class="nav-tab<?php if($_GET['tab'] == 'web-service') { echo " nav-tab-active"; } ?>"><?php _e('Web Service', 'wp-sms'); ?></a>
		<a href="?page=jaiminho-sms/setting&tab=newsletter" class="nav-tab<?php if($_GET['tab'] == 'newsletter') { echo " nav-tab-active"; } ?>"><?php _e('Newsletter', 'wp-sms'); ?></a>
		<a href="?page=jaiminho-sms/setting&tab=features" class="nav-tab<?php if($_GET['tab'] == 'features') { echo " nav-tab-active"; } ?>"><?php _e('Features', 'wp-sms'); ?></a>
		<a href="?page=jaiminho-sms/setting&tab=notification" class="nav-tab<?php if($_GET['tab'] == 'notification') { echo " nav-tab-active"; } ?>"><?php _e('Notification', 'wp-sms'); ?></a>
		<a href="?page=jaiminho-sms/setting&tab=quota" class="nav-tab<?php if($_GET['tab'] == 'quota') { echo " nav-tab-active"; } ?>"><?php _e('Quota', 'wp-sms'); ?></a>
	</h2>

	<table class="form-table">
		<form method="post" action="options.php" name="form">
			<?php wp_nonce_field('update-options');?>
			<tr>
				<th><?php _e('Current blog quota', 'wp-sms'); ?></th>
				<td>
					<span><?php printf('%s SMS', get_option('wpsms_quota')); ?></span>
				</td>
			</tr>

			<tr>
				<th><?php _e('Add to quota', 'wp-sms'); ?></th>
				<td>
					<input type="text" dir="ltr" style="width: 200px;" name="wpsms_quota" value="0"/>
				</td>
			</tr>

			<tr>
				<td>
					<p class="submit">
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="page_options" value="wpsms_quota" />
						<input type="submit" class="button-primary" name="Submit" value="<?php _e('Update', 'wp-sms'); ?>" />
					</p>
				</td>
			</tr>
		</form>
	</table>
</div>
