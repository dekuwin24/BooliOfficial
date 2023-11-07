<?php

class Tophive {

	static $_instance;
	static $version;
	static $theme_url;
	static $theme_name;
	static $theme_author;
	static $path;

	/**
	 * @var Tophive_Customizer
	 */
	public $customizer = null;

	/**
	 * Add functions to hooks
	 */
	function init_hooks() {
		
		add_action( 'init', array( $this, 'tophive_custom_rewrite' ));
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
		add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 95 );
		if( is_admin() ){
			add_action( 'wp_default_scripts', array( $this, 'wp_default_custom_scripts' ) );
		}
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
		add_filter( 'query_vars', array($this, 'tophive_custom_query_var') );
		add_action( 'wp_ajax_th_ajax_login', array($this, 'tophive_ajax_login') );
		add_action( 'wp_ajax_nopriv_th_ajax_login', array($this, 'tophive_ajax_login') );	
		add_action( 'wp_ajax_th_ajax_reset_pass', array($this, 'tophive_ajax_reset_pass') );
		add_action( 'wp_ajax_nopriv_th_ajax_reset_pass', array($this, 'tophive_ajax_reset_pass') );	
		add_action( 'wp_ajax_th_ajax_register', array($this, 'tophive_ajax_register') );
		add_action( 'wp_ajax_nopriv_th_ajax_register', array($this, 'tophive_ajax_register') );
		add_action( 'wp_logout', array($this, 'logout_redirect') );


