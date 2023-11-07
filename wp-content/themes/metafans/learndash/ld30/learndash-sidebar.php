<?php
global $post, $wpdb;

$parent_course_data  = learndash_get_setting( $post, 'course' );
if ( 0 === $parent_course_data ) {
	$parent_course_data = $course_id;
    if ( 0 === $parent_course_data ) {
	    $course_id = buddyboss_theme()->learndash_helper()->ld_30_get_course_id( $post->ID );
    }
	$parent_course_data  = learndash_get_setting( $course_id, 'course' );
}
$parent_course       = get_post( $parent_course_data );
$parent_course_link  = $parent_course->guid;
$parent_course_title = $parent_course->post_title;
$is_enrolled         = false;
$current_user_id     = get_current_user_id();
$get_course_groups   = learndash_get_course_groups( $parent_course->ID );
$course_id           = $parent_course->ID;
$admin_enrolled      = LearnDash_Settings_Section::get_section_setting('LearnDash_Settings_Section_General_Admin_User', 'courses_autoenroll_admin_users' );

// if( buddyboss_theme_get_option( 'learndash_course_participants', null, true ) ) {
	$members_count = apply_filters( 'tophive/learndash/single-course/enrolled-users-list', $course_id );
	$members_arr   = learndash_get_users_for_course( $course_id, array( 'number' => 5 ), false );
	if ( ( $members_arr instanceof WP_User_Query ) && ( property_exists( $members_arr, 'results' ) ) && ( ! empty( $members_arr->results ) ) ) {
		$members = $members_arr->get_results();
	} else {
		$members = array();
	}
// }

if ( isset( $get_course_groups ) && !empty( $get_course_groups ) && ( function_exists( 'buddypress' ) && bp_is_active( 'groups' ) ) ) {
    foreach ( $get_course_groups as $k => $group ) {
        $bp_group_id = (int) get_post_meta( $group, '_sync_group_id', true );
	    if ( ! groups_is_user_member( bp_loggedin_user_id(), $bp_group_id ) ) {
		    if (($key = array_search( $group, $get_course_groups)) !== false) {
			    unset($get_course_groups[$key]);
		    }
	    }
    }
}

if ( sfwd_lms_has_access( $course_id, $current_user_id ) ) {
	$is_enrolled = true;
} else {
	$is_enrolled = false;
}

// if admins are enrolled
if ( current_user_can('administrator') && $admin_enrolled === 'yes' ) {
	$is_enrolled = true;
}

//check if lesson sidebar is closed
$side_panel_state_class = '';
if ( ( isset( $_COOKIE['lessonpanel'] ) && 'closed' == $_COOKIE['lessonpanel'] )){
	$side_panel_state_class = 'lms-topic-sidebar-close';
}
?>

