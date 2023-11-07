<?php
if ( ! function_exists( 'tophive_customizer_styling_config' ) ) {
	function tophive_customizer_styling_config( $configs ) {

		$section = 'global_styling';
		$dark_section = 'global_dark_version';
		$config = array(

			// Styling panel.
			array(
				'name'     => 'styling_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( 'Styling', 'metafans' ),
			),

			// Styling Global Section.
			array(
				'name'     => "{$section}",
				'type'     => 'section',
				'panel'    => 'styling_panel',
				'title'    => esc_html__( 'Global Colors', 'metafans' ),
				'priority' => 10,
			),

			array(
				'name'    => "{$section}_color_theme_heading",
				'type'    => 'heading',
				'section' => $section,
				'title'   => esc_html__( 'Theme Colors', 'metafans' ),
			),

			array(
				'name'        => "{$section}_color_primary",
				'type'        => 'color',
				'section'     => $section,
				'placeholder' => '#81d742',
				'title'       => esc_html__( 'Primary Color', 'metafans' ),
				'css_format'  => apply_filters(
					'tophive/styling/primary-color',
					'
					.header-top .header--row-inner,
					.button,
					button,
					button.button,
					input[type="button"],
					input[type="reset"],
					input[type="submit"],
					.button:not(.components-button):not(.customize-partial-edit-shortcut-button), 
					input[type="button"]:not(.components-button):not(.customize-partial-edit-shortcut-button),
					input[type="reset"]:not(.components-button):not(.customize-partial-edit-shortcut-button), 
					input[type="submit"]:not(.components-button):not(.customize-partial-edit-shortcut-button),
					.pagination .nav-links > *:hover,
					.pagination .nav-links span,
					.nav-menu-desktop.style-full-height .primary-menu-ul > li.current-menu-item > a, 
					.nav-menu-desktop.style-full-height .primary-menu-ul > li.current-menu-ancestor > a,
					.hover-info-wishlist.course-single-wishlist a.on,
					.hover-info-wishlist a.on,
					.nav-menu-desktop.style-full-height .primary-menu-ul > li > a:hover,
					.posts-layout .readmore-button:hover,
					.tophive-lp-content ul.learn-press-nav-tabs .course-nav.active a:after, 
					.tophive-lp-content ul.learn-press-nav-tabs .course-nav:hover a:after,
					.theme-primary-bg-color,
					.woocommerce-tabs ul.tabs li.reviews_tab a span,
					.buddypress-wrap .bp-navs li.dynamic a .count, .buddypress-wrap .bp-navs li.dynamic.current a .count, .buddypress-wrap .bp-navs li.dynamic.selected a .count, .buddypress_object_nav .bp-navs li.dynamic a .count, .buddypress_object_nav .bp-navs li.dynamic.current a .count, .buddypress_object_nav .bp-navs li.dynamic.selected a .count,
					.elementor-widget .item-options a.selected:after, .buddypress.widget .item-options a.selected:after, .buddypress .widget .item-options a.selected:after,
					.buddypress-wrap .activity-list .load-newest,
					.buddypress-wrap .activity-list .load-more,
					.buddypress-wrap .activity-list .load-newest a:hover,
					.buddypress-wrap .activity-list .load-more a:hover,
					.buddypress-wrap .activity-list .load-newest a:focus,
					.buddypress-wrap .activity-list .load-more a:focus,
					.buddypress-wrap .tabbed-links ol li.current a, .buddypress-wrap .tabbed-links ul li.current a,
					.activity-update-form #whats-new-options #whats-new-submit #aw-whats-new-submit,
					.activity-update-form #whats-new-options #whats-new-submit #aw-whats-new-submit:hover,
					.buddypress-wrap .bp-navs li.selected a .count,
					.rtcl-pagination ul.page-numbers li span.page-numbers.current, .rtcl-pagination ul.page-numbers li a.page-numbers:hover,
					.th-bpm-chat-members .single-thread.unread:before,
					.tophive-bp-messenger-sticky-main .messenger-toggler .new-message-count,
					.entry-tags.tags-links a,
					.buddypress-wrap .members-list li .members-action-buttons a.bp-th-friends-button,
					.buddypress-wrap .members-list li .members-action-buttons a.bp-th-follow-button.following,
					.notifications-action-buttons a.bp-th-friends-button,
					body.groups.group-create ol.group-create-buttons li .cnm,
					#bp-upload-image, #bp-create-album,#popup-upload, #album-upload,.pagination .nav-links span.current, a.button-add-new
					{
					    background-color: {{value}};
					}
					#album-upload,.pagination .nav-links span.current
					{
						border-color: {{value}};
					}

					.ac-vi-active .ac-vi-option-selected-fill,.ac-vi-form-active .ac-vi-form-option-selected-fill,
					.ac-vi-group-item.active .ac-vi-group-select
					{
						background: {{value}} !important;
						outline: 1px solid {{value}};
					}
					.ac-vi-option-selected-fill,.ac-vi-form-option-selected-fill,.ac-vi-group-select
					{
						outline: 1px solid {{value}};
					}
					.posts-layout .readmore-button,
					body .theme-primary-color,
					.theme-primary-color,
					.theme-primary-color-head-hover:hover h1,
					.theme-primary-color-head-hover:hover h2,
					.theme-primary-color-head-hover:hover h3,
					.theme-primary-color-head-hover:hover h4,
					.theme-primary-color-head-hover:hover h5,
					.theme-primary-color-head-hover:hover h6,
					.hover-info-wishlist.course-single-wishlist a:not(.on),
					.hover-info-wishlist a:not(.on),
					.tophive-lp-content ul.learn-press-nav-tabs li a,
					.woocommerce-tabs ul.tabs li.active a,
					li.active a, li a.active,
					li.current a, li a.current,
					.buddypress .buddypress-wrap .show-all button.text-button:hover, 
					.buddypress-wrap .bp-navs li.current a, 
					.buddypress-wrap .bp-navs li.current a:focus, 
					.buddypress-wrap .bp-navs li.current a:hover, 
					.buddypress-wrap .bp-navs li.selected a, 
					.buddypress-wrap .bp-navs li.selected a:focus, 
					.buddypress-wrap .bp-navs li.selected a:hover,
					.buddypress-wrap .profile.edit ul.button-nav li.current a,
					.elementor-widget .item-options a.selected, .buddypress.widget .item-options a.selected, .buddypress .widget .item-options a.selected,
					.buddypress-wrap:not(.bp-single-vert-nav) .main-navs ul>li.selected>a,
					.atwho-container .atwho-view ul li .username,
					.activity-inner a,
					.bp-avatar-nav ul.avatar-nav-items li a,
					.rtcl .rtcl-MyAccount-wrap .rtcl-MyAccount-navigation ul li.is-active a,
					.buddypress-wrap .activity-comments ul li span.comment-content p > a,
					.woocommerce.single-product .entry-summary-inner .price .woocommerce-Price-amount
					{
						color: {{value}};
					}
					.pagination .nav-links > *:hover,
					.pagination .nav-links span,
					.entry-single .tags-links a:hover, 
					.entry-single .cat-links a:hover,
					.posts-layout .readmore-button,
					.hover-info-wishlist.course-single-wishlist a,
					.hover-info-wishlist a,
					.posts-layout .readmore-button:hover,
					li.active a, li a.active,
					li.current a, li a.current,
					.buddypress-wrap .profile.edit ul.button-nav li.current,
					.buddypress-wrap .bp-navs li.current a, .buddypress-wrap .bp-navs li.selected a,
					.bp-avatar-nav ul.avatar-nav-items li.current,
					.bp-avatar-nav ul.avatar-nav-items li a,
					.rtcl .rtcl-MyAccount-wrap .rtcl-MyAccount-navigation ul li.is-active a
					{
					    border-color: {{value}};
					}'
				),
				'selector'    => 'format',
			),

			array(
				'name'        => "{$section}_color_secondary",
				'type'        => 'color',
				'section'     => $section,
				'placeholder' => '#c3512f',
				'title'       => esc_html__( 'Secondary Color', 'metafans' ),
				'css_format'  => apply_filters(
					'tophive/styling/secondary-color',
					'
				
					.tophive-builder-btn,
					{
					    background-color: {{value}};
					}
					.widget_display_stats dl dd,
					.secondary-color,
					.theme-secondary-color,
					.elementor-widget .bp-widget-single-activity .bp-activity-content a, 
					.buddypress.widget .bp-widget-single-activity .bp-activity-content a, 
					.buddypress .widget .bp-widget-single-activity .bp-activity-content a,
					.activity-list .activity-item .activity-header a,
					.bbp-replies-widget li a, .bbp-topics-widget li a,
					.buddypress.widget a, .buddypress .widget a,
					.buddypress-wrap .activity-comments ul li span.comment-meta-actions a,
					#group-settings-form label,
					body #buddypress div#item-header-cover-image h2 a, body #buddypress div#item-header-cover-image h2,
					body.single-item.groups #buddypress div#item-header #item-header-cover-image #item-header-content .group-name, body.single-item.groups #buddypress div#item-header #item-header-cover-image #item-header-content .group-status, #group-settings-form h2,
					table thead th, .buddypress-wrap .standard-form input[type=text], .buddypress-wrap .standard-form textarea,
					 .buddypress-wrap .standard-form textarea:focus,
					 #buddypress .profile h2.view-profile-screen, #buddypress .profile h2.edit-profile-screen,
					 .buddypress-wrap .profile.public .profile-group-title,
					 .buddypress-wrap .standard-form label, .buddypress-wrap .standard-form span.label,
					 .buddypress-wrap .item-body .screen-heading,.buddypress-wrap .standard-form input:focus, .buddypress-wrap .standard-form select:focus, .buddypress-wrap .standard-form textarea:focus, .buddypress-wrap .standard-form input, .buddypress-wrap .standard-form select, .buddypress-wrap .standard-form textarea,
					 #buddypress #bbpress-forums div.bbp-search-form input[type=text], .bbpress #bbpress-forums div.bbp-search-form input[type=text], .user-account-segment ul.loggedin-user-links li.user-account-dd-segment .account-diplay-name h6, .buddypress .tophive-mc-recent-post-widget h6, .buddypress .tophive-mc-recent-post-widget h6 small,
					 .entry.entry-single .entry-title, .comments-area .comment-reply-title,
					 .tophive-bbpress-new-post-form .form-title, .tophive-forum-recent-topics-tab-container h6,
					 .tophive-forum-topic-loop-single .tophive-forum-topic-loop-single-footer-meta div.meta-item > span, .topic-lead-question-head h6,  #bbpress-forums fieldset.bbp-form h4, .richtexteditor rte-content, .richtexteditor.rte-modern rte-toolbar, .richtexteditor rte-content,
					 .wc-product-nav .nav-btn, .product-remove a
					{
						color: {{value}};
					}'
				),
				'selector'    => 'format',
			),

			array(
				'name'        => "{$section}_color_text",
				'type'        => 'color',
				'section'     => $section,
				'title'       => esc_html__( 'Text Color', 'metafans' ),
				'placeholder' => '#686868',
				'css_format'  => apply_filters(
					'tophive/styling/text-color',
					'
					table th{
						background-color:{{value}};
					}
					body,.widget_display_stats dl dt,
					#activity-stream .activity-list .activity-item .activity-content p,
					#buddypress .activity-footer-links > div a,
					body.rte-toggleborder,
					.whats-new-live-preview .preview-content span:last-of-type,
					.th-bpm-chat-members .single-thread .name,
					.tophive-bp-messenger-sticky-main .messenger-toggler,
					.th-messenger-chat-main .chat-filed-header .avatar-img .item-content .name,
					.messenger-sticky-main-content .th-messenger-chat-main .conversion-form textarea,
					table.shop_table thead tr th,table.shop_table td .amount,
					.woocommerce form .form-row label,
					table.shop_table tfoot tr th
					{
					    color: {{value}};
					}
					abbr, acronym {
					    border-bottom-color: {{value}};
					}'
				),
				'selector'    => 'format',
			),

			array(
				'name'        => "{$section}_background_color",
				'type'        => 'color',
				'section'     => $section,
				'title'       => esc_html__( 'Primary Background Color', 'metafans' ),
				'placeholder' => '#1e4b75',
				'css_format'  => apply_filters(
					'tophive/styling/link-color',
					'body .tophive-popup-modal .tophive-popup-content-wrapper, .activity-inner .whats-new-live-preview, .th-bp-post-share-button ul.sharing-options, .th-bp-activity-like-button .reaction_icons, .tophive-bp-messenger-main-wrapper .th-messenger-chat-list, .tophive-bp-messenger-sticky-main, .th-bpm-chat-members,
						.messenger-sticky-main-content .th-bpm-top, .th-bp-header-notification-container ul, .th-bp-header-notification-container ul li, .messenger-sticky-main-content .tophive-bp-messenger-main-wrapper .th-messenger-chat-main, .th-messenger-chat-main .chat-filed-header, .tophive-bp-messenger-main-wrapper, .messenger-sticky-main-content .th-messenger-chat-main .conversion-form, .th-messenger-chat-main.loading:before, .show_searched_members, .group-create .buddypress-wrap, .cart-collaterals, .group-highlight-box, .woocommerce-checkout-review-order, .woocommerce-account .woocommerce-MyAccount-navigation, .woocommerce-account .addresses .title .edit{background-color: {{value}};}'
				),
				'selector'    => 'format',
			),
			array(
				'name'        => "{$section}_background_color_secondary",
				'type'        => 'color',
				'section'     => $section,
				'title'       => esc_html__( 'Secondary Background Color', 'metafans' ),
				'placeholder' => '#1e4b75',
				'css_format'  => apply_filters(
					'tophive/styling/link-color',
					'.th-messenger-chat-main .conversion-content .single-conversation span.c-left{background-color: {{value}};}'
				),
				'selector'    => 'format',
			),
			array(
				'name'        => "{$section}_background_color_hover",
				'type'        => 'color',
				'section'     => $section,
				'title'       => esc_html__( 'Background Hover Color', 'metafans' ),
				'placeholder' => '#1e4b75',
				'css_format'  => apply_filters(
					'tophive/styling/link-color',
					'.th-bp-post-share-button ul.sharing-options a, .tophive-bp-messenger-main-wrapper .th-messenger-chat-list .th-bpm-chat-members .single-thread:hover, 
					.messenger-sticky-main-content .th-messenger-chat-main .conversion-form textarea:focus{background-color: {{value}};}'
				),
				'selector'    => 'format',
			),
			array(
				'name'        => "{$section}_color_link",
				'type'        => 'color',
				'section'     => $section,
				'title'       => esc_html__( 'Link Color', 'metafans' ),
				'placeholder' => '#1e4b75',
				'css_format'  => apply_filters(
					'tophive/styling/link-color',
					'a, .tophive-breadcrumbs a{color: {{value}};}'
				),
				'selector'    => 'format',
			),

			array(
				'name'        => "{$section}_color_link_hover",
				'type'        => 'color',
				'section'     => $section,
				'title'       => esc_html__( 'Link Hover Color', 'metafans' ),
				'placeholder' => '#111111',
				'css_format'  => apply_filters(
					'tophive/styling/link-color-hover',
					'
					a:hover, 
					a:focus,
					.widget-area li:hover a,
					.widget-area li:hover:before,
					.posts-layout .readmore-button:hover,
					.link-meta:hover, .link-meta a:hover,
					.buddypress-wrap .bp-navs li:not(.current) a:focus, .buddypress-wrap .bp-navs li:not(.current) a:hover, .buddypress-wrap .bp-navs li:not(.selected) a:focus, .buddypress-wrap .bp-navs li:not(.selected) a:hover
					{
					    color: {{value}};
					}'
				),
				'selector'    => 'format',
			),

			array(
				'name'        => "{$section}_color_border",
				'type'        => 'color',
				'section'     => $section,
				'title'       => esc_html__( 'Border Color', 'metafans' ),
				'placeholder' => '#eaecee',
				'css_format'  => apply_filters(
					'tophive/styling/color-border',
					'
					h2 + h3, 
					.comments-area h2 + .comments-title, 
					.h2 + h3, 
					.comments-area .h2 + .comments-title, 
					.page-breadcrumb,.entry-author-bio {
					    border-top-color: {{value}};
					}
					table.shop_table tfoot td, table.shop_table tfoot th, .woocommerce-Addresses .woocommerce-Address{
						border-color: {{value}};
					}
					blockquote,
					.site-content .widget-area .menu li.current-menu-item > a:before
					{
					    border-left-color: {{value}};
					}
					.woocommerce-tabs ul.tabs, table.shop_table thead tr th
					{
					    border-bottom-color: {{value}};
					}

					@media screen and (min-width: 64em) {
					    .comment-list .children li.comment {
					        border-left-color: {{value}};
					    }
					    .comment-list .children li.comment:after {
					        background-color: {{value}};
					    }
					}

					.page-titlebar, .page-breadcrumb,
					.posts-layout .entry-inner, #bbpress-forums .topic-lead-question .topic-lead-question-head,
					.th-bpm-chat-members .single-thread,
					.messenger-sticky-main-content .th-bpm-top,
					.th-messenger-chat-main .chat-filed-header,
					body .buddypress-wrap .profile.public .profile-group-title, #buddypress .profile .bp-widget h3, #buddypress .profile h2.view-profile-screen {
					    border-bottom-color: {{value}};
					}

					.header-search-form .search-field,
					.entry-content .page-links a,
					.header-search-modal,
					.pagination .nav-links > *,
					.entry-footer .tags-links a, .entry-footer .cat-links a,
					.search .content-area article,
					.site-content .widget-area .menu li.current-menu-item > a,
					.posts-layout .entry-inner,
					.post-navigation .nav-links,
					article.comment .comment-meta,
					.widget-area .widget_pages li a, .widget-area .widget_categories li a, .widget-area .widget_archive li a, .widget-area .widget_meta li a, .widget-area .widget_nav_menu li a, .widget-area .widget_product_categories li a, .widget-area .widget_recent_entries li a, .widget-area .widget_rss li a,
					.widget-area .widget_recent_comments li,
					.post-navigation .nav-links .nav-next a, .post-navigation .nav-links .nav-previous a,
					.buddypress-wrap.round-avatars .avatar,
					.activity-inner > .shared-activity,
					.directory.groups #groups-list li .list-wrap .item-avatar img,
					.th-messenger-chat-main .conversion-form textarea,
					.messenger-sticky-main-content .th-messenger-chat-main .conversion-form,
					 .group-create .buddypress-wrap, .group-create .buddypress-wrap .bp-subhead
					{
					    border-color: {{value}};
					}

					.header-search-modal::before {
					    border-top-color: {{value}};
					    border-left-color: {{value}};
					}
					.tophive-forum-topic-loop-single .tophive-forum-topic-loop-single-footer-meta div.meta-item:first-of-type:after{
						background: {{value}};
					}

					@media screen and (min-width: 48em) {
					    .content-sidebar.sidebar_vertical_border .content-area {
					        border-right-color: {{value}};
					    }
					    .sidebar-content.sidebar_vertical_border .content-area {
					        border-left-color: {{value}};
					    }
					    .sidebar-sidebar-content.sidebar_vertical_border .sidebar-primary {
					        border-right-color: {{value}};
					    }
					    .sidebar-sidebar-content.sidebar_vertical_border .sidebar-secondary {
					        border-right-color: {{value}};
					    }
					    .content-sidebar-sidebar.sidebar_vertical_border .sidebar-primary {
					        border-left-color: {{value}};
					    }
					    .content-sidebar-sidebar.sidebar_vertical_border .sidebar-secondary {
					        border-left-color: {{value}};
					    }
					    .sidebar-content-sidebar.sidebar_vertical_border .content-area {
					        border-left-color: {{value}};
					        border-right-color: {{value}};
					    }
					    .sidebar-content-sidebar.sidebar_vertical_border .content-area {
					        border-left-color: {{value}};
					        border-right-color: {{value}};
					    }
					}
					'
				),
				'selector'    => 'format',
			),

			array(
				'name'        => "{$section}_color_meta",
				'type'        => 'color',
				'section'     => $section,
				'title'       => esc_html__( 'Meta Color', 'metafans' ),
				'placeholder' => '#6d6d6d',
				'css_format'  => apply_filters(
					'tophive/styling/color-meta',
					'
					.pagination .nav-links > *,
					.link-meta, 
					.link-meta a,
					.color-meta,
					.entry-single .tags-links:before, 
					.entry-single .cats-links:before,
					.elementor-widget .bp-widget-single-activity .bp-activity-content p, 
					.buddypress.widget .bp-widget-single-activity .bp-activity-content p, 
					.buddypress .widget .bp-widget-single-activity .bp-activity-content p,
					.activity-list .activity-item .activity-content p,
					.activity-list .activity-item .activity-header .time-since,
					.bp-widget-single-activity .time-since,
					.elementor-widget .item .item-meta .activity, .buddypress.widget .item .item-meta .activity,
					.buddypress .widget .item .item-meta .activity,
					.buddypress-wrap .activity-comments ul li span.comment-content .comment-meta .comment-date,
					.bbp-topics-widget li div, .bbp-replies-widget li div,
					#activity-stream .activity-list .activity-item .activity-content .activity-header p,
					.buddypress-wrap #whats-new-post-in-box select,
					body .buddypress-wrap .mf-activity-accessibility-container select,
					#whats-new-attachments > p svg,
					.tophive-forum-topic-loop-single .tophive-forum-topic-loop-single-meta span:last-child,
					.buddypress-wrap .activity-comments ul li span.comment-meta-actions a,
					.user-account-segment ul.loggedin-user-links li.user-account-dd-segment .account-diplay-name p, .comments-area .comment-form-comment label,
					input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], input[type="range"], input[type="date"], input[type="month"], input[type="week"], input[type="time"], input[type="datetime"], input[type="datetime-local"], input[type="color"], select, textarea, .select2-container .select2-selection--single, .tophive-bbpress-new-post-form form .form-group label, .topic-lead-question-head,
					.bp-user-designation small, .metafans-footer-nav li a, .footer-copyright-text,
					.tophive-mc-recent-post-widget p.widget-blog-date
					{
					    color: {{value}};
					}'
				),
				'selector'    => 'format',
			),

			array(
				'name'        => "{$section}_color_heading",
				'type'        => 'color',
				'section'     => $section,
				'title'       => esc_html__( 'Heading Color', 'metafans' ),
				'placeholder' => '#2b2b2b',
				'css_format'  => apply_filters( 'tophive/styling/color-heading', 'h1, h2, h3, h4, h5, h6 { color: {{value}};}' ),
				'selector'    => 'format',
			),

			array(
				'name'        => "{$section}_color_w_title",
				'type'        => 'color',
				'section'     => $section,
				'title'       => esc_html__( 'Widget Title Color', 'metafans' ),
				'placeholder' => '#444444',
				'css_format'  => '.site-content .widget-title { color: {{value}};}',
				'selector'    => 'format',
			),

			// Styling Dark Version Section.
			array(
				'name'     => "{$dark_section}",
				'type'     => 'section',
				'panel'    => 'styling_panel',
				'title'    => esc_html__( 'Dark Version', 'metafans' ),
				'priority' => 10,
			),
			array(
				'name'            => "{$dark_section}_show",
				'type'            => 'checkbox',
				'section'         => $dark_section,
				'title'           => esc_html__( 'Enable Dark Mode', 'metafans' ),
				'checkbox_label'  => esc_html__( 'Make dark', 'metafans' ),
			),
			array(
				'name'        => "{$dark_section}_site_bg",
				'type'        => 'color',
				'section'     => $dark_section,
				'title'       => esc_html__( 'Site Background', 'metafans' ),
				'default' 	  => '#000',
				'required'    => array( $dark_section . '_show', '==', '1' ),
				'css_format'  => apply_filters(
					'tophive/styling/dark/site-background',
					'
						.metafans-dark .site-content,
						.metafans-dark .site-content .content-area{
							background-color: {{value}}
						}
					'
				),
				'selector'    => 'format',
			),
			array(
				'name'        => "{$dark_section}_color_primary_bg",
				'type'        => 'color',
				'section'     => $dark_section,
				'title'       => esc_html__( 'Primary Background Color', 'metafans' ),
				'description' => esc_html__( 'Set dark version primary background color', 'metafans' ),
				'default' 	  => '#111827',
				'required'        => array( $dark_section . '_show', '==', '1' ),
				'css_format'  => apply_filters(
					'tophive/styling/dark/primary-bg',
					'
					.metafans-dark .header--row-inner.header-main-inner,
					.metafans-dark #activity-stream .activity-list.bp-list .activity-item,
					.metafans-dark .item-list.members-group-list.bp-list.grid > li > .list-wrap, 
					.metafans-dark .item-list.members-friends-list.bp-list.grid > li > .list-wrap,
					.metafans-dark #buddypress .activity-extension-links ul,
					.metafans-dark .buddypress-wrap .bp-feedback,
					.metafans-dark .bp-profile-custom-page,
					.metafans-dark #buddypress #item-header,
					.metafans-dark #whats-new-attachments,
					.metafans-dark .ac-vi-form-content,
					.metafans-dark .ac-group-main,
					.metafans-dark .th-bp-post-share-button ul.sharing-options,
					.metafans-dark #buddypress div.ac-post-form-showcase,
					.metafans-dark .buddypress-wrap.bp-dir-hori-nav:not(.bp-vertical-navs) nav:not(.tabbed-links),
					.metafans-dark .widget_area .buddypress.widget, 
					.metafans-dark .buddypress.widget, 
					.metafans-dark .buddypress .widget_area .widget, 
					.metafans-dark .widget_area .widget, 
					.metafans-dark .widget-area .widget, 
					.metafans-dark .buddypress .widget,
					.metafans-dark .skeleton-container,
					.metafans-dark .metafans-skeleton.activity .skeleton-container
					{
					    background-color: {{value}};
					}
					.metafans-dark.directory.members #members-list li .list-wrap,
					.metafans-dark #buddypress div.ac-post-form-showcase,
					.metafans-dark .activity-update-form.activity-post-form-popup #whats-new-form{
						background-color: {{value}} !important;
					}
					'
				),
				'selector'    => 'format',
			),
			array(
				'name'        => "{$dark_section}_color_secondary_bg",
				'type'        => 'color',
				'section'     => $dark_section,
				'title'       => esc_html__( 'Secondary Background Color', 'metafans' ),
				'description' => esc_html__( 'Set dark version secondary background color', 'metafans' ),
				'default' 	  => '#666',
				'required'        => array( $dark_section . '_show', '==', '1' ),
				'css_format'  => apply_filters(
					'tophive/styling/dark/secondary-bg',
					'
					.metafans-dark .buddypress-wrap .activity-comments,
					.metafans-dark #buddypress #header-cover-image,
					.metafans-dark .mode-switcher,
					.metafans-dark #whats-new-attachments > p:hover,
					.metafans-dark .ac-vi-form-active, 
					.metafans-dark .ac-vi-form-option-selected-fill, 
					.metafans-dark .ac-vi-group-select, 
					.metafans-dark .ac-vi-group-item:hover, 
					.metafans-dark .ac-vi-form-option-public:hover, 
					.metafans-dark .ac-vi-form-option-friends:hover, 
					.metafans-dark .ac-vi-form-option-onlyme:hover, 
					.metafans-dark .ac-vi-form-option-group:hover,
					.metafans-dark .activity-update-form #whats-new-options #whats-new-submit #aw-whats-new-submit:disabled,
					.metafans-dark #buddypress.buddypress-wrap .comments-text.editable-div,
					.metafans-dark #buddypress .activity-extension-links ul li a:hover,
					.metafans-dark #buddypress .activity-extension-links .open-button:hover,
					.metafans-dark .buddypress-wrap .members-list li .members-action-buttons a,
					.metafans-dark .buddypress-wrap .members-list li .members-action-buttons a.private-msg:hover,
					.metafans-dark .skeleton-box,
					.metafans-dark .metafans-skeleton .skeleton-media .skeleton-box
					{
						background-color: {{value}};
					}
					.metafans-dark .ac-post-form-showcase svg circle{
						fill: {{value}};
					} 
					.metafans-dark .whats-new-close,
					.metafans-dark .close-popup, 
					.metafans-dark .close-ac-vi-popup,
					.metafans-dark .ac-group-search input, 
					.metafans-dark .th-bp-post-share-button ul.sharing-options li a:hover{
						background-color: {{value}} !important;
					}
					'
				),
				'selector'    => 'format',
			),
			array(
				'name'        => "{$dark_section}_color_border",
				'type'        => 'color',
				'section'     => $dark_section,
				'title'       => esc_html__( 'Border Color', 'metafans' ),
				'description' => esc_html__( 'Set dark version border color', 'metafans' ),
				'default' 	  => '#888',
				'required'        => array( $dark_section . '_show', '==', '1' ),
				'css_format'  => apply_filters(
					'tophive/styling/dark/border-color',
					'
					.metafans-dark.directory.members #members-list li .list-wrap,
					.metafans-dark #buddypress #item-header,
					.metafans-dark .bp-profile-custom-page.photos-page,
					.metafans-dark .bp-profile-custom-page .section-heading,
					.metafans-dark .item-list.members-group-list.bp-list.grid > li > .list-wrap, 
					.metafans-dark .item-list.members-friends-list.bp-list.grid > li > .list-wrap,
					.metafans-dark #buddypress div.ac-post-form-showcase,
					.metafans-dark #visibility-handler,
					.metafans-dark .buddypress-wrap .bp-feedback,
					.metafans-dark .activity-post-form-header,
					.metafans-dark .activity-update-form #whats-new-options,
					.metafans-dark .ac-group-search input, 
					.metafans-dark .ac-vi-form-head,
					.metafans-dark .ac-group-header,
					.metafans-dark .ac-group-footer,
					.metafans-dark #buddypress .activity-footer-links .th-bp-footer-meta-actions,
					.metafans-dark #activity-stream .activity-list.bp-list .activity-item,
					.metafans-dark #buddypress.buddypress-wrap .comments-text.editable-div,
					.metafans-dark .buddypress-wrap.bp-dir-hori-nav:not(.bp-vertical-navs) nav:not(.tabbed-links),
					.metafans-dark .widget_area .buddypress.widget, 
					.metafans-dark .buddypress.widget, 
					.metafans-dark .buddypress .widget_area .widget, 
					.metafans-dark .widget_area .widget, 
					.metafans-dark .widget-area .widget,
					.metafans-dark .buddypress .widget,
					.metafans-dark .skeleton-container,
					.metafans-dark .metafans-skeleton.members,
					.metafans-dark .metafans-skeleton.activity .skeleton-container
					{
					    border-color: {{value}};
					}'
				),
				'selector'    => 'format',
			),
			array(
				'name'        => "{$dark_section}_color_text_primary",
				'type'        => 'color',
				'section'     => $dark_section,
				'title'       => esc_html__( 'Text Color Primary', 'metafans' ),
				'default' 	  => '#ffffff',
				'required'        => array( $dark_section . '_show', '==', '1' ),
				'css_format'  => apply_filters(
					'tophive/styling/dark/text-color-primary',
					'
					.metafans-dark .nav-menu-desktop .menu > li > a,
					.metafans-dark.directory.members #members-list li .list-wrap .list-title.member-name a,
					.metafans-dark .bp-profile-custom-page .section-heading .title,
					.metafans-dark .buddypress-wrap .members-list li .user-facts p span:first-of-type,
					.metafans-dark #buddypress div#item-header-cover-image h2,
					.metafans-dark .item-list.members-group-list.bp-list > li .list-wrap .list-title.member-name a, 
					.metafans-dark .item-list.members-friends-list.bp-list > li .list-wrap .list-title.member-name a,
					.metafans-dark .buddypress-wrap .members-list li .members-action-buttons a.bp-th-follow-button,
					.metafans-dark #buddypress .bp-search form button[type="submit"],
					.metafans-dark .activity-list .activity-item .activity-header a,
					.metafans-dark #buddypress .activity-extension-links ul li a h4,
					.metafans-dark #buddypress .activity-footer-links > div a,
					.metafans-dark #buddypress .activity-post-form-header h4,
					.metafans-dark .activity-post-form-popup .advanced-th-bp-activity-form,
					.metafans-dark .ac-vi-form-header-text,
					.metafans-dark .buddypress-wrap .bp-feedback p,
					.metafans-dark .ac-vi-form-option-title,
					.metafans-dark .ac-group-header p,
					.metafans-dark .ac-vi-group-label,
					.metafans-dark .buddypress-wrap .activity-comments ul li span.comment-content .comment-meta a,
					.metafans-dark .activity-list .activity-item .activity-content p,
					.metafans-dark .buddypress.widget .bp-widget-single-activity .bp-activity-content a, 
					.metafans-dark .buddypress .widget .bp-widget-single-activity .bp-activity-content a,
					.metafans-dark .bp-widget-single-activity .time-since
					{
					    color: {{value}};
					}
					.metafans-dark #buddypress .activity-post-form-popup.activity-update-form .what-is-new-avatar-text{
						color: {{value}} !important;
					}
					'
				),
				'selector'    => 'format',
			),
			array(
				'name'        => "{$dark_section}_color_text_secondary",
				'type'        => 'color',
				'section'     => $dark_section,
				'title'       => esc_html__( 'Text Color Secondary', 'metafans' ),
				'default' 	  => '#999',
				'required'        => array( $dark_section . '_show', '==', '1' ),
				'css_format'  => apply_filters(
					'tophive/styling/dark/text-color-secondary',
					'
					.metafans-dark #visibility-handler > span, 
					.metafans-dark .profile-header-meta-date, 
					.metafans-dark.bp-user #buddypress #item-header .user-facts p span, 
					.metafans-dark .buddypress-wrap:not(.bp-single-vert-nav) .main-navs ul > li > a, 
					.metafans-dark .ac-vi-form-option-des, 
					.metafans-dark .activity-list .activity-item .activity-content p, 
					.metafans-dark #buddypress .activity-extension-links ul li a p, 
					.metafans-dark .activity-list .activity-item .activity-header .time-since, 
					.metafans-dark .buddypress.widget .bp-widget-single-activity .bp-activity-content p, 
					.metafans-dark .buddypress .widget .bp-widget-single-activity .bp-activity-content p,
					.metafans-dark .bp-widget-single-activity .time-since
					{
						color: {{value}};
					}
					.metafans-dark #visibility-handler > svg{
						fill: {{value}};
					}
					'
				),
				'selector'    => 'format',
			),
		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'tophive/customizer/config', 'tophive_customizer_styling_config' );
