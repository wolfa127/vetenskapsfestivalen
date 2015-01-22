<?php

function us_post_format_image_preview($thumbnail_size = 'blog-grid', &$content = null)
{
	global $post;
	$thumbnail = get_the_post_thumbnail(get_the_ID(), $thumbnail_size);
	$preview = "";

	if (empty($content))
	{
		$content = $post->post_content;
	}

	if( ! $thumbnail)
	{
		preg_match("%^(https?(?://([^/?#]*))?([^?#]*?\.(?:jpg|gif|png)))%", $content, $image_link_result);

		if( ! empty($image_link_result[0]))
		{
			$preview = '<img src="'.$image_link_result[0].'" alt="">';
			$content = str_replace($image_link_result[0], "", $content);
		}
		else
		{
			preg_match("%^<img.+?>%", $content, $image_tag_result);
			if( ! empty($image_tag_result[0]))
			{
				$preview = $image_tag_result[0];
				$content = str_replace($image_tag_result[0], "", $content);
			}
		}
	}
	else
	{
		$preview = $thumbnail;
	}

	$post->post_content = $content;

	return $preview;
}

function us_post_format_video_preview(&$content = null)
{
	global $post;
	$preview = "";

	if (empty($content))
	{
		$content = $post->post_content;
	}

	$content = preg_replace( '|^\s*(https?://[^\s"]+)\s*$|im', "[embed]$1[/embed]", $content);

	preg_match("%\[embed.+?\]|\[vc_video.+?\]%", $content, $video_result);

	if(!empty($video_result[0]))
	{
		global $wp_embed;
		$video = $video_result[0];
		$preview = do_shortcode($wp_embed->run_shortcode($video));
		if (strpos($preview, 'w-video') === FALSE) {
			$preview = '<div class="w-video"><div class="w-video-h">' . $preview . '</div></div>';
		}
		$content = str_replace($video_result[0], "", $content);
	}

	$post->post_content = $content;

	return $preview;
}

function us_post_format_gallery_preview($change_to_slider = true, $thumbnail_size = '', &$content = null)
{
	global $post;
	$preview = "";

	if (empty($content))
	{
		$content = $post->post_content;
	}

	preg_match("%\[vc_gallery.+?\]|\[vc_simple_slider.+?\]|\[gallery.+?\]%", $content, $gallery_result);

	if(!empty($gallery_result[0]))
	{
		$gallery = $gallery_result[0];

//		if ($change_to_slider AND $thumbnail_size == 'blog-grid')
//		{
//			if(strpos($gallery, 'vc_gallery') !== false)   $gallery = str_replace("vc_gallery", 'vc_grid_blog_slider', $gallery);
//			if(strpos($gallery, 'gallery') !== false)   $gallery = str_replace("gallery", 'vc_grid_blog_slider', $gallery);
//			if(strpos($gallery, 'vc_simple_slider') !== false)   $gallery = str_replace("vc_simple_slider", 'vc_grid_blog_slider', $gallery);
//		}
//		elseif ($change_to_slider)
//		{
			if(strpos($gallery, 'vc_gallery') !== false)   $gallery = str_replace("vc_gallery", 'vc_simple_slider', $gallery);
			if(strpos($gallery, 'gallery') !== false)   $gallery = str_replace("gallery", 'vc_simple_slider', $gallery);
//		}

		$preview = do_shortcode($gallery);
		$content = str_replace($gallery_result[0], "", $content);

	}

	$post->post_content = $content;

	return $preview;
}