<div class="lms-topic-sidebar-wrapper <?php echo $side_panel_state_class;?>">
	<div class="lms-topic-sidebar-data">
        <?php $course_progress = learndash_course_progress(array("user_id" => get_current_user_id(), "course_id" => $parent_course->ID, "array" => true)); ?>

		<div class="mf-elementor-header-items">
			<a href="#" id="mf-toggle-theme">
				<span class="sfwd-dark-mode" data-balloon-pos="down" data-balloon="<?php _e( 'Dark Mode', 'metafans' ); ?>"><i class="mf-icon-moon-circle"></i></span>
				<span class="sfwd-light-mode" data-balloon-pos="down" data-balloon="<?php _e( 'Light Mode', 'metafans' ); ?>"><i class="mf-icon-sun"></i></span>
			</a>
			<a href="#" class="header-maximize-link course-toggle-view" data-balloon-pos="down" data-balloon="<?php _e( 'Maximize', 'metafans' ); ?>"><i class="mf-icon-maximize"></i></a>
			<a href="#" class="header-minimize-link course-toggle-view" data-balloon-pos="down" data-balloon="<?php _e( 'Minimize', 'metafans' ); ?>"><i class="mf-icon-minimize"></i></a>
		</div>

        <div class="lms-topic-sidebar-course-navigation">
            <div class="ld-course-navigation">
                <a title="<?php echo $parent_course_title; ?>" href="<?php echo get_permalink( $parent_course->ID ); ?>" class="course-entry-link"><span><i class="mf-icons mf-icon-chevron-left"></i><?php echo sprintf( esc_html_x('Back to %s', 'link: Back to Course', 'metafans'), LearnDash_Custom_Label::get_label( 'course' ) );?></span></a>
                <h2 class="course-entry-title"><?php echo $parent_course_title; ?></h2>
            </div>
        </div>

        <div class="lms-topic-sidebar-progress">
            <div class="course-progress-wrap">
                <?php learndash_get_template_part( 'modules/progress.php', array(
                    'context'   =>  'course',
                    'user_id'   =>  get_current_user_id(),
                    'course_id' =>  $parent_course->ID
                ), true ); ?>
    		</div>
        </div>

        <?php $course_progress = get_user_meta( get_current_user_id(), '_sfwd-course_progress', true ); ?>

		<div class="lms-lessions-list">
			<?php if ( ! empty( $lession_list ) ) :

				$sections = learndash_30_get_course_sections($parent_course->ID);
			?>
				<ol class="mf-lessons-list">
					<?php foreach( $lession_list as $lesson ) { ?>

						<?php
                        $lesson_topics = learndash_get_topic_list( $lesson->ID, $parent_course->ID );
                        $lesson_sample = learndash_get_setting( $lesson->ID, 'sample_lesson' ) == 'on' ? 'mf-lms-is-sample' : '';

                        $is_sample    = ( isset($lesson->sample) ? $lesson->sample : false );
                        $has_access   = sfwd_lms_has_access( $lesson->ID, $user_id );

                        $atts = apply_filters( 'learndash_quiz_row_atts', ( isset($has_access) && !$has_access && !$is_sample ? 'data-balloon-pos="up" data-balloon="' . __( "You don't currently have access to this content", "buddyboss-theme" ) . '"' : '' ) );
                        $atts_access_marker = apply_filters( 'learndash_quiz_row_atts', ( isset($has_access) && !$has_access && !$is_sample ? '<span class="lms-is-locked-ico"><i class="mf-icons mf-icon-lock-fill"></i></span>' : '' ) );
                        $locked_class = apply_filters( 'learndash_quiz_row_atts', ( isset($has_access) && !$has_access && !$is_sample ? 'lms-is-locked' : 'lms-not-locked' ) );
                        if ( $has_access ) {
                        ?>

						<li class="lms-lesson-item <?php echo $lesson->ID == $post->ID ? 'current' : 'lms-lesson-turnover'; ?> <?php echo $lesson_sample . ' ' . $locked_class; ?> <?php echo !empty( $lesson_topics ) ? '' : 'mf-lesson-item-no-topics'; ?>">

							<?php
							if( isset($sections[$lesson->ID]) ):

								learndash_get_template_part( 'lesson/partials/section.php', array(
									'section'   => $sections[$lesson->ID],
									'course_id' => $course_id,
									'user_id'   => $user_id,
								), true );

							endif;
							?>
                            
							<a href="<?php echo get_permalink( $lesson->ID ); ?>" title="<?php echo $lesson->post_title; ?>" class="mf-lesson-head flex">
                                <?php
								$lesson_progress = apply_filters( 'tophive/learndash/single-course/lesson/progress', $lesson->ID, $course_id );
								$completed = ! empty( $course_progress[ $course_id ]['lessons'][$lesson->ID] ) && 1 === $course_progress[ $course_id ]['lessons'][ $lesson->ID ];
								?>
                                <?php if( ! empty( $lesson_topics ) ) : ?>
                                    <span class="lms-toggle-lesson">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right" viewBox="0 0 16 16">
                                          <path d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
                                        </svg>
                                    </span>
                                <?php endif; ?>
                                <div class="flex-1 push-left <?php echo $completed ? 'mf-completed-item' : 'mf-not-completed-item'; ?>">
                                    <div class="mf-lesson-title"><?php echo $lesson->post_title; ?></div>
                                    <?php echo $atts_access_marker; ?>
                                </div>
                                <?php if( ! empty( $lesson_topics ) ) : ?>
                                <div class="mf-lesson-topics-count">
                                    <?php echo sizeof($lesson_topics); ?> <?php echo sizeof($lesson_topics) > 1 ? LearnDash_Custom_Label::get_label( 'topics' ) : LearnDash_Custom_Label::get_label( 'topic' ); ?>
                                </div>
                                <?php endif; ?>

                                <?php
                                if( $lesson_progress['percentage'] == '100' ) {
                                    $lesson_progress_data_balloon = __( 'Completed', 'metafans' );
                                } elseif( $lesson_progress['percentage'] == '0' ) {
                                    $lesson_progress_data_balloon = __( 'Not Completed', 'metafans' );
                                } else {
                                    $lesson_progress_data_balloon = $lesson_progress['percentage'] . __( '% Completed', 'metafans' );
                                }
                                ?>

                                <div class="flex align-items-center <?php echo $lesson_progress['percentage'] == '100' ? 'mf-check-completed' : 'mf-check-not-completed'; ?>">
									<div class="mf-lms-progress-wrap" data-balloon-pos="left" data-balloon="<?php echo $lesson_progress_data_balloon; ?>">
                                        <?php if ($lesson_progress['percentage'] == '100') { ?>
                                            <div class="i-progress i-progress-completed"><i class="mf-icon-check"></i></div>
                                        <?php } else { ?>
                                            <div class="mf-progress <?php echo $completed ? 'mf-completed' : 'mf-not-completed'; ?>" data-percentage="<?php echo $lesson_progress['percentage']; ?>">
    											<span class="mf-progress-left"><span class="mf-progress-circle"></span></span>
    											<span class="mf-progress-right"><span class="mf-progress-circle"></span></span>
    										</div>
                                        <?php } ?>
									</div>
								</div>
							</a>

                            <div class="lms-lesson-content" <?php echo $lesson->ID == $post->ID ? '' : 'style="display: none;"'; ?>>
								<?php if ( ! empty( $lesson_topics ) ) : ?>
                                    <ol class="mf-type-list">
										<?php foreach ( $lesson_topics as $lesson_topic ) {
											$has_access = sfwd_lms_has_access( $lesson_topic->ID, $user_id );
											if ( $has_access ) { ?>
                                                <li class="lms-topic-item <?php echo $lesson_topic->ID == $post->ID ? 'current' : ''; ?>">
                                                    <a class="flex mf-title mf-lms-title-wrap"
                                                       href="<?php echo get_permalink( $lesson_topic->ID ); ?>"
                                                       title="<?php echo $lesson_topic->post_title; ?>">
														<?php
														$topic_settings       = learndash_get_setting( $lesson_topic );
														$lesson_video_enabled = isset( $topic_settings['lesson_video_enabled'] ) ? $topic_settings['lesson_video_enabled'] : null;

														$completed = ! empty( $course_progress[ $course_id ]['topics'][ $lesson->ID ][ $lesson_topic->ID ] ) && 1 === $course_progress[ $course_id ]['topics'][ $lesson->ID ][ $lesson_topic->ID ];

														if ( ! empty( $lesson_video_enabled ) ) { ?>
                                                            <span class="mf-lms-ico mf-lms-ico-topic"><i
                                                                        class="mf-icons mf-icon-play-thin"></i></span>
														<?php } else { ?>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-justify-right" viewBox="0 0 16 16">
                                                              <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-4-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                                                            </svg>
														<?php } ?>
                                                        <span class="flex-1 mf-lms-title <?php echo $completed ? 'mf-completed-item' : 'mf-not-completed-item'; ?>"><?php echo $lesson_topic->post_title; ?></span>
														<?php if ( ( ! empty( $course_progress[ $course_id ]['topics'][ $lesson->ID ][ $lesson_topic->ID ] ) && 1 === $course_progress[ $course_id ]['topics'][ $lesson->ID ][ $lesson_topic->ID ] ) ) : ?>
                                                            <div class="mf-completed mf-lms-status"
                                                                 data-balloon-pos="left"
                                                                 data-balloon="<?php _e( 'Completed', 'metafans' ); ?>">
                                                                <div class="i-progress i-progress-completed"><i
                                                                            class="mf-icon-check"></i></div>
                                                            </div>
														<?php else : ?>
                                                            <div class="mf-not-completed mf-lms-status"
                                                                 data-balloon-pos="left"
                                                                 data-balloon="<?php _e( 'Not Completed', 'metafans' ); ?>">
                                                                <div class="i-progress i-progress-not-completed"><i
                                                                            class="mf-icon-circle"></i></div>
                                                            </div>
														<?php endif; ?>
                                                    </a>

													<?php $topic_quizzes = learndash_get_lesson_quiz_list( $lesson_topic->ID, get_current_user_id(), $course_id ); ?>

													<?php if ( ! empty( $topic_quizzes ) ) : ?>
                                                        <ol class="lms-quiz-list">
															<?php foreach ( $topic_quizzes as $topic_quiz ) {
																$has_access = sfwd_lms_has_access( $topic_quiz['post']->ID, $user_id );
																if ( $has_access ) {
																	?>
                                                                    <li class="lms-quiz-item <?php echo $topic_quiz['post']->ID == $post->ID ? 'current' : ''; ?>">
                                                                        <a class="flex mf-title mf-lms-title-wrap"
                                                                           href="<?php echo get_permalink( $topic_quiz['post']->ID ); ?>"
                                                                           title="<?php echo $topic_quiz['post']->post_title; ?>">
                                                                    <span class="mf-lms-ico mf-lms-ico-quiz"><i
                                                                                class="mf-icons mf-icon-question-thin"></i></span>
                                                                            <span class="flex-1 mf-lms-title <?php echo learndash_is_quiz_complete( $user_id, $topic_quiz['post']->ID ) ? 'mf-completed-item' : 'mf-not-completed-item'; ?>"><?php echo $topic_quiz['post']->post_title; ?></span>
																			<?php if ( learndash_is_quiz_complete( $user_id, $topic_quiz['post']->ID ) ) : ?>
                                                                                <div class="mf-completed mf-lms-status"
                                                                                     data-balloon-pos="left"
                                                                                     data-balloon="<?php _e( 'Completed', 'metafans' ); ?>">
                                                                                    <div class="i-progress i-progress-completed">
                                                                                        <i class="mf-icon-check"></i>
                                                                                    </div>
                                                                                </div>
																			<?php else: ?>
                                                                                <div class="mf-not-completed mf-lms-status"
                                                                                     data-balloon-pos="left"
                                                                                     data-balloon="<?php _e( 'Not Completed', 'metafans' ); ?>">
                                                                                    <div class="i-progress i-progress-not-completed">
                                                                                        <i class="mf-icon-circle"></i>
                                                                                    </div>
                                                                                </div>
																			<?php endif; ?>
                                                                        </a>
                                                                    </li>
																	<?php
																}
															} ?>
                                                        </ol>
													<?php endif; ?>
                                                </li>
												<?php
											}
										} ?>
                                    </ol>
								<?php endif; ?>

							<?php $lesson_quizzes = learndash_get_lesson_quiz_list( $lesson->ID, get_current_user_id(), $course_id ); ?>

							<?php if( ! empty( $lesson_quizzes ) ) : ?>
								<ul class="lms-quiz-list">
									<?php foreach( $lesson_quizzes as $lesson_quiz ) { ?>
										<li class="lms-quiz-item <?php echo $lesson_quiz['post']->ID == $post->ID ? 'current' : ''; ?>">
											<a class="flex mf-title mf-lms-title-wrap" href="<?php echo get_permalink( $lesson_quiz['post']->ID ); ?>" title="<?php echo $lesson_quiz['post']->post_title; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                                                </svg>
                                                <span class="flex-1 mf-lms-title <?php echo learndash_is_quiz_complete($user_id,$lesson_quiz['post']->ID) ? 'mf-completed-item' : 'mf-not-completed-item'; ?>"><?php echo $lesson_quiz['post']->post_title; ?></span>
                                                <?php if ( learndash_is_quiz_complete($user_id,$lesson_quiz['post']->ID) ) : ?>
                                                    <div class="mf-completed mf-lms-status" data-balloon-pos="left" data-balloon="<?php _e( 'Completed', 'metafans' ); ?>">
                                                        <div class="i-progress i-progress-completed"><i class="mf-icon-check"></i></div>
                                                    </div>
												<?php else: ?>
													<div class="mf-not-completed mf-lms-status" data-balloon-pos="left" data-balloon="<?php _e( 'Not Completed', 'metafans' ); ?>">
                                                        <div class="i-progress i-progress-not-completed"><i class="mf-icon-circle"></i></div>
                                                    </div>
												<?php endif; ?>
											</a>
										</li>
									<?php } ?>
								</ul>
							<?php endif; ?>
                            </div><?php /*lms-lesson-content*/ ?>

						</li>
					<?php } } ?>
				</ol>
			<?php endif; ?>
		</div>

		<?php $course_quizzes = learndash_get_course_quiz_list( $course_id ); ?>

		<?php if ( ! empty( $course_quizzes ) ) : ?>
			<div class="lms-course-quizzes-list">
                <h4 class="lms-course-quizzes-heading"><?php echo LearnDash_Custom_Label::get_label( 'quizzes' ); ?></h4>
				<ul class="lms-quiz-list mf-type-list">
					<?php foreach( $course_quizzes as $course_quiz ) {

                        $is_sample    = ( isset($lesson->sample) ? $lesson->sample : false );
                        $has_access   = sfwd_lms_has_access( $course_quiz['post']->ID, $user_id );

                        $atts = apply_filters( 'learndash_quiz_row_atts', ( isset($has_access) && !$has_access && !$is_sample ? 'data-balloon-pos="up" data-balloon="' . __( "You don't currently have access to this content", "buddyboss-theme" ) . '"' : '' ) );
                        $atts_access_marker = apply_filters( 'learndash_quiz_row_atts', ( isset($has_access) && !$has_access && !$is_sample ? '<span class="lms-is-locked-ico"><i class="mf-icons mf-icon-lock-fill"></i></span>' : '' ) );
                        $locked_class = apply_filters( 'learndash_quiz_row_atts', ( isset($has_access) && !$has_access && !$is_sample ? 'lms-is-locked' : 'lms-not-locked' ) );
                       ?>
						<li class="lms-quiz-item <?php echo $course_quiz['post']->ID == $post->ID ? 'current' : ''; ?> <?php echo $locked_class; ?>">
							<a class="flex mf-title mf-lms-title-wrap" href="<?php echo get_permalink( $course_quiz['post']->ID ); ?>" title="<?php echo $course_quiz['post']->post_title; ?>">
                                <span class="mf-lms-ico mf-lms-ico-quiz"><i class="mf-icons mf-icon-question-thin"></i></span>
								<span class="flex-1 push-left mf-lms-title <?php echo learndash_is_quiz_complete($user_id,$course_quiz['post']->ID) ? 'mf-completed-item' : 'mf-not-completed-item'; ?>">
                                    <span class="mf-quiz-title"><?php echo $course_quiz['post']->post_title; ?></span>
                                    <?php echo $atts_access_marker; ?>
                                </span>
                                <?php if ( learndash_is_quiz_complete($user_id,$course_quiz['post']->ID) ) : ?>
									<div class="mf-completed mf-lms-status" data-balloon-pos="left" data-balloon="<?php _e( 'Completed', 'metafans' ); ?>">
                                        <div class="i-progress i-progress-completed"><i class="mf-icon-check"></i></div>
                                    </div>
								<?php else: ?>
									<div class="mf-not-completed mf-lms-status" data-balloon-pos="left" data-balloon="<?php _e( 'Not Completed', 'metafans' ); ?>">
                                        <div class="i-progress i-progress-not-completed"><i class="mf-icon-circle"></i></div>
                                    </div>
								<?php endif; ?>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php endif; ?>

        <?php
        /** Hide Course Groups
        if ( isset( $get_course_groups ) && !empty( $get_course_groups ) ) { ?>
            <div class="lms-course-groups-list">
                <div class="lms-group-flag">

                    <?php
                    $count         = 0;
                    $groups_leader = 0;
                    $count_groups  = count( $get_course_groups );


                    $cookie_key = 'bp-ld-active-course-groups-'.$parent_course->ID;
                    if( isset( $_COOKIE[$cookie_key] ) ) {
                        foreach ( $get_course_groups as $k => $group ) {
	                        $bp_group_id = (int) get_post_meta( $group, '_sync_group_id', true );
	                        if ( $bp_group_id === (int) $_COOKIE[$cookie_key] ) {
		                        array_unshift($get_course_groups, $group );
                            }
                        }
                    }

                    $get_course_groups = array_unique( $get_course_groups );

                    foreach ( $get_course_groups as $k => $group ) {

	                    $bp_group_id = (int) get_post_meta( $group, '_sync_group_id', true );
	                    $group_obj   = groups_get_group( array( 'group_id' => (int) $bp_group_id ) );

	                    if ( 0 === $count ) {

		                    $cookie_key = 'bp-ld-active-course-groups-'.$parent_course->ID;
                            if( isset( $_COOKIE[$cookie_key] ) ) {
                                $bp_ld_active_group = $_COOKIE[$cookie_key];
                                $groups_leader      = $bp_ld_active_group;
                            } else {
                                ?>
                                <script type="text/javascript">
                                    jQuery( document ).ready(function() {
                                        jQuery.cookie('bp-ld-active-course-groups-'+<?php echo $parent_course->ID; ?>, <?php echo $bp_group_id; ?>,{ path: '/'});
                                    });
                                </script>
                                <?php
                                $groups_leader = $bp_group_id;
                            }
                            ?>
                            <div href="#" class="group-flag-index">
                                <a class="ld-set-cookie" data-course-id="<?php echo esc_attr( $parent_course->ID ); ?>" data-group-id="<?php echo esc_attr( $bp_group_id ); ?>" href="<?php echo bp_get_group_permalink( $group_obj ); ?>"><?php echo bp_core_fetch_avatar( array ( 'item_id' => $bp_group_id, 'object' => 'group', 'class' => 'lms-flag-group-avatar' ) ); ?></a>
                                <div class="lms-group-heading">
                                    <a class="ld-set-cookie" data-course-id="<?php echo esc_attr( $parent_course->ID ); ?>" data-group-id="<?php echo esc_attr( $bp_group_id ); ?>" href="<?php echo bp_get_group_permalink( $group_obj ); ?>"><span><?php echo bp_get_group_name( $group_obj );?></span></a> <span><?php esc_html_e( 'Group', 'metafans' ); ?></span>
                                </div>
                                <?php
                                if ( $count_groups > 1 ) { ?>
                                    <span class="flag-group-exp push-right"><i class="mf-icons mf-icon-chevron-down"></i></span><?php
                                }
                                ?>
                            </div>
                            <?php
                        } else {
                            if ( 1 === $count ) {
                                ?><ul class="course-group-list"><?php
                            }
                            ?>
                            <li>
                                <a class="ld-set-cookie" data-course-id="<?php echo esc_attr( $parent_course->ID ); ?>" data-group-id="<?php echo esc_attr( $bp_group_id ); ?>" href="<?php echo bp_get_group_permalink( $group_obj ); ?>">
	                                <?php echo bp_core_fetch_avatar( array ( 'item_id' => $bp_group_id, 'object' => 'group', 'class' => 'round' ) ); ?>
                                    <div class="lms-group-title"><?php echo bp_get_group_name( $group_obj );?></div>
                                </a>
                            </li>
                            <?php
                            if ( count( $get_course_groups ) === $count ) {
                                ?></ul><?php
                                }
                            }
                        $count++;
                    }
                    ?>
                </div>

                <?php
                if( isset( $groups_leader ) && $groups_leader > 0 ) {
	                $group_obj        = groups_get_group( array( 'group_id' => (int) $groups_leader ) );
	                $group_admins     = bp_group_admin_ids( $group_obj, 'array' );
	                $group_moderators = bp_group_mod_ids( $group_obj, 'array' );
	                $leader_arr       = array_merge( $group_admins, $group_moderators );
	                ?>
                    <div class="lms-group-exec">
                        <h4 class="lms-course-sidebar-heading"><?php _e( 'Group Leaders', 'metafans' ); ?>
                            <span class="lms-count"><?php echo count( $leader_arr ) ?></span>
                        </h4>
                        <ul class="group-exec-list">
                            <?php
                            foreach ( $group_admins as $member_single ) {
                                ?>
                                <li>
                                    <a href="<?php echo bp_core_get_user_domain( $member_single ); ?>">
	                                    <?php echo bp_core_fetch_avatar( array( 'item_id' => $member_single, 'class' => 'round' ) ); ?>
                                        <div class="lms-group-lead">
                                            <span>
                                                <?php
                                                $user = get_userdata( $member_single );
                                                echo $user->display_name; ?>
                                            </span>
                                            <span>
                                                <?php echo esc_html( get_group_role_label( $group_obj->id, 'organizer_singular_label_name' ) ); ?>
                                            </span>
                                        </div>
                                    </a>
                                </li><?php
                            }

                            if ( isset( $group_moderators ) && !empty( $group_moderators ) ) {
	                            foreach ( $group_moderators as $moderators ) {
		                            ?>
                                    <li>
                                    <a href="<?php echo bp_core_get_user_domain( $moderators ); ?>">
			                            <?php echo bp_core_fetch_avatar( array( 'item_id' => $moderators, 'class' => 'round' ) ); ?>
                                        <div class="lms-group-lead">
                                            <span>
                                                <?php
                                                $user = get_userdata( $moderators );
                                                echo $user->display_name; ?>
                                            </span>
                                            <span>
                                                <?php echo esc_html( get_group_role_label( $group_obj->id, 'moderator_singular_label_name' ) ); ?>
                                            </span>
                                        </div>
                                    </a>
                                    </li><?php
	                            }
                            }
                            ?>
                        </ul>
                    </div><?php
                }
                ?>
            </div><?php
        }
        */
        ?>

        <?php
        //if( buddyboss_theme_get_option( 'learndash_course_participants', null, true ) && ! empty( $members ) ) : ?>
            <div class="lms-course-members-list">
                <h4 class="lms-course-sidebar-heading"><?php _e( 'Participants', 'metafans' ); ?><span class="lms-count"><?php echo $members_count; ?></span></h4>
	            <input type="hidden" name="buddyboss_theme_learndash_course_participants_course_id" id="buddyboss_theme_learndash_course_participants_course_id" value="<?php echo esc_attr( $course_id ); ?>">
    			<div class="mf-course-member-wrap">

    				<ul class="course-members-list">
                    <?php $count = 0; ?>
    				<?php foreach( $members as $course_member ) : ?>
    					<?php
                        if ( $count > 4 ) { break; } ?>
                        <li>

                        <?php if ( class_exists( 'BuddyPress' ) ) { ?>
        				    <a href="<?php echo bp_core_get_user_domain( (int) $course_member ); ?>">
            			<?php } ?>
    					   <img class="round" src="<?php echo get_avatar_url( (int) $course_member, array( 'size' => 96 ) ); ?>" alt="" />
                            <?php if ( class_exists( 'BuddyPress' ) ) { ?>
                                <span><?php echo bp_core_get_user_displayname( (int) $course_member ); ?></span>
                            <?php } else { ?>
	                            <?php $course_member = get_userdata( (int) $course_member ); ?>
                                <span><?php echo $course_member->display_name; ?></span>
                            <?php } ?>
                        <?php if ( class_exists( 'BuddyPress' ) ) { ?>
                            </a>
                        <?php } ?>
                        </li>
    				    <?php $count++; ?>
                    <?php endforeach; ?>
    				</ul>

                    <ul class="course-members-list course-members-list-extra">
                    </ul>
                    <?php if( $members_count > 5 ) { ?>
    				<a href="javascript:void(0);" class="list-members-extra lme-more"><span class="members-count-g"></span> <?php _e( 'Show more', 'metafans' ); ?><i class="mf-icons mf-icon-chevron-down"></i></a>
                    <?php } ?>
    			</div>
            </div>
		<!-- <?php //endif; ?> -->

        <?php if(is_active_sidebar('learndash_lesson_sidebar')) { ?>
			<div class="ld-sidebar-widgets">
				<ul>
					<?php dynamic_sidebar('learndash_lesson_sidebar') ?>
				</ul>
			</div>
		<?php } ?>

	</div>

</div>
