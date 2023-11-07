<?php
/**
 * BuddyPress - Activity Post Form
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

if( isMobile() ){
	$submit_button_state = '';
}else{
	$submit_button_state = 'disabled';
}

?>

<div id="bp-nouveau-activity-form" class="activity-update-form">
	<form action="<?php bp_activity_post_form_action(); ?>" method="post" id="whats-new-form" name="whats-new-form">
		<div class="activity-post-form-header">
			<h4> <?php esc_html_e("Create post", "metaphone"); ?> </h4>
			<span class="whats-new-close">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
					<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
				</svg>
			</span>
	    </div>

		<?php


		/**
		 * Fires before the activity post form.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_activity_post_form' ); ?>

		<div id="whats-new-avatar">
			<a href="<?php echo bp_loggedin_user_domain(); ?>">
				<?php bp_loggedin_user_avatar( 'width=' . bp_core_avatar_thumb_width() . '&height=' . bp_core_avatar_thumb_height() ); ?>
			</a>
			<p class="whats-new-intro-header"><?php esc_html_e( 'What\'s on your mind, ' . bp_get_user_firstname( bp_get_loggedin_user_fullname() ) . '?', 'metafans' ); ?></p>
			<div class="whats-new-header-media-section">
				<p>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera" viewBox="0 0 16 16">
					  <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
					  <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
					</svg>
				</p>
			</div>
		</div>

		<div id="whats-new-content">
			<div id="whats-new-textarea">
				
				<div contenteditable="true"
					class="bp-suggestions advanced-th-bp-activity-form" 
					data-placeholder="<?php esc_html_e( 'What\'s on your mind, ' . bp_get_user_firstname( bp_get_loggedin_user_fullname() ) . '?', 'metafans' ); ?>" 
					name="whats-new" 
					id="th-bp-whats-new" 
					cols="50" 
					rows="10"
					<?php if ( bp_is_group() ) : ?>
						data-suggestions-group-id="<?php echo esc_attr( (int) bp_get_current_group_id() ); ?>" 
					<?php endif; ?>
				><?php if ( isset( $_GET['r'] ) ) : ?>@<?php echo esc_textarea( $_GET['r'] ); ?> <?php endif; ?></div>
				<div class="whats-new-previewer">
					<p class="previewer-uploader">
						<label for="upload-media">+</label>
						<input type="file" name="upload-media" id="upload-media">
					</p>
				</div>	
				<div id="whats-new-attachments">
					<p class="image has-tooltip">
						<span class="new-post-tooltip"><?php esc_html_e( 'Photos', 'metafans' ); ?></span>
						<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M9 14.7059C9 14.3925 9 14.2358 9.01316 14.1038C9.14004 12.8306 10.1531 11.8234 11.4338 11.6973C11.5666 11.6842 11.7327 11.6842 12.065 11.6842C12.1931 11.6842 12.2571 11.6842 12.3114 11.6809C13.0055 11.6391 13.6134 11.2036 13.8727 10.5622C13.893 10.512 13.912 10.4554 13.95 10.3421C13.988 10.2289 14.007 10.1722 14.0273 10.122C14.2866 9.48058 14.8945 9.04506 15.5886 9.00327C15.6429 9 15.7029 9 15.823 9H20.177C20.2971 9 20.3571 9 20.4114 9.00327C21.1055 9.04506 21.7134 9.48058 21.9727 10.122C21.993 10.1722 22.012 10.2289 22.05 10.3421C22.088 10.4554 22.107 10.512 22.1273 10.5622C22.3866 11.2036 22.9944 11.6391 23.6886 11.6809C23.7429 11.6842 23.8069 11.6842 23.935 11.6842C24.2673 11.6842 24.4334 11.6842 24.5662 11.6973C25.8469 11.8234 26.86 12.8306 26.9868 14.1038C27 14.2358 27 14.3925 27 14.7059V21.7053C27 23.2086 27 23.9602 26.7057 24.5344C26.4469 25.0395 26.0338 25.4501 25.5258 25.7074C24.9482 26 24.1921 26 22.68 26H13.32C11.8079 26 11.0518 26 10.4742 25.7074C9.96619 25.4501 9.55314 25.0395 9.29428 24.5344C9 23.9602 9 23.2086 9 21.7053V14.7059Z" stroke="#C4C4C4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M18 21.9737C19.9882 21.9737 21.6 20.3713 21.6 18.3947C21.6 16.4181 19.9882 14.8158 18 14.8158C16.0118 14.8158 14.4 16.4181 14.4 18.3947C14.4 20.3713 16.0118 21.9737 18 21.9737Z" stroke="#C4C4C4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</p>
					<p class="play video has-tooltip">
						<span class="new-post-tooltip"><?php esc_html_e( 'Video', 'metafans' ); ?></span>
						<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M28.0002 13L21.3184 18L28.0002 23V13Z" stroke="#C4C4C4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M19.4091 11H8.90909C7.85473 11 7 11.8954 7 13V23C7 24.1046 7.85473 25 8.90909 25H19.4091C20.4635 25 21.3182 24.1046 21.3182 23V13C21.3182 11.8954 20.4635 11 19.4091 11Z" stroke="#C4C4C4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</p>
					<p class="documents rotate-45 has-tooltip">
						<span class="new-post-tooltip"><?php esc_html_e( 'Documents', 'metafans' ); ?></span>
						<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M20 10H13.6C13.1757 10 12.7687 10.1686 12.4686 10.4686C12.1686 10.7687 12 11.1757 12 11.6V24.4C12 24.8243 12.1686 25.2313 12.4686 25.5314C12.7687 25.8314 13.1757 26 13.6 26H23.2C23.6243 26 24.0313 25.8314 24.3314 25.5314C24.6314 25.2313 24.8 24.8243 24.8 24.4V14.8L20 10Z" stroke="#C4C4C4" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M20 10V14.8H24.8" stroke="#C4C4C4" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M21.6 18.8H15.2" stroke="#C4C4C4" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M21.6 22H15.2" stroke="#C4C4C4" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M16.8 15.6H16H15.2" stroke="#C4C4C4" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</p>
					<p class="emojipicker has-tooltip">
						<span class="new-post-tooltip"><?php esc_html_e( 'Emoji', 'metafans' ); ?></span>
						<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M14.4 19.8C14.4 19.8 15.75 21.6 18 21.6C20.25 21.6 21.6 19.8 21.6 19.8M20.7 15.3H20.709M15.3 15.3H15.309M27 18C27 22.9706 22.9706 27 18 27C13.0294 27 9 22.9706 9 18C9 13.0294 13.0294 9 18 9C22.9706 9 27 13.0294 27 18ZM21.15 15.3C21.15 15.5485 20.9485 15.75 20.7 15.75C20.4515 15.75 20.25 15.5485 20.25 15.3C20.25 15.0515 20.4515 14.85 20.7 14.85C20.9485 14.85 21.15 15.0515 21.15 15.3ZM15.75 15.3C15.75 15.5485 15.5485 15.75 15.3 15.75C15.0515 15.75 14.85 15.5485 14.85 15.3C14.85 15.0515 15.0515 14.85 15.3 14.85C15.5485 14.85 15.75 15.0515 15.75 15.3Z" stroke="#C4C4C4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</p>
				</div>
			</div>
			<div id="whats-new-options">

				<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
				<input type="hidden" id="whats-new-post-media" name="whats-new-post-media" value="" />
				<input type="hidden" id="whats-new-post-url-preview" name="whats-new-post-url-preview" value="" />
				<?php if ( bp_is_active( 'groups' ) && !bp_is_my_profile() && !bp_is_group() ) : ?>

					<div id="whats-new-post-in-box">

						<label for="whats-new-post-in" class="bp-screen-reader-text"><?php
							/* translators: accessibility text */
							_e( 'Post in', 'metafans' );
						?></label>
						<select id="whats-new-post-in" name="whats-new-post-in">
							<option selected="selected" value="0"><?php _e( 'My Profile', 'metafans' ); ?></option>

							<?php if ( bp_has_groups( 'user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100&populate_extras=0&update_meta_cache=0' ) ) :
								while ( bp_groups() ) : bp_the_group(); ?>
									 <?php echo bp_group_avatar();?>
									<option value="<?php bp_group_id(); ?>"><?php bp_group_name(); ?></option>
								<?php endwhile;
							endif; ?>

						</select>
					</div>

				<?php elseif ( bp_is_group_activity() ) : ?>

					<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
					<input type="hidden" id="whats-new-post-in" name="whats-new-post-in" value="<?php bp_group_id(); ?>" />

				<?php endif; ?>
					
				<div id="whats-new-submit">
					<input type="submit" name="aw-whats-new-submit" id="aw-whats-new-submit" value="<?php esc_attr_e( 'Post', 'metafans' ); ?>" <?php echo $submit_button_state; ?> />
				</div>

				<?php

				/**
				 * Fires at the end of the activity post form markup.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_activity_post_form_options' ); ?>

			</div><!-- #whats-new-options -->
		</div><!-- #whats-new-content -->

		<?php wp_nonce_field( 'post_update', '_wpnonce_post_update' ); ?>
		<?php

		/**
		 * Fires after the activity post form.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_activity_post_form' ); ?>

	</form><!-- #whats-new-form -->
</div>
	<div class="ac-post-form-showcase">
	   <?php echo get_avatar( get_current_user_id() ); ?>
	   <span><?php _e("What's on your mind?","metafans") ?></span>
	   <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="18" cy="18" r="18" fill="#F8F8F8"/>
            <path d="M9 14.7059C9 14.3925 9 14.2358 9.01316 14.1038C9.14004 12.8306 10.1531 11.8234 11.4338 11.6973C11.5666 11.6842 11.7327 11.6842 12.065 11.6842C12.1931 11.6842 12.2571 11.6842 12.3114 11.6809C13.0055 11.6391 13.6134 11.2036 13.8727 10.5622C13.893 10.512 13.912 10.4554 13.95 10.3421C13.988 10.2289 14.007 10.1722 14.0273 10.122C14.2866 9.48058 14.8945 9.04506 15.5886 9.00327C15.6429 9 15.7029 9 15.823 9H20.177C20.2971 9 20.3571 9 20.4114 9.00327C21.1055 9.04506 21.7134 9.48058 21.9727 10.122C21.993 10.1722 22.012 10.2289 22.05 10.3421C22.088 10.4554 22.107 10.512 22.1273 10.5622C22.3866 11.2036 22.9944 11.6391 23.6886 11.6809C23.7429 11.6842 23.8069 11.6842 23.935 11.6842C24.2673 11.6842 24.4334 11.6842 24.5662 11.6973C25.8469 11.8234 26.86 12.8306 26.9868 14.1038C27 14.2358 27 14.3925 27 14.7059V21.7053C27 23.2086 27 23.9602 26.7057 24.5344C26.4469 25.0395 26.0338 25.4501 25.5258 25.7074C24.9482 26 24.1921 26 22.68 26H13.32C11.8079 26 11.0518 26 10.4742 25.7074C9.96619 25.4501 9.55314 25.0395 9.29428 24.5344C9 23.9602 9 23.2086 9 21.7053V14.7059Z" stroke="#C4C4C4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M18 21.9737C19.9882 21.9737 21.6 20.3713 21.6 18.3947C21.6 16.4181 19.9882 14.8158 18 14.8158C16.0118 14.8158 14.4 16.4181 14.4 18.3947C14.4 20.3713 16.0118 21.9737 18 21.9737Z" stroke="#C4C4C4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
           </svg>
	</div>
