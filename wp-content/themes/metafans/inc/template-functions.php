<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package tophive
 */

if ( ! function_exists( 'tophive_get_config_sidebar_layouts' ) ) {
	function tophive_get_config_sidebar_layouts() {
		return array(
			'content-sidebar'         => esc_html__( 'Content / Sidebar', 'metafans' ),
			'sidebar-content'         => esc_html__( 'Sidebar / Content', 'metafans' ),
			'content'                 => esc_html__( 'Content (no sidebars)', 'metafans' ),
			'sidebar-content-sidebar' => esc_html__( 'Sidebar / Content / Sidebar', 'metafans' ),
			'sidebar-sidebar-content' => esc_html__( 'Sidebar / Sidebar / Content', 'metafans' ),
			'content-sidebar-sidebar' => esc_html__( 'Content / Sidebar / Sidebar', 'metafans' ),
		);
	}
}
if ( ! function_exists( 'tophive_get_all_image_sizes' ) ) {
	/**
	 * Get all the registered image sizes along with their dimensions
	 *
	 * @global array $_wp_additional_image_sizes
	 *
	 * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
	 * @return array $image_sizes The image sizes
	 */
	function tophive_get_all_image_sizes() {
		global $_wp_additional_image_sizes;
		$default_image_sizes = array( 'thumbnail', 'medium', 'large' );

		foreach ( $default_image_sizes as $size ) {
			$image_sizes[ $size ]['width']  = intval( get_option( "{$size}_size_w" ) );
			$image_sizes[ $size ]['height'] = intval( get_option( "{$size}_size_h" ) );
			$image_sizes[ $size ]['crop']   = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
		}

		if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
			$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
		}

		$options = array();
		foreach ( $image_sizes as $k => $option ) {
			$options[ $k ] = sprintf( '%1$s - (%2$s x %3$s)', $k, $option['width'], $option['height'] );
		}

		$options['full'] = 'Full';

		return $options;
	}
}

