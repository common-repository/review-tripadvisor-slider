<?php

/**
 * This class is loaded on the front-end since its main job is 
 * to display the Admin to box.
 */
register_activation_hook(__FILE__, 'gmtrip_activation');

function gmtrip_isa_add_cron_recurrence_interval( $schedules ) {
 
    
 
    $schedules['every_fifteen_minutes'] = array(
            'interval'  => 900,
            'display'   => __( 'Every 15 Minutes', 'textdomain' )
    );  
     
    return $schedules;
}
add_filter( 'cron_schedules', 'gmtrip_isa_add_cron_recurrence_interval' );


function gmtrip_activation() {
	
    if (! wp_next_scheduled ( 'gmtrip_daily_event' )) {
			wp_schedule_event(time(), 'every_fifteen_minutes', 'gmtrip_daily_event');
	}
}
add_action('gmtrip_daily_event', 'gmtrip_daily_event');

function gmtrip_daily_event() {

	//require_once plugin_dir_path( __FILE__ ) . 'admin/class-wp-tripadvisor-review-slider-admin.php';
	//$plugin_admin = new GMTRI_Admin(  );
	global $gmtri_admin;
	$wp_tripadv_url = get_option( 'gmtri_next_url' );
	if($wp_tripadv_url!='no_found'){
		$my_array = array($wp_tripadv_url);
		$gmtri_admin->GMTRI_download_scrap($my_array);
	}
	
	
}

add_action('init', 'gmtrip_default');
function gmtrip_default(){
	$defalarr = array(
		'gm_layout' => 'slider',
		'gm_column' => '3',
		'gm_per_page' => '9',
		'gm_background_color' => '#bd986b',
		'gm_item_background_color' => '#fff',
		'gm_reviewtext_color' => '#777',
		'gm_usertext_color' => '#fff',
		'gm_datetext_color' => '#ffd9b8',
		'gm_limit_for_readmore' => '150',
	);
	foreach ($defalarr as $keya => $valuea) {
		if (get_option( $keya )=='') {
			update_option( $keya, sanitize_text_field($valuea) );
		}
		
	}
}

?>