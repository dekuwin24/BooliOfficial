<?php 
/**
 ***
 ** MetaFans BuddyPress Media Integration
 ** @package WordPress
 ** @subpackage Metafans
 ** @since 2.3.0
 *
 *
 */
class Tophive_BP_Media
{

	/*
	** Get Media Type by a given URL
	** @since v1.5.0
	*
	*/
	public function get_media_type( $url ){
		$media_filename = basename($url);
		$ext = pathinfo($media_filename, PATHINFO_EXTENSION);
		$video_extensions = array("mov", "mp4", "3gp");
		$image_extensions = array("jpg", "jpeg", "gif", "png");
		if( in_array($ext, $video_extensions) ){
			return 'video';
		}else if(in_array($ext, $image_extensions)){
			return 'image';
		}
	}

}