if ( ! function_exists( 'tophive_get_layout' ) ) {
	/**
	 * Get the layout for the current page from Customizer setting or individual page/post.
	 *
	 * @since 0.0.1
	 * @since 0.2.6
	 */
	function tophive_get_layout() {
		global $wp_query;
		$default = tophive_metafans()->get_setting( 'sidebar_layout' );
		$layout  = apply_filters( 'tophive_get_layout', null );
	
		if ( ! $layout ) {
			$page = tophive_metafans()->get_setting( 'page_sidebar_layout' );

			if ( is_home() && is_front_page() || ( is_home() && ! is_front_page() ) ) { // Blog page.
				$blog_posts = tophive_metafans()->get_setting( 'posts_sidebar_layout' );
				if( is_active_sidebar( 'sidebar-1' ) ){
					$layout     = $blog_posts;
				}else{
					$layout     = 'content';
				}
			} elseif ( is_page() ) { // Page.
				$layout = tophive_metafans()->get_setting( 'page_sidebar_layout' );
				if( is_active_sidebar( 'sidebar-1' ) ){
					$layout     = $layout;
				}else{
					$layout     = 'content';
				}
			} elseif ( is_search() ) { // Search.
				$search = tophive_metafans()->get_setting( 'search_sidebar_layout' );
				$layout = $search;
				if( is_active_sidebar( 'sidebar-1' ) ){
					$layout     = $layout;
				}else{
					$layout     = 'content';
				}
			} elseif ( is_archive() ) { // Archive.
				$archive = tophive_metafans()->get_setting( 'posts_archives_sidebar_layout' );
				$layout  = $archive;
				if( is_active_sidebar( 'sidebar-1' ) ){
					$layout     = $layout;
				}else{
					$layout     = 'content';
				}
			} elseif ( is_category() || is_tag() || is_singular( 'post' ) ) { // blog page and single page.
				$blog_posts = tophive_metafans()->get_setting( 'posts_sidebar_layout' );
				if( is_active_sidebar( 'sidebar-1' ) ){
					$layout     = $blog_posts;
				}else{
					$layout     = 'content';
				}
			} elseif ( is_404() ) { // 404 Page.
				$layout = tophive_metafans()->get_setting( '404_sidebar_layout' );
			} elseif ( is_singular() ) {
				$layout = tophive_metafans()->get_setting( get_post_type() . '_sidebar_layout' );
			} 
			if(  tophive_metafans()->is_bbpress_active() ){
				if( is_bbpress() ){
					$layout = tophive_metafans()->get_setting( 'bbpress_sidebar_layout' );
				}
			}
			// Support for all posts that using meta settings.
			if ( tophive_metafans()->is_using_post() && tophive_is_support_meta() ) {

				$post_type   = get_post_type();
				$page_custom = get_post_meta( tophive_get_support_meta_id() . '_tophive_sidebar', true );

				if ( ! $page_custom ) {
					if ( tophive_metafans()->is_woocommerce_active() ) {
						if ( is_cart() || is_checkout() || is_account_page() || is_product() ) {
							$page_custom = 'content';
						}
					}
				}

				if ( $page_custom ) {
					if ( $page_custom && 'default' != $page_custom ) {
						$layout = $page_custom;
					}
				} elseif ( 'page' == $post_type ) {
					if(  tophive_metafans()->is_buddypress_active() && bp_is_user() ){
						if( bp_current_component() == 'activity' ){
							$layout = tophive_metafans()->get_setting( 'buddypress_profile_sidebar_layout' );
						}else{
							$layout = 'content';
						}
					}elseif(  tophive_metafans()->is_buddypress_active() && bp_current_component() === 'activity' ){
						$layout = tophive_metafans()->get_setting( 'buddypress_activity_sidebar_layout' );
					}elseif(  tophive_metafans()->is_buddypress_active() && bp_current_component() === 'groups' && !bp_is_group_single() ){
						$layout = tophive_metafans()->get_setting( 'buddypress_groups_sidebar_layout' );
					}elseif(  tophive_metafans()->is_buddypress_active() && bp_current_component() === 'groups' && bp_is_group_single() ){
						$layout = tophive_metafans()->get_setting( 'buddypress_groups_single_sidebar_layout' );
					}elseif(  tophive_metafans()->is_buddypress_active() && bp_current_component() === 'members' ){
						$layout = tophive_metafans()->get_setting( 'buddypress_memebrs_sidebar_layout' );
					}else{
						$layout = $page;
					}
				} elseif( 'forum' == $post_type ){
					if(  tophive_metafans()->is_bbpress_active() && is_singular('forum') ){
						$layout = tophive_metafans()->get_setting( 'forum_sidebar_layout' );
					}
				} elseif( 'topic' == $post_type ){
					if(  tophive_metafans()->is_bbpress_active() && is_singular('topic') ){
						$layout = tophive_metafans()->get_setting( 'topic_sidebar_layout' );
					}
				}

			}
		}

		if ( ! $layout ) {
			$layout = 'content';
		}


		return $layout;
	}
}

if ( ! function_exists( 'tophive_get_sidebars' ) ) {
	/**
	 * Display primary or/and secondary sidebar base on layout setting.
	 *
	 * @since 0.0.1
	 */
	function tophive_get_sidebars() {

		// Get the current layout.
		$layout = tophive_get_layout();
		if ( ! $layout || 'default' == $layout ) {
			$layout = 'content-sidebar';
		}

		// Layout with 2 column.
		$layout_2_columns = array( 'sidebar-content', 'content-sidebar' );

		// Layout with 3 column.
		$layout_3_columns = array( 'sidebar-sidebar-content', 'sidebar-content-sidebar', 'content-sidebar-sidebar' );

		// Only show primary sidebar for 2 column layout.
		if ( in_array( $layout, $layout_2_columns ) ) { // phpcs:ignore
			get_sidebar();
		}

		// Show both sidebar for 3 column layout.
		if ( in_array( $layout, $layout_3_columns ) ) { // phpcs:ignore
			get_sidebar();
			get_sidebar( 'secondary' );
		}

	}
}
add_action( 'tophive/sidebars', 'tophive_get_sidebars' );

