<?php
if ( ! function_exists( 'tophive_customizer_theme_config' ) ) {
	/**
	 * Add typograhy settings.
	 *
	 * @since 0.0.1
	 * @since 0.2.6
	 *
	 * @param array $configs
	 * @return array
	 */
	function tophive_customizer_theme_config( $configs ) {

		$section = 'theme_globals';

		$config = array(
			array(
				'name'     => 'theme_customizer_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( 'Metafans', 'metafans' ),
			),

			// Base.
			array(
				'name'  => "{$section}_base",
				'type'  => 'section',
				'panel' => 'theme_customizer_panel',
				'title' => esc_html__( 'Base', 'metafans' ),
			),

			array(
				'name'        => "{$section}_base_cards",
				'type'        => 'styling',
				'section'     => "{$section}_base",
				'selector'    => array(
					'normal' => '.search-contents, .metafans-skeleton.activity .skeleton-container, .buddypress-wrap .bp-feedback, .widget_area .buddypress.widget, .buddypress.widget, .buddypress .widget_area .widget, .widget-area .widget, .buddypress .widget, #buddypress .activity-update-form, .buddypress-wrap.bp-dir-hori-nav:not(.bp-vertical-navs) nav:not(.tabbed-links), #activity-stream .activity-list.bp-list .activity-item, #buddypress .activity-footer-links .th-bp-footer-meta-actions,.buddypress.widget .item-options, .buddypress .widget .item-options, .directory.members #members-list li .list-wrap, .directory.groups #groups-list li .list-wrap, .buddypress-wrap .members-list li .user-facts, .directory.members #members-list li .list-wrap .item-avatar img, .dark-mode .header-social_search_box-item .search-form-fields .search-field, .activity-comments-form form textarea, #whats-new-attachments, .activity-update-form #whats-new-options, .buddypress-wrap #whats-new-post-in-box select, body #buddypress div#item-header, #buddypress .bp-wrap > nav.horizontal, .buddypress-wrap .buddypress.widget ul#friends-list li, .buddypress-wrap .buddypress.widget ul#groups-list li, .buddypress-wrap .buddypress.widget ul#members-list li, .buddypress-wrap.bp-dir-hori-nav:not(.bp-vertical-navs) nav.bp-subnavs:not(.tabbed-links), .activity-update-form #whats-new-options #whats-new-submit #aw-whats-new-submit:disabled, .activity-update-form #whats-new-form.submitting:before, #buddypress .activity-extension-links ul,.item-list.members-group-list.bp-list.grid > li > .list-wrap, .item-list.members-friends-list.bp-list.grid > li > .list-wrap, .item-list.members-group-list.bp-list > li .item .item-block button.friendship-button,.bp-invites-content ul#members-list li,#group-settings-form, body #drag-drop-area,#buddypress .bp-avatar-nav ul,#buddypress #item-header-cover-image #item-header-avatar img.avatar, body.single-item.groups #buddypress div#item-header #item-header-cover-image #item-header-content .group-status, .buddypress-wrap .standard-form select, .buddypress-wrap .standard-form input[type=text], .buddypress-wrap .standard-form input[type=email], .buddypress-wrap .standard-form textarea, #buddypress .groups-list > li .list-wrap, #buddypress .profile, #buddypress .profile h2.edit-profile-screen, .buddypress-wrap table.wp-profile-fields tr.alt td,.buddypress-wrap .standard-form input:focus, .buddypress-wrap .standard-form select:focus, .buddypress-wrap .standard-form textarea:focus, .tophive-forum-topic-loop-single, #bbpress-forums ul.bbp-forums, #bbpress-forums ul.bbp-lead-topic, #bbpress-forums ul.bbp-replies, #bbpress-forums ul.bbp-search-results, #bbpress-forums ul.bbp-topics, #bbpress-forums li.bbp-body ul.forum, #bbpress-forums li.bbp-body ul.topic, #buddypress #bbpress-forums li.bbp-body ul.forum:first-of-type, #buddypress #bbpress-forums li.bbp-body ul.topic:first-of-type, #buddypress #bbpress-forums div.bbp-search-form input[type=text], .bbpress #bbpress-forums div.bbp-search-form input[type=text], .th-bp-header-notification-container .notification-title, .user-account-segment ul.loggedin-user-links li.user-account-dd-segment, input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], input[type="range"], input[type="date"], input[type="month"], input[type="week"], input[type="time"], input[type="datetime"], input[type="datetime-local"], input[type="color"], select, textarea, .select2-container .select2-selection--single, input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type="number"]:focus, input[type="tel"]:focus, input[type="range"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="week"]:focus, input[type="time"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="color"]:focus, select:focus, textarea:focus, .select2-container .select2-selection--single:focus, .entry-content #buddypress.buddypress-wrap .activity-comments ul li span.comment-options ul, .buddypress-wrap .activity-comments ul li span.comment-options-toggle, .bb-press-forum-loop-top-bar, .tophive-breadcrumbs-container, .tophive-bbpress-new-post-form, .richtexteditor.rte-modern rte-toolbar, .tophive-bbpress-new-post-form .richtexteditor.rte-modern, #bbpress-forums .topic-lead-question, #bbpress-forums fieldset.bbp-form, .richtexteditor.rte-modern, .richtexteditor rte-content, #bbpress-forums ul.bbp-replies li > div, .rtcl .rtcl-list-view .listing-item, .tophive-popup-modal .tophive-popup-content-wrapper, .th-bp-post-share-button ul.sharing-options, #whats-new-textarea .url-scrap-view, .activity-inner .whats-new-live-preview,body #buddypress .bp-profile-custom-page.photos-page, .bp-profile-custom-page .section-heading,body #buddypress .bp-image-previewer .post-media-single,body #buddypress select#mf-activity-accessibility, .ac-vi-content, .activity-post-form-popup, .activity-update-form.activity-post-form-popup #whats-new-form, body #buddypress div.ac-post-form-showcase, body #buddypress div.ac-vi-form-content,body #buddypress div.ac-group-main,.buddypress-wrap .members-list li .members-action-buttons a,.widget-area .widget_shopping_cart .buttons a',
				    'hover' => 'body #buddypress .activity-extension-links ul li :hover'
				),
				'title'       => esc_html__( 'Cards Styling', 'metafans' ),
				'description' => esc_html__( 'Apply styling to cards', 'metafans' ),
				'css_format'  => 'styling',
				'fields'     => array(
					'normal_fields' => array(
						// 'link_color' => false,
						'margin' => false,
						'padding' => false,
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => array(
						'link_color' => false,
						'margin' => false,
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
						'bg_attachment' => false,	
						'border_style' => false,	
						'border_radius' => false,	
						'box_shadow' => false,	
					)
				),
			),
			array(
				'name'        => "{$section}_base_comments",
				'type'        => 'styling',
				'section'     => "{$section}_base",
				'selector'    => array(
					'normal' => 'body #buddypress.buddypress-wrap .activity-comments, .bp-document-container .document-preview-wrapper'
				),
				'title'       => esc_html__( 'Comments Styling', 'metafans' ),
				'description' => esc_html__( 'Apply styling to comments', 'metafans' ),
				'css_format'  => 'styling',
				'fields'     => array(
					'normal_fields' => array(
						'margin' => false,
						'padding' => false,
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => false
				),
			),
			array(
				'name'        => "{$section}_base_comments_form",
				'type'        => 'styling',
				'section'     => "{$section}_base",
				'selector'    => array(
					'normal' => 'body #buddypress.buddypress-wrap .comments-text.editable-div'
				),
				'title'       => esc_html__( 'Comments form Styling', 'metafans' ),
				'description' => esc_html__( 'Apply styling to comments form', 'metafans' ),
				'css_format'  => 'styling',
				'fields'     => array(
					'normal_fields' => array(
						'margin' => false,
						'padding' => false,
						'bg_image' => false,
						'bg_cover' => false,
						'bg_position' => false,
						'bg_repeat' => false,
						'bg_attachment' => false,
						'bg_attachment' => false,
					),
					'hover_fields' => false
				),
			),
			array(
				'name'        => "{$section}_photos_viewer",
				'type'        => 'heading',
				'section'     => "{$section}_base",
				'title'       => esc_html__( 'Image Preview', 'metafans' )
			),
			array(
				'name'        => "{$section}_photos_preview_bg",
				'type'        => 'color',
				'section'     => "{$section}_base",
				'selector'    => 'body .th-media-viewer .th-media-comments',
				'css_format' => 'background: {{value}};',
				'title'       => esc_html__( 'Background color', 'metafans' )
			),
			array(
				'name'        => "{$section}_photos_preview_comments_bg",
				'type'        => 'color',
				'section'     => "{$section}_base",
				'css_format' => 'background: {{value}};',
				'selector'    => 'body .th-media-viewer .th-media-comments .comment_section .th-media-comments-all .th-media-single-comment',
				'title'       => esc_html__( 'Comments Background color', 'metafans' )
			),
			array(
				'name'        => "{$section}_photos_preview_border",
				'type'        => 'color',
				'section'     => "{$section}_base",
				'css_format' => 'border-color: {{value}};',
				'selector'    => 'body .th-media-viewer .th-media-comments .comment_section .th-bp-media-comment-button',
				'title'       => esc_html__( 'Border Color', 'metafans' )
			),

			// Panel BuddyPress
			array(
				'name'  => "{$section}_buddypress",
				'type'  => 'panel',
				'panel' => 'theme_customizer_panel',
				'title' => esc_html__( 'BuddyPress', 'metafans' ),
			),
			array(
				'name'       => "{$section}_buddypress_members",
				'type'       => 'section',
				'panel'      => "{$section}_buddypress",
				'title'      => esc_html__( 'Member', 'metafans' ),
			),
			array(
				'name'       => "{$section}_buddypress_members_heading",
				'type'       => 'heading',
				'section'    => "{$section}_buddypress_members",
				'title'      => esc_html__( 'Members settings', 'metafans' ),
			),
			array(
				'name'            => "{$section}_show_gp_badges",
				'type'            => 'checkbox',
				'section'    	  => "{$section}_buddypress_members",
				'selector'    	  => "#buddypress #members-dir-list",
				'default'         => 0,
				'render_callback' => 'render_metafans_theme_opt',
				'checkbox_label'  => esc_html__( 'Gamipress Show Badges', 'metafans' ),
			),

			// Site Title and Tagline.
			array(
				'name'  => "{$section}_site_bbpress",
				'type'  => 'section',
				'panel' => 'theme_customizer_panel',
				'title' => esc_html__( 'BBPress', 'metafans' ),
			),

			array(
				'name'       => "{$section}_site_bbp_new_post_link",
				'type'       => 'text',
				'section'    => "{$section}_site_bbpress",
				'title'      => esc_html__( 'New Post Link', 'metafans' ),
			),
			// Signin & SignUP
			array(
				'name'  => "{$section}_site_signin_signup",
				'type'  => 'section',
				'panel' => 'theme_customizer_panel',
				'title' => esc_html__( 'Login/Register', 'metafans' ),
			),
			array(
				'name'       => "{$section}_site_sign_in_heading",
				'type'       => 'heading',
				'section'    => "{$section}_site_signin_signup",
				'title'      => esc_html__( 'Login Options', 'metafans' ),
			),
			array(
				'name'            => "{$section}_signin_form_title",
				'type'            => 'text',
				'section'    => "{$section}_site_signin_signup",
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'default'  => esc_html__( 'Signin', 'metafans' ),
				'title'  => esc_html__( 'Login title', 'metafans' ),
			),
			array(
				'name'            => "{$section}_text_after_login_title",
				'type'            => 'textarea',
				'section'    => "{$section}_site_signin_signup",
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'title'  => esc_html__( 'Text After Title', 'metafans' ),
			),
			array(
				'name'            => "{$section}_text_after_login_form",
				'type'            => 'textarea',
				'section'    => "{$section}_site_signin_signup",
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'title'  => esc_html__( 'Text After Form', 'metafans' ),
			),
			array(
				'name'            => "{$section}_unsigned_redirect",
				'type'            => 'text',
				'section'    => "{$section}_site_signin_signup",
				'title'  => esc_html__( 'Signed Out users redirect', 'metafans' ),
				'description'     => esc_html__( 'Put page name here, (i.e: account or login) if you want to protect all of your site from non loggedin users.', 'metafans' ),
			),
			array(
				'name'       => "{$section}_site_sign_up_heading",
				'type'       => 'heading',
				'section'    => "{$section}_site_signin_signup",
				'title'      => esc_html__( 'Registration Options', 'metafans' ),
			),

			array(
				'name'            => "{$section}_signup_form_title",
				'type'            => 'text',
				'section'    => "{$section}_site_signin_signup",
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'default'  => esc_html__( 'New Signup', 'metafans' ),
				'title'  => esc_html__( 'Signup title', 'metafans' ),
			),
			array(
				'name'            => "{$section}_text_after_title",
				'type'            => 'textarea',
				'section'    => "{$section}_site_signin_signup",
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'title'  => esc_html__( 'Text After Title', 'metafans' ),
			),
			array(
				'name'            => "{$section}_enable_first_name",
				'type'            => 'checkbox',
				'section'    => "{$section}_site_signin_signup",
				'default'         => 1,
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'checkbox_label'  => esc_html__( 'Enable first name', 'metafans' ),
			),
			array(
				'name'            => "{$section}_enable_display_name",
				'type'            => 'checkbox',
				'section'    => "{$section}_site_signin_signup",
				'default'         => 1,
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'checkbox_label'  => esc_html__( 'Enable display name', 'metafans' ),
			),
			array(
				'name'            => "{$section}_enable_gender",
				'type'            => 'checkbox',
				'section'    => "{$section}_site_signin_signup",
				'default'         => 1,
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'checkbox_label'  => esc_html__( 'Enable gender', 'metafans' ),
			),
			array(
				'name'            => "{$section}_enable_birth_day",
				'type'            => 'checkbox',
				'section'    => "{$section}_site_signin_signup",
				'default'         => 1,
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'checkbox_label'  => esc_html__( 'Enable birthday', 'metafans' ),
			),
			array(
				'name'            => "{$section}_password_length",
				'type'            => 'number',
				'section'    => "{$section}_site_signin_signup",
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'title'  => esc_html__( 'Password length', 'metafans' ),
				'default'  => 8,
			),
			array(
				'name'            => "{$section}_text_before_button",
				'type'            => 'textarea',
				'section'    => "{$section}_site_signin_signup",
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'title'  => esc_html__( 'Text Before Button', 'metafans' ),
			),
			array(
				'name'            => "{$section}_text_after_button",
				'type'            => 'textarea',
				'section'    => "{$section}_site_signin_signup",
				'selector' 		  => '.tophive-popup-content-wrapper .signup-segment',
				'title'  => esc_html__( 'Text After Button', 'metafans' ),
			),
		);

		return array_merge( $configs, $config );
	}
}
function render_metafans_theme_opt(){
	echo 'hello';
}
add_filter( 'tophive/customizer/config', 'tophive_customizer_theme_config' );
