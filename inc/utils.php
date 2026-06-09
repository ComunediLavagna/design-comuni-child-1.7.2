<?php
/*
if ( ! ( WP_DEBUG ) ) {
	// wp original:
	#error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
	// sts 2025:
	error_reporting( E_CORE_ERROR | E_COMPILE_ERROR | E_ERROR | E_PARSE | E_USER_ERROR );
}
*/
if(!function_exists("sts_get_img_by_id")) {
    function sts_get_img_by_id( $imgid, $classes, $width = '', $height='', $resize='', $lazy=true ) {
	$img_post = get_post( $imgid );
	$image_alt = get_post_meta( $img_post->ID, '_wp_attachment_image_alt', true);
	$image_title = get_the_title( $img_post->ID );
 	if (trim($image_alt)=='') $image_alt = $image_title;
	if (trim($image_alt)=='') $image_alt = 'immagine decorativa'; // per l'accessibilità
       $url = '';
	if ($resize) {
		$url = wp_get_attachment_image_url($imgid,$resize); // resized image, default size is 'thumbnail'	
	}
	if (!$url) {
		$url = wp_get_attachment_image_url($imgid,'full'); // original image	
	}
	if ($url) {
		$img = '<img src="'.$url.'" ';        
		if ($lazy) $img .= 'loading="lazy" ';
		if ($classes) $img .= 'class="'.$classes.'" ';
		if ($width) $img .= 'width="'.$width.'" ';
		if ($height) $height .= 'height="'.$height.'" ';
		if ($image_alt) $img .= 'alt="'.$image_alt.'" ';
		if ($image_title) $img .= 'title="'.$image_title.'" ';
		$img .= '/>';
		
		print($img);
	}
    }
}