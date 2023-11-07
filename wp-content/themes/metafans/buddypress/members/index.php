<?php
/**
 * BuddyPress Members Directory
 *
 * @since 3.0.0
 * @version 6.0.0
 */

?>

	<?php bp_nouveau_before_members_directory_content(); ?>

	<?php if ( ! bp_nouveau_is_object_nav_in_sidebar() ) : ?>

		<?php bp_get_template_part( 'common/nav/directory-nav' ); ?>

	<?php endif; ?>

	<div class="screen-content">

	<?php bp_get_template_part( 'common/search-and-filters-bar' ); ?>

		<div id="members-dir-list" class="members dir-list" data-bp-list="members">
			<div id="bp-ajax-loader" class="members-list">
                <div class="metafans-skeleton members">
                    <main class="skeleton-container">
                        <div class="skeleton-cover">
                            <span class="skeleton-box"></span>
                        </div>
                        <div class="skeleton-media">
                            <span class="skeleton-box"></span>
                        </div>
                        <div class="skeleton-content">
                            <span class="skeleton-box content" style="width:60%"></span>
                            <span class="skeleton-box content" style="width:40%"></span>
                        </div>
                        <div class="skeleton-footer">
                            <span class="skeleton-box follow"></span>
                            <span class="skeleton-box"></span>
                        </div>
                    </main>
                </div>
                <div class="metafans-skeleton members">
                    <main class="skeleton-container">
                        <div class="skeleton-cover">
                            <span class="skeleton-box"></span>
                        </div>
                        <div class="skeleton-media">
                            <span class="skeleton-box"></span>
                        </div>
                        <div class="skeleton-content">
                            <span class="skeleton-box content" style="width:60%"></span>
                            <span class="skeleton-box content" style="width:40%"></span>
                        </div>
                        <div class="skeleton-footer">
                            <span class="skeleton-box follow"></span>
                            <span class="skeleton-box"></span>
                        </div>
                    </main>
                </div>
                <div class="metafans-skeleton members">
                    <main class="skeleton-container">
                        <div class="skeleton-cover">
                            <span class="skeleton-box"></span>
                        </div>
                        <div class="skeleton-media">
                            <span class="skeleton-box"></span>
                        </div>
                        <div class="skeleton-content">
                            <span class="skeleton-box content" style="width:60%"></span>
                            <span class="skeleton-box content" style="width:40%"></span>
                        </div>
                        <div class="skeleton-footer">
                            <span class="skeleton-box follow"></span>
                            <span class="skeleton-box"></span>
                        </div>
                    </main>
                </div>
            </div>
		</div><!-- #members-dir-list -->

		<?php bp_nouveau_after_members_directory_content(); ?>
	</div><!-- // .screen-content -->

	<?php bp_nouveau_after_directory_page(); ?>
