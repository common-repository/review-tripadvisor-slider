<?php
$gm_layout = get_option( 'gm_layout' );
$gm_column = get_option( 'gm_column' );
$gm_per_page = get_option( 'gm_per_page' );
$gm_background_color = get_option( 'gm_background_color' );
$gm_item_background_color = get_option( 'gm_item_background_color' );
$gm_reviewtext_color = get_option( 'gm_reviewtext_color' );
$gm_usertext_color = get_option( 'gm_usertext_color' );
$gm_datetext_color = get_option( 'gm_datetext_color' );
$gm_limit_for_readmore = get_option( 'gm_limit_for_readmore' );
?>
<div class="inside">
    <form action="#" method="post" id="wp_trip_layout">
        <?php wp_nonce_field( 'trip_nonce_action_layout', 'trip_nonce_field_layout' ); ?>
        <h3><?php _e('Settings', 'gmtrip'); ?></h3>
       
        <table class="form-table">
            <tr>
                <th scope="row"><label><?php _e('Layout', 'gmtrip'); ?></label></th>
                <td>
                   <input type="radio" name="gmlayotarr[gm_layout]" <?php echo ($gm_layout=='slider')?'checked':''; ?> value="slider"><?php _e('Slider', 'gmtrip'); ?>
                  <input type="radio" name="gmlayotarr[gm_layout]" <?php echo ($gm_layout=='grid')?'checked':''; ?> value="grid"><?php _e('Grid', 'gmtrip'); ?> 
                   <input type="radio" name="gmlayotarr[gm_layout]" <?php echo ($gm_layout=='mansory')?'checked':''; ?> value="mansory"><?php _e('Mansory', 'gmtrip'); ?> 
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php _e('Column', 'gmtrip'); ?></label></th>
                <td>
                   <input type="number" name="gmlayotarr[gm_column]" value="<?php echo $gm_column; ?>">
                   <p class="description">
                        <?php _e('Default will be take <strong>3 Column</strong>', 'gmtrip'); ?>
            
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php _e('Number Of Item Show', 'gmtrip'); ?></label></th>
                <td>
                   <input type="number" name="gmlayotarr[gm_per_page]" value="<?php echo $gm_per_page; ?>">
                   <p class="description">
                        <?php _e('Default will be take <strong>9 Number Of Item Show</strong>', 'gmtrip'); ?>
            
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php _e('Character Limit For Read More', 'gmtrip'); ?></label></th>
                <td>
                   <input type="number" disabled name="gmlayotarr[gm_limit_for_readmore]" value="<?php echo $gm_limit_for_readmore; ?>">
                   <p class="description">
                        <?php _e('Default will be take <strong>150 Character limit</strong>', 'gmtrip'); ?>
            
                    </p>
                    <a href="https://www.codesmade.com/store/review-slider-for-tripadvisor-pro/" target="_blank">Get Pro</a>
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php _e('Background Color', 'gmtrip'); ?></label></th>
                <td>
                   <input type="text" disabled class="gm-color-field" name="gmlayotarr[gm_background_color]" value="<?php echo $gm_background_color; ?>">
                   <p class="description">
                        <?php _e('Enter Color Like <strong>#bd986b</strong>. Default will be take <strong>#bd986b</strong>', 'gmtrip'); ?>
                    </p>
                    <a href="https://www.codesmade.com/store/review-slider-for-tripadvisor-pro/" target="_blank">Get Pro</a>
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php _e('Item Background Color', 'gmtrip'); ?></label></th>
                <td>
                   <input type="text" disabled class="gm-color-field" name="gmlayotarr[gm_item_background_color]" value="<?php echo $gm_item_background_color; ?>">
                   <p class="description">
                        <?php _e('Enter Color Like <strong>#fff</strong>. Default will be take <strong>#fff</strong>', 'gmtrip'); ?>
                    </p>
                    <a href="https://www.codesmade.com/store/review-slider-for-tripadvisor-pro/" target="_blank">Get Pro</a>
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php _e('Review Text Color', 'gmtrip'); ?></label></th>
                <td>
                   <input type="text" disabled class="gm-color-field" name="gmlayotarr[gm_reviewtext_color]" value="<?php echo $gm_reviewtext_color; ?>">
                   <p class="description">
                        <?php _e('Enter Color Like <strong>#777</strong>. Default will be take <strong>#777</strong>', 'gmtrip'); ?>
                    </p>
                    <a href="https://www.codesmade.com/store/review-slider-for-tripadvisor-pro/" target="_blank">Get Pro</a>
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php _e('Review Users Text Color', 'gmtrip'); ?></label></th>
                <td>
                   <input type="text" disabled class="gm-color-field" name="gmlayotarr[gm_usertext_color]" value="<?php echo $gm_usertext_color; ?>">
                   <p class="description">
                        <?php _e('Enter Color Like <strong>#fff</strong>. Default will be take <strong>#fff</strong>', 'gmtrip'); ?>
                    </p>
                    <a href="https://www.codesmade.com/store/review-slider-for-tripadvisor-pro/" target="_blank">Get Pro</a>
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php _e('Review Date Text Color', 'gmtrip'); ?></label></th>
                <td>
                   <input type="text" disabled  class="gm-color-field" name="gmlayotarr[gm_datetext_color]" value="<?php echo $gm_datetext_color; ?>">
                   <p class="description">
                        <?php _e('Enter Color Like <strong>#ffd9b8</strong>. Default will be take <strong>#ffd9b8</strong>', 'gmtrip'); ?>
                    </p>
                    <a href="https://www.codesmade.com/store/review-slider-for-tripadvisor-pro/" target="_blank">Get Pro</a>
                </td>
            </tr>
            
        </table>
        
        <p class="submit">
            <input type="hidden" name="action" value="wp_trip_layout">
            <input type="submit" name="submit"  class="button button-primary" value="Save">
        </p>
    </form>
</div>