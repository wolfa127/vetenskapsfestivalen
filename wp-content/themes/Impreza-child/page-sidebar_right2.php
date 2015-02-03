<?php
/*
Template Name: Page: Right Sidebar Menu
*/
define('THEME_TEMPLATE', TRUE);
//define('THEME_TEMPLATE', TRUE);
define('SIDEBAR_POS', 'right');
get_header();
global $smof_data, $us_shortcodes;
function get_sidebar_menu() {

	$page_id  = get_queried_object_id(); // Get current page id
	$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $page_id . '&echo=0' );

	if($childpages)
		return '<h6>'.get_the_title().'</h6><ul>' . $childpages . '</ul>';

	$args = array(
		'sort_order' => 'ASC',
		'sort_column' => 'post_title',
		'hierarchical' => 1,
		'exclude' => '',
		'include' => $page_id,
		'meta_key' => '',
		'meta_value' => '',
		'authors' => '',
		'child_of' => 0,
		'parent' => -1,
		'exclude_tree' => '',
		'number' => '',
		'offset' => 0,
		'post_type' => 'page',
		'post_status' => 'publish'
	);
	$pages = get_pages($args);

	$parentID = $pages[0]->post_parent; // Get current page parent id

	$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $parentID . '&echo=0' );

	if ( $childpages ) {
		$string = '<h6>'. get_the_title($parentID) .'</h6><ul>' . $childpages . '</ul>';
	}
	return $string;
}
?>

<?php if (have_posts()) { while(have_posts()) { the_post(); ?>
	<?php get_template_part( 'templates/pagehead' ); ?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<?php the_content(); ?>

			</div>
			<div class="l-sidebar at_left">

			</div>

			<div class="l-sidebar at_right sidebar_menu">
				<?php echo get_sidebar_menu(); ?>
			</div>
		</div>
	</div>

<?php }  } else { ?>
	<?php _e('No posts were found.', 'us'); ?>
<?php } ?>
<?php get_footer(); ?>