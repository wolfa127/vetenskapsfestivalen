<?php

if ( ! function_exists('portfolioAjaxPagination'))
{
	function portfolioAjaxPagination() {
		global $smof_data, $us_thumbnail_size;

		$ratio_vals = array(
			'3-2',
			'4-3',
			'1-1',
			'2-3',
			'3-4',
		);

		$columns_vals = array (
			5, 4, 3, 2,
		);

		$style_vals = array(
			'type_1',
			'type_2',
			'type_3',
			'type_4',
			'type_5',
			'type_6',
			'type_7',
			'type_8',
			'type_9',
			'type_10',
		);

		$meta_vals = array (
			'date',
			'category',
		);

		$align_vals = array (
			'left',
			'center',
			'right',
		);

		if (isset($_POST['columns']) AND in_array($_POST['columns'], $columns_vals)) {
			$columns = $_POST['columns'];
		} else {
			$columns = 3;
		}

		if (isset($_POST['ratio']) AND in_array($_POST['ratio'], $ratio_vals)) {
			$ratio = $_POST['ratio'];
		} else {
			$ratio = '3-2';
		}

		if (isset($_POST['style']) AND in_array($_POST['style'], $style_vals)) {
			$style = $_POST['style'];
		} else {
			$style = 'type_1';
		}

		if (isset($_POST['meta']) AND in_array($_POST['meta'], $meta_vals)) {
			$meta = $_POST['meta'];
		} else {
			$meta = '';
		}

		if (isset($_POST['align']) AND in_array($_POST['align'], $align_vals)) {
			$align = $_POST['align'];
		} else {
			$align = 'left';
		}
		$portfolio_items = (is_integer(intval($_POST['items'])) AND intval($_POST['items']) > 0)?intval($_POST['items']):$columns;


		if (isset($_POST['page']) AND $_POST['page'] > 1)
		{
			$page = $_POST['page'];
		}
		else
		{
			return;
		}

		$args = array(
			'post_type' 		=> 'us_portfolio',
			'posts_per_page' 	=> $portfolio_items,
			'post_status' 		=> 'publish',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			'paged' 			=> $page
		);

		$categories_slugs = null;

		if ( ! empty($_POST['category']))
		{
			$categories_slugs = explode(',', $_POST['category']);
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'us_portfolio_category',
					'field' => 'slug',
					'terms' => $categories_slugs
				)
			);
		}

		$wp_query = new WP_Query();

		$lang_param = '';

		if (defined('ICL_LANGUAGE_CODE'))
		{
			$args['lang'] = ICL_LANGUAGE_CODE;
		}

		$wp_query->query($args);

		$output = '';

		while ($wp_query->have_posts())
		{
			$wp_query->the_post();
			$item_categories_links = '';
			$item_categories_classes = '';
			$item_categories = get_the_terms(get_the_ID(), 'us_portfolio_category');
			if (is_array($item_categories))
			{
				foreach ($item_categories as $item_category)
				{
					$item_categories_links .= $item_category->name.' / ';
					$item_categories_classes .= ' '.$item_category->slug;
				}
			}
			if (function_exists('mb_strlen'))
			{
				if (mb_strlen($item_categories_links) > 0 )
				{
					$item_categories_links = mb_substr($item_categories_links, 0, -2);
				}
			}
			else
			{
				if (strlen($item_categories_links) > 0 )
				{
					$item_categories_links = substr($item_categories_links, 0, -2);
				}
			}

			$link_ref = $link_target = '';
			$link = esc_url( apply_filters( 'the_permalink', get_permalink() ) );

			if (rwmb_meta('us_custom_link') != ''){
				$link = rwmb_meta('us_custom_link');
				if (rwmb_meta('us_custom_link_blank') == 1){
					$link_target = ' target="_blank"';
				}
			}

			if (rwmb_meta('us_lightbox') == 1){
				$img_id = get_post_thumbnail_id();
				$link = wp_get_attachment_image_src($img_id, 'full');
				$link = $link[0];
				$link_ref = ' ref="magnificPopup"';
			}

			$meta_html = '';

			if ($meta == 'date') {
				$meta_html = get_the_date();
			} elseif ($meta == 'category') {
				$meta_html = $item_categories_links;
			}

			$anchor_css = '';
			if (rwmb_meta('us_title_bg_color') != '') {
				$anchor_css .= ' background-color: '.rwmb_meta('us_title_bg_color').';';
			}
			if (rwmb_meta('us_title_text_color') != '') {
				$anchor_css .= ' color: '.rwmb_meta('us_title_text_color').';';
			}
			if ($anchor_css != '') {
				$anchor_css = ' style="'.$anchor_css.'"';
			}

			$output .= '<div class="w-portfolio-item order_'.$item_categories_classes.'">
							<div class="w-portfolio-item-h">
								<a class="w-portfolio-item-anchor"'.$link_target.$link_ref.' href="'.$link.'"'.$anchor_css.'>
									<div class="w-portfolio-item-image">';
			if (has_post_thumbnail()) {
				$output .= get_the_post_thumbnail(null, 'portfolio-list-'.$ratio, array('class' => 'w-portfolio-item-image-first'));
			} else {
				$output .= '<img class="w-portfolio-item-image-first" src="'.get_template_directory_uri().'/img/placeholder/500x500.gif" alt="">';
			}

			$additional_image = '';
			if (rwmb_meta('us_additional_image') != '')
			{
				$additional_img_id = preg_replace('/[^\d]/', '', rwmb_meta('us_additional_image'));
				$additional_img = wp_get_attachment_image_src($additional_img_id, 'portfolio-list-'.$ratio, 0);

				if ( $additional_img != NULL )
				{
					$additional_image = $additional_img[0];
				}
			}
			if ($additional_image != '')
			{
				$output .= '<img class="w-portfolio-item-image-second" src="'.$additional_image.'" alt="">';
			}
			$output .= '	</div>
									<div class="w-portfolio-item-meta">
										<div class="w-portfolio-item-meta-h">
											<h2 class="w-portfolio-item-title">'.the_title('','', FALSE).'</h2>
											<span class="w-portfolio-item-arrow"></span>
											<span class="w-portfolio-item-text">'.$meta_html.'</span>
										</div>
									</div>
								</a>
							</div>
						</div>';
		}

		echo $output;

		die();

	}

	add_action( 'wp_ajax_nopriv_portfolioAjaxPagination', 'portfolioAjaxPagination' );
	add_action( 'wp_ajax_portfolioAjaxPagination', 'portfolioAjaxPagination' );
}