if ( ! function_exists( 'tophive_pingback_header' ) ) {
	/**
	 * Add a pingback url auto-discovery header for singularly identifiable articles.
	 */
	function tophive_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
}
add_action( 'wp_head', 'tophive_pingback_header' );

if ( ! function_exists( 'tophive_is_support_meta' ) ) {
	function tophive_is_support_meta() {
		$support = is_singular();
		if ( is_home() && get_option( 'page_for_posts' ) ) {
			$support = true;
		}

		return $support;
	}
}

if ( ! function_exists( 'tophive_get_support_meta_id' ) ) {
	function tophive_get_support_meta_id() {
		$id = is_singular() ? get_the_ID() : false;
		if ( is_home() && get_option( 'page_for_posts' ) ) {
			$id = get_option( 'page_for_posts' );
		}
		if( is_page() ){
			$id = get_queried_object_id();
		}

		return $id;
	}
}

if ( ! function_exists( 'tophive_is_header_display' ) ) {
	/**
	 * Check if show header
	 *
	 * @return bool
	 */
	function tophive_is_header_display() {
		$show = true;
		// page_for_posts.
		if ( tophive_is_support_meta() ) {
			$disable = get_post_meta( tophive_get_support_meta_id(), '_tophive_disable_header', true );
			if ( $disable ) {
				$show = false;
			}
		}

		return apply_filters( 'tophive_is_header_display', $show );
	}
}

if ( ! function_exists( 'tophive_is_footer_display' ) ) {
	/**
	 * Check if show header
	 *
	 * @return bool
	 */
	function tophive_is_footer_display() {
		$show = true;
		if ( tophive_is_support_meta() ) {
			$rows  = array( 'main', 'bottom' );
			if ( class_exists( 'Tophive_Pro' ) ) {
				$rows[] = 'top';
			}
			$count = 0;
			foreach ( $rows as $row_id ) {
				if ( ! tophive_is_builder_row_display( 'footer', $row_id ) ) {
					$count ++;
				}
			}
			if ( $count >= count( $rows ) ) {
				$show = false;
			}
		}

		return apply_filters( 'tophive_is_footer_display', $show );
	}
}

if ( ! function_exists( 'tophive_is_builder_row_display' ) ) {

	/**
	 * Check if show header
	 *
	 * @param string $builder_id
	 * @param bool   $row_id
	 * @param bool   $post_id
	 *
	 * @return mixed
	 */
	function tophive_is_builder_row_display( $builder_id, $row_id = false, $post_id = false ) {
		$show = true;
		if ( $row_id && $builder_id ) {
			if ( ! $post_id ) {
				$post_id = apply_filters( 'tophive_builder_row_display_get_post_id', tophive_get_support_meta_id() );
			}
			$key     = $builder_id . '_' . $row_id;
			$disable = get_post_meta( $post_id, '_tophive_disable_' . $key, true );
			if ( $disable ) {
				$show = false;
			}
		}

		return apply_filters( 'tophive_is_builder_row_display', $show, $builder_id, $row_id, $post_id );
	}
}

if( !function_exists( 'tophive_sanitize_attr' ) ){
	function tophive_sanitize_attr( $to_sanitize = '' ){
		return $to_sanitize;
	}
}

if ( ! function_exists( 'tophive_show_post_title' ) ) {
	/**
	 * Check if display title of any post type
	 */
	function tophive_is_post_title_display() {
		$show = true;
		if ( tophive_metafans()->is_using_post() ) {
			$disable = get_post_meta( tophive_metafans()->get_current_post_id(), '_tophive_disable_page_title', true );
			if ( $disable ) {
				$show = false;
			}
		}

		$r = apply_filters( 'tophive_is_post_title_display', $show );

		return $r;
	}
}


/**
 * Retrieve the archive title based on the queried object.
 *
 * @param string $title
 *
 * @return string Archive title.
 */
