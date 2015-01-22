<?php
/*
Template Name: Blog: Grid with AJAX load
*/
define('THEME_TEMPLATE', TRUE);
define('IS_BLOG', TRUE);
define('IS_FULLWIDTH', TRUE);
get_header();

?>
<?php if (have_posts()) : while(have_posts()) :
	the_post();
	get_template_part( 'templates/pagehead' );
	$page_content = get_the_content();
	if ($page_content) {
		$page_content = apply_filters('the_content', $page_content);
		$page_content = str_replace(']]>', ']]&gt;', $page_content);
		echo $page_content;
	}

endwhile; endif;?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<?php get_template_part( 'templates/blog_grid' ); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
