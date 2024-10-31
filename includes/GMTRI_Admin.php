<?php

/**
 * This class is loaded on the back-end since its main job is 
 * to display the Admin to box.
 */

class GMTRI_Admin {
	
	public function __construct () {

		add_action( 'init', array( $this, 'GMTRI_init' ) );
		add_action( 'admin_menu', array( $this, 'GMTRI_admin_menu' ) );
		add_action('admin_enqueue_scripts', array( $this, 'GMTRI_admin_script' ));
		if ( is_admin() ) {
			return;
		}
		
	}

	public function GMTRI_admin_script () {
		//wp_enqueue_style('gmtri_admin_css', GMTRIP_PLUGINURL.'css/admin-style.css');
		wp_enqueue_script( 'wp-color-picker' ); 
		wp_enqueue_script('gmtri_admin_js', GMTRIP_PLUGINURL.'js/admin-script.js');
	}

	public function GMTRI_init () {

		$args = array(
				'label'               => __( 'wpgmtri', 'gmtri' ),
				'show_ui'             => false,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'menu_position'       => 5,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				);
		register_post_type( 'wpgmtri', $args );

		if($_REQUEST['action'] == 'wp_trip_settings'){
			if(!isset( $_POST['trip_nonce_field'] ) || !wp_verify_nonce( $_POST['trip_nonce_field'], 'trip_nonce_action' ) ){
                print 'Sorry, your nonce did not verify.';
                exit;
            }else{
				update_option( 'wp_tripadv_url', sanitize_text_field($_REQUEST['wp_tripadv_url']) );
				$this->GMTRI_download_master(sanitize_text_field($_REQUEST['wp_tripadv_url']));
				
				wp_redirect( admin_url( 'admin.php?page=gmtri-page&view=list_review&msg=success') );
			}
			exit;
		}
		if($_REQUEST['action'] == 'wp_trip_layout'){
			if(!isset( $_POST['trip_nonce_field_layout'] ) || !wp_verify_nonce( $_POST['trip_nonce_field_layout'], 'trip_nonce_action_layout' ) ){
                print 'Sorry, your nonce did not verify.';
                exit;
            }else{
            	foreach ($_REQUEST['gmlayotarr'] as $keya => $valuea) {
            		update_option( $keya, sanitize_text_field($valuea) );
            	}
				wp_redirect( admin_url( 'admin.php?page=gmtri-page&view=layout&msg=success') );
			}
			exit;
		}
		if($_REQUEST['action'] == 'wp_trip_hide_item'){
			update_post_meta( $_REQUEST['id'], 'ishiderev', 'No' );
			wp_redirect( admin_url( 'admin.php?page=gmtri-page&view=list_review') );
			exit;
		}
		if($_REQUEST['action'] == 'wp_trip_addhide_item'){
			update_post_meta( $_REQUEST['id'], 'ishiderev', 'Yes' );
			wp_redirect( admin_url( 'admin.php?page=gmtri-page&view=list_review') );
			exit;
		}
		if($_REQUEST['action'] == 'wp_add_custom_review'){
			$user_name = $_REQUEST['reviewer_name'];
			$userimage = $_REQUEST['userimage'];
			$rating = $_REQUEST['rating'];
			$rtext = $_REQUEST['rtext'];
			$timestamp = date('Y-m-d h:i:s');
			$post_data = array(
												'post_title' => trim($user_name),
												'post_type' => 'wpgmtri',
												'post_status' => 'publish'
												);
			$post_id = wp_insert_post( $post_data );
			update_post_meta( $post_id, 'reviewer_name', trim($user_name) );
			update_post_meta( $post_id, 'userpic', $userimage );
			update_post_meta( $post_id, 'rating',  $rating );
			update_post_meta( $post_id, 'created_time', $timestamp );
			update_post_meta( $post_id, 'created_time_stamp', $unixtimestamp );
			update_post_meta( $post_id, 'review_text', trim($rtext) );
			update_post_meta( $post_id, 'ishiderev', 'No' );
			wp_redirect( admin_url( 'admin.php?page=gmtri-page&view=list_review') );
			exit;
		}

	}