function tophive_get_the_archive_title( $title ) {
	$disable = tophive_metafans()->get_setting( 'page_header_show_archive_prefix' );
	if ( ! $disable ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_year() ) {
			$title = get_the_date( _x( 'Y', 'yearly archives date format', 'metafans' ) );
		} elseif ( is_month() ) {
			$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'metafans' ) );
		} elseif ( is_day() ) {
			$title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'metafans' ) );
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		}
	}

	return $title;
}

add_filter( 'get_the_archive_title', 'tophive_get_the_archive_title', 15 );

function tophive_search_form( $form ) {
	$form = '
		<form role="search" class="sidebar-search-form" action="' . esc_url( home_url( '/' ) ) . '">
            <label>
                <span class="screen-reader-text">' . _x( 'Search for:', 'label', 'metafans' ) . '</span>
                <input type="search" class="search-field" placeholder="' . esc_attr__( 'Search &hellip;', 'metafans' ) . '" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search for:', 'label', 'metafans' ) . '" />
            </label>
            <button type="submit" class="search-submit" >
                <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21">
                    <path id="svg-search" fill="currentColor" fill-rule="evenodd" d="M12.514 14.906a8.264 8.264 0 0 1-4.322 1.21C3.668 16.116 0 12.513 0 8.07 0 3.626 3.668.023 8.192.023c4.525 0 8.193 3.603 8.193 8.047 0 2.033-.769 3.89-2.035 5.307l4.999 5.552-1.775 1.597-5.06-5.62zm-4.322-.843c3.37 0 6.102-2.684 6.102-5.993 0-3.31-2.732-5.994-6.102-5.994S2.09 4.76 2.09 8.07c0 3.31 2.732 5.993 6.102 5.993z"></path>
                </svg>
            </button>
        </form>';

	return $form;
}

add_filter( 'get_search_form', 'tophive_search_form' );

function tophive_add_meta_image(){
    if( is_single() ) {
        echo '<meta property="og:image" content="'. get_the_post_thumbnail_url(get_the_ID(),'full')   .'" />';
    }
}
add_action('wp_head', 'tophive_add_meta_image');


