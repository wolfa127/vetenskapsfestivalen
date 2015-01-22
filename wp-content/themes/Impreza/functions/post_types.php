<?php
add_action( 'init', 'create_post_types' );

if ( ! function_exists('create_post_types')) {
	function create_post_types() {
		global $smof_data;
		// Portfolio post type
		register_post_type( 'us_portfolio',
			array(
				'labels' => array(
					'name' => 'Portfolio Items',
					'singular_name' => 'Portfolio Item',
					'add_new' => 'Add Portfolio Item',
				),
				'public' => true,
//                'has_archive' => true,
				'rewrite' => array('slug' => empty($smof_data['portfolio_slug'])?'us_portfolio':$smof_data['portfolio_slug']),
				'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'comments'),
				'can_export' => true,
			)
		);

		// Clients post type
		register_post_type( 'us_client',
			array(
				'labels' => array(
					'name' => 'Clients Logos',
					'singular_name' => 'Client Logo',
					'add_new' => 'Add Client Logo',
				),
				'public' => false,
				'publicly_queryable' => false,
				'exclude_from_search' => false,
				'show_in_nav_menus' => false,
				'show_ui' => true,
				'has_archive' => false,
				'query_var' => false,
				'supports' => array('title', 'thumbnail'),
				'can_export' => true,
			)
		);

	}

	// Portfolio categories
	register_taxonomy('us_portfolio_category', array('us_portfolio'), array('hierarchical' => true, 'label' => 'Portfolio Categories','singular_label' => 'Portfolio Category', 'rewrite' => true));

	function portfolio_add_taxonomy_filters() {
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'us_portfolio_category' );

		// must set this to the post type you want the filter(s) displayed on
		if ( $typenow == 'portfolio' ) {

			foreach ( $taxonomies as $tax_slug ) {
				$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				if ( count( $terms ) > 0) {
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}
	}
}

add_filter( 'the_password_form', 'custom_password_form' );
function custom_password_form() {
	global $post;
	$output = '<form class="w-form protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
				<div class="w-form-row">
					<div class="w-form-label">
						<label>' . 'This post is password protected. To view it please enter your password below' . '</label>
					</div>
					<div class="w-form-field">
						<input type="password" value="" name="post_password"/><i class="fa fa-lock"></i>
					</div>
					<div class="w-form-field">
						<input class="g-btn" type="submit" value="'.'Submit' .'" />
					</div>
				</div>
			</form>';
	return $output;
}

add_action( 'admin_head', 'us_portfolio_icons' );

function us_portfolio_icons() {
	?>
	<style type="text/css" media="screen">
		#adminmenu #menu-posts-us_portfolio .menu-icon-post div.wp-menu-image:before {
			content: "\f232";
			}
		#adminmenu #menu-posts-us_client .menu-icon-post div.wp-menu-image:before {
			content: "\f313";
			}
	</style>
<?php }
