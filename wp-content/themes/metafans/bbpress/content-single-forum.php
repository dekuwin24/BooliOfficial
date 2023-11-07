<?php

/**
 * Single Forum Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<div id="bbpress-forums" class="bbpress-wrapper">



	<?php do_action( 'bbp_template_before_single_forum' ); ?>

	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>

		<?php if ( bbp_has_forums() ) : ?>

			<?php bbp_get_template_part( 'loop', 'forums' ); ?>

		<?php endif; ?>
		<div class="bb-press-forum-loop-top-bar">
			
			<?php if ( ! bbp_is_forum_category() && bbp_has_topics() ) : ?>

				<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
					<div>
						<?php bbp_forum_subscription_link(); 
							$new_post_link = tophive_metafans()->get_setting( 'theme_globals_site_bbp_new_post_link' );
						?>
						<a href="<?php echo tophive_sanitize_filter($new_post_link); ?>" class="th-bbpress-create-new-topic theme-primary-bg-color">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
							  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
							</svg>
							<?php esc_html_e( 'Start a Conversation', 'metafans' ); ?>
						</a>
					</div>
				</div>

				<?php bbp_get_template_part( 'loop',       'topics'    ); ?>

			<?php elseif ( ! bbp_is_forum_category() ) : ?>

				<?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>
			<?php endif; ?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_single_forum' ); ?>

</div>
