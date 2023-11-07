<?php
/**
 * Template Name: Buddypress Photos
 * The templates for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tophive
 */

get_header(); ?>
	<div class="content-inner">
		<div class="bp-image-uploads">
			<div class="bp-image-filters">
			  <span>
				  <span id="allphoto-link" class="bp-image-filter bp-image-filter-active">All Photos </span>
				  <span id="allphoto" class="bp-img-no">0</span>
			  </span>
			  <span>
				  <span id="myphoto" class="bp-image-filter">My Photos </span>
				  <span id="myphoto-count" class="bp-img-no">0</span>
			  </span>
		    </div>

			<form class="bp-search-input-box">
				<input id="bp-image-search" type="text" placeholder="Search photos">
				<svg  viewBox="0 0 48 48" ><path d="m40.8994141 39.4853516-7.8127441-7.8127441c2.3978882-2.734375 3.7209473-6.1942749 3.7209473-9.8649902 0-4.0068359-1.5605469-7.7734375-4.3935547-10.6064453s-6.5996094-4.3935547-10.6064453-4.3935547-7.7734375 1.5605469-10.6064453 4.3935547-4.3935547 6.5996094-4.3935547 10.6064453 1.5605469 7.7734375 4.3935547 10.6064453 6.5996094 4.3935547 10.6064453 4.3935547c3.6707153 0 7.1306152-1.3230591 9.8649902-3.7209473l7.8127441 7.8127441c.1953125.1953125.4511719.2929688.7070313.2929688s.5117188-.0976563.7070313-.2929688c.3906249-.390625.3906249-1.0234375-.0000001-1.4140625zm-28.2841797-8.4853516c-2.4550781-2.4555664-3.8076172-5.7202148-3.8076172-9.1923828s1.3525391-6.7368164 3.8076172-9.1923828c2.4555664-2.4550781 5.7202148-3.8076172 9.1923828-3.8076172s6.7368164 1.3525391 9.1923828 3.8076172c2.4550781 2.4555664 3.8076172 5.7202148 3.8076172 9.1923828s-1.3525391 6.7368164-3.8076172 9.1923828c-2.4555664 2.4550781-5.7202148 3.8076172-9.1923828 3.8076172s-6.7368164-1.3525391-9.1923828-3.8076172z"></path></svg>
			</form>
			<div class="bp-image-upload-box">
				<a href="#" id="bp-upload-image" for="bp-upload-image-input">
					<svg  viewBox="0 0 24 24" ><g><path xmlns="http://www.w3.org/2000/svg" d="M22,13a1,1,0,0,0-1,1v4.213A2.79,2.79,0,0,1,18.213,21H5.787A2.79,2.79,0,0,1,3,18.213V14a1,1,0,0,0-2,0v4.213A4.792,4.792,0,0,0,5.787,23H18.213A4.792,4.792,0,0,0,23,18.213V14A1,1,0,0,0,22,13Z" ></path><path xmlns="http://www.w3.org/2000/svg" d="M6.707,8.707,11,4.414V17a1,1,0,0,0,2,0V4.414l4.293,4.293a1,1,0,0,0,1.414-1.414l-6-6a1,1,0,0,0-1.414,0l-6,6A1,1,0,0,0,6.707,8.707Z" ></path></g></svg>
					<?php _e("Add Photos","tophive"); ?>
				</a>
			</div>
			<div class="bp-create-album-box">
				<a id="bp-create-album" href="#">
				<svg  viewBox="0 0 24 24" ><g><g xmlns="http://www.w3.org/2000/svg"><path d="m17.453 24c-.168 0-.34-.021-.51-.066l-15.463-4.141c-1.06-.292-1.692-1.39-1.414-2.45l1.951-7.272c.072-.267.346-.422.612-.354.267.071.425.346.354.612l-1.95 7.27c-.139.53.179 1.082.71 1.229l15.457 4.139c.531.14 1.079-.176 1.217-.704l.781-2.894c.072-.267.346-.426.613-.353.267.072.424.347.353.613l-.78 2.89c-.235.89-1.045 1.481-1.931 1.481z" ></path></g><g xmlns="http://www.w3.org/2000/svg"><path d="m22 18h-16c-1.103 0-2-.897-2-2v-12c0-1.103.897-2 2-2h16c1.103 0 2 .897 2 2v12c0 1.103-.897 2-2 2zm-16-15c-.551 0-1 .449-1 1v12c0 .551.449 1 1 1h16c.551 0 1-.449 1-1v-12c0-.551-.449-1-1-1z" ></path></g><g xmlns="http://www.w3.org/2000/svg"><path d="m9 9c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zm0-3c-.551 0-1 .449-1 1s.449 1 1 1 1-.449 1-1-.449-1-1-1z" ></path></g><g xmlns="http://www.w3.org/2000/svg"><path d="m4.57 16.93c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707l4.723-4.723c.566-.566 1.555-.566 2.121 0l1.406 1.406 3.892-4.67c.283-.339.699-.536 1.142-.54h.011c.438 0 .853.19 1.139.523l5.23 6.102c.18.209.156.525-.054.705-.209.18-.524.157-.705-.054l-5.23-6.102c-.097-.112-.231-.174-.38-.174-.104-.009-.287.063-.384.18l-4.243 5.091c-.09.108-.221.173-.362.179-.142.01-.277-.046-.376-.146l-1.793-1.793c-.189-.188-.518-.188-.707 0l-4.723 4.723c-.097.097-.225.146-.353.146z" ></path></g></g></svg>
				<?php _e("Create Album","tophive"); ?>
				</a>
			</div>
		</div>
		<div class="media-upload-popup-container hide-popup">
			<div class="media-upload-popup">
				<span class="activity-uploading-loading"></span>
				<div class="media-upload-header">
					<h3 class="media-upload-header-text"><?php echo _e('Upload','tophive') ?></h3>
					<span class="close-media-popup dashicons dashicons-no-alt"></span>
				</div>
				<div class="media-upload-caption">
				<textarea id="media-caption" name="" cols="30" rows="4" placeholder="<?php _e("Write something about your photos..",'tophive') ?>"></textarea>
				</div>
				<div class="media-upload-box">
					<input id="media-upload-btn" type="file" accept="image/*" >
					<label for="media-upload-btn">
						<svg  viewBox="0 0 24 24" ><g><g xmlns="http://www.w3.org/2000/svg"><path d="m17.453 24c-.168 0-.34-.021-.51-.066l-15.463-4.141c-1.06-.292-1.692-1.39-1.414-2.45l1.951-7.272c.072-.267.346-.422.612-.354.267.071.425.346.354.612l-1.95 7.27c-.139.53.179 1.082.71 1.229l15.457 4.139c.531.14 1.079-.176 1.217-.704l.781-2.894c.072-.267.346-.426.613-.353.267.072.424.347.353.613l-.78 2.89c-.235.89-1.045 1.481-1.931 1.481z" ></path></g><g xmlns="http://www.w3.org/2000/svg"><path d="m22 18h-16c-1.103 0-2-.897-2-2v-12c0-1.103.897-2 2-2h16c1.103 0 2 .897 2 2v12c0 1.103-.897 2-2 2zm-16-15c-.551 0-1 .449-1 1v12c0 .551.449 1 1 1h16c.551 0 1-.449 1-1v-12c0-.551-.449-1-1-1z" ></path></g><g xmlns="http://www.w3.org/2000/svg"><path d="m9 9c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zm0-3c-.551 0-1 .449-1 1s.449 1 1 1 1-.449 1-1-.449-1-1-1z" ></path></g><g xmlns="http://www.w3.org/2000/svg"><path d="m4.57 16.93c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707l4.723-4.723c.566-.566 1.555-.566 2.121 0l1.406 1.406 3.892-4.67c.283-.339.699-.536 1.142-.54h.011c.438 0 .853.19 1.139.523l5.23 6.102c.18.209.156.525-.054.705-.209.18-.524.157-.705-.054l-5.23-6.102c-.097-.112-.231-.174-.38-.174-.104-.009-.287.063-.384.18l-4.243 5.091c-.09.108-.221.173-.362.179-.142.01-.277-.046-.376-.146l-1.793-1.793c-.189-.188-.518-.188-.707 0l-4.723 4.723c-.097.097-.225.146-.353.146z" ></path></g></g></svg>
						<h4>Add Photos</h4>
					</label>
				</div>
				<div class="upload-ready-medias"></div>
				<div class="mf-activity-accessibility-container">
					<select id="mf-activity-accessibility" class="mf-activity-accessibility" name="">
						<option value="public"><?php esc_html_e('Public','tophive'); ?></option>
						<option value="friends"><?php esc_html_e('Friends','tophive'); ?></option>
						<option value="onlyme"><?php esc_html_e('Onlyme','tophive'); ?></option>
					</select>
					<button id="popup-upload" disabled>Upload<buttona>
				</div>
			</div>
		</div>


		<div class="album-upload-popup-container hide-popup">
			<div class="album-upload-popup">
				<span class="activity-uploading-loading"></span>
				<div class="media-upload-header">
					<h3 class="media-upload-header-text"><?php echo _e('Create album','tophive') ?></h3>
					<span class="close-album-popup dashicons dashicons-no-alt"></span>
				</div>
				<div class="media-upload-caption">
				<label for="album-name" class="album-name">
					<input id="album-name" type="text" placeholder="<?php _e("Name",'tophive') ?>">
				</label>
				<textarea id="album-caption" name="" cols="30" rows="4" placeholder="<?php _e("Write something about your albun..",'tophive') ?>"></textarea>
				</div>
				<div class="media-upload-box">
					<input id="album-upload-btn" type="file" accept="image/*" multiple>
					<label for="album-upload-btn">
						<svg  viewBox="0 0 24 24" ><g><g xmlns="http://www.w3.org/2000/svg"><path d="m17.453 24c-.168 0-.34-.021-.51-.066l-15.463-4.141c-1.06-.292-1.692-1.39-1.414-2.45l1.951-7.272c.072-.267.346-.422.612-.354.267.071.425.346.354.612l-1.95 7.27c-.139.53.179 1.082.71 1.229l15.457 4.139c.531.14 1.079-.176 1.217-.704l.781-2.894c.072-.267.346-.426.613-.353.267.072.424.347.353.613l-.78 2.89c-.235.89-1.045 1.481-1.931 1.481z" ></path></g><g xmlns="http://www.w3.org/2000/svg"><path d="m22 18h-16c-1.103 0-2-.897-2-2v-12c0-1.103.897-2 2-2h16c1.103 0 2 .897 2 2v12c0 1.103-.897 2-2 2zm-16-15c-.551 0-1 .449-1 1v12c0 .551.449 1 1 1h16c.551 0 1-.449 1-1v-12c0-.551-.449-1-1-1z" ></path></g><g xmlns="http://www.w3.org/2000/svg"><path d="m9 9c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zm0-3c-.551 0-1 .449-1 1s.449 1 1 1 1-.449 1-1-.449-1-1-1z" ></path></g><g xmlns="http://www.w3.org/2000/svg"><path d="m4.57 16.93c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707l4.723-4.723c.566-.566 1.555-.566 2.121 0l1.406 1.406 3.892-4.67c.283-.339.699-.536 1.142-.54h.011c.438 0 .853.19 1.139.523l5.23 6.102c.18.209.156.525-.054.705-.209.18-.524.157-.705-.054l-5.23-6.102c-.097-.112-.231-.174-.38-.174-.104-.009-.287.063-.384.18l-4.243 5.091c-.09.108-.221.173-.362.179-.142.01-.277-.046-.376-.146l-1.793-1.793c-.189-.188-.518-.188-.707 0l-4.723 4.723c-.097.097-.225.146-.353.146z"></path></g></g></svg>
						<h4>Add Photos</h4>
					</label>
				</div>
				<div class="album-upload-ready-medias"></div>
				<div class="mf-activity-accessibility-container">
					<select id="mf-activity-accessibility" class="mf-activity-accessibility" name="">
						<option value="public"><?php esc_html_e('Public','tophive'); ?></option>
						<option value="friends"><?php esc_html_e('Friends','tophive'); ?></option>
						<option value="onlyme"><?php esc_html_e('Onlyme','tophive'); ?></option>
					</select>
					<button id="album-upload" disabled>Upload</button>
				</div>
			</div>
		</div>

		<div id="loading-con"><div></div><div></div><div></div><div></div><div></div><div></div></div>