if( !function_exists('tophive_registration_form') ){
	/** 
	** Tophive Basic registration form
	** @since v2.3.0
	*/
	function tophive_registration_form(){
		if( !get_option( 'users_can_register' ) ){
			?>
				<h2>User Registration is currently Disabled</h2>
			<?php
		}
		$after_title_text = tophive_metafans()->get_setting('theme_globals_text_after_title');
		$before_btn_text = tophive_metafans()->get_setting('theme_globals_text_before_button');
		$after_btn_text = tophive_metafans()->get_setting('theme_globals_text_after_button');
		?>
		<p><?php echo $after_btn_text; ?></p>
		<form name="th-modal-register" class="th-modal-register" method="post">
	    	<p class="ec-text-center login-notices"></p>
	        <ul class="form-fields">
                <li>
                	<div class="ec-row">
                		<?php if( tophive_metafans()->get_setting('theme_globals_enable_first_name') == 1 ){ ?>
	                		<div class="ec-col">
								<div class="th-form-field">
									<label for="reg_first_name"><?php esc_html_e( 'First Name', 'metafans' ); ?></label>
								</div>
								<div class="th-form-field">
									<input size="30" placeholder="<?php esc_html_e( 'First name', 'metafans' ); ?>" type="text" required="required" id="reg_first_name" class="th-form-field" name="reg_first_name">
								</div>
	                		</div>
                		<?php } ?>
                		<?php if( tophive_metafans()->get_setting('theme_globals_enable_display_name') == 1 ){ ?>
                		<div class="ec-col">
							<div class="th-form-field">
								<label for="reg_display_name"><?php esc_html_e( 'Display Name', 'metafans' ); ?></label>
							</div>
							<div class="th-form-field">
								<input size="30" placeholder="<?php esc_html_e( 'Display name', 'metafans' ); ?>" type="text" required="required" id="reg_display_name" class="th-form-field" name="reg_display_name">
							</div>
                		</div>
                		<?php } ?>
                	</div>
				</li>                
				<li>
            		<?php if( tophive_metafans()->get_setting('theme_globals_enable_gender') == 1 ){ ?>
						<div class="th-form-field">
							<label for="reg_gender"><?php esc_html_e( 'Gender', 'metafans' ); ?></label>
						</div>
					<div class="th-form-field">
						<select class="th-form-field" id="reg_gender" name="reg_gender">
							<option value=""><?php esc_html_e( 'Gender', 'metafans' ) ?></option>
							<option value="male"><?php esc_html_e( 'Male', 'metafans' ) ?></option>
							<option value="female"><?php esc_html_e( 'Female', 'metafans' ) ?></option>
							<option value="other"><?php esc_html_e( 'Others', 'metafans' ) ?></option>
						</select>
					</div>
            		<?php } ?>
				</li>
				<li>
            		<?php if( tophive_metafans()->get_setting('theme_globals_enable_birth_day') == 1 ){ ?>
                	<div class="ec-row">
                		<div class="ec-col-md-12">
                			<p><?php esc_html_e( 'Date of birth', 'metafans' ) ?></p>
                		</div>
                		<div class="ec-col-4">
							<div class="th-form-field">
								<select class="th-form-field" id="reg_bday_date" name="reg_bday_date">
									<option value=""><?php esc_html_e( 'Day', 'metafans' ) ?></option>
									<option value="01"><?php esc_html_e( '1', 'metafans' ) ?></option>
									<option value="02"><?php esc_html_e( '2', 'metafans' ) ?></option>
									<option value="03"><?php esc_html_e( '3', 'metafans' ) ?></option>
									<option value="04"><?php esc_html_e( '4', 'metafans' ) ?></option>
									<option value="05"><?php esc_html_e( '5', 'metafans' ) ?></option>
									<option value="06"><?php esc_html_e( '6', 'metafans' ) ?></option>
									<option value="07"><?php esc_html_e( '7', 'metafans' ) ?></option>
									<option value="08"><?php esc_html_e( '8', 'metafans' ) ?></option>
									<option value="09"><?php esc_html_e( '9', 'metafans' ) ?></option>
									<option value="10"><?php esc_html_e( '10', 'metafans' ) ?></option>
									<option value="11"><?php esc_html_e( '11', 'metafans' ) ?></option>
									<option value="12"><?php esc_html_e( '12', 'metafans' ) ?></option>
									<option value="13"><?php esc_html_e( '13', 'metafans' ) ?></option>
									<option value="14"><?php esc_html_e( '14', 'metafans' ) ?></option>
									<option value="15"><?php esc_html_e( '15', 'metafans' ) ?></option>
									<option value="16"><?php esc_html_e( '16', 'metafans' ) ?></option>
									<option value="17"><?php esc_html_e( '17', 'metafans' ) ?></option>
									<option value="18"><?php esc_html_e( '18', 'metafans' ) ?></option>
									<option value="19"><?php esc_html_e( '19', 'metafans' ) ?></option>
									<option value="20"><?php esc_html_e( '20', 'metafans' ) ?></option>
									<option value="21"><?php esc_html_e( '21', 'metafans' ) ?></option>
									<option value="22"><?php esc_html_e( '22', 'metafans' ) ?></option>
									<option value="23"><?php esc_html_e( '23', 'metafans' ) ?></option>
									<option value="24"><?php esc_html_e( '24', 'metafans' ) ?></option>
									<option value="25"><?php esc_html_e( '25', 'metafans' ) ?></option>
									<option value="26"><?php esc_html_e( '26', 'metafans' ) ?></option>
									<option value="27"><?php esc_html_e( '27', 'metafans' ) ?></option>
									<option value="28"><?php esc_html_e( '28', 'metafans' ) ?></option>
									<option value="29"><?php esc_html_e( '29', 'metafans' ) ?></option>
									<option value="30"><?php esc_html_e( '30', 'metafans' ) ?></option>
									<option value="31"><?php esc_html_e( '31', 'metafans' ) ?></option>
								</select>
							</div>
                		</div>
                		<div class="ec-col-4">
							<div class="th-form-field">
								<select class="th-form-field" id="reg_bday_month" name="reg_bday_month">
									<option value=""><?php esc_html_e( 'Month', 'metafans' ) ?></option>
									<option value="01"><?php esc_html_e( 'January', 'metafans' ) ?></option>
									<option value="02"><?php esc_html_e( 'February', 'metafans' ) ?></option>
									<option value="03"><?php esc_html_e( 'March', 'metafans' ) ?></option>
									<option value="04"><?php esc_html_e( 'April', 'metafans' ) ?></option>
									<option value="05"><?php esc_html_e( 'May', 'metafans' ) ?></option>
									<option value="06"><?php esc_html_e( 'June', 'metafans' ) ?></option>
									<option value="07"><?php esc_html_e( 'July', 'metafans' ) ?></option>
									<option value="08"><?php esc_html_e( 'August', 'metafans' ) ?></option>
									<option value="09"><?php esc_html_e( 'September', 'metafans' ) ?></option>
									<option value="10"><?php esc_html_e( 'October', 'metafans' ) ?></option>
									<option value="11"><?php esc_html_e( 'November', 'metafans' ) ?></option>
									<option value="12"><?php esc_html_e( 'December', 'metafans' ) ?></option>
								</select>
							</div>
                		</div>
                		<div class="ec-col-4">
							<div class="th-form-field">
								<select class="th-form-field" id="reg_bday_year" name="reg_bday_year">
									<option value="0">Year</option><option value="2021" selected="1">2021</option><option value="2020">2020</option><option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option>
								</select>
							</div>
                		</div>
                	</div>
            		<?php } ?>
				</li>
				<li>
				</li>
				<li>
					<div class="th-form-field">
						<label for="reg_username"><?php esc_html_e( 'Username', 'metafans' ); ?></label>
					</div>
					<div class="th-form-field">
						<input size="30" placeholder="<?php esc_html_e( 'Username', 'metafans' ); ?>" type="text" autocomplete="nope" required="required" id="reg_username" class="th-form-field" name="reg_username">
					</div>
				</li>
				<li>
					<div class="th-form-field">
						<label for="reg_mail"><?php esc_html_e( 'Email', 'metafans' ); ?></label>	
					</div>
					<div class="th-form-field">
						<input size="30" placeholder="<?php esc_html_e( 'Email', 'metafans' ); ?>" type="email" required="" id="reg_mail" class="th-form-field" name="reg_mail">
					</div>
				</li>
				<li class="form-field">
					<div class="th-form-field">
						<label for="reg_password"><?php esc_html_e('Password', 'metafans'); ?>
							
						</label>
					</div>
					<div class="th-form-field">
						<input size="30" placeholder="<?php esc_html_e( 'Password', 'metafans' ); ?>" type="password" required="" id="reg_password" class="th-form-field" name="reg_password">
						<?php if( !empty($before_btn_text) ){ ?>
							<p id="reg_password-description" class="description">
								<?php echo $before_btn_text; ?>
							</p>
						<?php } ?>
					</div>
				</li>
	        </ul>
			<p class="ec-mb-3 ec-text-center ">
	        	<?php esc_html_e( 'Already have an account?', 'metafans' ) ?> <a href="#" class="ec-d-inline-block switch-login"><b><?php esc_html_e( 'Login', 'metafans' ) ?></b></a>
	        </p>
	        <p class="ec-mx-6">
				<?php wp_nonce_field( 'th-modal-register', 'th-modal-register-nonce' ); ?>
	            <button class="components-button tophive-infinity-button" type="submit"><?php esc_html_e( 'Register', 'metafans' ); ?></button>
	            <?php if( !empty($after_btn_text) ){ ?>
					<p id="reg_password-description" class="description">
						<?php echo $after_btn_text; ?>
					</p>
				<?php } ?>
	        </p>

	    </form>
		<?php
	}
}

