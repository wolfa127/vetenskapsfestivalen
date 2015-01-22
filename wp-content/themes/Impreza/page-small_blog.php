<?php
/*
Template Name: Blog: Small Image
*/
define('THEME_TEMPLATE', TRUE);
global $smof_data, $us_shortcodes;
define('IS_BLOG', TRUE);
if ($smof_data['blog_sidebar_pos'] == 'No Sidebar') {
	define('IS_FULLWIDTH', TRUE);
}
get_header();

// Disabling Section shortcode
global $disable_section_shortcode;
$disable_section_shortcode = TRUE;
?>
<?php if (have_posts()) : while(have_posts()) :
	the_post();
	get_template_part( 'templates/pagehead' );
	$page_content = get_the_content();
	$page_content = apply_filters('the_content', $page_content);
	$page_content = str_replace(']]>', ']]&gt;', $page_content);
endwhile; endif;?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<?php echo $page_content; ?>
				<?php get_template_part( 'templates/blog_small' ); ?>
			</div>
			<div class="l-sidebar at_left">
				<?php if ($smof_data['blog_sidebar_pos'] != 'Right') generated_dynamic_sidebar(); ?>
			</div>

			<div class="l-sidebar at_right">
				<?php if ($smof_data['blog_sidebar_pos'] == 'Right') generated_dynamic_sidebar(); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>