		add_filter( 'ocdi/import_files', array($this, 'import_demo_files') );
	}

	function logout_redirect(){
		wp_safe_redirect( home_url() );
	  	exit;
	}

	function tophive_custom_query_var( $query_vars ){
		$query_vars[] = 'user_slug';
		return $query_vars;
	}
	function tophive_custom_rewrite(){
		wp_enqueue_script( 'jquery' );
		$pages = get_pages(array(
		    'meta_key' => '_wp_page_template',
		    'meta_value' => 'page-instructor.php'
		));
		if(!empty($pages)){
			add_rewrite_rule(
				'^instructor/([^/]*)/?',
				'index.php?page_id='. $pages[0]->ID .'&user_slug=$matches[1]',
				'top'
			);
		}
	}
	function excerpt_length( $length ) {
		return 25;
	}

	/**
	 * Filter the excerpt "read more" string.
	 *
	 * @param string $more "Read more" excerpt string.
	 *
	 * @return string (Maybe) modified "read more" excerpt string.
	 */
	function excerpt_more( $more ) {
		return '&hellip;';
	}

	/**
	 * Main Tophive Instance.
	 *
	 * Ensures only one instance of Tophive is loaded or can be loaded.
	 *
	 * @return Tophive Main instance.
	 */
	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance    = new self();
			$theme              = wp_get_theme();
			self::$version      = $theme->get( 'Version' );
			self::$theme_url    = $theme->get( 'ThemeURI' );
			self::$theme_name   = $theme->get( 'Name' );
			self::$theme_author = $theme->get( 'Author' );
			self::$path         = get_template_directory();

			self::$_instance->init();
		}

		return self::$_instance;
	}

	/**
	 * Get data from method of property
	 *
	 * @param string $key
	 *
	 * @return bool|mixed
	 */
	function get( $key ) {
		if ( method_exists( $this, 'get_' . $key ) ) {
			return call_user_func_array( array( $this, 'get_' . $key ), array() );
		} elseif ( property_exists( $this, $key ) ) {
			return $this->{$key};
		}

		return false;
	}


	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function content_width() {
		$GLOBALS['content_width'] = apply_filters( 'tophive_content_width', 843 );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on tophive, use a find and replace
		 * to change 'metafans' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'metafans', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		// Adds different image sizes
		add_image_size( 'tophive-vertical-thumb-sm', 300, 200, array('center', 'center') );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'metafans' ),
				'menu-2' => esc_html__( 'Secondary', 'metafans' ),
				'menu-3' => esc_html__( 'Tertiery', 'metafans' ),
				'menu-4' => esc_html__( 'Querternary', 'metafans' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add theme support for page excerpt.
		add_post_type_support( 'page', 'excerpt' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/**
		 * WooCommerce support.
		 */
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		/**
		 * Support Gutenberg.
		 *
		 * @since 0.2.6
		 */
		add_theme_support( 'align-wide' );

		/**
		 * Add editor style support.
		 */
		add_theme_support( 'editor-styles' );

		add_theme_support( 'html5', [ 'script', 'style' ] );

	}

	/**
	 * Register sidebars area.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Primary Sidebar', 'metafans' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
				'show_in_rest'	=> true
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'Secondary Sidebar', 'metafans' ),
				'id'            => 'sidebar-2',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
				'show_in_rest'	=> true
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'Activity - Left', 'metafans' ),
				'id'            => 'buddy-press-activity-left',
				'description'   => esc_html__( 'Widgets in this area will appear on left side of activity page.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
				'show_in_rest'	=> true
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'Activity - Right', 'metafans' ),
				'id'            => 'buddy-press-activity-right',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'Members - Left', 'metafans' ),
				'id'            => 'buddy-press-members-left',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'Members - Right', 'metafans' ),
				'id'            => 'buddy-press-members-right',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'Groups - Left', 'metafans' ),
				'id'            => 'buddy-press-groups-left',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'Groups - Right', 'metafans' ),
				'id'            => 'buddy-press-groups-right',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'Profile - Left', 'metafans' ),
				'id'            => 'buddy-press-profile-left',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'Profile - Right', 'metafans' ),
				'id'            => 'buddy-press-profile-right',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'BuddyPress Sidebar Primary', 'metafans' ),
				'id'            => 'buddy-press-sidebar',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'BuddyPress Sidebar Secondary', 'metafans' ),
				'id'            => 'buddy-press-sidebar-2',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'BBPress Forum Single Right', 'metafans' ),
				'id'            => 'bbp-forum-single-sidebar-right',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);		
		register_sidebar(
			array(
				'name'          => esc_html__( 'BBPress Forum Single Left', 'metafans' ),
				'id'            => 'bbp-forum-single-sidebar-left',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'BBPress Single Topic', 'metafans' ),
				'id'            => 'bbp-topic-single-sidebar-1',
				'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		for ( $i = 1; $i <= 6; $i ++ ) {
			register_sidebar(
				array(
					/* translators: 1: Widget number. */
					'name'          => sprintf( esc_html__( 'Block %d', 'metafans' ), $i ),
					'id'            => 'footer-' . $i,
					'description'   => esc_html__( 'Add widgets here.', 'metafans' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				)
			);
		}

	}

	/**
	 * Get asset suffix `.min` or empty if WP_DEBUG enabled
	 *
	 * @return string
	 */
	function get_asset_suffix() {
		$suffix = '.min';
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$suffix = '';
		}

		return $suffix;
	}

	/**
	 * Get theme style.css url
	 *
	 * @return string
	 */
	function get_style_uri() {
		$suffix     = $this->get_asset_suffix();
		$style_dir  = get_template_directory();
		$suffix_css = $suffix;
		$css_file   = false;
		if ( is_rtl() ) {
			$suffix_css = '-rtl' . $suffix;
		}

		$min_file = $style_dir . '/style' . $suffix_css . '.css';
		if ( file_exists( $min_file ) ) {
			$css_file = esc_url( get_template_directory_uri() ) . '/style' . $suffix_css . '.css';
		}

		if ( ! $css_file ) {
			$css_file = get_stylesheet_uri();
		}

		return $css_file;
	}

	/**
	 * Enqueue scripts and styles.
	 */
	function scripts() {
		wp_enqueue_style( 'mc-google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', false );
		wp_enqueue_style('dashicons');
		if ( ! class_exists( 'Tophive_Font_Icons' ) ) {
			require_once get_template_directory() . '/inc/customizer/class-customizer-icons.php';
		}
		Tophive_Font_Icons::get_instance()->enqueue();

		$suffix = $this->get_asset_suffix();

		do_action( 'tophive/load-scripts' );

		$css_files = apply_filters(
			'tophive/theme/css',
			array(
				'google-font' => Tophive_Customizer_Auto_CSS::get_instance()->get_font_url(),
				'style'       => $this->get_style_uri(),
				'themify-icons' => array(
					'url'  => esc_url( get_template_directory_uri() ) . '/assets/fonts/themify/css/themify-icons.css',
					'ver'  => self::$version,
				)
			)
		);

		$js_files = apply_filters(
			'tophive/theme/js',
			array(
				'tophive-themejs' => array(
					'url'  => esc_url( get_template_directory_uri() ) . '/assets/js/theme' . $suffix . '.js',
					'ver'  => self::$version,
					'deps' => array('jquery'),
				),
				'tophive-learnpress-js' => array(
					'url'  => esc_url( get_template_directory_uri() ) . '/assets/js/compatibility/learnpress.js',
					'ver'  => self::$version,
					'deps' => array('jquery'),
				),
				'tophive-sidebar-sticky-js' => array(
					'url'  => esc_url( get_template_directory_uri() ) . '/assets/js/sticky-sidebar'. $suffix .'.js',
					'ver'  => self::$version,
					'deps' => array('jquery'),
				),
			)
		);

		foreach ( $css_files as $id => $url ) {
			$deps = array();
			if ( is_array( $url ) ) {
				$arg = wp_parse_args(
					$url,
					array(
						'deps' => array(),
						'url'  => '',
						'ver'  => self::$version,
					)
				);
				wp_enqueue_style( 'tophive-' . $id, $arg['url'], $arg['deps'], $arg['ver'] );
			} elseif ( $url ) {
				wp_enqueue_style( 'tophive-' . $id, $url, $deps, self::$version );
			}
		}

		foreach ( $js_files as $id => $arg ) {
			$deps = array();
			$ver  = '';
			if ( is_array( $arg ) ) {
				$arg = wp_parse_args(
					$arg,
					array(
						'deps' => '',
						'url'  => '',
						'ver'  => '',
					)
				);

				$deps = $arg['deps'];
				$url  = $arg['url'];
				$ver  = $arg['ver'];
			} else {
				$url = $arg;
			}

			if ( ! $ver ) {
				$ver = self::$version;
			}

			wp_enqueue_script( $id, $url, $deps, $ver, true );
		}

		if ( is_singular() &&  is_page_template("page-images.php")) {
				wp_enqueue_script("photo-page-script",get_stylesheet_directory_uri() . '/assets/js/compatibility/popup-media-upload.js',array("jquery"),false,true);
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
    wp_enqueue_style( 'tophive-style' );
		wp_add_inline_style( 'tophive-style', Tophive_Customizer_Auto_CSS::get_instance()->auto_css() );
		wp_localize_script(
			'tophive-themejs',
			'Metafans_JS',
			apply_filters( // phpcs:ignore
				'Metafans_JS',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
			        'redirecturl' => home_url(),
					'is_rtl' => is_rtl(),
					'logged_in' => is_user_logged_in(),
					'delete_comment' => esc_html__( 'You Want to delete this comment?', 'metafans' ),
					'css_media_queries' => Tophive_Customizer_Auto_CSS::get_instance()->media_queries,
					'sidebar_menu_no_duplicator' => tophive_metafans()->get_setting( 'header_sidebar_menu_no_duplicator' ),
					'haha_text' => esc_html__( 'Haha', 'metafans' ),
					'haha_img' 	=> get_template_directory_uri() . '/assets/images/reactions/haha.png',
					'love_text' => esc_html__( 'Love', 'metafans' ),
					'love_img' 	=> get_template_directory_uri() . '/assets/images/reactions/love.png',
					'wow_text' 	=> esc_html__( 'Wow', 'metafans' ),
					'wow_img' 	=> get_template_directory_uri() . '/assets/images/reactions/wow.png',
					'angry_text'=> esc_html__( 'Angry', 'metafans' ),
					'angry_img' => get_template_directory_uri() . '/assets/images/reactions/angry.png',
					'cry_text' 	=> esc_html__( 'Cry', 'metafans' ),
					'cry_img' 	=> get_template_directory_uri() . '/assets/images/reactions/sad.png',
					'like_text' => esc_html__( 'Like', 'metafans' ),
					'like_img' 	=> get_template_directory_uri() . '/assets/images/reactions/like.png',
					'like_base_img' 	=> '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>',
					'like_base_text' 	=> esc_html__( 'Like', 'metafans' ),
					'follow' 			=> esc_html__( '+ Follow', 'metafans' ),
					'following'			=> '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/></svg>' . esc_html__( ' Following', 'metafans' ),
				)
			)
		);


		do_action( 'tophive/theme/scripts' );
	}
	function wp_default_custom_scripts( $scripts ){
		did_action( 'init' ) && $scripts->localize(
                'wp-color-picker',
                'wpColorPicker',
                array(
                        'clear'            => esc_html__( 'Clear', 'metafans' ),
                        'clearAriaLabel'   => esc_html__( 'Clear color', 'metafans' ),
                        'defaultString'    => esc_html__( 'Default', 'metafans' ),
                        'defaultAriaLabel' => esc_html__( 'Select default color', 'metafans' ),
                        'pick'             => esc_html__( 'Select Color', 'metafans' ),
                        'defaultLabel'     => esc_html__( 'Color value', 'metafans' ),
                )
        );
	}
	function admin_scripts(){

    }
	private function includes() {
		$files = array(
			'/inc/class-metabox.php',
			// Metabox settings.
			'/inc/template-class.php',
			// Template element classes.
			'/inc/extras.php',
			// Custom functions that act independently of the theme templates.
			'/inc/element-classes.php',
			// Functions which enhance the theme by hooking into WordPress and itself (huh?).
			'/inc/template-tags.php',
			// Custom template tags for this theme.
			'/inc/template-functions.php',
			// Functions which enhance the theme by hooking into WordPress.
			'/inc/customizer/class-customizer.php',
			// Customizer additions.
			'/inc/panel-builder/class-panel-builder.php',
			// Panel builder additions.
			'/inc/blog/class-related-posts.php',
			// Blog entry builder.
			'/inc/blog/class-post-entry.php',
			// Blog entry builder.
			'/inc/blog/class-posts-layout.php',
			// Blog posts layout.
			'/inc/blog/functions-posts-layout.php',
			// Vertical Nav
			'/inc/vertical-nav/tophive-vertical-nav.php',
		);

		foreach ( $files as $file ) {
			require_once self::$path . $file;
		}

		$this->load_configs();
		$this->load_compatibility();
		$this->admin_includes();
		// Custom categories walker class.
		if ( ! is_admin() ) {
			require_once self::$path . '/inc/class-categories-walker.php';
		}
	}

	/**
	 * Load admin files
	 *
	 * @since 0.0.1
	 * @since 0.2.6 Load editor style.
	 *
	 * @return void
	 */
	private function admin_includes() {
		if ( ! is_admin() ){
            return ;
        }

        $files = array(
            '/inc/admin/dashboard.php',
        );

        foreach( $files as $file ) {
            require_once self::$path.$file;
        }
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Load configs
	 */
	private function load_configs() {

		$config_files = array(
			// Site Settings.
			'layouts',
			'blogs',
			'single-blog-post',
			'related-posts',

			'search',
			'styling',
			'typography',
			'page-header',
			'background',
			'compatibility',
			'theme-options',
			// Header Builder Panel.
			'header/panel',
			'header/html',
			'header/logo',
			'header/nav-icon',
			'header/primary-menu',
			'header/notification',
			'header/messages',
			'header/signin-signup',
			'header/vertical-nav',
			'header/templates',
			'header/templates',
			'header/logo',
			'header/search-icon',
			'header/search-box',
			'header/search-community',
			'header/mode-switcher',
			'header/menus',
			'header/nav-icon',
			'header/button',
			'header/social-icons',
			// Footer Builder Panel.
			'footer/panel',
			'footer/html',
			'footer/contact',
			'footer/subscribe',
			'footer/widgets',
			'footer/templates',
			'footer/widgets',
			'footer/copyright',
			'footer/social-icons',
			'footer/link-list',

		);

		$path = get_template_directory();
		// Load default config values.
		require_once $path . '/inc/customizer/configs/config-default.php';

		// Load site configs.
		foreach ( $config_files as $f ) {
			$file = $path . "/inc/customizer/configs/{$f}.php";
			if ( file_exists( $file ) ) {
				require_once $file;
			}
		}

	}

	/**
	 * Load site compatibility supports
	 */
	private function load_compatibility() {

		$compatibility_config_files = array(
			'elementor',
			'multiple-thumbs',
			'breadcrumb',
			'woocommerce/woocommerce',
			'learnpress/learnpress',
			'learndash/learndash',
			'buddypress/buddypress',
			'classified-listing/classified-listing',
			'bbpress/bbpress',
		);
		foreach ( $compatibility_config_files as $f ) {
			$file = self::$path . "/inc/compatibility/{$f}.php";
			if ( file_exists( $file ) ) {
				require_once $file;
			}
		}
	}

	/**
	 * Check if WooCommerce plugin activated
	 *
	 * @see WooCommerce
	 * @see wc
	 *
	 * @return bool
	 */
	function is_woocommerce_active() {
		return class_exists( 'WooCommerce' ) || function_exists( 'wc' );
	}

	/**
	 * Check if Learnpress plugin activated
	 *
	 * @see LearnPress
	 *
	 * @return bool
	 */
	function is_learnpress_active() {
		return class_exists( 'LearnPress' );
	}

	/**
	 * Check if LearnDash plugin activated
	 *
	 * @see LearnDash
	 *
	 * @return bool
	 */
	function is_learndash_active() {
		return class_exists( 'SFWD_LMS' );
	}
	/**
	 * Check if BuddyPress plugin activated
	 *
	 * @see BuddyPress
	 *
	 * @return bool
	 */
	function is_buddypress_active() {
		return function_exists( 'bp_is_active' );
	}
	/**
	 * Check if BBPress plugin activated
	 *
	 * @see BBpress
	 *
	 * @return bool
	 */
	function is_bbpress_active() {
		return class_exists('bbPress');
	}
	/**
	 * uncheck special chars
	 *
	 * @see LearnPress
	 *
	 * @return bool
	 */
	function is_classified_listing_active() {
		return class_exists('Rtcl');
	}
	/**
	 * uncheck special chars
	 *
	 * @see LearnPress
	 *
	 * @return bool
	 */
	function tophive_sanitize( $i ){
		return $i;
	}


	function is_using_post() {
		$use = false;
		if ( is_singular() ) {
			$use = true;
		} else {
			if ( is_front_page() && is_home() ) {
				$use = false;
			} elseif ( is_front_page() ) {
				// static homepage.
				$use = true;
			} elseif ( is_home() ) {
				// blog page.
				$use = true;
			} else {
				if ( $this->is_woocommerce_active() ) {
					if ( is_shop() ) {
						$use = true;
					}
				}
			}
		}

		return $use;
	}

	function is_blog() {
		$is_blog = false;
		if ( is_front_page() && is_home() ) {
			$is_blog = true;
		} elseif ( is_front_page() ) { //phpcs:ignore
			// static homepage.
		} elseif ( is_home() ) {
			$is_blog = true;
		}

		return $is_blog;
	}

	function get_current_post_id() {
		$id = get_the_ID();
		if ( is_front_page() && is_home() ) {
			$id = false;
		} elseif ( is_front_page() ) {
			// Static homepage.
			$id = get_option( 'page_on_front' );
		} elseif ( is_home() ) {
			// Blog page.
			$id = get_option( 'page_for_posts' );
		} else {
			if ( $this->is_woocommerce_active() ) {
				if ( is_shop() ) {
					$id = wc_get_page_id( 'shop' );
				}
			}
		}

		return $id;
	}

	function init() {
		$this->init_hooks();
		$this->includes();
		$this->customizer = Tophive_Customizer::get_instance();
		$this->customizer->init();
		do_action( 'tophive/init' );
	}

	function get_setting( $id, $device = 'desktop', $key = null ) {
		return Tophive_Customizer::get_instance()->get_setting( $id, $device, $key );
	}

	function get_media( $value, $size = null ) {
		return Tophive_Customizer::get_instance()->get_media( $value, $size );
	}

	function get_setting_tab( $name, $tab = null ) {
		return Tophive_Customizer::get_instance()->get_setting_tab( $name, $tab );
	}

	function get_post_types( $_builtin = true ) {
		if ( 'all' === $_builtin ) {
			$post_type_args = array(
				'publicly_queryable' => true,
			);
		} else {
			$post_type_args = array(
				'publicly_queryable' => true,
				'_builtin'           => $_builtin,
			);
		}

		$_post_types = get_post_types( $post_type_args, 'objects' );

		$post_types = array();

		foreach ( $_post_types as $post_type => $object ) {
			$post_types[ $post_type ] = array(
				'name'          => $object->label,
				'singular_name' => $object->labels->singular_name,
			);
		}

		return $post_types;
	}

	function tophive_ajax_login(){
		$formdata = [];
		foreach (explode('&', urldecode($_REQUEST['formdata'])) as $key => $value) {
			$newdata = explode('=', $value);
			$formdata[$newdata[0]] = $newdata[1];
		}
		if(wp_verify_nonce($formdata['th-modal-login-nonce'],'th-modal-login' )){
			$info = array();
			$info['user_login'] = $formdata['username'];
		    $info['user_password'] = $formdata['password'];
		    $info['remember'] = true;

		    $user_signon = wp_signon( $info, is_ssl() );
		    if ( is_wp_error($user_signon) ){
		        $res = array(
		        	'loggedin'=>false, 
		        	'message'=> esc_html__('Wrong credentials', 'metafans')
		        );
		    } else {
		        $res = array(
		        	'loggedin'=>true, 
		        	'message'=> esc_html__('Login successful, redirecting...', 'metafans'),
		        );
		    }
		}else{
			$res = esc_html__( 'Validation failed', 'metafans' );
		}

		wp_send_json( $res, 200 );
	}
	function tophive_ajax_reset_pass(){
		$formdata = [];
		foreach (explode('&', urldecode($_REQUEST['formdata'])) as $key => $value) {
			$newdata = explode('=', $value);
			$formdata[$newdata[0]] = $newdata[1];
		}
		if(wp_verify_nonce($formdata['th-modal-recover-nonce'],'th-modal-recover' )){
			$user_login = $formdata['username'];
		    global $wpdb, $current_site;

		    if ( empty( $user_login) ) {
		        return false;
		    } else if ( strpos( $user_login, '@' ) ) {
		        $user_data = get_user_by( 'email', trim( $user_login ) );
		    } else {
		        $login = trim($user_login);
		        $user_data = get_user_by('login', $login);
		    }
		    if( empty($user_data) ){
		    	$res = array(
		        	'success'=> false, 
		        	'message'=> esc_html__('No user found!', 'metafans')
		        );
		        wp_send_json( $res, 200 ); 
		    }

		    do_action('lostpassword_post');


		    if ( !$user_data ) return false;

		    // redefining user_login ensures we return the right case in the email
		    $user_login = $user_data->user_login;
		    $user_email = $user_data->user_email;

		    do_action('retreive_password', $user_login);  // Misspelled and deprecated
		    do_action('retrieve_password', $user_login);

		    $allow = apply_filters('allow_password_reset', true, $user_data->ID);

		    if ( ! $allow )
		        return false;
		    else if ( is_wp_error($allow) )
		        return false;

		    $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
		    if ( empty($key) ) {
		        // Generate something random for a key...
		        $key = wp_generate_password(20, false);
		        do_action('retrieve_password_key', $user_login, $key);
		        // Now insert the new md5 key into the db
		        $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
		    }
		    $message = esc_html__('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
		    $message .= network_home_url( '/' ) . "\r\n\r\n";
		    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		    $message .= esc_html__('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
		    $message .= esc_html__('To reset your password, visit the following address:') . "\r\n\r\n";
		    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";

		    if ( is_multisite() )
		        $blogname = $GLOBALS['current_site']->site_name;
		    else
		        // The blogname option is escaped with esc_html on the way into the database in sanitize_option
		        // we want to reverse this for the plain text arena of emails.
		        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

		    $title = sprintf( __('[%s] Password Reset'), $blogname );

		    $title = apply_filters('retrieve_password_title', $title);
		    $message = apply_filters('retrieve_password_message', $message, $key);

		    if ( $message && !wp_mail($user_email, $title, $message) ){
		        $res = array(
		        	'success'=> false, 
		        	'message'=> esc_html__('The e-mail could not be sent.Possible reason: your host may have disabled the mail() function...', 'metafans')
		        );
		    }else{
			    $res = array(
		        	'success'=> true, 
		        	'message'=> esc_html__('Please check your mail to reset your password!', 'metafans')
		        );
		    }

		}else{
			$res = esc_html__( 'Validation failed', 'metafans' );
		}

		wp_send_json( $res, 200 );
	}
	function tophive_ajax_register(){
		$formdata = [];
		foreach (explode('&', urldecode($_REQUEST['formdata'])) as $key => $value) {
			$newdata = explode('=', $value);
			$formdata[$newdata[0]] = $newdata[1];
		}
		$new_user_name 		= stripcslashes($formdata['reg_username']);
		$new_user_email 	= $formdata['reg_mail'];
		$new_user_password 	= $formdata['reg_password'];

		// User meta
		$gender 			= $formdata['reg_gender'];
		$display_name 		= $formdata['reg_display_name'];
		$first_name 		= $formdata['reg_first_name'];
		$DOB 				= $formdata['reg_bday_date'] . '-' . $formdata['reg_bday_month'] . '-' . $formdata['reg_bday_year'];
		
		$usermeta = array(
			'first_name' 	=> $first_name,
			'display_name' 	=> $DOB,
			'dob'			=> $DOB,
			'gender' 		=> $gender
		);
	    $password = $new_user_password;
	    $password_len = !empty(tophive_metafans()->get_setting('theme_globals_password_length')) ? tophive_metafans()->get_setting('theme_globals_password_length') : 2;
	    if (strlen($password) < $password_len) {
	        $res = array(
	        	'loggedin' => false, 
	        	'message'=> sprintf(esc_html__('Your password should be at least %s character long', 'metafans'), $password_len),
	        );
	    }
	    else{
			if( function_exists('bp_core_signup_user') ){
				$user_id = 
					bp_core_signup_user(
						$new_user_name, 
						$new_user_password, 
						$new_user_email, 
						$usermeta 
					);
			}else{
				$user_id = false;
			}
		  	if (!is_wp_error($user_id)) {
				$res = array(
					'loggedin'=>true, 
					'message'=> esc_html__('Please check your email to activate your account.', 'metafans')
				);
		  	}else {
		    	if (isset($user_id->errors['empty_user_login'])) {
		          	$res = array(
			        	'loggedin' => false, 
			        	'message'  => esc_html__('User Name and Email are mandatory', 'metafans')
			        );
		      	}elseif (isset($user_id->errors['existing_user_login'])) {
		          	$res = array(
			        	'loggedin' => false, 
			        	'message'  => esc_html__('User name already exixts.', 'metafans')
			        );
		      	}else {
		          	$res = array(
			        	'loggedin' => false, 
			        	'message'  => esc_html__('Error Occured please fill up the sign up form carefully.', 'metafans'),
			        );
		      	}
		  	}
	    }
		wp_send_json( $res, 200 );
	}
	function import_demo_files() {
		return array(
			array(
				'import_file_name'           => 'Demo Import 1',
				'categories'                 => array( 'Category 1', 'Category 2' ),
				'import_file_url'            => 'https://api.tophivetheme.com/themes/metafans/demos/content/metafans-classic.xml',
				'import_widget_file_url'     => 'https://api.tophivetheme.com/themes/metafans/demos/widgets/metafans-classic-widgets.wie',
				'import_customizer_file_url' => 'https://api.tophivetheme.com/themes/metafans/demos/customizer/metafans-classic-customizer.dat',
				
				'import_preview_image_url'   => 'https://i.ibb.co/nkbXWbr/classic.jpg',
				'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
				'preview_url'                => 'https://demo.tophivetheme.com/metafans/classic/',
			),
			array(
				'import_file_name'           => 'Demo Import 2',
				'categories'                 => array( 'New category', 'Old category' ),
				'import_file_url'            => 'http://www.your_domain.com/ocdi/demo-content2.xml',
				'import_widget_file_url'     => 'http://www.your_domain.com/ocdi/widgets2.json',
				'import_customizer_file_url' => 'http://www.your_domain.com/ocdi/customizer2.dat',
				'import_redux'               => array(
					array(
						'file_url'    => 'http://www.your_domain.com/ocdi/redux.json',
						'option_name' => 'redux_option_name',
					),
					array(
						'file_url'    => 'http://www.your_domain.com/ocdi/redux2.json',
						'option_name' => 'redux_option_name_2',
					),
				),
				'import_preview_image_url'   => 'http://www.your_domain.com/ocdi/preview_import_image2.jpg',
				'import_notice'              => __( 'A special note for this import.', 'your-textdomain' ),
				'preview_url'                => 'http://www.your_domain.com/my-demo-2',
			),
		);
	}

}