<?php
	if( class_exists('BuddyPress') ){
		global $wpdb;
		$activities = $wpdb->get_results("SELECT id from {$wpdb->base_prefix}bp_activity", ARRAY_A);

		do_action( 'tophive/content/before' );
		echo '<div class="mf-photo-previewer">';
		$i = 1;
		foreach($activities as $id){
			$is_album = bp_activity_get_meta($id['id'],'is_album_activity',true);

			if(! empty($is_album) ){
				$images = bp_activity_get_meta( $id['id'], 'activity_media', false );

				if( !empty($images) ){
					$newImages = $images[0];
					$media_html  = '<div class="mf-album">';
					$media_html .= '<svg width="16" height="16" viewBox="0 0 512 512">
<path d="M464,128h-16v-16c0-26.51-21.49-48-48-48h-16V48c0-26.51-21.49-48-48-48H48C21.49,0,0,21.49,0,48v288    c0,26.51,21.49,48,48,48h16v16c0,26.51,21.49,48,48,48h16v16c0,26.51,21.49,48,48,48h288c26.51,0,48-21.49,48-48V176    C512,149.49,490.51,128,464,128z M48,352c-8.837,0-16-7.163-16-16V48c0-8.837,7.163-16,16-16h288c8.837,0,16,7.163,16,16v288    c0,8.837-7.163,16-16,16H48z M112,416c-8.837,0-16-7.163-16-16v-16h240c26.51,0,48-21.49,48-48V96h16c8.837,0,16,7.163,16,16v288    c0,8.837-7.163,16-16,16H112z M480,464c0,8.837-7.163,16-16,16H176c-8.837,0-16-7.163-16-16v-16h240c26.51,0,48-21.49,48-48V160    h16c8.837,0,16,7.163,16,16V464z"></path>
</svg>';			$img_markup = array();
					foreach( $newImages as $newImage  ){
					   $newImage['activity_id'] = $id['id'];

					   if(!empty($newImage['full']) && !empty($newImage['thumb'])){
						$markup      = '<div class="bp-image-single" id="'. $i .'">';
						$markup 	.= '<div class="post-media-single">';
						$markup 	.= '<a class="media-popup-thumbnail" href="'. $newImage['thumb'][0] .'" data-id="'. $newImage['id'] .'" data-activity="'. $newImage['activity_id'] .'"><img src="'. $newImage['full'] .'" alt="gm"></a>';
						$markup 	.= '</div>';
						$markup 	.= '</div>';
						array_unshift($img_markup,$markup);
				            }

						$i++;
					}
					$imges_markup = implode(" ", $img_markup);
					$media_html .= $imges_markup;
					$media_html .= '</div>';
					echo tophive_sanitize_filter( $media_html );
				}
			}else{
			$images = bp_activity_get_meta( $id['id'], 'activity_media', false );

			if( !empty($images) ){
				$newImages = $images[0];
				foreach( $newImages as $newImage  ){
				   $newImage['activity_id'] = $id['id'];

				   if(!empty($newImage['full']) && !empty($newImage['thumb'])){
					$media_html  = '<div class="bp-image-single" id="'. $i .'">';
					$media_html .= '<div class="post-media-single">';
					$media_html .= '<a class="media-popup-thumbnail" href="'. $newImage['thumb'][0] .'" data-id="'. $newImage['id'] .'" data-activity="'. $newImage['activity_id'] .'"><img src="'. $newImage['full'] .'" alt="gm"></a>';
					$media_html .= '</div>';
					$media_html .= '</div>';

					$i++;
					echo tophive_sanitize_filter( $media_html );
				    }
				}
			    }
			}
		}
		echo '<div/>';
		do_action( 'tophive/content/after' );
		
	}
?>
	</div><!-- #.content-inner -->
	<script>
		const mf_total_img = <?php echo $i; ?>	
		const totalImg = document.getElementById("allphoto");
		totalImg.innerText = mf_total_img;
	</script>
<?php
get_footer();
