<?php
$wp_tripadv_url = get_option( 'wp_tripadv_url' );
?>
<div class="inside">
	<form action="#" method="post" id="wp_trip_setting">
		<?php wp_nonce_field( 'trip_nonce_action', 'trip_nonce_field' ); ?>
		<h3><?php _e('Settings', 'gmtrip'); ?></h3>
		<p><strong>WP Tripadvisor</strong> allow you to auto sync all review in your website. just you need to pass you bussiness url.</p>
		<p>Shortcode: <code>[wp_tripadvisor_review]</code></p>
		<table class="form-table">
			<tr>
				<th scope="row"><label><?php _e('TripAdvisor Business URL', 'gmtrip'); ?></label></th>
				<td>
					<input type="text" style="width:100%;" required value="<?php echo $wp_tripadv_url;?>" class="regular-text" name="wp_tripadv_url">
					<p class="description">
						<?php _e('Enter the TripAdvisor URL for your business and click Save Settings. Example:<br>
			https://www.tripadvisor.com/Restaurant_Review-g30620-d10262422-Reviews-Yellowhammer_Brewing-Huntsville_Alabama.html<br>', 'gmtrip'); ?>
			
					</p>
				</td>
			</tr>
			
		</table>
		<?php
		if(get_option( 'gmtri_next_url' )=='no_found'){
			?>
			<p class="description" style="color:green;">Tripadvisor Review Sync Done</p>
			<?php
		}else{
			?>
			<p class="description" style="color:red;">Tripadvisor Review Sync Working</p>
			<?php
		}
		?>
		
		
		<p class="submit">
			<input type="hidden" name="action" value="wp_trip_settings">
			<input type="submit" name="submit"  class="button button-primary" value="Save">
		</p>
	</form>
</div>