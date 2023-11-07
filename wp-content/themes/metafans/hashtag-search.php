<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package tophive
 */

get_header(); ?>
	<div class="content-inner">
		<?php
		do_action( 'tophive/content/before' );
		$searchtext = $_GET['hashtag'];
		echo '<h3>' . esc_html__( 'Hashtag: #', 'metafans' ) . $searchtext . '</h3>';
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM {$wpdb->base_prefix}bp_activity WHERE content LIKE '%". $searchtext ."%'", ARRAY_A);

		echo '<p>' . count($results) . esc_html__(' posts found for your hashtag #') .$searchtext . '</p>';
		?>
		<div id="buddypress" class="buddypress">
			<div id="activity-stream" class="activity buddypress-wrap round-avatars">
				<ul class="activity-list item-list bp-list">
				<?php
					foreach( $results as $activity ){
						?>
							<li class="activity activity_update activity-item" id="activity-<?php $activity['id']; ?>">

									<div class="activity-avatar item-avatar">
										<?php bp_activity_avatar( array( 'type' => 'full', 'user_id' => $activity['user_id'] ) ); ?>
									</div>

									<div class="activity-content ">

										<div class="activity-header">
											<?php do_action( 'tophive/buddypress/search/activity/header', $activity['id'] ); ?>
										</div>
										<?php  
											if( $activity['type'] === 'new_avatar' ){
												?>
												<?php 
													// Get the Cover Image
													$cover_src = bp_attachments_get_attachment( 'url', array(
														'item_id' => $activity['user_id']
													) );
											    ?>
											 
													<div class="bp-activity-avatar-change">
											      		<img class="image-cover" src="<?php echo tophive_sanitize_filter($cover_src); ?>" alt="imgur"/>
														<?php bp_activity_avatar( array( 'type' => 'full' ) ); ?>				
													</div>
												<?php
											}
										?>
										<?php if ( $activity['content'] ) : ?>

											<div class="activity-inner">
												<?php 
													echo '<p>' . $activity['content'] . '</p>';
													
													do_action( 'tophive/buddypress/search/activity/media', $activity['id'] );
													if( bp_get_activity_type() === 'activity_share' ){
														$share_id = bp_activity_get_meta( $activity['id'], 'shared_activity_id', true );
														do_action( 'tophive/buddypress/activity/share-activity', $share_id );
													}
												?>
											</div>

										<?php endif; ?>
										<div class="activity-footer-links">
											<?php do_action( 'bp_footer_search_actions', $activity['id'] ); ?>
										</div>
									</div>
									<?php if ( bp_activity_get_comment_count() || ( is_user_logged_in() && ( bp_activity_can_comment() || bp_is_single_activity() ) ) ) : ?>
										<div class="activity-comments">
											<?php do_action( 'tophive/buddypress/search/activity/comments', $activity['id'] ); ?>
										</div>
									<?php endif; ?>
								</li>
						<?php
					}
				?>
				</ul>
			</div>
		</div>
		<?php		
		if( empty($results) ){
			$response = '<p class="ec-mb-0">' . esc_html__( 'Nothing Found for your search', 'metafans' ) . '</p>';
		}
		echo tophive_sanitize_filter($response);
		do_action( 'tophive/content/after' );
		?>
	</div><!-- #.content-inner -->
<?php
get_footer();
