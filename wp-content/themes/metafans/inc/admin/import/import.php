<?php 
if ( !is_admin() ) { return; }


function metafans_ocdi_import_files() {
	global $metafans_demo_list;
	$metafans_demo_list = array(
		array(
			'import_file_name'           => 'Metafans Classic',
			'import_file_url'            => get_template_directory_uri() . '/demo-data/content/metafans-classic.xml',
			'import_widget_file_url'     => get_template_directory_uri() . '/demo-data/widgets/metafans-classic-widgets.wie',
			'import_customizer_file_url' => get_template_directory_uri() . '/demo-data/customizer/metafans-classic-customizer.dat',
			'import_preview_image_url'   => 'https://i.ibb.co/nkbXWbr/classic.jpg',
			'preview_url'                => 'https://demo.tophivetheme.com/metafans/classic/',
		),
		array(
			'import_file_name'           => 'Metafans Classic Dark',
			'import_file_url'            => get_template_directory_uri() . '/demo-data/content/metafans-dark.xml',
			'import_widget_file_url'     => get_template_directory_uri() . '/demo-data/widgets/metafans-dark-widgets.wie',
			'import_customizer_file_url' => get_template_directory_uri() . '/demo-data/customizer/metafans-dark.dat',
			'import_preview_image_url'   => 'https://i.ibb.co/PFyLc1P/dark.jpg',
			'preview_url'                => 'https://demo.tophivetheme.com/metafans/dev-community/',
		),
		array(
			'import_file_name'           => 'Forum Demo',
			'import_file_url'            => get_template_directory_uri() . '/demo-data/content/metafans-bbpress.xml',
			'import_widget_file_url'     => get_template_directory_uri() . '/demo-data/widgets/metafans-bbpress-widgets.wie',
			'import_customizer_file_url' => get_template_directory_uri() . '/demo-data/customizer/metafans-bbpress-customizer.dat',
			'import_preview_image_url'   => 'https://i.ibb.co/vBDPwq7/bbpress.jpg',
			'preview_url'                => 'https://demo.tophivetheme.com/metafans/bbpress/',
		),
		
		array(
			'import_file_name'           => 'Forum Dark demo',
			'import_file_url'            => get_template_directory_uri() . '/demo-data/content/forum-dark.xml',
			'import_widget_file_url'     => get_template_directory_uri() . '/demo-data/widgets/forum-dark-widgets.wie',
			'import_customizer_file_url' => get_template_directory_uri() . '/demo-data/customizer/forum-dark-customizer.dat',
			'import_preview_image_url'   => 'https://i.ibb.co/7px7MWr/forums-dark.jpg',
			'preview_url'                => 'https://demo.tophivetheme.com/metafans/forums-dark/',
		),
		array(
			'import_file_name'           => 'Business Demo',
			'import_file_url'            => get_template_directory_uri() . '/demo-data/content/metafans-business.xml',
			'import_widget_file_url'     => get_template_directory_uri() . '/demo-data/widgets/metafans-business-widgets.wie',
			'import_customizer_file_url' => get_template_directory_uri() . '/demo-data/customizer/metafans-business.dat',
			'import_preview_image_url'   => 'https://i.ibb.co/7px7MWr/forums-dark.jpg',
			'preview_url'                => 'https://demo.tophivetheme.com/metafans/forums-dark/',
		),
		array(
			'import_file_name'           => 'Online Communities',
			'import_file_url'            => get_template_directory_uri() . '/demo-data/content/metafans-onlinecommunities.xml',
			'import_widget_file_url'     => get_template_directory_uri() . '/demo-data/widgets/metafans-online-communities-widgets.wie',
			'import_customizer_file_url' => get_template_directory_uri() . '/demo-data/customizer/metafans-online-communities-customizer.dat',
			'import_preview_image_url'   => 'https://i.ibb.co/x26hykn/buddypress.jpg',
			'preview_url'                => 'https://demo.tophivetheme.com/metafans/online-communities/',
		),
		
		array(
			'import_file_name'           => 'Gaming Community',
			'import_file_url'            => get_template_directory_uri() . '/demo-data/content/metafans-gamingcommunity.xml',
			'import_widget_file_url'     => get_template_directory_uri() . '/demo-data/widgets/metafans-gamingcommunity.wie',
			'import_customizer_file_url' => get_template_directory_uri() . '/demo-data/customizer/metafans-gamingcommunity.dat',
			'import_preview_image_url'   => 'https://i.ibb.co/d6k7jgD/gaming.jpg',
			'preview_url'                => 'https://demo.tophivetheme.com/metafans/gaming-community/',
		),
		array(
			'import_file_name'           => 'Youzify Demo',
			'import_file_url'            => get_template_directory_uri() . '/demo-data/content/profile-timeline.xml',
			'import_widget_file_url'     => get_template_directory_uri() . '/demo-data/widgets/profile-timeline.wie',
			'import_customizer_file_url' => get_template_directory_uri() . '/demo-data/customizer/profile-timeline.dat',
			'import_preview_image_url'   => 'https://i.ibb.co/bFPC0Md/youzify.jpg',
			'preview_url'                => 'https://metafans.tophivetheme.com/profile-timeline/account/',
		),
	);
	return $metafans_demo_list;
}
add_filter( 'pt-ocdi/import_files', 'metafans_ocdi_import_files' );


