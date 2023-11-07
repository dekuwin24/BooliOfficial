<?php 
/**
 ***
 ** MetaFans BuddyPress Profile Integration
 ** @package WordPress
 ** @subpackage Metafans
 ** @since 2.3.0
 *
 *
 */
class Tophive_BP_Profile
{
    static $_instance;
    public $helper = '';

	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function is_active() {
		return tophive_metafans()->is_buddypress_active();
	}
	function __construct(){
		if( $this->is_active() ){
			include_once 'helper.php';
			$this->helper = new Tophive_BP_Helper();
			add_action( 'tophive/buddypress/profile-header', array( $this, 'profile_header' ) );
			add_action( 'bp_profile_header_meta', array( $this, 'profile_header_meta' ) );
			add_action( 'tophive/buddypress/profile/header/socials', array( $this, 'social_profiles' ) );
			add_filter( 'tophive/buddypress/profile/photos', array( $this, 'profile_photos' ) );
			add_action( 'bp_profile_header_meta', array( $this, 'profile_stats'), 10, 1 );
		}
	}
	/*
	** Enhanced Full width boxed header for profile pages
	** @since v2.2.1
	*
	*/
	public function profile_header(){
		$user_id = bp_displayed_user_id();
		do_action( 'bp_before_member_header' );
		?>
		<div id="buddypress" class="buddypress-wrap metafans round-avatars bp-dir-hori-nav">
			<div id="item-header" role="complementary" data-bp-item-id="1" data-bp-item-component="members" class="users-header single-headers top-header">
				<?php if(!class_exists('Youzify')){ ?>
					<div id="cover-image-container">
						<a id="header-cover-image" href="<?php bp_displayed_user_link(); ?>"></a>

						<div id="item-header-cover-image">
							<div id="item-header-avatar">
								<?php bp_displayed_user_avatar( 'type=full' ); ?>
							</div>
							<div id="item-header-content" class="desktop">
								
								<div class="user-section">
									<h2 class="user-nicename"><?php echo get_the_author_meta( 'display_name', bp_displayed_user_id() ); ?></h2>
									<?php 
										if( get_user_meta( bp_displayed_user_id(), 'designation', true ) ){
											?>
												<p class="bp-user-designation"><small><?php echo get_user_meta( bp_displayed_user_id(), 'designation', true ); ?></small></p>
											<?php
										}
										do_action( 'tophive/buddypress/profile/header/socials' );
									?>
									<div id="item-meta">
										<?php do_action( 'bp_profile_header_meta' ); ?>
									</div>
								</div>
								<div id="item-buttons">
										<?php 
										$following_id = $user_id;
										$follower_id 	= get_current_user_id();
								
										if( Tophive_BP_Members::get_instance()->is_already_following( $follower_id, $following_id ) ){
											$class = $status = 'following';
											$text 	= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/></svg>' . esc_html__( ' Following', 'metafans' );
										}else{
											$class = $status = '';
											$text = esc_html__( '+ Follow', 'metafans' );
										}
										if(is_user_logged_in()){ ?>
											<div class="members-list">
												<li>
													<div class="members-action-buttons">
														<?php if( $user_id != get_current_user_id() ){ ?>
															<a href="" class="bp-th-follow-button <?php echo $class; ?>" data-follower-id="<?php echo $follower_id; ?>" data-following="<?php echo $status; ?>" data-following-id="<?php echo $following_id; ?>"><?php echo $text; ?></a>
															<a href="" class="bp-th-friends-button" data-user-id="<?php echo bp_displayed_user_id(); ?>" data-action="<?php echo $this->helper->get_friendship_status( $user_id ); ?>"><?php echo $this->helper->get_friend_button_text( $user_id ) ?></a>
															<a href="#" data-recipients-id="<?php echo $user_id; ?>" class="private-msg"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
															  <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
															  <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
															</svg></a>
														<?php } ?>
													</div>
												</li>
											</div>
										<?php } ?>
									<?php do_action( 'bp_member_header_actions' ); ?></div>
							</div>
							<div id="item-header-content" class=" mobile">
								
								<div class="user-section">
									<h2 class="user-nicename"><?php echo get_the_author_meta( 'display_name', bp_displayed_user_id() ); ?></h2>
									<?php 
										if( get_user_meta( bp_displayed_user_id(), 'designation', true ) ){
											?>
												<p class="bp-user-designation"><small><?php echo get_user_meta( bp_displayed_user_id(), 'designation', true ); ?></small></p>
											<?php
										}
										do_action( 'tophive/buddypress/profile/header/socials' );
									?>

									
								</div>
								<div id="item-buttons">
										<?php if(is_user_logged_in()){ ?>
											<div class="members-list">
												<li>
													<div class="members-action-buttons">
														<?php if( $user_id != get_current_user_id() ){ ?>
															<a href="" class="bp-th-friends-button" data-user-id="<?php echo bp_displayed_user_id(); ?>" data-action="<?php echo $this->helper->get_friendship_status( $user_id ); ?>"><?php echo $this->helper->get_friend_button_text( $user_id ) ?></a>
															<a href="#" data-recipients-id="<?php echo $user_id; ?>" class="private-msg"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
															  <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
															  <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
															</svg></a>
														<?php } ?>
													</div>
												</li>
											</div>
										<?php } ?>
									<?php do_action( 'bp_member_header_actions' ); ?>
								</div>
								<div id="item-meta">
									<?php do_action( 'bp_profile_header_meta' ); ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

				<?php

				do_action( 'bp_after_member_header' ); ?>

				<div id="template-notices" role="alert" aria-atomic="true">
					<?php do_action( 'template_notices' ); ?>
				</div>
			</div>

			<?php if( !class_exists('Youzify') ){?>
				<nav class="<?php bp_nouveau_single_item_nav_classes(); ?>" id="object-nav" role="navigation" aria-label="<?php esc_attr_e( 'Member menu', 'metafans' ); ?>">

					<?php if ( bp_nouveau_has_nav( array( 'type' => 'primary' ) ) ) : ?>

						<ul class="nav-bar-filter" id="nav-bar-filter">

							<?php
							while ( bp_nouveau_nav_items() ) :
								bp_nouveau_nav_item();
							?>

								<li id="<?php bp_nouveau_nav_id(); ?>" class="<?php bp_nouveau_nav_classes(); ?>">
									<a href="<?php bp_nouveau_nav_link(); ?>" id="<?php bp_nouveau_nav_link_id(); ?>">
										<?php bp_nouveau_nav_link_text(); ?>

										<?php if ( bp_nouveau_nav_has_count() ) : ?>
											<span class="count"><?php bp_nouveau_nav_count(); ?></span>
										<?php endif; ?>
									</a>
								</li>

							<?php endwhile; ?>

							<?php bp_nouveau_member_hook( '', 'options_nav' ); ?>

						</ul>
						<ul id="more-nav">			  
							<li><a href="#" class="more-nav-anchor">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
									<path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
								</svg>
							</a>
								<ul class="subfilter">
									<?php
										while ( bp_nouveau_nav_items() ) :
											bp_nouveau_nav_item();
										?>

											<li id="<?php bp_nouveau_nav_id(); ?>" class="<?php bp_nouveau_nav_classes(); ?>">
												<a href="<?php bp_nouveau_nav_link(); ?>" id="<?php bp_nouveau_nav_link_id(); ?>">
													<?php bp_nouveau_nav_link_text(); ?>

													<?php if ( bp_nouveau_nav_has_count() ) : ?>
														<span class="count"><?php bp_nouveau_nav_count(); ?></span>
													<?php endif; ?>
												</a>
											</li>

									<?php endwhile; ?>
								</ul>
							</li>    
						</ul>

					<?php endif; ?>

				</nav>

			<?php } ?>


		</div>
		<?php
	}
	/*
	** Profile Header Meta
	** @since v1.0.0
	*
	*/
	public function profile_header_meta(){
		global $bp;
		?>
			<p class="profile-header-meta-date"><span class="hide-badge">@<?php bp_displayed_user_mentionname(); ?></span> • <span>Joined : <?php echo date( "F j, Y", strtotime( $bp->displayed_user->userdata->user_registered ) ) ?> </span></p>
		<?php
	}
	function profile_stats(){
        $following_id = $user_id = bp_displayed_user_id();
        $follower_id 	= get_current_user_id();

		$bbpress_query = new WP_Query( 
			array( 
				'author' 	=> $user_id,
				'post_type' => 'topic',
				'post_status' => 'publish',
				'posts_per_page' => -1
			)
		);

		$friends_for_member = bp_is_active( 'friends' ) ?  friends_get_friend_count_for_user( $user_id ) : '';

        // $user_title = !empty(get_the_author_meta( 'designation', $user_id )) ? get_the_author_meta( 'designation', $user_id ) : '@' . get_the_author_meta( 'display_name', $user_id );
		?>
			<div class="user-facts">
				<p>
					<span class="secondary-color followers-count-<?php echo $following_id; ?>"><?php echo Tophive_BP_Members::get_instance()->get_followers_count( $following_id ); ?></span>
					<span><?php esc_html_e( 'Followers', 'metafans' ); ?></span>
				</p>
				<p>
					<span class="secondary-color following-count-<?php echo $user_id; ?>"><?php echo Tophive_BP_Members::get_instance()->get_following_count( $following_id ); ?></span>
					<span><?php esc_html_e( 'Following', 'metafans' ); ?></span>
				</p>
				<!-- <p>
					<span class="secondary-color"><?php echo $bbpress_query->found_posts; ?></span>
					<span><?php esc_html_e( 'Topics', 'metafans' ); ?></span>
				</p>
				<?php if( bp_is_active( 'friends' ) ): ?>
					<p>
						<span class="secondary-color"><?php echo $friends_for_member; ?></span>
						<span><?php esc_html_e( 'Friends', 'metafans' ); ?></span>
					</p>
				<?php endif; ?> -->
				<?php if( class_exists('GamiPress_BuddyPress') ): 
	        		
	        		$points_type_to_show = gamipress_bp_members_get_points_types()[0];
	                $user_points = gamipress_get_user_points( $user_id, $points_type_to_show );

				?>
					<p>
						<span class="secondary-color"><?php echo $this->helper->convertThousandsPlus($user_points); ?></span>
						<span><?php esc_html_e( 'Points', 'metafans' ); ?></span>
					</p>
				<?php endif; ?>
			</div>
		<?php
	}

	/*
	** Profile author social profiles
	** @since v1.0.0
	*
	*/
	public function social_profiles(){
		$html = '';
		$socials = [];
		$facebook 	= get_the_author_meta( 'facebook', bp_displayed_user_id() );
		$twitter 	= get_the_author_meta( 'twitter', bp_displayed_user_id() );
		$linkedin 	= get_the_author_meta( 'linkedin', bp_displayed_user_id() );
		$youtube 	= get_the_author_meta( 'youtube', bp_displayed_user_id() );
		$slack 		= get_the_author_meta( 'slack', bp_displayed_user_id() );
		if( !empty($facebook) ){
			array_push($socials, array( 'name' => 'facebook', 'url' => $facebook ));
		}
		if( !empty($twitter) ){
			array_push($socials, array( 'name' => 'twitter', 'url' => $twitter ));
		}
		if( !empty($linkedin) ){
			array_push($socials, array( 'name' => 'linkedin', 'url' => $linkedin ));
		}
		if( !empty($youtube) ){
			array_push($socials, array( 'name' => 'youtube', 'url' => $youtube ));
		}
		if( !empty($slack) ){
			array_push($socials, array( 'name' => 'slack', 'url' => $slack ));
		}
		$html .= '<ul class="bp-socials-vertical">';
		foreach ($socials as $value) {
			$html .= '<li class="'. $value['name'] .'"><a href="'. $value['url'] .'"><i class="fa fa-'. $value['name'] .'"></i></a></li>';
		}
		$html .= '</ul>';
		echo tophive_sanitize_filter($html);
	}
	/**
	** Profile Photos
	*/
	public function profile_photos(){
		global $wpdb;
		$user_id = bp_displayed_user_id();
		$all_images = [];
		$media_html = '';
		$activities = $wpdb->get_results("SELECT id from {$wpdb->base_prefix}bp_activity WHERE user_id={$user_id} and type='activity_update'", ARRAY_N);

		if( !empty($activities) ){
			foreach ($activities as $key => $value) {
				$images = bp_activity_get_meta( $value[0], 'activity_media', false );
				$newImages = $images[0];
	 			$newImages[0]['activity_id'] = $value[0];

	 			if( !empty($images) )
	 				array_push($all_images, ...$newImages);
			}
			array_filter($all_images);
			$media_html .= '<div class="ec-row bp-image-previewer">';
			$i = 1;
			foreach ($all_images as $url) {
				if( !empty($url['thumb']) ){
					$media_html .= '<div class="ec-col-md-3 bp-image-single" id="'. $i .'">';
						$media_html .= '<div class="post-media-single">';
							$media_html .= '<a class="media-popup-thumbnail" href="'. $url['thumb'][0] .'" data-id="'. $url['id'] .'" data-activity="'. $url['activity_id'] .'"><img src="'. $url['full'] .'" alt="gm"></a>';
						$media_html .= '</div>';
					$media_html .= '</div>';
				}
				$i++;
			}
			if( empty($all_images) ){
				$media_html .= '<span class="no-photos">' . esc_html__( 'No photos uploaded', 'metafans' ) . '</span>';
			}
			$media_html .= '</div>';
		}
		return $media_html;
	}
}
function Tophive_BP_Profile() {
	return Tophive_BP_Profile::get_instance();
}

if ( tophive_metafans()->is_buddypress_active() ) {
	Tophive_BP_Profile();
}
