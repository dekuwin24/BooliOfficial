<?php
/**
 * BuddyPress Activity templates
 *
 * @since 2.3.0
 * @version 6.0.0
 */
?>

	<?php bp_nouveau_before_activity_directory_content(); ?>

	<?php if ( is_user_logged_in() ) : ?>

		<?php bp_get_template_part( 'activity/post-form' ); ?>

	<?php endif; ?>

	<?php bp_nouveau_template_notices(); ?>

	<?php if ( ! bp_nouveau_is_object_nav_in_sidebar() ) : ?>

		<?php 
			if( is_user_logged_in() ){
				bp_get_template_part( 'common/nav/directory-nav' ); 
			}
		?>

	<?php endif; ?>

	<div class="screen-content">

		<?php bp_get_template_part( 'common/search-and-filters-bar' ); ?>

		<?php bp_nouveau_activity_hook( 'before_directory', 'list' ); ?>

		<div id="activity-stream" class="activity" data-bp-list="activity">

				<div id="bp-ajax-loader">
					<div class="metafans-skeleton activity">
						<main class="skeleton-container">
							<div class="skeleton-header">
								<div class="skeleton-media">
									<span class="skeleton-box"></span>
								</div>
								<div class="skeleton-heading">
									<span class="skeleton-box action"></span>
									<span class="skeleton-box meta"></span>
								</div>
							</div>
							<div class="skeleton-content">
								<span class="skeleton-box content" style="width:50%"></span>
								<span class="skeleton-box content" style="width:90%"></span>
								<span class="skeleton-box content" style="width:70%"></span>
							</div>
							<div class="skeleton-footer">
								<span class="skeleton-box footer"></span>
								<span class="skeleton-box footer"></span>
								<span class="skeleton-box footer"></span>
							</div>
						</main>
					</div>
					<div class="metafans-skeleton activity">
						<main class="skeleton-container">
							<div class="skeleton-header">
								<div class="skeleton-media">
									<span class="skeleton-box"></span>
								</div>
								<div class="skeleton-heading">
									<span class="skeleton-box action"></span>
									<span class="skeleton-box meta"></span>
								</div>
							</div>
							<div class="skeleton-content">
								<span class="skeleton-box content" style="width:50%"></span>
								<span class="skeleton-box content" style="width:90%"></span>
								<span class="skeleton-box content" style="width:70%"></span>
							</div>
							<div class="skeleton-footer">
								<span class="skeleton-box footer"></span>
								<span class="skeleton-box footer"></span>
								<span class="skeleton-box footer"></span>
							</div>
						</main>
					</div>
				</div>

		</div><!-- .activity -->

		<?php bp_nouveau_after_activity_directory_content(); ?>

	</div><!-- // .screen-content -->

	<?php bp_nouveau_after_directory_page(); ?>
