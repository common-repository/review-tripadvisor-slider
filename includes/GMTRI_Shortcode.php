<?php

/**
 * This class is loaded on the front-end since its main job is 
 * to display the Admin to box.
 */

class GMTRI_Shortcode {
	
	public function __construct () {
		
		add_action('wp_enqueue_scripts',  array( $this, 'GMTRI_script' ) );
		add_shortcode( 'wp_tripadvisor_review', array( $this, 'wp_tripadvisor_review' ) );
		add_action('wp_footer',  array( $this, 'GMTRI_footer' ) );
	}

	public function GMTRI_script () {
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'gmtrip-owlcarousel-min', GMTRIP_PLUGINURL . '/assets/owlcarousel/assets/owl.carousel.min.css', false, '1.0.0' );
        wp_enqueue_style( 'gmtrip-owlcarousel-theme', GMTRIP_PLUGINURL . '/assets/owlcarousel/assets/owl.theme.default.min.css', false, '1.0.0' );
        wp_enqueue_script( 'gmtrip-owlcarousel', GMTRIP_PLUGINURL . '/assets/owlcarousel/owl.carousel.js', false, '1.0.0' );
        wp_enqueue_script('gmtrip-masonry', GMTRIP_PLUGINURL . '/js/masonry.pkgd.min.js', array(), '1.0.0', true );
     	wp_enqueue_style('gmtrip-style', GMTRIP_PLUGINURL . '/css/style.css', array(), '1.0.0', 'all');
		wp_enqueue_script('gmtrip-script', GMTRIP_PLUGINURL . '/js/script.js', array(), '1.0.0', true );
	}

	public function GMTRI_footer () {
		$gm_layout = get_option( 'gm_layout' );
		$gm_column = get_option( 'gm_column' );
		$gm_background_color = get_option( 'gm_background_color' );
		?>
		 <script>
        	jQuery(document).ready(function(){
        		<?php
        		if($gm_layout=='slider'){
        		?>
				    jQuery("#gmtri-testimonial-slider").owlCarousel({
				        items:3,
				        itemsDesktop:[1000,3],
				        itemsDesktopSmall:[979,2],
				        itemsTablet:[768,2],
				        itemsMobile:[650,1],
				        pagination:true,
				        autoPlay:true
				    });
			    <?php
				}
			    ?>
			    <?php
        		if($gm_layout=='mansory' || $gm_layout=='grid'){
        		?>
				    var mansoryclis = jQuery('#gmtri-testimonial-slider').masonry({
					  itemSelector: '.gmtri_testimonial',
					 
					});
			    <?php
				}
			    ?>
			    jQuery( ".gmtri_rd_morea" ).click(function() {
					jQuery(this ).closest('.gmtri_rd_more').hide();
					jQuery(this ).closest('.gmtri_description').find(".gmtri_rd_more_text").show();
					<?php
		        		if($gm_layout=='mansory' || $gm_layout=='grid'){
		        	?>
					mansoryclis.masonry('layout');
					<?php
						}
					?>
					return false;
				});
				jQuery( ".gmtri_rd_less" ).click(function() {
					jQuery(this ).closest('.gmtri_rd_more_text').hide();
					jQuery(this ).closest('.gmtri_description').find(".gmtri_rd_more").show();
					<?php
		        		if($gm_layout=='mansory' || $gm_layout=='grid'){
		        	?>
					mansoryclis.masonry('layout');
					<?php
						}
					?>
					return false;
				});
			    
			});
        </script>
        <style>
        	<?php
    		if($gm_layout=='grid' || $gm_layout=='mansory'){
    			$gm_perctange = 100 / $gm_column;
    		?>
        	.gmtri_testimonial{
        		width: <?php echo $gm_perctange;?>%;
			    float: left;
			    margin-bottom: 20px;
        	}
	        	<?php
	        	if($gm_layout=='grid'){
	        	/*?>
	        	.gmtri_description{
	        		  display: -webkit-box;
					  -webkit-line-clamp: 3;
					  -webkit-box-orient: vertical;  
					  overflow: hidden;
	        	}
	        	<?php
	        	*/
	        	}
        	}
        	?>
        </style>
		<?php
	}

	public function wp_tripadvisor_review ($atts, $content = null) {
		ob_start();
		
		
		$gm_layout = get_option( 'gm_layout' );
		$gm_column = get_option( 'gm_column' );
		$gm_per_page = get_option( 'gm_per_page' );
		$gm_background_color = get_option( 'gm_background_color' );
		$gm_item_background_color = get_option( 'gm_item_background_color' );
		$gm_reviewtext_color = get_option( 'gm_reviewtext_color' );
		$gm_usertext_color = get_option( 'gm_usertext_color' );
		$gm_datetext_color = get_option( 'gm_datetext_color' );
		$gm_limit_for_readmore = get_option( 'gm_limit_for_readmore' );
		if($gm_layout=='slider'){
			$class_main = 'owl-carousel';
		}elseif ($gm_layout=='grid') {
			$class_main = 'gmtrigrid';
		}elseif ($gm_layout=='mansory') {
			$class_main = 'gmtrimansory';
		}
		$args = array(
		    'post_type' => 'wpgmtri',
		    'meta_query' => array( 
		    						array(
							            'key'     => 'ishiderev',
							            'value'   => 'Yes',
							            'compare' => '!=',
							        ),
		    				),
		    'posts_per_page' => $gm_per_page
		);
		$the_query = new WP_Query( $args );
		?>
		<Style>
			<?php
			if($gm_background_color!=''){
			?>
			.gmtri-testimonical-main{
				background-color:<?php echo $gm_background_color;?>;
			}
			.gmtri_testimonial .gmtri_pic{
				box-shadow:0 0 2px 2px <?php echo $gm_background_color;?>;
			}
			.gmtri-testimonical-main .owl-dots .owl-dot.active span, .gmtri-testimonical-main .owl-dots .owl-dot:hover span{
				background-color:<?php echo $gm_background_color;?>;
			}
			<?php
			}
			if($gm_item_background_color!=''){
			?>
			.gmtri_testimonial_inner{
				background-color:<?php echo $gm_item_background_color;?>;
			}
			.gmtri_testimonial_inner:before, .gmtri_testimonial_inner:after{
				border-top-color:<?php echo $gm_item_background_color;?>;
			}
			.gmtri-testimonical-main .owl-dots .owl-dot span{
				border-color:<?php echo $gm_item_background_color;?>;
			}
			<?php
			}
			if($gm_reviewtext_color!=''){
			?>
			.gmtri_testimonial .gmtri_description{
				color:<?php echo $gm_reviewtext_color;?>;
			}
			<?php
			}
			if($gm_usertext_color!=''){
			?>
			.gmtri_testimonial .gmtri_title{
				color:<?php echo $gm_usertext_color;?>;
			}
			<?php
			}
			if($gm_datetext_color!=''){
			?>
			.gmtri_testimonial .gmtri_post{
				color:<?php echo $gm_datetext_color;?>;
			}
			<?php
			}
			?>
		</Style>
		<div class="gmtri-testimonical-main" gm_layout='<?php echo $gm_layout;?>' >
			<h3 class="gmtri-heading"><?php _e('TripAdvisor Review', 'gmtrip'); ?></h3>
		
			<div id="gmtri-testimonial-slider" class="<?php echo $class_main;?>">
				<?php 
				while ( $the_query->have_posts() ) : $the_query->the_post(); 
				$post_id = get_the_ID();
				$reviewer_name = get_post_meta( $post_id, 'reviewer_name', true );
				$userpic = get_post_meta( $post_id, 'userpic', true );
				$rating = get_post_meta( $post_id, 'rating', true );
				$created_time = get_post_meta( $post_id, 'created_time', true );
				$review_text = get_post_meta( $post_id, 'review_text', true );
				?>
	            <div class="gmtri_testimonial">
	            	<div class="gmtri_testimonial_inner">
		                <div class="gmtri_icon">
		                	<?php
		                	for ($i=1; $i <= 5; $i++) { 
								if($rating<=$i){
		                			echo '<span class="iniconb"></span>';
		                		}else{
		                			echo '<span class="iniconb"><span class="gmfill"></span></span>';
		                		}
		                	}
		                	?>
		                </div>
		                <p class="gmtri_description">
		                	
		                	<?php
		                	if ($gm_layout=='mansory') {
		                		echo $review_text;
		                	}else{
		                		$review_full = $review_text;
			                	if (strlen($review_text) > $gm_limit_for_readmore) {
			                		
			                		$stringCut = substr($review_text, 0, $gm_limit_for_readmore);
								    $endPoint = strrpos($stringCut, ' ');
								    $review_text ="<span class='gmtri_rd_more'>";
								    //if the string doesn't contain any space then it will cut without word basis.
								    $review_text .= $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
								    $review_text .= "... <a class='gmtri_rd_morea'>read more</a></span>";
								    $review_text .= "<span class='gmtri_rd_more_text' style='display:none;'>";
								    $review_text .= $review_full;
								    $review_text .= " <a class='gmtri_rd_less' >read less</a></span>";
			                	}
			                	echo $review_text;
		                	}
		                	?>
		               	</p>
		                <div class="gmtri_testimonial-content">
		                    <div class="gmtri_pic"><img src="<?php echo $userpic;?>" alt=""></div>
		                    <h3 class="gmtri_title"><?php echo $reviewer_name;?></h3>
		                    <span class="gmtri_post"><?php echo date('d M, Y',strtotime($created_time));?></span>
		                </div>
	                </div>
	            </div>
	            <?php endwhile; 
	            wp_reset_postdata();
	            ?>

	            
	            
	        </div>
        </div>
       
		<?php
		return $output = ob_get_clean();
	}

	

	
	
}

?>