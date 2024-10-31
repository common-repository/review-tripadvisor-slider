<div class="inside">
	<form action="#" method="post" id="wp_custom_trip_setting">
		<?php wp_nonce_field( 'custom_review_trip_nonce_action', 'custom_review_trip_nonce_field' ); ?>
		<h3><?php _e('Add Custom Review', 'gmtrip'); ?></h3>
		
		<table class="form-table">
			<tr>
				<th scope="row"><label><?php _e('Profile Image URL', 'gmtrip'); ?></label></th>
				<td>
					<input type="text" style="width:100%;" required  class="regular-text" name="userimage">
				</td>
			</tr>
			<tr>
				<th scope="row"><label><?php _e('Review Name', 'gmtrip'); ?></label></th>
				<td>
					<input type="text" style="width:100%;" required  class="regular-text" name="reviewer_name">
				</td>
			</tr>
			<tr>
				<th scope="row"><label><?php _e('Rating', 'gmtrip'); ?></label></th>
				<td>
					<input type="number" style="width:100%;" required max="5"  class="regular-text" name="rating">
				</td>
			</tr>
			<tr>
				<th scope="row"><label><?php _e('Review Text', 'gmtrip'); ?></label></th>
				<td>
					<textarea name="rtext"  style="width:100%;" required></textarea>
					
				</td>
			</tr>
			
		</table>
		
		
		
		<p class="submit">
			<input type="hidden" name="action" value="wp_add_custom_review">
			<input type="submit" name="submit"  class="button button-primary" value="Add Review">
		</p>
	</form>
</div>