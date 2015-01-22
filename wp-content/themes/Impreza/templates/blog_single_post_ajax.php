<?php

global $smof_data;

$post_format = get_post_format()?get_post_format():'standard';

global $us_thumbnail_size, $post;
if (empty($us_thumbnail_size))
{
	$us_thumbnail_size = 'blog-grid';
}


if ($post_format == 'image')
{
	$preview = us_post_format_image_preview($us_thumbnail_size);
}
elseif ($post_format == 'gallery')
{
	$preview = (has_post_thumbnail())?get_the_post_thumbnail(get_the_ID(), $us_thumbnail_size):'';

	if ($preview == '') {
		if ($us_thumbnail_size == 'blog-small') {
			$preview = '<span class="w-blog-entry-preview-icon">
							<i class="fa fa-camera"></i>
						</span>';
		} else {
			$preview = us_post_format_gallery_preview(true, $us_thumbnail_size);
		}
	}
}
elseif ($post_format == 'video')
{
	$preview = (has_post_thumbnail())?get_the_post_thumbnail(get_the_ID(), $us_thumbnail_size):'';

	if ($preview == '') {
		if ($us_thumbnail_size == 'blog-small') {
			$preview = '<span class="w-blog-entry-preview-icon">
						<i class="fa fa-film"></i>
					</span>';
		} else {
			$preview = us_post_format_video_preview();
		}
	}

}
elseif ($post_format == 'quote')
{
	$preview = (has_post_thumbnail())?get_the_post_thumbnail(get_the_ID(), $us_thumbnail_size):'';

	if ($preview == '' AND $us_thumbnail_size == 'blog-small') {
		$preview = '<span class="w-blog-entry-preview-icon">
						<i class="fa fa-quote-left"></i>
					</span>';
	}
}
else
{
	$preview = (has_post_thumbnail())?get_the_post_thumbnail(get_the_ID(), $us_thumbnail_size):'';
}

if (empty($preview) AND $us_thumbnail_size == 'blog-small')
{
	$preview = '<span class="w-blog-entry-preview-icon"><i class="fa fa-file-o"></i></span>';
}
?>
<div <?php post_class('w-blog-entry') ?>>
	<div class="w-blog-entry-h">
		<?php  if ($preview AND in_array($post_format, array('video', 'gallery'))) {
			echo '<span class="w-blog-entry-preview">'.$preview.'</span>';
		} ?>
		<a class="w-blog-entry-link" href="<?php the_permalink(); ?>">
			<?php  if ($preview AND ! in_array($post_format, array('video', 'gallery'))) {
				echo '<span class="w-blog-entry-preview">'.$preview.'</span>';
			} ?>
			<?php
			if ($post_format == 'quote')
			{
				?><div class="w-blog-entry-title">
					<blockquote class="w-blog-entry-title-h"><?php the_title(); ?></blockquote>
				</div><?php
			}
			else
			{
				?><h2 class="w-blog-entry-title">
					<span class="w-blog-entry-title-h"><?php the_title(); ?></span>
				</h2><?php
			}
			?>
		</a>
		<div class="w-blog-entry-body">
			<div class="w-blog-meta">
				<?php if ($_POST['show_date'] == "1" OR $_POST['show_date'] == "yes") { ?>
				<div class="w-blog-meta-date">
					<i class="fa fa-clock-o"></i>
					<span><?php echo get_the_date() ?></span>
				</div>
				<?php } ?>
				<?php if ($_POST['show_author'] == "1" OR $_POST['show_author'] == "yes") { ?>
					<div class="w-blog-meta-author">
						<i class="fa fa-user"></i>
						<?php if (get_the_author_meta('url')) { ?>
							<a href="<?php echo esc_url( get_the_author_meta('url') ); ?>"><?php echo get_the_author() ?></a>
						<?php } else { ?>
							<span><?php echo get_the_author() ?></span>
						<?php } ?>
					</div>
				<?php } ?>
				<?php if ($_POST['show_categories'] == "1" OR $_POST['show_categories'] == "yes") { ?>
					<div class="w-blog-meta-tags">
						<i class="fa fa-folder-open"></i>
						<?php the_category(', '); ?>
					</div>
				<?php } ?>
				<?php if ($_POST['show_tags'] == "1" OR $_POST['show_tags'] == "yes") {
					$tags = wp_get_post_tags($post->ID);
					if ($tags) {
				?>
					<div class="w-blog-meta-tags">
						<i class="fa fa-tags"></i>
						<?php
						$tags_output = '';
						$separator = ', ';
						foreach($tags as $tag) {
							$tags_output .= '<a href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a>'.$separator;
						}
						echo trim($tags_output, $separator);
						?>

					</div>
				<?php
					}
				}
				?>
				<?php if ($_POST['show_comments'] == "1" OR $_POST['show_comments'] == "yes") { ?>
					<div class="w-blog-meta-comments">
						<?php if ( ! (get_comments_number() == 0 AND ! comments_open() AND ! pings_open())) { echo '<i class="fa fa-comments"></i>'; }  ?>
						<?php comments_popup_link(__('No Comments', 'us'), __('1 Comment', 'us'), __('% Comments', 'us'), 'w-blog-meta-comments-h', ''); ?>
					</div>
				<?php } ?>
			</div>
			<?php if ($_POST['post_content'] != 'none') { ?>
			<div class="w-blog-entry-short">
				<?php
				if ($_POST['post_content'] == 'full' AND $us_thumbnail_size != 'blog-grid')
				{
					global $disable_section_shortcode;
					$original_section_shortcode_state = $disable_section_shortcode;
					$disable_section_shortcode = TRUE;

					$content = $post->post_content;

					if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
						$content = explode( $matches[0], $content, 2 );
						$content = $content[0];
					}

					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					echo $content;

					$disable_section_shortcode = $original_section_shortcode_state;
				}
				else
				{
					$excerpt = trim(get_the_excerpt());
					if(!empty($excerpt))
					{
						the_excerpt();
					}
					else
					{
						$excerpt = apply_filters('the_content', $post->post_content);
						$excerpt = apply_filters('the_excerpt', $excerpt);
						$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
						$excerpt_length = apply_filters('excerpt_length', 55);
						$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
						$excerpt = wp_trim_words( $excerpt, $excerpt_length, $excerpt_more );
						echo $excerpt;
					}

				}
				?>
			</div>
			<?php } ?>
			<?php
			if ($_POST['show_read_more'] == "1" OR $_POST['show_read_more'] == "yes") { ?><a class="w-blog-entry-more g-btn color_default size_small outlined" href="<?php the_permalink(); ?>"><span>L&auml;s mer</span></a><?php }
			?>
		</div>
	</div>
</div>
