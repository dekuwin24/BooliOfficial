<?php 
/**
 * MetaFans Integration for BuddyBress, Buddypress-gammiperss, Buddypress-learnpress
 */
class Tophive_BBP
{
    static $_instance;

	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function is_active() {
		return tophive_metafans()->is_bbpress_active();
	}
	function __construct(){
		if( $this->is_active() ){
			add_action( 'wp_enqueue_scripts', array($this, 'load_scripts') );
		}
		add_action( 'bbp_theme_before_topic_content', array( $this, 'bbp_topic_title' ) );
		if( class_exists('GamiPress_bbPress') && class_exists('GamiPress') ){
			add_action( 'th_bbp_gamipress_author', array( $this, 'bbp_gamipress_author' ), 10, 1 );
			add_action( 'th_bbp_gamipress_author', array( $this, 'bbp_gamipress_author_achievements_count' ), 11, 1 );
			add_action( 'bbp_theme_after_reply_author_details', array( $this, 'bbp_gamipress_author_achievements_count' ), 11, 1 );
		}
		add_action( 'wp_ajax_th_bbp_new_reply', array($this, 'tophive_bbp_new_reply') );
        add_action( 'wp_ajax_nopriv_th_bbp_new_reply', array($this, 'tophive_bbp_new_reply') );
        add_filter( 'bbp_get_forum_pagination_count', array($this, 'tophive_bbp_pagination_text_filter') );
        add_action( 'tophive/sidebar-id', array($this, 'th_bbpress_sidebar'), 10, 3 );
	}
	function th_bbpress_sidebar( $id, $type, $location ){
		if( $this->is_active() ){
			if( $location == 'forum-single' ){
				switch( $type ){
					case 'secondary':
							return 'bbp-forum-single-sidebar-left';
						break;
					default:
							return 'bbp-forum-single-sidebar-right';
						break;
				}
			}elseif ( $location == 'topic-single' ) {
				switch( $type ){
					case 'primary':
							return 'bbp-topic-single-sidebar-1';
						break;
					case 'secondary':
							return 'bbp-topic-single-sidebar-2';
						break;
					default:
							return 'bbp-topic-single-sidebar-1';
						break;
				}
			}
		}else{
			return $id;
		}
		return $id;
	}
	function tophive_bbp_pagination_text_filter( $str ){
		$arr = explode('-', $str);
		return $arr[0];
	}
	function load_scripts(){
		wp_enqueue_style( 'th-bbpress', get_template_directory_uri() . '/assets/css/compatibility/bbpress.css', $deps = array(), $ver = false, $media = 'all' );
	}
	private function bbp_topic_title(){
		return bbp_topic_title();
	}
	public function tophive_bbp_new_reply(){
		$data = $_REQUEST['data'];
		$response = [];
		$action = $data['action'];
		// Bail if action is not bbp-new-reply
		if ( 'bbp-new-reply' !== $action ) {
			return;
		}

		// Define local variable(s)
		$topic_id = $forum_id = $reply_author = $reply_to = 0;
		$reply_title = $reply_content = $terms = '';
		$anonymous_data = array();

		/** Reply Author **********************************************************/

		// User is anonymous
		if ( bbp_is_anonymous() ) {

			// Filter anonymous data (variable is used later)
			$anonymous_data = bbp_filter_anonymous_post_data();

			// Anonymous data checks out, so set cookies, etc...
			bbp_set_current_anonymous_user_data( $anonymous_data );

		// User is logged in
		} else {

			// User cannot create replies
			if ( ! current_user_can( 'publish_replies' ) ) {
				$response['errors'][] = esc_html__( 'You do not have permission to reply', 'metafans' );
			}

			// Reply author is current user
			$reply_author = bbp_get_current_user_id();
		}

		/** Topic ID **************************************************************/

		// Topic id was not passed
		if ( empty( $_REQUEST['data']['bbp_topic_id'] ) ) {
			$response['errors'][] = esc_html__( 'Topic ID is missing', 'metafans' );

		// Topic id is not a number
		} elseif ( ! is_numeric( $_REQUEST['data']['bbp_topic_id'] ) ) {
			$response['errors'][] = esc_html__( 'Topic ID must be a number', 'metafans' );

		// Topic id might be valid
		} else {

			// Get the topic id
			$posted_topic_id = intval( $_REQUEST['data']['bbp_topic_id'] );

			// Topic id is a negative number
			if ( 0 > $posted_topic_id ) {
				$response['errors'][] = esc_html__( 'Topic ID cannot be a negative number', 'metafans' );

			// Topic does not exist
			} elseif ( ! bbp_get_topic( $posted_topic_id ) ) {
				$response['errors'][] = esc_html__( 'Topic does not exist', 'metafans' );

			// Use the POST'ed topic id
			} else {
				$topic_id = $posted_topic_id;
			}
		}

		/** Forum ID **************************************************************/

		// Try to use the forum id of the topic
		if ( ! isset( $_REQUEST['data']['bbp_forum_id'] ) && ! empty( $topic_id ) ) {
			$forum_id = bbp_get_topic_forum_id( $topic_id );

		// Error check the POST'ed forum id
		} elseif ( isset( $_REQUEST['data']['bbp_forum_id'] ) ) {

			// Empty Forum id was passed
			if ( empty( $_REQUEST['data']['bbp_forum_id'] ) ) {
				$response['errors'][] = esc_html__( 'Forum ID is missing', 'metafans' );

			// Forum id is not a number
			} elseif ( ! is_numeric( $_REQUEST['data']['bbp_forum_id'] ) ) {
				$response['errors'][] = esc_html__( 'Forum ID must be a number', 'metafans' );

			// Forum id might be valid
			} else {

				// Get the forum id
				$posted_forum_id = intval( $_REQUEST['data']['bbp_forum_id'] );

				// Forum id is empty
				if ( 0 === $posted_forum_id ) {
					$response['errors'][] = esc_html__( 'Forum ID is missing', 'metafans' );

				// Forum id is a negative number
				} elseif ( 0 > $posted_forum_id ) {
					$response['errors'][] = esc_html__( 'Forum ID cannot be a negative number', 'metafans' );

				// Forum does not exist
				} elseif ( ! bbp_get_forum( $posted_forum_id ) ) {
					$response['errors'][] = esc_html__( 'Forum does not exist', 'metafans' );

				// Use the POST'ed forum id
				} else {
					$forum_id = $posted_forum_id;
				}
			}
		}

		// Forum exists
		if ( ! empty( $forum_id ) ) {

			// Forum is a category
			if ( bbp_is_forum_category( $forum_id ) ) {
				$response['errors'][] = esc_html__( 'This forum is a category. No replies can be created in this forum', 'metafans' );

			// Forum is not a category
			} else {

				// Forum is closed and user cannot access
				if ( bbp_is_forum_closed( $forum_id ) && ! current_user_can( 'edit_forum', $forum_id ) ) {
					$response['errors'][] = esc_html__( 'This forum has been closed to new replies', 'metafans');
				}

				// Forum is private and user cannot access
				if ( bbp_is_forum_private( $forum_id ) && ! current_user_can( 'read_forum', $forum_id ) ) {
					$response['errors'][] = esc_html__( 'This forum is private and you do not have the capability to read or create new replies in it', 'metafans' );

				// Forum is hidden and user cannot access
				} elseif ( bbp_is_forum_hidden( $forum_id ) && ! current_user_can( 'read_forum', $forum_id ) ) {
					$response['errors'][] = esc_html__( 'This forum is hidden and you do not have the capability to read or create new replies in it', 'metafans' );
				}
			}
		}

		/** Unfiltered HTML *******************************************************/

		// // Remove kses filters from title and content for capable users and if the nonce is verified
		// if ( current_user_can( 'unfiltered_html' ) && ! empty( $_POST['_bbp_unfiltered_html_reply'] ) && wp_create_nonce( 'bbp-unfiltered-html-reply_' . $topic_id ) === $_POST['_bbp_unfiltered_html_reply'] ) {
			remove_filter( 'bbp_new_reply_pre_title',   'wp_filter_kses'      );
			remove_filter( 'bbp_new_reply_pre_content', 'bbp_encode_bad',  10 );
			remove_filter( 'bbp_new_reply_pre_content', 'bbp_filter_kses', 30 );
		// }

		/** Reply Title ***********************************************************/

		if ( ! empty( $_REQUEST['data']['bbp_reply_title'] ) ) {
			$reply_title = sanitize_text_field( $_REQUEST['data']['bbp_reply_title'] );
		}

		// Filter and sanitize
		$reply_title = apply_filters( 'bbp_new_reply_pre_title', $reply_title );

		// Title too long
		if ( bbp_is_title_too_long( $reply_title ) ) {
			$response['errors'][] = esc_html__( 'Your title is too long', 'metafans' );
		}

		/** Reply Content *********************************************************/

		if ( ! empty( $_REQUEST['data']['bbp_reply_content'] ) ) {
			$reply_content = $_REQUEST['data']['bbp_reply_content'];
		}

		// Filter and sanitize
		$pattern = "/<p[^>]*><\\/p[^>]*>/";
		$reply_content = preg_replace( $pattern, '', $reply_content ); 
		$reply_content = apply_filters( 'bbp_new_reply_pre_content', trim($reply_content) );

		// No reply content
		if ( empty( $reply_content ) ) {
			$response['errors'][] = esc_html__( 'Your reply cannot be empty', 'metafans' );
		}

		/** Reply Flooding ********************************************************/

		if ( ! bbp_check_for_flood( $anonymous_data, $reply_author ) ) {
			$response['errors'][] = esc_html__( 'Slow down; you move too fast', 'metafans' );
		}

		/** Reply Duplicate *******************************************************/

		if ( ! bbp_check_for_duplicate( array( 'post_type' => bbp_get_reply_post_type(), 'post_author' => $reply_author, 'post_content' => $reply_content, 'post_parent' => $topic_id, 'anonymous_data' => $anonymous_data ) ) ) {
			$response['errors'][] = esc_html__( 'Duplicate reply detected; it looks as though you&#8217;ve already said that', 'metafans' );
		}

		/** Reply Bad Words *******************************************************/

		if ( ! bbp_check_for_moderation( $anonymous_data, $reply_author, $reply_title, $reply_content, true ) ) {
			$response['errors'][] = esc_html__( 'Your reply cannot be created at this time', 'metafans' );
		}

		/** Reply Status **********************************************************/

		// Maybe put into moderation
		if ( bbp_is_topic_pending( $topic_id ) || ! bbp_check_for_moderation( $anonymous_data, $reply_author, $reply_title, $reply_content ) ) {
			$reply_status = bbp_get_pending_status_id();

		// Default
		} else {
			$reply_status = bbp_get_public_status_id();
		}

		/** Reply To **************************************************************/

		// Handle Reply To of the reply; $_REQUEST for non-JS submissions
		if ( isset( $_REQUEST['bbp_reply_to'] ) ) {
			$reply_to = bbp_validate_reply_to( $_REQUEST['bbp_reply_to'] );
		}

		/** Topic Closed **********************************************************/

		// If topic is closed, moderators can still reply
		if ( bbp_is_topic_closed( $topic_id ) && ! current_user_can( 'moderate', $topic_id ) ) {
			$response['errors'][] = esc_html__( 'Topic is closed', 'metafans' );
		}

		/** Topic Tags ************************************************************/

		// Either replace terms
		if ( bbp_allow_topic_tags() && current_user_can( 'assign_topic_tags', $topic_id ) && ! empty( $_REQUEST['data']['bbp_topic_tags'] ) ) {
			$terms = sanitize_text_field( $_REQUEST['data']['bbp_topic_tags'] );

		// ...or remove them.
		} elseif ( isset( $_REQUEST['data']['bbp_topic_tags'] ) ) {
			$terms = '';

		// Existing terms
		} else {
			$terms = bbp_get_topic_tag_names( $topic_id );
		}

		/** Additional Actions (Before Save) **************************************/

		do_action( 'bbp_new_reply_pre_extras', $topic_id, $forum_id );

		// Bail if errors
		if ( !empty($response['errors']) ) {
			wp_send_json( $response, 200 );
			return;
		}

		/** No Errors *************************************************************/

		// Add the content of the form to $reply_data as an array
		// Just in time manipulation of reply data before being created
		$reply_data = apply_filters( 'bbp_new_reply_pre_insert', array(
			'post_author'    => $reply_author,
			'post_title'     => $reply_title,
			'post_content'   => $reply_content,
			'post_status'    => $reply_status,
			'post_parent'    => $topic_id,
			'post_type'      => bbp_get_reply_post_type(),
			'comment_status' => 'closed',
			'menu_order'     => bbp_get_topic_reply_count( $topic_id, true ) + 1
		) );

		// Insert reply
		$reply_id = wp_insert_post( $reply_data, true );

		/** No Errors *************************************************************/

		// Check for missing reply_id or error
		if ( ! empty( $reply_id ) && ! is_wp_error( $reply_id ) ) {

			/** Topic Tags ********************************************************/

			// Just in time manipulation of reply terms before being edited
			$terms = apply_filters( 'bbp_new_reply_pre_set_terms', $terms, $topic_id, $reply_id );

			// Insert terms
			$terms = wp_set_post_terms( $topic_id, $terms, bbp_get_topic_tag_tax_id(), false );

			// Term error
			if ( is_wp_error( $terms ) ) {
				$response['errors'][] = esc_html__( 'There was a problem adding the tags to the topic', 'metafans' );
			}

			/** Trash Check *******************************************************/

			// If this reply starts as trash, add it to pre_trashed_replies
			// for the topic, so it is properly restored.
			if ( bbp_is_topic_trash( $topic_id ) || ( $reply_data['post_status'] === bbp_get_trash_status_id() ) ) {

				// Trash the reply
				wp_trash_post( $reply_id );

				// Only add to pre-trashed array if topic is trashed
				if ( bbp_is_topic_trash( $topic_id ) ) {

					// Get pre_trashed_replies for topic
					$pre_trashed_replies = (array) get_post_meta( $topic_id, '_bbp_pre_trashed_replies', true );

					// Add this reply to the end of the existing replies
					$pre_trashed_replies[] = $reply_id;

					// Update the pre_trashed_reply post meta
					update_post_meta( $topic_id, '_bbp_pre_trashed_replies', $pre_trashed_replies );
				}

			/** Spam Check ********************************************************/

			// If reply or topic are spam, officially spam this reply
			} elseif ( bbp_is_topic_spam( $topic_id ) || ( $reply_data['post_status'] === bbp_get_spam_status_id() ) ) {
				add_post_meta( $reply_id, '_bbp_spam_meta_status', bbp_get_public_status_id() );

				// Only add to pre-spammed array if topic is spam
				if ( bbp_is_topic_spam( $topic_id ) ) {

					// Get pre_spammed_replies for topic
					$pre_spammed_replies = (array) get_post_meta( $topic_id, '_bbp_pre_spammed_replies', true );

					// Add this reply to the end of the existing replies
					$pre_spammed_replies[] = $reply_id;

					// Update the pre_spammed_replies post meta
					update_post_meta( $topic_id, '_bbp_pre_spammed_replies', $pre_spammed_replies );
				}
			}

			/** Update counts, etc... *********************************************/

			do_action( 'bbp_new_reply', $reply_id, $topic_id, $forum_id, $anonymous_data, $reply_author, false, $reply_to );

			/** Additional Actions (After Save) ***********************************/

			do_action( 'bbp_new_reply_post_extras', $reply_id );

			/** Redirect **********************************************************/

			// Redirect to
			$redirect_to = bbp_get_redirect_to();

			/** Successful Save ***************************************************/

			$response['success']['goto'] = $_REQUEST['data']['redirect_to'];
			$response['success']['text'] = esc_html__( 'Replied Successfuly', 'metafans' );

		/** Errors ****************************************************************/

		// WP_Error
		} elseif ( is_wp_error( $reply_id ) ) {
			$response['errors'][] = sprintf( __( 'The following problem(s) occurred: %s', 'metafans' ), $reply_id->get_error_message() );

		// Generic error
		} else {
			$response['errors'][] = esc_html__( 'The reply was not created', 'metafans' );
		}
		wp_send_json( $response, 200 );
	}
	public function bbp_gamipress_author_achievements_count( $user_id ){
		// Check desired points types
	    $achievement_types = gamipress_get_achievement_types_slugs();
	    

	    // Force to set current user as user ID

	    $earned_achievements = 0;

	    foreach( $achievement_types as $achievement_type ) {

	        // Ensure that this points type slug is registered
	        if( ! in_array( $achievement_type, gamipress_get_achievement_types_slugs() ) ) {
	            continue;
	        }

	        $earned_achievements += count( gamipress_get_user_achievements( array(
	            'user_id'           => $user_id,
	            'achievement_type'  => $achievement_type,
	        ) ) );
	    }

	    // Return the sum of achievements earned of all or specific points types
	    if( $earned_achievements == 0 ){
	    	echo '';
	    }else{
		    $total = $earned_achievements - 1;

		    echo '<span class="gp-achievements-count">+ ' . $total . '</span>';
	    }
	}
	public function bbp_gamipress_author( $user_id ){

	    /* -------------------------------
	     * Achievement Types
	       ------------------------------- */

	    // Setup achievement types vars
	    $achievement_types = gamipress_get_achievement_types();
	    $achievement_types_slugs = gamipress_get_achievement_types_slugs();

	    // Get achievement type display settings
	    $achievement_types_to_show          = gamipress_bbp_get_achievement_types();
	    $achievement_types_thumbnail        = (bool) gamipress_bbp_get_option( 'achievement_types_thumbnail', false );
	    $achievement_types_thumbnail_size   = (int) gamipress_bbp_get_option( 'achievement_types_thumbnail_size', 25 );
	    $achievement_types_title            = (bool) gamipress_bbp_get_option( 'achievement_types_title', false );
	    $achievement_types_link             = (bool) gamipress_bbp_get_option( 'achievement_types_link', false );
	    $achievement_types_label            = (bool) gamipress_bbp_get_option( 'achievement_types_label', false );
	    $achievements_limit                 = absint( gamipress_bbp_get_option( 'achievements_limit', '' ) );


	    // Parse thumbnail size
	    if( $achievement_types_thumbnail_size > 0 ) {
	        $achievement_types_thumbnail_size = array( $achievement_types_thumbnail_size, $achievement_types_thumbnail_size );
	    } else {
	        $achievement_types_thumbnail_size = 'gamipress-achievement';
	    }

	    if( ! empty( $achievement_types_to_show ) ) : ?>

	        <div class="gamipress-bbpress-achievements">

	            <?php foreach( $achievement_types_to_show as $achievement_type_to_show ) :

	                // If achievements type not registered, skip
	                if( ! in_array( $achievement_type_to_show, $achievement_types_slugs ) )
	                    continue;

	                $achievement_type = $achievement_types[$achievement_type_to_show];
	                $user_achievements = gamipress_get_user_achievements( array(
	                    'user_id' => $user_id,
	                    'achievement_type' => $achievement_type_to_show,
	                    'limit' => ( $achievements_limit > 0 ? $achievements_limit : -1 ),
	                    'groupby' => 'achievement_id',
	                    'display' => true,
	                ) );

	                // If user has not earned any achievements of this type, skip
	                if( empty( $user_achievements ) ) {
	                    continue;
	                } ?>

	                <div class="gamipress-bbpress-achievement gamipress-bbpress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>">

	                    <?php // The achievement type label
	                    if( $achievement_types_label) : ?>
	                        <span class="gamipress-bbpress-achievement-type-label gamipress-bbpress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>-label">
	                            <?php echo tophive_sanitize_filter($achievement_type['plural_name']); ?>:
	                        </span>
	                    <?php endif; ?>

	                    <?php // Lets to get just the achievement thumbnail and title
	                    foreach( $user_achievements as $user_achievement ) : ?>

	                        <?php // The achievement thumbnail ?>
	                        <?php if( $achievement_types_thumbnail ) :
	                            $achievement_thumbnail = gamipress_get_achievement_post_thumbnail( $user_achievement->ID, $achievement_types_thumbnail_size ); ?>

	                            <?php if( ! empty( $achievement_thumbnail ) ) : ?>

	                                <?php // The achievement link ?>
	                                <?php if( $achievement_types_link ) : ?>

	                                    <a href="<?php echo get_permalink( $user_achievement->ID ); ?>" title="<?php echo get_the_title( $user_achievement->ID ); ?>" class="gamipress-bbpress-achievement-thumbnail gamipress-bbpress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>-thumbnail">
	                                        <?php echo tophive_sanitize_filter($achievement_thumbnail); ?>
	                                    </a>

	                                <?php else : ?>

	                                    <span title="<?php echo get_the_title( $user_achievement->ID ); ?>" class="gamipress-bbpress-achievement-thumbnail gamipress-bbpress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>-thumbnail">
	                                        <?php echo tophive_sanitize_filter($achievement_thumbnail); ?>
	                                    </span>

	                                <?php endif; ?>

	                            <?php endif; ?>

	                        <?php endif; ?>

	                        <?php // The achievement title ?>
	                        <?php if( $achievement_types_title ) :
	                            $achievement_title = get_the_title( $user_achievement->ID ); ?>

	                            <?php if( ! empty( $achievement_title ) ) : ?>

	                                <?php // The achievement link ?>
	                                <?php if( $achievement_types_link ) : ?>

	                                    <a href="<?php echo get_permalink( $user_achievement->ID ); ?>" title="<?php echo get_the_title( $user_achievement->ID ); ?>" class="gamipress-bbpress-achievement-title gamipress-bbpress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>-title">
	                                        <?php echo tophive_sanitize_filter($achievement_title); ?>
	                                    </a>

	                                <?php else : ?>

	                                    <span class="gamipress-bbpress-achievement-title gamipress-bbpress-<?php echo tophive_sanitize_filter($achievement_type_to_show); ?>-title">
	                                        <?php echo tophive_sanitize_filter($achievement_title); ?>
	                                    </span>

	                                <?php endif; ?>

	                            <?php endif; ?>

	                        <?php endif; ?>

	                    <?php endforeach; ?>

	                </div>

	            <?php endforeach; ?>

	        </div>

	    <?php endif;

		}
	}
function Tophive_BBP() {
	return Tophive_BBP::get_instance();
}

if ( tophive_metafans()->is_bbpress_active() ) {
	Tophive_BBP();
}	