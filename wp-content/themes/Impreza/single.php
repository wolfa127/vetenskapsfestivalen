<?php
define('THEME_TEMPLATE', TRUE);
global $smof_data, $us_shortcodes, $post;
define('IS_POST', TRUE);
if ($smof_data['post_sidebar_pos'] == 'No Sidebar') {
	define('IS_FULLWIDTH', TRUE);
}
get_header();


// Disabling Section shortcode
global $disable_section_shortcode;
$disable_section_shortcode = TRUE;

wp_enqueue_script('comment-reply');
?>
<?php if (have_posts()) : while(have_posts()) : the_post();

	$post_format = get_post_format()?get_post_format():'standard';
	$post_content = get_the_content();

	$preview = '';
	if ($post_format == 'image')
	{
		$preview = us_post_format_image_preview('blog-big', $post_content);
	}
	elseif ($post_format == 'video')
	{
		$preview = us_post_format_video_preview($post_content);
	}
	elseif ($post_format == 'gallery')
	{
		$preview = us_post_format_gallery_preview(false, '', $post_content);
	}
	?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<div <?php post_class("w-blog"); ?>>

					<div class="w-blog-preview">

						<?php echo $preview; ?>

					</div>
					<div class="w-blog-content">

						<?php
						if ($post_format == 'quote')
						{
							?><div class="w-blog-title entry-title">
								<blockquote><?php the_title(); ?></blockquote>
							</div><?php
						}
						else
						{
							?><h1 class="w-blog-title entry-title"><?php the_title(); ?></h1><?php
						}
						?>

						<div class="w-blog-meta">
							<time class="w-blog-meta-date
								<?php if (isset($smof_data['post_meta_date']) AND $smof_data['post_meta_date'] == 0) echo 'hidden'; ?>">
								<i class="fa fa-clock-o"></i>
								<span class="date updated"><?php echo get_the_date() ?></span>
							</time>
							<div class="w-blog-meta-author vcard author
								<?php if (isset($smof_data['post_meta_author']) AND $smof_data['post_meta_author'] == 0) echo 'hidden'; ?>">
								<i class="fa fa-user"></i>
								<?php if (get_the_author_meta('url')) { ?>
									<a href="<?php echo esc_url( get_the_author_meta('url') ); ?>" class="fn"><?php echo get_the_author() ?></a>
								<?php } else { ?>
									<span class="fn"><?php echo get_the_author() ?></span>
								<?php } ?>
							</div>
							<?php if ( ! isset($smof_data['post_meta_categories']) OR $smof_data['post_meta_categories'] == 1) { ?>
								<div class="w-blog-meta-tags">
									<i class="fa fa-folder-open"></i>
									<?php the_category(', '); ?>
								</div>
							<?php } ?>
							<?php if ( ! isset($smof_data['post_meta_comments']) OR $smof_data['post_meta_comments'] == 1) { ?>
							<div class="w-blog-meta-comments">
								<span><i class="fa fa-comments"></i></span>
								<?php comments_popup_link(); ?>
							</div>
							<?php } ?>
						</div>
						<div class="w-blog-text i-cf">
							<?php
							$content = apply_filters('the_content', $post_content);
							$content = str_replace(']]>', ']]&gt;', $content);
							echo $content;
							?>

						</div>
					</div>
					<?php
					$tags = wp_get_post_tags($post->ID);
					if ($tags) {
					?>
					<?php if ( ! isset($smof_data['post_meta_tags']) OR $smof_data['post_meta_tags'] == 1) { ?>
					<div class="w-tags">
						<span class="w-tags-title"><?php echo __('Tags', 'us') ?>:</span>
						<?php foreach ($tags as $tag) { ?>
						<span class="w-tags-item">
							<a class="w-tags-item-link" href="<?php echo get_tag_link($tag->term_id) ?>"><?php echo $tag->name ?></a><span class="w-tags-item-separator">,</span>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php } ?>

				</div>
				<?php if ($smof_data['post_related_posts'] == 1) { ?>
					<?php
					if ($tags) {
						$tag_ids = array();
						foreach ($tags as $tag )
						{
							$tag_ids[] = (int)$tag->term_id;
						}

						$args=array(
							'tag__in' => $tag_ids,
							'post__not_in' => array($post->ID),
							'paged' => 1,
							'showposts' => 3,
							'orderby'=>'rand',
							'ignore_sticky_posts'=>1,
							'post_type' => get_post_type($post->ID),
						);
						$related_query = new WP_Query($args);
						if( $related_query->have_posts() ) {
							?>
							<div class="w-bloglist">
								<h4 class="w-bloglist-title"><?php echo __('Related Posts', 'us') ?></h4>
								<div class="w-bloglist-list">
									<?php while ($related_query->have_posts()) { $related_query->the_post(); ?>
										<div class="w-bloglist-entry">
											<a class="w-bloglist-entry-link" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
											<span class="w-bloglist-entry-date"><?php the_date(); ?></span>
										</div>
									<?php
									}
									wp_reset_query();
									?>

								</div>
							</div>
						<?php
						}
					}
				} ?>
				<?php if (comments_open() || get_comments_number() != '0') { comments_template(); } ?>
			</div>
			<div class="l-sidebar at_left">
				<?php if ($smof_data['post_sidebar_pos'] != 'Right') generated_dynamic_sidebar(); ?>
			</div>

			<div class="l-sidebar at_right">
				<?php if ($smof_data['post_sidebar_pos'] == 'Right') generated_dynamic_sidebar(); ?>
			</div>
		</div>
	</div>
<?php endwhile; else : ?>
	<?php _e('No posts were found.', 'us'); ?>
<?php endif; ?>
<?php get_footer(); ?>
