<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;


		$forum_args = array(
			'post_type' => 'forum',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'post_parent' => 0
		);
		$forum = new \WP_Query($forum_args);
if( $forum->have_posts() ){
while( $forum->have_posts() ){
	$forum->the_post();

	$last_active_id = bbp_get_forum_last_active_id(get_the_ID());
	$main_title = get_the_title(); 
	$main_desc = get_the_content(); 
	$forum_childs_args = array(
		'post_type' 	 => 'forum',
		'post_status' 	 => 'publish',
		'post_parent'    => get_the_ID(),
		'posts_per_page' => -1,
	);
	$forum_childs = new \WP_Query( $forum_childs_args );

	if( $forum_childs->have_posts() ){
		echo '<h6 class="th-forum-main-heading">' . $main_title . '</h6>';
		echo '<p>' . $main_desc . '</p>';
		while ( $forum_childs->have_posts() ) {
		    $forum_childs->the_post();
		    ?>
			<div class="tophive-forum-topic-loop-single">
		    	<div class="tophive-forum-topic-loop-single-details tophive-forums">
					<h4>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="single-icon" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z"/>
						</svg>
						<a class="theme-secondary-color" href="<?php echo bbp_get_forum_permalink(get_the_ID()); ?>">
								<?php 
									the_title();
									echo '<span>' . get_the_content() . '</span>';
								?>
						</a>

					</h4>
				</div>

				<div class="tophive-forum-topic-loop-single-footer-meta">
					<div class="meta-item">
						<?php 
							echo '<span>';
							global $wpdb;
							$post_ide = get_the_ID();
							$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_parent={$post_ide} and post_type='topic'");
							echo count($results);
							echo '</span>';
							esc_html_e( ' Topics', 'metafans' ); ?>
					</div>
					<div class="meta-item last-active-time">
						<?php 
							echo '<span>';
							echo bbp_forum_reply_count(get_the_ID());
							echo '</span>';
							esc_html_e( ' Replies', 'metafans' ); ?>
					</div>
				</div>
				<div class="tophive-forum-last-topic">
					<?php if( bbp_get_forum_topic_count(get_the_ID()) > 0 ) : ?>
						<span class="bbp-topic-freshness-author">
							<?php 
								bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id( get_the_ID() ), 'size' => 45 ) );
							?>		
						</span>
						<span class="bbp-topic-freshness-details">
							<span class="bbp-last-topic-title">
								<?php echo '<a href="'. bbp_get_forum_last_topic_permalink( get_the_ID() ) .'">'. bbp_get_forum_last_topic_title( get_the_ID() ) .'</a>' ?>
							</span>
							<span class="last-active-time">
								<?php echo bbp_get_forum_last_active_time( get_the_ID(), false ); ?> •
								<?php
									echo bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id( get_the_ID() ), 'type' => 'name' ) );
								?>
							</span>
						</span>
					<?php endif; ?>
				</div>
			</div>
		    <?php
		}
	}else{
		?>
			<div class="tophive-forum-topic-loop-single">
				<div class="tophive-forum-topic-loop-single-details tophive-forums">
					<h4>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="single-icon" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z"/>
						</svg>
						<a href="<?php echo bbp_get_forum_permalink(get_the_ID()); ?>">
								<?php 
									the_title();
									the_content();
								?>
						</a>

					</h4>
				</div>

				<div class="tophive-forum-topic-loop-single-footer-meta">
					<div class="meta-item">
						<?php 
							echo '<span>';
							global $wpdb;
							$post_ide = get_the_ID();

							$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_parent={$post_ide} and post_type='topic'");
							
							echo count($results);
							echo '</span>';
							esc_html_e( ' Topics', 'metafans' ); ?>
					</div>
					<div class="meta-item last-active-time">
						<?php 
							echo '<span>';
							echo bbp_forum_reply_count(get_the_ID());
							echo '</span>';
							esc_html_e( ' Replies', 'metafans' ); ?>
					</div>
				</div>
				<div class="tophive-forum-last-topic">
					<span class="bbp-topic-freshness-author">
						<?php 
							bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id( get_the_ID() ), 'size' => 45 ) );
						?>		
					</span>
					<span class="bbp-topic-freshness-details">
						<span class="bbp-last-topic-title">
							<?php echo bbp_get_forum_last_topic_title( get_the_ID() ); ?>
						</span>
						<span class="last-active-time">
							<?php echo bbp_get_forum_last_active_time( get_the_ID(), false ); ?> • 
							<?php
								echo bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id( get_the_ID() ), 'type' => 'name' ) );
							?>
						</span>
					</span>
				</div>
			</div>
		<?php
	}
}
}
?>