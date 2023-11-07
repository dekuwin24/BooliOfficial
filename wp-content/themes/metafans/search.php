<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package tophive
 */

function mf_get_time_since($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'min',
	        's' => 'sec',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . esc_html__(' ago', 'metafans') : esc_html__('just now', 'metafans');
	}

get_header(); ?>
	<div class="content-inner">
		<div class="search-contents">
		<?php
		do_action( 'tophive/content/before' );
		tophive_blog_posts_heading();

		$searchtext = $_GET['s'];
		$posts_per_page = 3;
		//Tabs 
		$tabs = [
			array("text" => __("All","metafans"),	    "id" => "mf-search-all-tab" ),
			array("text" => __("Users","metafans"),	    "id" => "mf-search-user-tab" ),
			array("text" => __("Activity","metafans"),  "id" => "mf-search-activity-tab" ),
			array("text" => __("Forum","metafans"),     "id" => "mf-search-forum-tab" ),
			array("text" => __("Topics","metafans"),    "id" => "mf-search-topics-tab" ),
			array("text" => __("Blogs","metafans"),     "id" => "mf-search-blogs-tab" ),
		];


		//user query
		$users_query = new WP_User_Query( array(
		    'search'         => '*'.esc_attr( $searchtext ).'*',
		    'number'	     => $posts_per_page,
		    'search_columns' => array(
			'user_login',
			'user_nicename',
		    ),
		) );

		$users = $users_query->get_results();
		
		// Activities Query
		global $wpdb;
		$activities_sql = $wpdb->prepare("SELECT * FROM {$wpdb->base_prefix}bp_activity  WHERE content LIKE '%%%s%%' ORDER BY id DESC  LIMIT %d ",array( $searchtext,$posts_per_page ));

		$activities_results = $wpdb->get_results( $activities_sql );

		//forum query
		$forum_query = new WP_Query(array(
			"s"	=> $searchtext,
			"post_type" => "forum",
			"posts_per_page" => $posts_per_page,
		));

		//topics query
		$topics_query = new WP_Query(array(
			"s"	=> $searchtext,
			"post_type" => "topic",
			"posts_per_page" => $posts_per_page,
		));
		$topics = '';
		if( $topics_query->have_posts() ){
			$topics .= '<div class="search-section">';
			while( $topics_query->have_posts() ){
				$topics_query->the_post();

				if( function_exists('bbp_get_topic_forum_id') && function_exists('bbp_get_forum_title') ){
					$forum_id = bbp_get_topic_forum_id( get_the_ID() );
					$forum_title = ! empty( $forum_id ) ? bbp_get_forum_title( $forum_id ) : '';
					$forum_link = ! empty( $forum_id ) ? bbp_get_forum_permalink( $forum_id ) : '';
				}else{
					$forum_title = '';
				}

				$last_updated_by = '';
				$last_active = get_post_meta( get_the_ID(), '_bbp_last_active_time', true );
				if ( empty( $last_active ) ) {
					$reply_id = bbp_get_topic_last_reply_id( get_the_ID() );
					if ( ! empty( $reply_id ) ) {
						$last_active = get_post_field( 'post_date', $reply_id );
					} else {
						$last_active = get_post_field( 'post_date', get_the_ID() );
					}
				}
				$last_updated_by = bbp_get_author_link( array( 'post_id' => bbp_get_topic_last_reply_id( get_the_ID() ), 'size' => 20 ) );
				
				$last_active = ! empty( $last_updated_by ) ? bbp_get_time_since( bbp_convert_date( $last_active ) ) : '';

				$topics .= '<div class="tophive-forum-topic-loop-single recent-topics">
					<div class="tophive-forum-topic-loop-single-avatar">
						'. get_avatar( get_the_author_meta( 'ID' ), 40 ) .'
					</div>
					<div class="tophive-forum-topic-loop-single-details">
						<div class="tophive-forum-topic-loop-single-meta">
							<span><a href="">'. get_the_author_meta('display_name') .'</a></span>
								• <span>Posted in : <a href="'. $forum_link .'">'. $forum_title .'</a></span>
						</div>
						<h6><a href="'. bbp_get_topic_permalink(get_the_ID()) .'">'. get_the_title() .'</a></h6>
						<p>'. get_the_excerpt() .'</p>

						<div class="tophive-forum-topic-loop-single-footer-meta">
							<span class="replies"><svg width="0.9em" height="0.9em" viewBox="0 0 16 16" class="bi bi-chat-right-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M2 1h12a1 1 0 0 1 1 1v11.586l-2-2A2 2 0 0 0 11.586 11H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
								<path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg> '. bbp_get_topic_reply_count(get_the_ID()) . esc_html__( ' Replies', 'metafans' ) .'</span>
							<span class="last-active-time">
								'. $last_updated_by . $last_active .'
							</span>
						</div>
					</div>
				</div>';
			}
			$topics .= '</div>';
		}
		//blogs query
		$blogs_query = new WP_Query(array(
			"s"	=> $searchtext,
			"post_type" => "post",
			"posts_per_page" => $posts_per_page,
		));
?>

	<div class="main-search-page">

		<!-- <div class="search-page-tabs">
			<ul>
				<?php foreach($tabs as $tab): ?>
					<li><a class="search-tab" id="<?php echo $tab["id"] ?>" href="#"><?php echo $tab["text"]?></a></li>
				<?php endforeach; ?>
			</ul>
		</div> -->

		<div class="search-page-main-content">
		
		<?php if( count($activities_results) > 0 ){ ?>
		<div class="found_activity_result search-result-sections">
			<h4><?php esc_html_e( 'Activities', 'metafans' ); ?></h4>
			<?php foreach($activities_results as $activity): ?>
				<!-- <a> -->
					<div class="activity_item">
						<div class="activity_avatar">
							<?php echo get_avatar( $activity->user_id); ?>
						</div>
					<div>
						<span class="activity_action"><?php echo $activity->action; ?></span>
						<span class="activity_time"><?php echo mf_get_time_since($activity->date_recorded); ?></span>
					</div>
					<span class="activity_content"><?php echo $activity->content; ?></span>
					</div>
				<!-- </a> -->
			<?php endforeach; ?>
		</div>
		<?php } ?>

		<?php if( count($users) > 0 ){ ?>
			<div class="found_user_result search-result-sections">
				<h4><?php esc_html_e( 'Users', 'metafans' ); ?></h4>
		   	<?php foreach($users as $user): ?>
		   	<a href="<?php echo bp_core_get_user_domain($user->ID) ?>">
				<div class="user_item">
					<?php echo get_avatar($user->ID);?>
			   		<p class="user_name"><?php echo $user->user_nicename; ?></p>
				</div>
		   	</a>
		   <?php endforeach; ?>
		</div>
		<?php } ?>
		
		<?php if($topics_query->have_posts()){ ?>
			<div class="found_topics_result search-result-sections">
				<h4><?php esc_html_e( 'Topics', 'metafans' ); ?></h4>
				<?php echo $topics; ?>
			</div>
		<?php } ?>


	  </div>

	</div>
   <?php do_action( 'tophive/content/after' ) ?>
</div>
</div><!-- #.content-inner -->

<script>
 const searchUrl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
</script>
<script src="<?php echo get_stylesheet_directory_uri() . "/assets/js/search.js" ?>"></script>
<?php
get_footer();
