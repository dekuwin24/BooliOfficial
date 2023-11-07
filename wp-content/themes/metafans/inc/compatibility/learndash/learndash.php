<?php  
	
class Tophive_LD{
	static $_instance;

	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function is_active() {
		return tophive_metafans()->is_learndash_active();
	}

	function __construct() {
		if( $this->is_active() ){
	        add_action( 'wp_enqueue_scripts', array($this, 'load_scripts') );
			
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 30 );

			add_action( 'tophive/before-site-content', array($this, 'render_ld_course_cover'));
			add_action( 'admin_init', array( $this, 'ld_course_cover_photo' ) );
			add_action( 'tophive/learndash/courses-progress', array($this, 'get_courses_progress'), 10, 1 );
			add_action( 'tophive/learndash/single-course/progress/percentage', array($this, 'get_courses_progress'), 10, 2 );
			add_action( 'tophive/learndash/single-course/enrolled-users-list', array($this, 'ld_course_enrolled_users_list'), 10, 1 );
			add_action( 'tophive/learndash/single-course/continue-url', array($this, 'ld_course_resume_link'), 10, 1 );
			add_action( 'tophive/learndash/single-course/course-id', array($this, 'ld_30_get_course_id'), 10, 1 );
			add_action( 'tophive/learndash/single-course/custom-pagination', array($this, 'metafans_ld_custom_pagination'), 10, 3 );
			add_action( 'tophive/learndash/single-course/quiz/count', array($this, 'metafans_ld_custom_quiz_count'), 10, 3 );
			add_action( 'tophive/learndash/single-course/next-prev-url', array($this, 'metafans_self_next_prev_url'), 10, 1 );
			add_action( 'tophive/learndash/single-course/custom-quiz-key', array($this, 'metafans_ld_custom_quiz_key'), 10, 2 );
			add_action( 'tophive/learndash/single-course/lesson/progress', array($this, 'learndash_get_lesson_progress'), 10, 2 );
		}
	}

	function load_scripts(){
		wp_enqueue_style( 'th-learndash', get_template_directory_uri() . '/assets/css/compatibility/learndash.css', $deps = array(), $ver = false, $media = 'all' );
		wp_enqueue_script( 'th-learndash', get_template_directory_uri() . '/assets/js/compatibility/learndash.js',array(), false, false );
	}
	public function learndash_get_lesson_progress( $lesson_id, $course_id = false ) {
		$user_id = get_current_user_id();

		if ( ! $course_id ) {
			$course_id = learndash_get_course_id( $lesson_id );
		}

		$course_progress = get_user_meta( $user_id, '_sfwd-course_progress', true );

		$topics  = learndash_get_topic_list( $lesson_id ) ?: [];
		$quizzes = learndash_get_lesson_quiz_list( $lesson_id ) ?: [];

		$total     = sizeof( $topics ) + sizeof( $quizzes );
		$completed = 0;

		if ( ! empty( $course_progress[ $course_id ]['lessons'][ $lesson_id ] ) && 1 === $course_progress[ $course_id ]['lessons'][ $lesson_id ] ) {
			$completed += 1;
		}

		foreach ( $topics as $topic ) {
			if ( ( ! empty( $course_progress[ $course_id ]['topics'][ $lesson_id ][ $topic->ID ] ) && 1 === $course_progress[ $course_id ]['topics'][ $lesson_id ][ $topic->ID ] ) ) {
				$completed ++;
			}
		}

		foreach ( $quizzes as $quiz ) {
			if ( learndash_is_quiz_complete( $user_id, $quiz['post']->ID ) ) {
				$completed ++;
			}
		}

		$percentage = 0;
		if ( $total != 0 ) {
			$percentage = intVal( $completed * 100 / $total );
			$percentage = ( $percentage > 100 ) ? 100 : $percentage;
		} elseif ( $total == 0 && ! empty( $course_progress[ $course_id ]['lessons'][ $lesson_id ] ) && 1 === $course_progress[ $course_id ]['lessons'][ $lesson_id ] ) {
			$percentage = 100;
		}

		return array(
			'total'      => $total,
			'completed'  => $completed,
			'percentage' => $percentage,
		);
	}
	/**
	 * Return the current quiz no.
	 *
	 * @param array $url_arr
	 * @param string $current_url
	 *
	 * @return false|int|string
	 */
	public function metafans_ld_custom_quiz_key( $url_arr = array(), $current_url = '' ) {

		// Protocol
		$url = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		// Get current URL
		$current_url = trailingslashit( $url );

		$key = array_search ( $current_url, $url_arr);
		return $key +1 ;
	}
	/**
	 * return the next and previous URL based on the course current URL.
	 *
	 * @param array $url_arr
	 * @param string $current_url
	 *
	 * @return array|string
	 */
	public function metafans_self_next_prev_url( $url_arr = array(), $current_url = '' ) {

		if ( empty( $url_arr ) ) {
			return;
		}

		// Protocol
		$url = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		// Get current URL
		$current_url = trailingslashit( $url );
		if ( ! $query = parse_url( $current_url, PHP_URL_QUERY ) ) {
			$current_url = trailingslashit( $current_url );
		}

		$key = array_search ( $current_url, $url_arr);


		$url = array();

		$next = current(array_slice($url_arr, array_search($key, array_keys($url_arr)) + 1, 1));
		$prev = current(array_slice($url_arr, array_search($key, array_keys($url_arr)) - 1, 1));

		$last_element = array_values(array_slice( $url_arr, -1))[0];

		$url['next'] = ( isset( $next ) && $last_element != $current_url ) ? '<a href="'.$next.'" class="next-link" rel="next">Next  <span class="meta-nav" data-balloon-pos="up" data-balloon="' . __( 'Next', 'metafans' ) . '">&rarr;</span></a>' : '';
		$url['prev'] = ( isset( $prev ) && $last_element != $prev ) ? '<a href="'.$prev.'" class="prev-link" rel="prev"><span class="meta-nav" data-balloon-pos="up" data-balloon="' . __( 'Previous', 'metafans' ) . '">&larr;</span> Previous</a>' : '';


		return $url;
	}
	/**
	 * Get all the URLs of current course ( quiz )
	 * @param $course_id
	 * @param $lession_list
	 * @param string $course_quizzes_list
	 *
	 * @return array
	 */
	public function metafans_ld_custom_quiz_count( $course_id, $lession_list, $course_quizzes_list = '' ) {
		global $post;

		$quiz_urls = array();
		if ( ! empty( $lession_list ) ) :

			foreach( $lession_list as $lesson ) {

				$lesson_topics = learndash_get_topic_list( $lesson->ID );

				if( ! empty( $lesson_topics ) ) :
					foreach( $lesson_topics as $lesson_topic ) {

						$topic_quizzes = learndash_get_lesson_quiz_list( $lesson_topic->ID );

						if( ! empty( $topic_quizzes ) ) :
							foreach( $topic_quizzes as $topic_quiz ) {
								$quiz_urls[] = get_permalink( $topic_quiz['post']->ID );
							}
						endif;

					}
				endif;

				$lesson_quizzes = learndash_get_lesson_quiz_list( $lesson->ID );

				if( ! empty( $lesson_quizzes ) ) :
					foreach( $lesson_quizzes as $lesson_quiz ) {
						$quiz_urls[] = get_permalink( $lesson_quiz['post']->ID );
					}
				endif;
			}

		endif;

		$course_quizzes = learndash_get_course_quiz_list( $course_id );
		if ( ! empty( $course_quizzes ) ) :
			foreach( $course_quizzes as $course_quiz ) {
				$quiz_urls[] = get_permalink( $course_quiz['post']->ID );
			}
		endif;


		return $quiz_urls;
	}
	/**
	 * Get all the URLs of current course ( lesson, topic, quiz )
	 * @param $course_id
	 * @param $lession_list
	 * @param string $course_quizzes_list
	 *
	 * @return array
	 */
	public function metafans_ld_custom_pagination( $course_id, $lession_list, $course_quizzes_list = '' ) {
		global $post;

		$navigation_urls = array();
		if ( ! empty( $lession_list ) ) :

			foreach( $lession_list as $lesson ) {

				$lesson_topics = learndash_get_topic_list( $lesson->ID );

				$navigation_urls[] = trailingslashit( get_permalink( $lesson->ID ) );

				if( ! empty( $lesson_topics ) ) :
					foreach( $lesson_topics as $lesson_topic ) {
						$navigation_urls[] = trailingslashit( get_permalink( $lesson_topic->ID ) );

						$topic_quizzes = learndash_get_lesson_quiz_list( $lesson_topic->ID );

						if( ! empty( $topic_quizzes ) ) :
							foreach( $topic_quizzes as $topic_quiz ) {
								$navigation_urls[] = trailingslashit( get_permalink( $topic_quiz['post']->ID ) );
							}
						endif;

					}
				endif;

				$lesson_quizzes = learndash_get_lesson_quiz_list( $lesson->ID );

				if( ! empty( $lesson_quizzes ) ) :
					foreach( $lesson_quizzes as $lesson_quiz ) {
						$navigation_urls[] = trailingslashit( get_permalink( $lesson_quiz['post']->ID ) );
					}
				endif;
			}

		endif;

		$course_quizzes = learndash_get_course_quiz_list( $course_id );
		if ( ! empty( $course_quizzes ) ) :
			foreach( $course_quizzes as $course_quiz ) {
				$navigation_urls[] = trailingslashit( get_permalink( $course_quiz['post']->ID ) );
			}
		endif;


		return $navigation_urls;
	}
	public function ld_30_get_course_id( $id ) {

		global $wpdb;

		$sql_str = $wpdb->prepare( "SELECT meta_value as post_id FROM " . $wpdb->postmeta . " WHERE meta_key LIKE %s AND post_id = %d", '%ld_course_%', $id );
		$course_id = $wpdb->get_col( $sql_str );
		$course_id = (int) isset( $course_id[0] ) ? $course_id[0] : 0;

		return $course_id;

	}
	public function render_ld_course_cover(){	
		if( !is_single() || get_post_type() !== 'sfwd-courses' ){
			return;
		}
		$course_cover_photo = false;
		if ( class_exists( 'MetafansMultiPostThumbnails' ) ) {
			$course_cover_photo = MetafansMultiPostThumbnails::get_post_thumbnail_url(
				'sfwd-courses',
				'course-cover-image'
			);
		}

		$course     = get_post( $course_id );
		$has_access = sfwd_lms_has_access( $course_id, get_current_user_id() );
		$lessons    = learndash_get_lesson_list( $course_id );
		?>
		<div class="metafans-vw-container metafans-learndash-banner">

			<?php if ( ! empty( $course_cover_photo ) ) { ?>
				<div class="mf-ld-cover-wrapper">
		        	<img src="<?php echo $course_cover_photo; ?>" alt="<?php the_title_attribute(array('post'=>$course_id)); ?>"
		             class="banner-img wp-post-image"/>
             	</div>
			<?php } ?>

		    <div class="metafans-course-banner-info container metafans-learndash-side-area">
		        <div class="flex flex-wrap">
		            <div class="metafans-course-banner-inner">
						<?php
						if ( taxonomy_exists( 'ld_course_category' ) ) {
							//category
							$course_cats = get_the_terms( $course->ID, 'ld_course_category' );
							if ( ! empty( $course_cats ) ) { ?>
		                        <div class="metafans-course-category">
									<?php foreach ( $course_cats as $course_cat ) { ?>
		                                <span class="course-category-item"><a title="<?php echo $course_cat->name; ?>"
		                                  href="<?php echo home_url() ?>/courses/?search=&filter-categories=<?php echo $course_cat->slug; ?>"><?php echo $course_cat->name; ?></a><span>,</span></span>
									<?php } ?>
		                        </div>
							<?php }
						}
						?>
		                <h1 class="entry-title"><?php echo get_the_title( $course_id ); ?></h1>

						<?php if ( has_excerpt( $course_id ) ) { ?>
		                    <div class="metafans-course-excerpt">
								<?php echo get_the_excerpt( $course_id ); ?>
		                    </div>
						<?php } ?>

						<?php
						// if ( buddyboss_theme_get_option( 'learndash_course_author' ) || buddyboss_theme_get_option( 'learndash_course_date' ) ) {
						// 	$bb_single_meta_pfx = 'bb_single_meta_pfx';
						// } else {
							$bb_single_meta_pfx = 'bb_single_meta_off';
						// }
						?>

		                <div class="metafans-course-single-meta flex align-items-center <?php echo $bb_single_meta_pfx; ?>">
							<?php if ( class_exists( 'BuddyPress' ) ) { ?>
		                    <a href="<?php echo bp_core_get_user_domain( $course->post_author ); ?>">
								<?php } else { ?>
		                        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID', $course->post_author ), get_the_author_meta( 'user_nicename', $course->post_author ) ); ?>">
									<?php } ?>
									<?php echo get_avatar( get_the_author_meta( 'email', $course->post_author ), 36 ); ?>
		                            <span class="author-name"><?php the_author_meta('display_name', $course->post_author); ?></span>
		                        </a>
						
		                            <span class="meta-saperator">&middot;</span>

		                            <span class="course-date"><?php echo get_the_date(); ?></span>
						</div>

		            </div>
		        </div>
		    </div>
		</div>
	<?php
	}
	public function get_courses_progress ( $user_id, $sort_order = 'desc' ) {
		$course_completion_percentage = array();

		if ( ! $course_completion_percentage = wp_cache_get ( $user_id, 'ld_courses_progress' ) ) {
			$course_progress = get_user_meta( $user_id, '_sfwd-course_progress', true );

			if ( ! empty( $course_progress ) && is_array( $course_progress ) ) {

				foreach ( $course_progress as $course_id => $coursep ) {
					// We take default progress value as 1 % rather than 0%
					$course_completion_percentage[ $course_id ] = 1;//

					if ( $coursep['total'] == 0 ) {
						continue;
					}

					$course_steps_count = learndash_get_course_steps_count( $course_id );
					$course_steps_completed = learndash_course_get_completed_steps( $user_id, $course_id, $coursep );

					$completed_on = get_user_meta( $user_id, 'course_completed_' . $course_id, true );
					if ( !empty( $completed_on ) ) {

						$coursep['completed'] = $course_steps_count;
						$coursep['total'] = $course_steps_count;

					} else {
						$coursep['total'] = $course_steps_count;
						$coursep['completed'] = $course_steps_completed;

						if ( $coursep['completed'] > $coursep['total'] )
							$coursep['completed'] = $coursep['total'];
					}

					// cannot divide by 0
					if ( $coursep['total'] == 0 ) {
						$course_completion_percentage[ $course_id ] = 0;
					} else {
						$course_completion_percentage[ $course_id ] = ceil( ( $coursep['completed'] * 100 ) / $coursep['total'] );
					}
				}
			}

			//Avoid running the queries multiple times if user's course progress is empty
			$course_completion_percentage = !empty( $course_completion_percentage ) ? $course_completion_percentage : 'empty';

			wp_cache_set( $user_id, $course_completion_percentage, 'ld_courses_progress' );
		}

		$course_completion_percentage = 'empty' !== $course_completion_percentage ? $course_completion_percentage : array();

		if ( !empty( $course_completion_percentage ) ) {
			// Sort.
			if ( 'asc' == $sort_order ) {
				asort( $course_completion_percentage );
			} else {
				arsort( $course_completion_percentage );
			}
		}

		return $course_completion_percentage;
	}
	public function add_meta_boxes() {
		add_meta_box( 'postexcerpt', esc_html__( 'Course Short Description', 'metafans' ), array( $this, 'course_short_description_metabox' ), 'sfwd-courses', 'normal', 'high' );
	}
	public function course_short_description_metabox( $post ){
		$settings = array(
			'textarea_name' => 'excerpt',
			'quicktags'     => array( 'buttons' => 'em,strong,link' ),
			'tinymce'       => array(
				'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
				'theme_advanced_buttons2' => '',
			),
			'editor_css'    => '<style>#wp-excerpt-editor-container .wp-editor-area{height:175px; width:100%;}</style>',
		);

		wp_editor( htmlspecialchars_decode( $post->post_excerpt, ENT_QUOTES ), 'excerpt', $settings );
	}
	public function ld_get_progress_course_percentage( $user_id, $course_id ) {

		if ( empty( $user_id ) ) {
			// $current_user = wp_get_current_user();
			if ( is_user_logged_in() ) {
				$user_id = get_current_user_id();
			} else {
				$user_id = 0;
			}
		}

		if ( empty( $course_id ) ) {
			$course_id = learndash_get_course_id();
		}

		if ( empty( $course_id ) ) {
			return '';
		}

		$completed = 0;
		$total     = false;

		if ( ! empty( $user_id ) ) {

			$course_progress = get_user_meta( $user_id, '_sfwd-course_progress', true );

			$percentage = 0;
			$message    = '';

			if ( ( ! empty( $course_progress ) ) && ( isset( $course_progress[ $course_id ] ) ) && ( ! empty( $course_progress[ $course_id ] ) ) ) {
				if ( isset( $course_progress[ $course_id ]['completed'] ) ) {
					$completed = absint( $course_progress[ $course_id ]['completed'] );
				}

				if ( isset( $course_progress[ $course_id ]['total'] ) ) {
					$total = absint( $course_progress[ $course_id ]['total'] );
				}
			} else {
				$total = 0;
			}
		}

		// If $total is still false we calculate the total from course steps.
		if ( false === $total ) {
			$total = learndash_get_course_steps_count( $course_id );
		}

		if ( $total > 0 ) {
			$percentage = intval( $completed * 100 / $total );
			$percentage = ( $percentage > 100 ) ? 100 : $percentage;
		} else {
			$percentage = 0;
		}

		return $percentage;

	}
	public function ld_course_enrolled_users_list( $course_id, $force_refresh = false ) {

		$course_enrolled_users_list = get_transient( 'metafans_ld_course_enrolled_users_count_' . $course_id );

		// If nothing is found, build the object.
		if ( true === $force_refresh || false === $course_enrolled_users_list ) {

			$members_arr = learndash_get_users_for_course( $course_id, array(), false );

			if ( ( $members_arr instanceof \WP_User_Query ) && ( property_exists( $members_arr, 'results' ) ) && ( ! empty( $members_arr->results ) ) ) {
				$course_enrolled_users_list = $members_arr->get_results();
			} else {
				$course_enrolled_users_list = array();
			}

			$course_enrolled_users_list = count( $course_enrolled_users_list );

			set_transient( 'metafans_ld_course_enrolled_users_count_' . $course_id, $course_enrolled_users_list );

		}

		return (int) $course_enrolled_users_list;
	}
	public function ld_course_resume_link( $course_id ) {

		if ( is_user_logged_in() ) {
			if ( ! empty( $course_id ) ) {
				$user           = wp_get_current_user();
				$step_course_id = $course_id;
				$course         = get_post( $step_course_id );

				$lession_list       = learndash_get_lesson_list( $course_id );
				$url = $this->ld_custom_continue_url_arr( $course_id, $lession_list );

				if ( isset( $course ) && 'sfwd-courses' === $course->post_type ) {
					//$last_know_step = get_user_meta( $user->ID, 'learndash_last_known_course_' . $step_course_id, true );
					$last_know_step = '';

					// User has not hit a LD module yet
					if ( empty( $last_know_step ) ) {

						if ( isset( $url ) && '' !== $url ) {
							return $url;
						} else {
							return '';
						}
					}

					//$step_course_id = 0;
					// Sanity Check
					if ( absint( $last_know_step ) ) {
						$step_id = $last_know_step;
					} else {
						if ( isset( $url ) && '' !== $url ) {
							return $url;
						} else {
							return '';
						}
					}

					$last_know_post_object = get_post( $step_id );

					// Make sure the post exists and that the user hit a page that was a post
					// if $last_know_page_id returns '' then get post will return current pages post object
					// so we need to make sure first that the $last_know_page_id is returning something and
					// that the something is a valid post
					if ( null !== $last_know_post_object ) {

						$post_type        = $last_know_post_object->post_type; // getting post_type of last page.
						$label            = get_post_type_object( $post_type ); // getting Labels of the post type.
						$title            = $last_know_post_object->post_title;
						$resume_link_text = __( 'RESUME', 'metafans' );

						if ( function_exists( 'learndash_get_step_permalink' ) ) {
							$permalink = learndash_get_step_permalink( $step_id, $step_course_id );
						} else {
							$permalink = get_permalink( $step_id );
						}

						return $permalink;
					}
				}
			}
		} else {
			$course_price_type   = learndash_get_course_meta_setting( $course_id, 'course_price_type' );
			if ( $course_price_type == 'open' ) {

				$lession_list       = learndash_get_lesson_list( $course_id );
				$url = $this->ld_custom_continue_url_arr( $course_id, $lession_list );
				return $url;
			}
		}

		return '';
	}
	public function ld_custom_continue_url_arr( $course_id, $lession_list, $course_quizzes_list = '' ) {
		global $post;

		$course_price_type   = learndash_get_course_meta_setting( $course_id, 'course_price_type' );
		if ( $course_price_type == 'closed' ) {
			$courses_progress    = $this->get_courses_progress( get_current_user_id() );
			$user_courses = learndash_user_get_enrolled_courses( get_current_user_id() );
			$course_progress     = isset( $courses_progress[ $course_id ] ) ? $courses_progress[ $course_id ] : null;
			if ( $course_progress <= 0 && ! in_array( $course_id, $user_courses) ) {
				return get_the_permalink( $course_id );
			}
		}

		$navigation_urls = array();
		if ( ! empty( $lession_list ) ) :

			foreach( $lession_list as $lesson ) {

				$lesson_topics = learndash_get_topic_list( $lesson->ID );

				$course_progress = get_user_meta( get_current_user_id(), '_sfwd-course_progress', true );
				$completed       = ! empty( $course_progress[ $course_id ]['lessons'][ $lesson->ID ] ) && 1 === $course_progress[ $course_id ]['lessons'][ $lesson->ID ];

				$navigation_urls[] = array(
					'url'      => get_permalink( $lesson->ID ),
					'complete' => $completed ? 'yes' : 'no',
				);

				if( ! empty( $lesson_topics ) ) :
					foreach( $lesson_topics as $lesson_topic ) {

						$completed = ! empty( $course_progress[ $course_id ]['topics'][ $lesson->ID ][ $lesson_topic->ID ] ) && 1 === $course_progress[ $course_id ]['topics'][ $lesson->ID ][ $lesson_topic->ID ];

						$navigation_urls[] = array(
							'url'      => get_permalink( $lesson_topic->ID ),
							'complete' => $completed ? 'yes' : 'no',
						);

						$topic_quizzes = learndash_get_lesson_quiz_list( $lesson_topic->ID );

						if( ! empty( $topic_quizzes ) ) :
							foreach( $topic_quizzes as $topic_quiz ) {
								$navigation_urls[] = array(
									'url'      => get_permalink( $topic_quiz['post']->ID ),
									'complete' => learndash_is_quiz_complete( get_current_user_id(), $topic_quiz['post']->ID ) ? 'yes' : 'no'
								);
							}
						endif;

					}
				endif;

				$lesson_quizzes = learndash_get_lesson_quiz_list( $lesson->ID );

				if( ! empty( $lesson_quizzes ) ) :
					foreach( $lesson_quizzes as $lesson_quiz ) {
						$navigation_urls[] = array(
							'url'      => get_permalink( $lesson_quiz['post']->ID ),
							'complete' => learndash_is_quiz_complete( get_current_user_id(), $lesson_quiz['post']->ID) ? 'yes' : 'no'
						);
					}
				endif;
			}

		endif;

		$course_quizzes = learndash_get_course_quiz_list( $course_id );
		if ( ! empty( $course_quizzes ) ) :
			foreach( $course_quizzes as $course_quiz ) {
				$navigation_urls[] = array(
					'url'      => get_permalink( $course_quiz['post']->ID ),
					'complete' => learndash_is_quiz_complete( get_current_user_id(), $course_quiz['post']->ID) ? 'yes' : 'no'
				);
			}
		endif;

		$key = array_search('no', array_column( $navigation_urls, 'complete') );
		if ( '' !== $key && isset( $navigation_urls[$key] )) {
			return $navigation_urls[$key]['url'];
		}
		return '';
	}
	public function ld_course_cover_photo() {
		if (class_exists('MetafansMultiPostThumbnails')) {

			new MetafansMultiPostThumbnails(
				array(
					'label' => __( 'Cover Photo', 'metafans'),
					'id' => 'course-cover-image',
					'post_type' => 'sfwd-courses'
				)
			);
		}
	}
	
}
function Tophive_LD() {
	return Tophive_LD::get_instance();
}

if ( tophive_metafans()->is_learndash_active() ) {
	Tophive_LD();
}

?>