add_action( 'tophive/registration/form', 'tophive_registration_form' );

if( !function_exists('tophive_login_form') ){
	function tophive_login_form(){
		$after_title_text = tophive_metafans()->get_setting('theme_globals_text_after_login_title');
		$after_form_text = tophive_metafans()->get_setting('theme_globals_text_after_login_form');
		?>
		    <p class="ec-text-center ec-mb-2"><?php echo $after_title_text; ?></p>
			<form name="th-modal-login" class="th-modal-login" method="post">
		    	<p class="ec-text-center login-notices"></p>
		        <ul class="form-fields">
					<li>
						<div class="th-form-field">
							<div class="th-form-field">
								<label for="username"><?php esc_html_e( 'Username or email', 'metafans' ) ?>
								</label>
							</div>
							<div class="th-form-field">
								<input size="30" placeholder="<?php esc_html_e( 'Username or email', 'metafans' ); ?>" type="text" required="required" id="username" class="" name="username">
							</div>
						</div>
					</li>
					<li class="form-field">
						<div class="th-form-field">
							<label for="password"><?php esc_html_e( 'Password', 'metafans' ); ?></label>
						</div>	
						<div class="th-form-field">
							<input size="30" placeholder="<?php esc_html_e( 'Password', 'metafans' ); ?>" type="password" required="required" id="password" class="th-form-field" name="password">
						</div>			                
					</li>
		        </ul>

				<p>
		            <label>
		                <input type="checkbox" name="rememberme"/>
						<?php esc_html_e( 'Remember me', 'metafans' ); ?>
		            </label>
		            <a class="ec-float-right switch-lost-pass" href="#"><?php esc_html_e( 'Lost your password?', 'metafans' ); ?></a>
		        </p>
		        <p class="ec-mx-6">
		            <input type="hidden" name="th-modal-login-nonce"
		                   value="<?php echo wp_create_nonce( 'th-modal-login' ); ?>">
		            <button type="submit" class="components-button tophive-infinity-button"><?php esc_html_e( 'Login', 'metafans' ); ?>
		            </button>
		        </p>
		        <?php if( get_option( 'users_can_register' ) ){ ?>
			        <p class="ec-mb-0 ec-text-center">
			        	<?php esc_html_e( "Don't have an account? ", 'masterclass' ) ?><a href="#" class="switch-register"><b><?php esc_html_e( 'Sign up for free', 'masterclass' ); ?></b></a>
			        </p>
		    	<?php }else{ ?>
		    		<p class="ec-mb-0 ec-text-center">
			        	<?php esc_html_e( 'Registration is disabled', 'masterclass' ) ?>
			        </p>
		    	<?php }?>
		    </form>
		    <p class="ec-text-center ec-mt-3"><?php echo $after_form_text; ?></p>
		<?php
	}
}
add_action( 'tophive/login/form', 'tophive_login_form' );

