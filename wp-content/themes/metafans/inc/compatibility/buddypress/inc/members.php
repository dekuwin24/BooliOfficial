<?php 
/**
 ***
 ** MetaFans BuddyPress Memebrs Integration
 ** @package WordPress
 ** @subpackage Metafans
 ** @since 2.3.0
 *
 *
 */
class Tophive_BP_Members
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
			add_action( 'bp_directory_members_item', array( $this, 'members_information'), 10, 1 );
			add_action( 'bp_directory_members_item', array( $this, 'members_buttons'), 10, 1 );
			add_action( 'wp_ajax_tophive_bp_friends_action', array($this, 'metafans_process_friend_requests') );
			add_action( 'wp_ajax_nopriv_tophive_bp_friends_action', array($this, 'metafans_process_friend_requests') );
			add_action( 'wp_ajax_metafans_handle_follow', array($this, 'metafans_process_follow_requests') );
			add_action( 'wp_ajax_nopriv_metafans_handle_follow', array($this, 'metafans_process_follow_requests') );
		}
	}
	// Handle Ajax Follow Requests
	public function metafans_process_follow_requests(){
		if( !is_user_logged_in() ){
			return;
		}

		$follower_id = (int) $_REQUEST['follower_id'];
		$following_id = (int) $_REQUEST['following_id'];

		if( empty( $follower_id ) || empty( $following_id ) ){
			return;
		}

		$response = array();

		$this->update_followers( $follower_id, $following_id );
		$this->update_following( $follower_id, $following_id );
		// $response['followers'] = $this->update_followers( $follower_id, $following_id );
		//  
		// $response['follower'] = $this->is_already_following( $follower_id, $following_id );
		// $response['followers'] = $follower_id;
		$response['is_following'] = $this->is_already_following( $follower_id, $following_id );
		$response['followers_count'] = $this->get_followers_count( $following_id );
		$response['following_count'] = $this->get_following_count( $follower_id );

		// $response['following_id'] = $following_id;

		wp_send_json( $response, 200 );
	}

	// Update Followers of a following account/id/user
	public function update_followers( $follower_id, $following_id ){
		$followers = $this->get_followers( $following_id );
		$followers = !empty( $followers ) ? $followers : [];

		// Check if current user is already following
		if( $this->is_already_following( $follower_id, $following_id ) ){
			if (($key = array_search($follower_id, $followers)) !== false) {
				unset($followers[$key]);
			}
			update_user_meta( $following_id, 'followers', $followers );
		}else{
			array_push( $followers, $follower_id );
			if( metadata_exists( 'user', $following_id, 'followers' ) ){
				update_user_meta( $following_id, 'followers', $followers );
			}else{
				add_user_meta( $following_id, 'followers', $followers, true );
			}
		}
	}
	// Update following if the current id
	public function update_following( $follower_id, $following_id ){
		$following = $this->get_following( $follower_id );
		$following = !empty( $following ) ? $following : [];

		// Check if current user is already following
		if( $this->is_already_followed( $follower_id, $following_id ) ){
			if (($key = array_search($following_id, $following)) !== false) {
				unset($following[$key]);
			}
			update_user_meta( $follower_id, 'following', $following );
		}else{
			array_push( $following, $following_id );
			if( metadata_exists( 'user', $follower_id, 'following' ) ){
				update_user_meta( $follower_id, 'following', $following );
			}else{
				add_user_meta( $follower_id, 'following', $following, true );
			}
		}
	}
	public function get_followers( $following_id ){
		return get_user_meta( $following_id, 'followers', true );
	}
	public function get_following( $follower_id ){
		return get_user_meta( $follower_id, 'following', true );
	}
	public function get_followers_count( $following_id ){
		$followers = $this->get_followers( $following_id );
		if( !empty($followers) || is_array( $followers ) ){
			return count($followers);
		}else{
			return 0;
		}
	}
	public function get_following_count( $follower_id ){
		$following = $this->get_following( $follower_id );
		if( !empty($following) || is_array( $following ) ){
			return count($following);
		}else{
			return 0;
		}
	}
	public function is_already_following( $follower_id, $following_id ){
		$followers = $this->get_followers( $following_id );
		$followers = !empty( $followers ) ? $followers : [];

		if( in_array( $follower_id, $followers ) ){
			return true;
		}else{
			return false;
		}
	}
	public function is_already_followed( $follower_id, $following_id ){
		$following = $this->get_following( $follower_id );
		$following = !empty( $following ) ? $following : [];

		if( in_array( $following_id, $following ) ){
			return true;
		}else{
			return false;
		}
	}
	public function metafans_process_friend_requests(){

		if( !is_user_logged_in() ){
			return;
		}
		$pending_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
		  <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
		</svg>';

		$response_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
		  <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
		</svg>';

		$friends_icon = '<svg class="small-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
		  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
		  <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
		</svg>';

		$add_friend_icon = '<svg class="small-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
		  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
		  <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
		</svg>';
		$response = array();
		$user_id = $_REQUEST['user_id'];

		$status = $this->helper->get_friendship_status( $user_id );
		if( class_exists('BP_Friends_Friendship') ){
			$friendship_id = BP_Friends_Friendship::get_friendship_id( get_current_user_id(), $user_id);
			if( $status == 'pending' ){
				$result = friends_withdraw_friendship( get_current_user_id(), $user_id );
				if( $result ){
					$response['result'] = true;
					$response['text'] = $add_friend_icon . esc_html__( ' Add Friend', 'metafans' );
					wp_send_json($response);
				}else{
					wp_send_json( 'failed withdraw friendship');
				}
			}elseif( $status == 'not_friends' ){
				if( function_exists('friends_add_friend') ){
					$result = friends_add_friend( get_current_user_id(), $user_id );
					if($result){
						$response['result'] = true;
						$response['text'] = '<span class="show">' . $pending_icon . esc_html__( ' Requested', 'metafans' ) . '</span><span class="hidden">' . esc_html__( 'Cancel', 'metafans' ) . '</span>';
					}
				}
			}elseif( $status == 'is_friend' ){
				if( function_exists('friends_remove_friend') ){
					$result = friends_remove_friend( get_current_user_id(), $user_id );
					if($result){
						$response['result'] = true;
						$response['text'] = $add_friend_icon . esc_html__( ' Add Friend', 'metafans' );
					}
				}
			}elseif( $status == 'awaiting_response' ){
				if( function_exists('friends_accept_friendship') ){
					$result = friends_accept_friendship( $friendship_id );
					if($result){
						$response['result'] = true;
						$response['text'] = '<span class="show">' . $friends_icon . esc_html__( ' Friends', 'metafans' ) . '</span><span class="hidden">'. esc_html__( 'Cancel', 'metafans' ) .'</span>';
					}
				}
			}else{
				$response['result'] = false;
			}
		}


		wp_send_json( $response, 200 );
	}
	public function members_information(){
		if( class_exists('Youzify') ){
			return;
		}
        $following_id = $user_id = bp_get_member_user_id();
        $follower_id 	= get_current_user_id();

		$bbpress_query = new WP_Query( 
			array( 
				'author' 	=> $user_id,
				'post_type' => 'topic',
				'post_status' => 'publish',
				'posts_per_page' => -1
			)
		);

		$friends_count = bp_is_active( 'friends' ) ?  friends_get_friend_count_for_user( $user_id ) : '';

        $user_title = !empty(get_the_author_meta( 'designation', $user_id )) ? get_the_author_meta( 'designation', $user_id ) : '@' . get_the_author_meta( 'display_name', $user_id );

        $cover_src = bp_attachments_get_attachment( 'url', array(
			'item_id' => $user_id
		));
		?>
			<?php if( tophive_metafans()->get_setting('theme_globals_show_gp_badges') ){ ?>
				<div class="tophive-members-gp">
					<?php echo $this->members_gamipress(); ?>
				</div>
			<?php } ?>
			<div class="user-facts">
				<p>
					<span class="secondary-color followers-count-<?php echo $following_id; ?>"><?php echo $this->get_followers_count( $following_id ); ?></span>
					<span><?php esc_html_e( 'Followers', 'metafans' ); ?></span>
				</p>
				<p>
					<span class="secondary-color following-count-<?php echo $user_id; ?>"><?php echo $this->get_following_count( $user_id ); ?></span>
					<span><?php esc_html_e( 'Following', 'metafans' ); ?></span>
				</p>
				<!-- <p>
					<span class="secondary-color"><?php echo $bbpress_query->found_posts; ?></span>
					<span><?php esc_html_e( 'Topics', 'metafans' ); ?></span>
				</p>
				<?php if( bp_is_active( 'friends' ) ): ?>
					<p>
						<span class="secondary-color"><?php echo $friends_count; ?></span>
						<span><?php esc_html_e( 'Friends', 'metafans' ); ?></span>
					</p>
				<?php endif; ?>
				<?php if( class_exists('GamiPress_BuddyPress') ): 
	        		
	        		$points_type_to_show = gamipress_bp_members_get_points_types()[0];
	                $user_points = gamipress_get_user_points( $user_id, $points_type_to_show );

				?>
					<p>
						<span class="secondary-color"><?php echo $this->helper->convertThousandsPlus($user_points); ?></span>
						<span><?php esc_html_e( 'Points', 'metafans' ); ?></span>
					</p>
				<?php endif; ?> -->
			</div>
		<?php
	}
	public function members_buttons(){
		if( class_exists('Youzify') ){
			return;
		}
        $following_id = $user_id = bp_get_member_user_id();
        $follower_id 	= get_current_user_id();

		if( $this->is_already_following( $follower_id, $following_id ) ){
			$class = $status = 'following';
			$text 	= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/></svg>' . esc_html__( ' Following', 'metafans' );
		}else{
			$class = $status = '';
			$text = esc_html__( '+ Follow', 'metafans' );
		}
		
		?>
			<?php if(is_user_logged_in()){ ?>
				<div class="members-action-buttons">
					<?php if( $following_id != get_current_user_id() ){ ?>

						<!-- Follow Button -->
						<a href="" class="bp-th-follow-button <?php echo $class; ?>" data-follower-id="<?php echo $follower_id; ?>" data-following="<?php echo $status; ?>" data-following-id="<?php echo $following_id; ?>"><?php echo $text; ?></a>

						<!-- Add Friend Button -->
						<!--<a href="" class="bp-th-friends-button" data-initiator-id="<?php echo get_current_user_id(); ?>" data-user-id="<?php echo $user_id; ?>" data-action="<?php echo $this->helper->get_friendship_status( $user_id ); ?>"><?php echo $this->helper->get_friend_button_text( $user_id ) ?></a> -->

						<!-- Private Message Button -->
						<a href="#" class="private-msg" data-recipients-id="<?php echo $user_id; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
						<path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path>
						<path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"></path>
						</svg>
						</a>
					<?php }else{ ?>
						<a href="" class="bp-th-friends-button disabled">spacer</a>
					<?php } ?>
				</div>
			<?php } ?>
		<?php
	}
	public function get_follow_status( $user_id ){
		return '';
	}
	function members_gamipress() {

		if( !class_exists('GamiPress_BuddyPress') ){
			return;
		}

	    // if ( bp_is_my_profile() || ! is_user_logged_in() ) {
	    //     return 0;
	    // }
        $user_id = bp_get_member_user_id();
	    if ( ! $user_id && bp_is_user() ) {
	        $user_id = bp_displayed_user_id();
	    }

	    if ( ! $user_id ) {
	        return;
	    }
	    ?>
    	<div class="tophive-buddypress-gamipress">
	    <?php
	    /* -------------------------------
	     * Points
	       ------------------------------- */

	    $points_placement = gamipress_bp_get_option( 'points_placement', '' );

	    if( $points_placement[0] === 'top' || $points_placement[0] === 'both' ) {

	        // Setup points types vars
	        $points_types = gamipress_get_points_types();
	        $points_types_slugs = gamipress_get_points_types_slugs();

	        // Get points display settings
	        $points_types_to_show = gamipress_bp_members_get_points_types();
	        $points_types_thumbnail = (bool) gamipress_bp_get_option( 'members_points_types_top_thumbnail', false );
	        $points_types_thumbnail_size = (int) gamipress_bp_get_option( 'members_points_types_top_thumbnail_size', 25 );
	        $points_types_label = (bool) gamipress_bp_get_option( 'members_points_types_top_label', false );

	        // Parse thumbnail size
	        if( $points_types_thumbnail_size > 0 ) {
	            $points_types_thumbnail_size = array( $points_types_thumbnail_size, $points_types_thumbnail_size );
	        } else {
	            $points_types_thumbnail_size = 'gamipress-points';
	        }

	        if( ! empty( $points_types_to_show ) ) : ?>

	            <div class="gamipress-buddypress-points">

	                <?php foreach( $points_types_to_show as $points_type_to_show ) :

	                // If points type not registered, skip
	                if( ! in_array( $points_type_to_show, $points_types_slugs ) )
	                    continue;

	                $points_type = $points_types[$points_type_to_show];
	                $user_points = gamipress_get_user_points( $user_id, $points_type_to_show ); ?>

	                <div class="gamipress-buddypress-points-type gamipress-buddypress-<?php echo tophive_sanitize_filter($points_type_to_show); ?>">
	                    <?php if( $points_types_thumbnail ) : ?>

	                        <span class="activity gamipress-buddypress-points-thumbnail gamipress-buddypress-<?php echo tophive_sanitize_filter($points_type_to_show); ?>-thumbnail">
	                            <?php echo gamipress_get_points_type_thumbnail( $points_type_to_show, $points_types_thumbnail_size ); ?>
	                        </span>

	                    <?php endif; ?>

	                    <span class="activity gamipress-buddypress-user-points gamipress-buddypress-user-<?php echo tophive_sanitize_filter($points_type_to_show); ?>">
	                        <?php echo tophive_sanitize_filter($user_points); ?>
	                    </span>

	                    <?php // The points label ?>
	                    <?php if( $points_types_label ) : ?>

	                        <span class="activity gamipress-buddypress-points-label gamipress-buddypress-<?php echo tophive_sanitize_filter($points_type_to_show); ?>-label">
	                            <?php echo _n( $points_type['singular_name'], $points_type['plural_name'], $user_points, 'metafans' ); ?>
	                        </span>

	                    <?php endif; ?>

	                </div>

	                <?php endforeach; ?>
	            </div>
	        <?php endif;

	    }

	    /* -------------------------------
	     * Achievements
	       ------------------------------- */

	    $achievements_placement = gamipress_bp_get_option( 'achievements_placement', '' );

	    if( $achievements_placement[0] === 'top' || $achievements_placement[0] === 'both' ) {

	        // Setup achievement types vars
	        $achievement_types = gamipress_get_achievement_types();
	        $achievement_types_slugs = gamipress_get_achievement_types_slugs();

	        // Get achievements display settings
	        $achievement_types_to_show = gamipress_bp_members_get_achievements_types();
	        $achievement_types_thumbnail = (bool) gamipress_bp_get_option( 'members_achievements_top_thumbnail', false );
	        $achievement_types_thumbnail_size = (int) gamipress_bp_get_option( 'members_achievements_top_thumbnail_size', 25 );
	        $achievement_types_title = (bool) gamipress_bp_get_option( 'members_achievements_top_title', false );
	        $achievement_types_link = (bool) gamipress_bp_get_option( 'members_achievements_top_link', false );
	        $achievement_types_label = (bool) gamipress_bp_get_option( 'members_achievements_top_label', false );
	        $achievement_types_limit = (int) gamipress_bp_get_option( 'members_achievements_top_limit', 10 );

	        // Parse thumbnail size
	        if( $achievement_types_thumbnail_size > 0 ) {
	            $achievement_types_thumbnail_size = array( $achievement_types_thumbnail_size, $achievement_types_thumbnail_size );
	        } else {
	            $achievement_types_thumbnail_size = 'gamipress-achievement';
	        }

	        if( ! empty( $achievement_types_to_show ) ) : ?>

	            <div class="gamipress-buddypress-achievements">

	                <?php foreach( $achievement_types_to_show as $achievement_type_to_show ) :

	                    // If achievements type not registered, skip
	                    if( ! in_array( $achievement_type_to_show, $achievement_types_slugs ) )
	                        continue;

	                    $achievement_type = $achievement_types[$achievement_type_to_show];
	                    $user_achievements = gamipress_get_user_achievements( array(
	                        'user_id' => $user_id,
	                        'achievement_type' => $achievement_type_to_show,
	                        'groupby' => 'achievement_id',
	                        'limit' => $achievement_types_limit,
	                    ) );

	                    // If user has not earned any achievements of this type, skip
	                    if( empty( $user_achievements ) ) {
	                        continue;
	                    } ?>

	                    <div class="gamipress-buddypress-achievement gamipress-buddypress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>">

	                        <?php // The achievement type label ?>
	                        <?php if( $achievement_types_label ) : ?>
	                        <span class="activity gamipress-buddypress-achievement-type-label gamipress-buddypress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>-label">
	                            <?php echo tophive_sanitize_filter($achievement_type['plural_name']); ?>:
	                        </span>
	                        <?php endif; ?>

	                        <?php // Lets to get just the achievement thumbnail and title
	                        foreach( $user_achievements as $user_achievement ) : ?>

	                            <?php // The achievement thumbnail ?>
	                            <?php if( $achievement_types_thumbnail ) : ?>

	                                <?php // The achievement link ?>
	                                <?php if( $achievement_types_link ) : ?>

	                                    <a href="<?php echo get_permalink( $user_achievement->ID ); ?>" title="<?php echo get_the_title( $user_achievement->ID ); ?>" class="activity gamipress-buddypress-achievement-thumbnail gamipress-buddypress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>-thumbnail">
	                                        <?php echo gamipress_get_achievement_post_thumbnail( $user_achievement->ID, $achievement_types_thumbnail_size ); ?>
	                                    </a>

	                                <?php else : ?>

	                                    <span title="<?php echo get_the_title( $user_achievement->ID ); ?>" class="activity gamipress-buddypress-achievement-thumbnail gamipress-buddypress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>-thumbnail">
	                                        <?php echo gamipress_get_achievement_post_thumbnail( $user_achievement->ID, $achievement_types_thumbnail_size ); ?>
	                                    </span>

	                                <?php endif; ?>

	                            <?php endif; ?>

	                            <?php // The achievement title ?>
	                            <?php if( $achievement_types_title ) : ?>

	                                <?php // The achievement link ?>
	                                <?php if( $achievement_types_link ) : ?>

	                                    <a href="<?php echo get_permalink( $user_achievement->ID ); ?>" title="<?php echo get_the_title( $user_achievement->ID ); ?>" class="gamipress-buddypress-achievement-title gamipress-buddypress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>-title">
	                                        <?php echo get_the_title( $user_achievement->ID ); ?>
	                                    </a>

	                                <?php else : ?>

	                                    <span class="activity gamipress-buddypress-achievement-title gamipress-buddypress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>-title">
	                                        <?php echo get_the_title( $user_achievement->ID ); ?>
	                                    </span>

	                                <?php endif; ?>

	                            <?php endif; ?>

	                        <?php endforeach; ?>

	                    </div>

	                <?php endforeach; ?>

	            </div>

	        <?php endif;

	    }

	    /* -------------------------------
	     * Ranks
	       ------------------------------- */

	    $ranks_placement = gamipress_bp_get_option( 'ranks_placement', '' );

	    if( $ranks_placement[0] === 'top' || $ranks_placement[0] === 'both' ) {

	        // Setup rank types vars
	        $rank_types = gamipress_get_rank_types();
	        $rank_types_slugs = gamipress_get_rank_types_slugs();

	        // Get ranks display settings
	        $rank_types_to_show = gamipress_bp_members_get_ranks_types();
	        $rank_types_thumbnail = (bool) gamipress_bp_get_option( 'members_ranks_top_thumbnail', false );
	        $rank_types_thumbnail_size = (int) gamipress_bp_get_option( 'members_ranks_top_thumbnail_size', 25 );
	        $rank_types_title = (bool) gamipress_bp_get_option( 'members_ranks_top_title', false );
	        $rank_types_link = (bool) gamipress_bp_get_option( 'members_ranks_top_link', false );
	        $rank_types_label = (bool) gamipress_bp_get_option( 'members_ranks_top_label', false );

	        // Parse thumbnail size
	        if( $rank_types_thumbnail_size > 0 ) {
	            $rank_types_thumbnail_size = array( $rank_types_thumbnail_size, $rank_types_thumbnail_size );
	        } else {
	            $rank_types_thumbnail_size = 'gamipress-rank';
	        }

	        if( ! empty( $rank_types_to_show ) ) : ?>

	            <div class="gamipress-buddypress-ranks">

	                <?php foreach( $rank_types_to_show as $rank_type_to_show ) :

	                    // If rank type not registered, skip
	                    if( ! in_array( $rank_type_to_show, $rank_types_slugs ) )
	                        continue;

	                    $rank_type = $rank_types[$rank_type_to_show];
	                    $user_rank = gamipress_get_user_rank( $user_id, $rank_type_to_show ); ?>

	                    <div class="gamipress-buddypress-rank gamipress-buddypress-<?php echo tophive_sanitize_filter($rank_type_to_show); ?>">

	                        <?php // The rank type label ?>
	                        <?php if( $rank_types_label ) : ?>
	                        <span class="activity gamipress-buddypress-rank-label gamipress-buddypress-<?php echo tophive_sanitize_filter($rank_type_to_show); ?>-label">
	                            <?php echo tophive_sanitize_filter($rank_type['singular_name']); ?>:
	                        </span>
	                        <?php endif; ?>

	                        <?php // The rank thumbnail ?>
	                        <?php if( $rank_types_thumbnail ) : ?>

	                            <?php // The rank link ?>
	                            <?php if( $rank_types_link ) : ?>

	                                <a href="<?php echo get_permalink( $user_rank->ID ); ?>" title="<?php echo tophive_sanitize_filter($user_rank->post_title); ?>" class="activity gamipress-buddypress-rank-thumbnail gamipress-buddypress-<?php echo tophive_sanitize_filter($rank_type_to_show); ?>-thumbnail">
	                                    <?php echo gamipress_get_rank_post_thumbnail( $user_rank->ID, $rank_types_thumbnail_size ); ?>
	                                </a>

	                            <?php else : ?>

	                                <span title="<?php echo tophive_sanitize_filter($user_rank->post_title); ?>" class="activity gamipress-buddypress-rank-thumbnail gamipress-buddypress-<?php echo tophive_sanitize_filter($rank_type_to_show); ?>-thumbnail">
	                                <?php echo gamipress_get_rank_post_thumbnail( $user_rank->ID, $rank_types_thumbnail_size ); ?>
	                            </span>

	                            <?php endif; ?>

	                        <?php endif; ?>

	                        <?php // The rank title ?>
	                        <?php if( $rank_types_title ) : ?>

	                            <?php // The rank link ?>
	                            <?php if( $rank_types_link ) : ?>

	                                <a href="<?php echo get_permalink( $user_rank->ID ); ?>" title="<?php echo tophive_sanitize_filter($user_rank->post_title); ?>" class="activity gamipress-buddypress-rank-title gamipress-buddypress-<?php echo tophive_sanitize_filter($rank_type_to_show); ?>-title">
	                                    <?php echo tophive_sanitize_filter($user_rank->post_title); ?>
	                                </a>

	                            <?php else : ?>

	                                <span class="activity gamipress-buddypress-rank-title gamipress-buddypress-<?php echo tophive_sanitize_filter($rank_type_to_show); ?>-title">
	                                <?php echo tophive_sanitize_filter($user_rank->post_title); ?>
	                            </span>

	                            <?php endif; ?>

	                        <?php endif; ?>

	                    </div>

	                <?php endforeach; ?>
	            </div>
	        <?php endif;

	    }
	    ?>
	    	</div>
	    <?php

	}


}
function Tophive_BP_Members() {
	return Tophive_BP_Members::get_instance();
}

if ( tophive_metafans()->is_buddypress_active() ) {
	Tophive_BP_Members();
}