	public function GMTRI_admin_menu () {

		add_menu_page('WP TripAdvisor', 'WP TripAdvisor', 'manage_options', 'gmtri-page', array( $this, 'GMTRI_page' ));
	}

	public function GMTRI_page() {
	?>
	<div class="wrap">
		<div class="headingmc">
			<h1 class="wp-heading-inline"><?php _e('WP TripAdvisor', 'gmtrip'); ?></h1>
			
		</div>
		<hr class="wp-header-end">
		<?php if($_REQUEST['msg'] == 'success'){ ?>
        <div class="notice notice-success is-dismissible"> 
            <p><strong><?php _e('WP TripAdvisor Updated', 'gmtrip'); ?></strong></p>
        </div>
    	<?php } ?>
		<?php
		$navarr = array(
			'page=gmtri-page'=>'Get TripAdvisor Reviews',
			'page=gmtri-page&view=list_review'=>'Reviews List',
			'page=gmtri-page&view=layout'=>'Layout',
			'page=gmtri-page&view=add_custom_review'=>'Add Custom Review',
		);
		?>
		<h2 class="nav-tab-wrapper">
			<?php
			foreach ($navarr as $keya => $valuea) {
				$pagexl = explode("=",$keya);
				?>
				<a href="<?php echo admin_url( 'admin.php?'.$keya);?>" class="nav-tab <?php if($pagexl[2]==$_REQUEST['view']){echo 'nav-tab-active';} ?>"><?php echo $valuea;?></a>
				<?php
			}
			?>
		</h2>
		<div class="postbox">
			<?php
			if($_REQUEST['view']==''){
				include(GMTRIP_PLUGIN_DIR.'includes/GMTRI_settings.php');
			}
			if($_REQUEST['view']=='list_review'){
				include(GMTRIP_PLUGIN_DIR.'includes/GMTRI_list.php');
			}
			if($_REQUEST['view']=='layout'){
				include(GMTRIP_PLUGIN_DIR.'includes/GMTRI_layout.php');
			}
			if($_REQUEST['view']=='add_custom_review'){
				include(GMTRIP_PLUGIN_DIR.'includes/GMTRI_custom_review.php');
			}
			?>
		</div>
	</div>
	<?php
	}

	
	public function GMTRI_download_master($currenturl){

		$stripvariableurl = strtok($currenturl, '?');
		$urlarray = $this->GMTRI_download($stripvariableurl);
		$tripadvisorurl[0] = $urlarray['page1'];
		$tripadvisorurl=array_filter($tripadvisorurl);
		$this->GMTRI_download_scrap($tripadvisorurl);
	}
	public function GMTRI_download_scrap($tripadvisorurl){
		foreach ($tripadvisorurl as $urlvalue) {
			
			//hotel page check
			if (strpos($urlvalue, 'ShowUserReviews') !== false) {
				$ShowUserReviews = true;
			}
			if (strpos($urlvalue, 'Hotel_Review') !== false) {
				$HotelUserReviews= true;
			}
			
			// Create DOM from URL or file
			$fileurlcontents = $this->GMTRI_get_html($urlvalue);
			//fix for lazy load base64 ""
			$fileurlcontents = str_replace('=="', '', $fileurlcontents);

			$html = new simple_html_dom();
 			$html->load($fileurlcontents);
			

			//find tripadvisor business name and add to db under pagename
			$pagename ='';
			if($html->find('.heading_title', 0)){
				$pagename = $html->find('.heading_title', 0)->plaintext;
			}
			
			if($pagename==''){
				if($html->find('h1[id=HEADING]',0)){
				$pagename = $html->find('h1[id=HEADING]',0)->plaintext;
				}
			}

			// Find 20 reviews
			$i = 1;
			
			//find lazyload image js variable and convert to array #\slazyImgs\s*=\s*(.*?);\s*$#s
			$startstringpos = stripos("$html","var lazyImgs = [") + 16;
			$choppedstr = substr("$html", $startstringpos);
			$endstringpos = stripos("$choppedstr","]");
			$finalstring = trim(substr("$html", $startstringpos, $endstringpos));
			$finalstring =str_replace(":true",':"true"',$finalstring);
			$finalstring ="[".str_replace(":false",':"false"',$finalstring)."]";
			$jsonlazyimg  = json_decode($finalstring, true);
			
			//fix for hotel reviews..
			if($HotelUserReviews){
				$reviewcontainerdiv = $html->find('div.hotels-hotel-review-community-content-review-list-parts-SingleReview__reviewContainer--2LYmA');
			} else {
				$reviewcontainerdiv = $html->find('div.review-container');
			}
			
			//print_r($reviewcontainerdiv );
			//die();
			$rtitlelinka = $html->find('a.next', 0)->href;
			if(isset($rtitlelinka)){
				$parseurla = parse_url($urlvalue);
				$newurla = $parseurla['scheme'].'://'.$parseurla['host'].$rtitlelinka;
				update_option( 'gmtri_next_url', $newurla );
			}else{
				update_option( 'gmtri_next_url', 'no_found' );
			}
			
			
			//$rtitlelink = $html->find('a.quote', 0)->find('a',0)->href

			foreach ($reviewcontainerdiv as $review) {

					if ($i > 21) {
							break;
					}
					$user_name='';
					$userimage='';
					$rating='';
					$datesubmitted='';
					$rtext='';
					// Find user_name
					if($review->find('div.username', 0)){
						$user_name = $review->find('div.username', 0)->plaintext;
					}
					if($user_name==''){
						if($review->find('div.info_text', 0)){
							$user_name = $review->find('div.info_text', 0)->find('div', 0)->plaintext;
						}
					}
					//echo $user_name;
					//die();
					
					// Find userimage ui_avatar, need to pull from lazy load varible
					if($review->find('div.ui_avatar', 0)->find('img.basicImg', 0)){
						$userimageid = $review->find('div.ui_avatar', 0)->find('img.basicImg', 0)->id;
						//strip id from 
						$userimageid = strrchr ($userimageid , "_" );
						//loop through array and return url
						if (is_array($jsonlazyimg)){
						for ($x = 0; $x <= count($jsonlazyimg); $x++) {
							//get temp id
							$tempid = $jsonlazyimg[$x]['id'];
							$tempid = strrchr ($tempid , "_" );
							if($userimageid==$tempid){
								$userimage = $jsonlazyimg[$x]['data'];
								$x = count($jsonlazyimg) + 1;
							}
						} 
						}
					}

					//if userimage not found check
					$checkstringpos =  strpos($userimage, 'base64');
						if($userimage =='' || $checkstringpos>0){
							if($review->find('div.ui_avatar', 0)->find('img.basicImg', 0)){
								if($review->find('div.ui_avatar', 0)->find('img.basicImg', 0)->{'data-lazyurl'}){
									$userimage =$review->find('div.ui_avatar', 0)->find('img.basicImg', 0)->{'data-lazyurl'};
								}
							}
						}
						
						
						

					// find rating
					if($review->find('span.ui_bubble_rating', 0)){
						$temprating = $review->find('span.ui_bubble_rating', 0)->class;
						$int = filter_var($temprating, FILTER_SANITIZE_NUMBER_INT);
						//echo $int."<br>";
						$rating = str_replace(0,"",$int);
					}
					
					// find date
					if($review->find('span.ratingDate', 0)){
						$datesubmitted = $review->find('span.ratingDate', 0)->title;
					}
					
					
					if($ShowUserReviews==true){
						// find text
						if($review->find('div.prw_reviews_text_summary_hsx', 0)){
						$rtext = $review->find('div.prw_reviews_text_summary_hsx', 0)->find('p', 0)->plaintext;
						}
						if($review->find('div.prw_reviews_resp_sur_review_text', 0)){
						$rtext = $review->find('div.prw_reviews_resp_sur_review_text', 0)->find('p', 0)->plaintext;
						}
					} else {
						// find text
						if($review->find('div.prw_reviews_text_summary_hsx', 0)){
						$rtext = $review->find('div.prw_reviews_text_summary_hsx', 0)->find('p', 0)->plaintext;
						}
					}
					//backukp text method for hotel
					if($rtext ==''){
						if($review->find('div.prw_reviews_text_summary_hsx', 0)){
						$rtext = $review->find('div.prw_reviews_text_summary_hsx', 0)->find('p', 0)->plaintext;
						}
					}
					
					
					if($rating>0){
						$review_length = str_word_count($rtext);
						$pos = strpos($userimage, 'default_avatars');
						if ($pos === false) {
							$userimage = str_replace("60s.jpg","120s.jpg",$userimage);
						}
						//$timestamp = strtotime($datesubmitted);
						$timestamp = $this->myStrtotime($datesubmitted);
						$unixtimestamp = $timestamp;
						$timestamp = date("Y-m-d H:i:s", $timestamp);
						//check option to see if this one has been hidden
						//pull array from options table of tripadvisor hidden
						$tripadvisorhidden = get_option( 'wptripadvisor_hidden_reviews' );
						if(!$tripadvisorhidden){
							$tripadvisorhiddenarray = array('');
						} else {
							$tripadvisorhiddenarray = json_decode($tripadvisorhidden,true);
						}
						$this_tripadvisor_val = trim($user_name)."-".strtotime($datesubmitted)."-".$review_length."-TripAdvisor-".$rating;
						if (in_array($this_tripadvisor_val, $tripadvisorhiddenarray)){
							$hideme = 'yes';
						} else {
							$hideme = 'no';
						}
						
						//add check to see if already in db, skip if it is and end loop
						$reviewindb = 'no';
						
						$args = array(
						    'post_type' => 'wpgmtri',
						    'post_status' => 'publish',
						    'meta_query' => array(
					    							'relation' => 'AND',
											        array(
											            'key'     => 'reviewer_name',
											            'value'   => trim($user_name),
											            'compare' => '=',
											        ),
											        array(
											            'key'     => 'created_time_stamp',
											            'value'   => $unixtimestamp,
											            'compare' => '=',
											        ),
											    ),
						);
						$checkrow = get_posts( $args );
						if( empty( $checkrow ) ){
								$post_data = array(
												'post_title' => trim($user_name),
												'post_type' => 'wpgmtri',
												'post_status' => 'publish'
												);
								$post_id = wp_insert_post( $post_data );
								update_post_meta( $post_id, 'reviewer_name', trim($user_name) );
								update_post_meta( $post_id, 'pagename', trim($pagename) );
								update_post_meta( $post_id, 'userpic', $userimage );
								update_post_meta( $post_id, 'rating',  $rating );
								update_post_meta( $post_id, 'created_time', $timestamp );
								update_post_meta( $post_id, 'created_time_stamp', $unixtimestamp );
								update_post_meta( $post_id, 'review_text', trim($rtext) );
								update_post_meta( $post_id, 'hide', $hideme );
								update_post_meta( $post_id, 'ishiderev', 'No' );
								update_post_meta( $post_id, 'review_length', $review_length );
						} 
						$review_length ='';
					}
			 
					$i++;
			}

			
			//sleep for random 2 seconds
			sleep(rand(0,2));
			$n++;
			
			// clean up memory
			if (!empty($html)) {
				$html->clear();
				unset($html);
			}
		}
	}
	public function GMTRI_get_html($currenturl){

		if (ini_get('allow_url_fopen') == true || function_exists('curl_init')) {
			$response = wp_remote_get( $currenturl );
			$fileurlcontents = $response['body'];
			return $fileurlcontents;
		} else {
			$fileurlcontents='<html><body>fopen is not allowed on this host.</body></html>';
			$errormsg = $errormsg . ' <p style="color: #A00;">fopen is not allowed on this host and cURL did not work either. Ask your web host to turn fopen on or fix cURL.</p>';
			$this->errormsg = $errormsg;
			echo $errormsg;
			die();
		}

	}
	public function GMTRI_download($currenturl){
		
		$fileurlcontents = $this->GMTRI_get_html($currenturl);
		//fix for lazy load base64 ""
		$fileurlcontents = str_replace('=="', '', $fileurlcontents);
				
		$html = new simple_html_dom();
 		$html->load($fileurlcontents);
		
		$rtitlelink ="";
	
		if($html->find('div.review-container')){
				$reviewobject = $html->find('div.review-container',0);
		} else {
			if($html->find('div.ui_card')){
				$reviewobject = $html->find('div.ui_card',0);
				if($reviewobject->find("div[class*=ReviewTitle]", 0)){
					$rtitlelink = $reviewobject->find("div[class*=ReviewTitle]", 0)->find('a',0)->href;
				}
			} else if($html->find("div[class*=ReviewTitle]", 0)){
				$rtitlelink = $html->find("div[class*=ReviewTitle]", 0)->find('a',0)->href;
			} else {
				echo "Error 103a: Unable to read TripAdvisor page.";
				die();	
			}
		}
		
		
		if(isset($reviewobject) && $reviewobject!="" && $rtitlelink==''){
			$rtitlelink = $reviewobject->find('div.quote', 0)->find('a',0)->href;
		}
		$parseurl = parse_url($currenturl);
		$newurl = $parseurl['scheme'].'://'.$parseurl['host'].$rtitlelink;
		$response =array("page1"=>$newurl);
		$html->clear(); 
		unset($html);
		return $response;
	}

	
	public function myStrtotime($date_string) { 
		$monthnamearray = array(
		'janvier'=>'jan',
		'février'=>'feb',
		'mars'=>'march',
		'avril'=>'apr',
		'mai'=>'may',
		'juin'=>'jun',
		'juillet'=>'jul',
		'août'=>'aug',
		'septembre'=>'sep',
		'octobre'=>'oct',
		'novembre'=>'nov',
		'décembre'=>'dec',
		'gennaio'=>'jan',
		'febbraio'=>'feb',
		'marzo'=>'march',
		'aprile'=>'apr',
		'maggio'=>'may',
		'giugno'=>'jun',
		'luglio'=>'jul',
		'agosto'=>'aug',
		'settembre'=>'sep',
		'ottobre'=>'oct',
		'novembre'=>'nov',
		'dicembre'=>'dec',
		'janeiro'=>'jan',
		'fevereiro'=>'feb',
		'março'=>'march',
		'abril'=>'apr',
		'maio'=>'may',
		'junho'=>'jun',
		'julho'=>'jul',
		'agosto'=>'aug',
		'setembro'=>'sep',
		'outubro'=>'oct',
		'novembro'=>'nov',
		'dezembro'=>'dec',
		'enero'=>'jan',
		'febrero'=>'feb',
		'marzo'=>'march',
		'abril'=>'apr',
		'mayo'=>'may',
		'junio'=>'jun',
		'julio'=>'jul',
		'agosto'=>'aug',
		'septiembre'=>'sep',
		'octubre'=>'oct',
		'noviembre'=>'nov',
		'diciembre'=>'dec',
		'januari'=>'jan',
		'februari'=>'feb',
		'maart'=>'march',
		'märz'=>'march',
		'april'=>'apr',
		'mei'=>'may',
		'juni'=>'jun',
		'juli'=>'jul',
		'augustus'=>'aug',
		'september'=>'sep',
		'oktober'=>'oct',
		'november'=>'nov',
		'december'=>'dec',
		' de '=>'',
		'dezember'=>'dec'
		);
		return strtotime(strtr(strtolower($date_string), $monthnamearray)); 
	}
}

?>