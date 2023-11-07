<?php

/**
 * Single Topic Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<div id="bbpress-forums" class="bbpress-wrapper">
	<div class="ec-mb-2">
		
		<?php bbp_breadcrumb(); ?>

	</div>


	<?php do_action( 'bbp_template_before_single_topic' ); ?>

	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>

		<?php if ( bbp_has_replies() ) : ?>

			<div class="bb-press-forum-loop-top-bar">
				
				<?php bbp_get_template_part( 'pagination', 'replies' ); ?>
				<div>
					<?php bbp_topic_favorite_link(); ?>

					<?php bbp_topic_subscription_link(); ?>
				</div>

			</div>

			<div class="topic-lead-question">
				<div class="topic-lead-question-head">
					<?php 
						echo '<h6>' . get_the_title() . '</h6>'; 
						echo bbp_reply_post_date( get_the_ID(), true );
						echo ' | ';
						echo bbp_topic_reply_count( get_the_ID() ) . esc_html__( ' Replies', 'metafans' );
					?>
				</div>
				<div class="topic-lead-question-user">
					<?php 
						bbp_reply_author_link( 
							array( 
								'post_id' => get_the_ID(),
								'type' => 'both', 
								'size' => 40, 
								'show_role' => true 
							) 
						);
					?>
				</div>
				<div class="topic-lead-question-details">
					<div class="topic-lead-question-details-gamipress">
						<?php
						    $user_id = bbp_get_reply_author_id( get_the_ID() );
						    do_action( 'th_bbp_gamipress_author', $user_id );
					    ?>
					</div>
					<div class="topic-lead-question-content">
						<?php 
							the_content(); 
							bbp_topic_tag_list();
						?>
					</div>
				</div>
			</div>


			<?php bbp_get_template_part( 'loop',       'replies' ); ?>

		<?php endif; ?>

		<?php bbp_get_template_part( 'form', 'reply' ); ?>

	<?php endif; ?>

	<?php bbp_get_template_part( 'alert', 'topic-lock' ); ?>

	<?php do_action( 'bbp_template_after_single_topic' ); ?>

</div>