if( !function_exists('tophive_recover_pass') ){
	function tophive_recover_pass(){
		?>
			<form name="th-modal-recover" class="th-modal-recover" method="post">
		    	<p class="ec-text-center login-notices"></p>
		        <ul class="form-fields">
					<li>
						<div class="th-form-field">
							<div class="th-form-field">
								<label for="username"><?php esc_html_e( 'Username or email', 'metafans' ) ?>
								</label>
							</div>
							<div class="th-form-field">
								<input size="30" placeholder="<?php esc_html_e( 'Username or email', 'metafans' ); ?>" type="text" required="required" id="username" class="" name="username">
							</div>
						</div>
					</li>
		        </ul>

		        <p class="ec-mx-6">
		        	<input type="hidden" name="th-modal-recover-nonce" value="<?php echo wp_create_nonce( 'th-modal-recover' ); ?>">
					<button class="components-button tophive-infinity-button" type="submit"><?php esc_html_e( 'Recover Password', 'metafans' ); ?></button>
		        </p>
		        <p class="ec-mb-3 ec-text-center ">
		        	<?php esc_html_e( 'Already registered? ', 'metafans' ) ?> <a href="#" class="ec-d-inline-block switch-login"><b><?php esc_html_e( 'Signin', 'metafans' ) ?></b></a>
		        </p>
		    </form>
		<?php
	}
}

add_action( 'tophive/recover-pass/form', 'tophive_recover_pass' );
