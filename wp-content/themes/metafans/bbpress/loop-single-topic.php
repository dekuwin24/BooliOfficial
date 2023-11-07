<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;
$last_updated_by = bbp_get_author_link( array( 'post_id' => bbp_get_topic_last_reply_id( get_the_ID() ), 'size' => 20 ) );
$last_active = get_post_meta( get_the_ID(), '_bbp_last_active_time', true );
if ( empty( $last_active ) ) {
	$reply_id = bbp_get_topic_last_reply_id( get_the_ID() );
	if ( ! empty( $reply_id ) ) {
		$last_active = get_post_field( 'post_date', $reply_id );
	} else {
		$last_active = get_post_field( 'post_date', get_the_ID() );
	}
}					
$last_active = ! empty( $last_updated_by ) ? bbp_get_time_since( bbp_convert_date( $last_active ) ) : '';
if( function_exists('bbp_get_topic_forum_id') && function_exists('bbp_get_forum_title') ){
	$forum_id = bbp_get_topic_forum_id( get_the_ID() );
	$forum_title = ! empty( $forum_id ) ? bbp_get_forum_title( $forum_id ) : '';
	$forum_link = ! empty( $forum_id ) ? bbp_get_forum_permalink( $forum_id ) : '';
}else{
	$forum_title = '';
}
?>

<ul id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class('bbp-topic-loop-single'); ?>>
	<div class="tophive-forum-topic-loop-single recent-topics">
		<div class="tophive-forum-topic-loop-single-avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
		</div>
		<div class="tophive-forum-topic-loop-single-details">
			<div class="tophive-forum-topic-loop-single-meta">
				<span><a href=""><?php echo get_the_author_meta('display_name'); ?></a></span>
				 • <span>Posted in : <a href="<?php echo tophive_sanitize_filter($forum_link); ?>"><?php echo tophive_sanitize_filter($forum_title); ?></a></span>
			</div>
			<h6><a href="<?php echo bbp_get_topic_permalink(get_the_ID()); ?>"><?php the_title() ?></a></h6>
			<p><?php echo get_the_excerpt() ?></p>

			<div class="tophive-forum-topic-loop-single-footer-meta">
				<span><svg width="0.9em" height="0.9em" viewBox="0 0 16 16" class="bi bi-chat-right-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M2 1h12a1 1 0 0 1 1 1v11.586l-2-2A2 2 0 0 0 11.586 11H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
				  <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
				</svg> <?php echo bbp_topic_reply_count(get_the_ID()) . esc_html__( ' Replies', 'metafans' ); ?></span>
				<span class="last-active-time">
					<?php echo tophive_sanitize_filter($last_updated_by) . $last_active; ?>
				</span>
			</div>
		</div>
	</div>
</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