// disable thumbnail regeneration
//add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );
//add_filter( 'merlin_regenerate_thumbnails_in_content_import', '__return_false' );



function metafans_ocdi_after_import( $selected_import ) {
	global $metafans_demo_list;

	// Assign menus to their locations.
	$header = get_term_by('name', 'Header Menu', 'nav_menu');
	$vertical = get_term_by('name', 'Vertical Menu', 'nav_menu');
	$forums = get_term_by('name', 'Forums', 'nav_menu');
	
	set_theme_mod( 'nav_menu_locations' , array(
			'menu-1'    => $header->term_id,
			'menu-2'     => $forums->term_id,
			'vertical-menu'  => $vertical->term_id,
		)
	);
	
	// Assign front, blog pages.
	$home = get_page_by_path('activity');
	$blog = get_page_by_path('blog');

	update_post_meta( $home->ID, '_tophive_page_header_display', 'none' );


	// // Override home and blog pages according to demo ID
	// $home = get_page_by_title($metafans_demo_list[$selected_import]['home']);
	if ($selected_import == 5) {
		$home = get_page_by_path('games-discussion');
	}elseif ($selected_import == 2 || $selected_import == 4) {
		$home = get_page_by_path('forum');
	}
	// Delete duplicates
	$pages2 = array('cart','checkout','my-account','wishlist', 'activity');
	foreach ($pages2 as $p2) {
		$p = get_page_by_path($p2 . '-2');
		if ($p) {
			wp_delete_post( $p->ID, true);
		}
	}
	foreach ($pages2 as $p2) {
		$p = get_page_by_path($p2 . '-3');
		if ($p) {
			wp_delete_post( $p->ID, true);
		}
	}
	// Get Shop page
	$shop2 = get_page_by_path('shop-2');
	if ($shop2) {
		$shop1 = get_page_by_path('shop');
		wp_delete_post( $shop1->ID, true);
		wp_update_post([
			'post_name' => 'shop',
			'ID' => $shop2->ID,
		]);
	}

	$shop = get_page_by_path('shop');
	$cart = get_page_by_path('cart');
	$checkout = get_page_by_path('checkout');
	$wishlist = get_page_by_path('wishlist');
	$myaccount = get_page_by_path('my-account');
	
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home->ID );
	update_option( 'page_for_posts', $blog->ID );	
	update_option( 'woocommerce_myaccount_page_id', $myaccount->ID );
	update_option( 'woocommerce_shop_page_id', $shop->ID );
	update_option( 'woocommerce_cart_page_id', $cart->ID );
	update_option( 'woocommerce_checkout_page_id', $checkout->ID );
	update_option( 'general-show_notice', '');
	
	// We no longer need to install pages for WooCommerce
	delete_option( '_wc_needs_pages' );
	delete_transient( '_wc_activation_redirect' );

	// // Flush rules after install
	flush_rewrite_rules();

	// global $wpdb;
	
	// // Change attribute types
	// $table_name = $wpdb->prefix . 'woocommerce_attribute_taxonomies';
	
	// $wpdb->query( "UPDATE `$table_name` SET `attribute_type` = 'color' WHERE `attribute_name` = 'color'" );
	// $wpdb->query( "UPDATE `$table_name` SET `attribute_type` = 'image' WHERE `attribute_name` = 'pattern'" );
	// $wpdb->query( "UPDATE `$table_name` SET `attribute_type` = 'button' WHERE `attribute_name` = 'size'" );
}
add_action( 'pt-ocdi/after_import', 'metafans_ocdi_after_import' );

/* Disable Branding */
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/* Intro text */
function metafans_ocdi_plugin_intro_text( $default_text ) {

	ob_start(); ?>
	
	<div class="ocdi__intro-notice  notice  notice-warning">
		<p><?php esc_html_e( 'Before you begin, make sure all the required plugins are activated.', 'metafans' ); ?></p>
	</div>
	
		<div class="ocdi__intro-text">
			<p class="about-description">
				<?php esc_html_e( 'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme.', 'metafans' ); ?>
				<?php esc_html_e( 'It will allow you to quickly edit everything instead of creating content from scratch.', 'metafans' ); ?>
			</p>

			<p><span class="dashicons dashicons-warning"></span>  <?php esc_html_e( 'Please click on the Import button only once and wait, it can take some minutes.', 'metafans' ); ?></p>

			<?php if ( empty( $_GET['import-mode'] ) || 'manual' !== $_GET['import-mode'] ) : ?>
				<a href="<?php echo esc_url("admin.php?page=pt-one-click-demo-import&amp;import-mode=manual"); ?>" class="ocdi__import-mode-switch"><?php esc_html_e( 'Switch to manual import!', 'metafans' ); ?></a>
				<?php else : ?>
					<a href="<?php echo esc_url("admin.php?page=pt-one-click-demo-import"); ?>" class="ocdi__import-mode-switch"><?php esc_html_e( 'Switch back to theme predefined imports!', 'metafans' ); ?></a>
			<?php endif; ?>

		</div>



	<?php
	$default_text = ob_get_clean();
	return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'metafans_ocdi_plugin_intro_text' );
