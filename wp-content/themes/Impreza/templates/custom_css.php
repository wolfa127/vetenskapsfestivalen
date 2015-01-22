<?php
global $smof_data, $output_styles_to_file;

// Compatibility with the previous version
if ( ! isset($smof_data['heading_font_family']) AND isset($smof_data['heading_font'])){
	$smof_data['heading_font_family'] = $smof_data['heading_font'];
}
if ( ! isset($smof_data['body_font_family']) AND isset($smof_data['body_text_font'])){
	$smof_data['body_font_family'] = $smof_data['body_text_font'];
}
if ( ! isset($smof_data['nav_font_family']) AND isset($smof_data['navigation_font'])){
	$smof_data['nav_font_family'] = $smof_data['navigation_font'];
}

$font_weights = array('200', '300', '400', '600', '700');
$prefixes = array('heading', 'body', 'nav');
foreach ( $prefixes as $prefix ){
	// Default font-family
	if ( ! isset($smof_data[$prefix.'_font_family']) OR $smof_data[$prefix.'_font_family'] == '') {
		$smof_data[$prefix.'_font_family'] = 'none';
	}
	// Add quotes for custom font namings
	elseif(strpos($smof_data[$prefix.'_font_family'], ',') === FALSE){
		$smof_data[$prefix.'_font_family'] = "'".$smof_data[$prefix.'_font_family']."'";
	}
	// Default font-weight
	$smof_data[$prefix.'_font_weight'] = '400';
	foreach ( $font_weights as $font_weight ) {
		if (isset($smof_data[$prefix.'_font_weight_'.$font_weight]) AND $smof_data[$prefix.'_font_weight_'.$font_weight] == 1) {
			$smof_data[$prefix.'_font_weight'] = $font_weight;
			break;
		}
	}
}

// Fault tolerance for missing options
$default_options = array(
	'nav_fontsize' => 16,
	'subnav_fontsize' => 14,
	'nav_fontsize_mobile' => 16,
	'subnav_fontsize_mobile' => 15,
	'regular_fontsize' => 14,
	'regular_lineheight' => 24,
	'regular_fontsize_mobile' => 13,
	'regular_lineheight_mobile' => 21,
	'h1_fontsize' => 38,
	'h2_fontsize' => 32,
	'h3_fontsize' => 26,
	'h4_fontsize' => 22,
	'h5_fontsize' => 20,
	'h6_fontsize' => 18,
	'h1_fontsize_mobile' => 30,
	'h2_fontsize_mobile' => 26,
	'h3_fontsize_mobile' => 22,
	'h4_fontsize_mobile' => 20,
	'h5_fontsize_mobile' => 18,
	'h6_fontsize_mobile' => 16,
);
foreach ( $default_options as $option_key => $option_value ) {
	if (empty($smof_data[$option_key])) {
		$smof_data[$option_key] = $option_value;
	}
}
?>
<?php if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE): ?>
<style id="us_fonts_inline">
<?php endif; ?>
body {
	<?php if ($smof_data['body_font_family'] != 'none'): ?>
	font-family: <?php echo $smof_data['body_font_family']; ?>;
	<?php endif; ?>
	font-size: <?php echo $smof_data['regular_fontsize']; ?>px;
	line-height: <?php echo $smof_data['regular_lineheight']; ?>px;
	font-weight: <?php echo $smof_data['body_font_weight']; ?>;
	}
.page-template-page-blank-php .l-main {
	font-size: <?php echo $smof_data['regular_fontsize']; ?>px;
	}

.l-header .w-nav-item {
	<?php if ($smof_data['nav_font_family'] != 'none'): ?>
	font-family: <?php echo $smof_data['nav_font_family']; ?>;
	<?php endif; ?>
	font-weight: <?php echo $smof_data['nav_font_weight']; ?>;
	}
.l-header .touch_disabled .w-nav-anchor.level_1,
.touch_disabled [class*="columns"] .has_sublevel .w-nav-anchor.level_2 {
	font-size: <?php echo $smof_data['nav_fontsize']; ?>px;
	}
.l-header .touch_disabled .w-nav-anchor.level_2,
.l-header .touch_disabled .w-nav-anchor.level_3 {
	font-size: <?php echo $smof_data['subnav_fontsize']; ?>px;
	}
.l-header .touch_enabled .w-nav-anchor.level_1 {
	font-size: <?php echo $smof_data['nav_fontsize_mobile']; ?>px;
	}
.l-header .touch_enabled .w-nav-anchor.level_2,
.l-header .touch_enabled .w-nav-anchor.level_3 {
	font-size: <?php echo $smof_data['subnav_fontsize_mobile']; ?>px;
	}

h1, h2, h3, h4, h5, h6,
.w-counter-number,
.w-logo-title,
.w-pricing-item-title,
.w-pricing-item-price,
.w-shortblog-entry-meta-date-day {
	<?php if ($smof_data['heading_font_family'] != 'none'): ?>
	font-family: <?php echo $smof_data['heading_font_family']; ?>;
	<?php endif; ?>
	font-weight: <?php echo $smof_data['heading_font_weight']; ?>;
	}
h1 {
	font-size: <?php echo $smof_data['h1_fontsize']; ?>px;
	}
h2 {
	font-size: <?php echo $smof_data['h2_fontsize']; ?>px;
	}
h3 {
	font-size: <?php echo $smof_data['h3_fontsize']; ?>px;
	}
h4, .widgettitle, .comment-reply-title {
	font-size: <?php echo $smof_data['h4_fontsize']; ?>px;
	}
h5, .w-portfolio-item-title {
	font-size: <?php echo $smof_data['h5_fontsize']; ?>px;
	}
h6 {
	font-size: <?php echo $smof_data['h6_fontsize']; ?>px;
	}
@media only screen and (max-width: 767px) {
body {
	font-size: <?php echo $smof_data['regular_fontsize_mobile']; ?>px;
	line-height: <?php echo $smof_data['regular_lineheight_mobile']; ?>px;
	}
h1 {
	font-size: <?php echo $smof_data['h1_fontsize_mobile']; ?>px;
	}
h2 {
	font-size: <?php echo $smof_data['h2_fontsize_mobile']; ?>px;
	}
h3 {
	font-size: <?php echo $smof_data['h3_fontsize_mobile']; ?>px;
	}
h4, .widgettitle, .comment-reply-title {
	font-size: <?php echo $smof_data['h4_fontsize_mobile']; ?>px;
	}
h5, .w-portfolio-item-title {
	font-size: <?php echo $smof_data['h5_fontsize_mobile']; ?>px;
	}
h6 {
	font-size: <?php echo $smof_data['h6_fontsize_mobile']; ?>px;
	}
}
<?php if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE): ?>
</style>
<style id="us_colors_inline">
<?php endif; ?>
/*************************** BODY ***************************/

/* Body Background Color */
.l-body {
	background-color: <?php echo ($smof_data['body_bg'] != '')?$smof_data['body_bg']:'#eee'; ?>;
	}

/*************************** HEADER ***************************/

/* Header Background Color */
.l-subheader.at_middle,
.l-subheader.at_middle .w-lang-list,
.l-subheader.at_middle .touch_enabled .w-nav-list.level_1 {
	background-color: <?php echo ($smof_data['header_bg'] != '')?$smof_data['header_bg']:'#fff'; ?>;
	}

/* Header Text Color */
.l-subheader.at_middle,
.transparent .l-subheader.at_middle .touch_enabled .w-nav-list.level_1 {
	color: <?php echo ($smof_data['header_text'] != '')?$smof_data['header_text']:'#666'; ?>;
	}

/* Header Text Hover Color */
.no-touch .w-logo-link:hover,
.no-touch .l-subheader.at_middle .w-contacts-item-value a:hover,
.no-touch .l-subheader.at_middle .w-lang-item:hover,
.no-touch .l-subheader.at_middle .w-cart:hover .w-cart-link,
.no-touch .l-subheader.at_middle .w-search-show:hover,
.l-subheader.at_middle .w-cart-quantity {
	color: <?php echo ($smof_data['header_text_hover'] != '')?$smof_data['header_text_hover']:'#d13a7a'; ?>;
	}

/* Extended Header Background Color */
.l-subheader.at_top,
.l-subheader.at_top .w-lang-list,
.l-subheader.at_bottom,
.l-subheader.at_bottom .touch_enabled .w-nav-list.level_1 {
	background-color: <?php echo ($smof_data['header_ext_bg'] != '')?$smof_data['header_ext_bg']:'#f5f5f5'; ?>;
	}

/* Extended Header Text Color */
.l-subheader.at_top,
.l-subheader.at_bottom,
.transparent .l-subheader.at_bottom .touch_enabled .w-nav-list.level_1,
.w-lang.active .w-lang-item {
	color: <?php echo ($smof_data['header_ext_text'] != '')?$smof_data['header_ext_text']:'#999'; ?>;
	}

/* Extended Header Text Hover Color */
.no-touch .l-subheader.at_top .w-contacts-item-value a:hover,
.no-touch .l-subheader.at_top .w-lang-item:hover,
.no-touch .l-subheader.at_bottom .w-cart:hover .w-cart-link,
.no-touch .l-subheader.at_bottom .w-search-show:hover,
.l-subheader.at_bottom .w-cart-quantity {
	color: <?php echo ($smof_data['header_ext_text_hover'] != '')?$smof_data['header_ext_text_hover']:'#d13a7a'; ?>;
	}

/* Search Screen Background Color */
.l-subheader .w-search-form:before {
	background-color: <?php echo ($smof_data['search_bg'] != '')?$smof_data['search_bg']:'#d13a7a'; ?>;
	}

/* Search Screen Text Color */
.l-subheader .w-search-form {
	color: <?php echo ($smof_data['search_text'] != '')?$smof_data['search_text']:'#fff'; ?>;
	}

/*************************** MAIN MENU ***************************/

/* Menu Hover Background Color */
.no-touch .l-header .w-nav-item.level_1:hover .w-nav-anchor.level_1 {
	background-color: <?php echo ($smof_data['menu_hover_bg'] != '')?$smof_data['menu_hover_bg']:'#fff'; ?>;
	}

/* Menu Hover Text Color */
.no-touch .l-header .w-nav-item.level_1:hover .w-nav-anchor.level_1 {
	color: <?php echo ($smof_data['menu_hover_text'] != '')?$smof_data['menu_hover_text']:'#d13a7a'; ?>;
	}
.w-nav-title:after {
	background-color: <?php echo ($smof_data['menu_hover_text'] != '')?$smof_data['menu_hover_text']:'#d13a7a'; ?>;
	}

/* Menu Active Background Color */
.l-header .w-nav-item.level_1.current-menu-item .w-nav-anchor.level_1,
.l-header .w-nav-item.level_1.current-menu-ancestor .w-nav-anchor.level_1 {
	background-color: <?php echo ($smof_data['menu_active_bg'] != '')?$smof_data['menu_active_bg']:'#fff'; ?>;
	}

/* Menu Active Text Color */
.l-header .w-nav-item.level_1.current-menu-item .w-nav-anchor.level_1,
.l-header .w-nav-item.level_1.current-menu-ancestor .w-nav-anchor.level_1 {
	color: <?php echo ($smof_data['menu_active_text'] != '')?$smof_data['menu_active_text']:'#d13a7a'; ?>;
	}

/* Dropdown Background Color */
.l-header .w-nav-list.level_2,
.l-header .w-nav-list.level_3 {
	background-color: <?php echo ($smof_data['drop_bg'] != '')?$smof_data['drop_bg']:'#fff'; ?>;
	}

/* Dropdown Text Color */
.l-header .w-nav-anchor.level_2,
.l-header .w-nav-anchor.level_3,
.touch_disabled [class*="columns"] .w-nav-item.has_sublevel.current-menu-item .w-nav-anchor.level_2,
.touch_disabled [class*="columns"] .w-nav-item.has_sublevel.current-menu-ancestor .w-nav-anchor.level_2,
.no-touch .touch_disabled [class*="columns"] .w-nav-item.has_sublevel:hover .w-nav-anchor.level_2 {
	color: <?php echo ($smof_data['drop_text'] != '')?$smof_data['drop_text']:'#666'; ?>;
	}

/* Dropdown Hover Background Color */
.no-touch .l-header .w-nav-item.level_2:hover .w-nav-anchor.level_2,
.no-touch .l-header .w-nav-item.level_3:hover .w-nav-anchor.level_3 {
	background-color: <?php echo ($smof_data['drop_hover_bg'] != '')?$smof_data['drop_hover_bg']:'#d13a7a'; ?>;
	}

/* Dropdown Hover Text Color */
.no-touch .l-header .w-nav-item.level_2:hover .w-nav-anchor.level_2,
.no-touch .l-header .w-nav-item.level_3:hover .w-nav-anchor.level_3 {
	color: <?php echo ($smof_data['drop_hover_text'] != '')?$smof_data['drop_hover_text']:'#fff'; ?>;
	}

/* Dropdown Active Background Color */
.l-header .w-nav-item.level_2.current-menu-item .w-nav-anchor.level_2,
.l-header .w-nav-item.level_2.current-menu-ancestor .w-nav-anchor.level_2,
.l-header .w-nav-item.level_3.current-menu-item .w-nav-anchor.level_3,
.l-header .w-nav-item.level_3.current-menu-ancestor .w-nav-anchor.level_3 {
	background-color: <?php echo ($smof_data['drop_active_bg'] != '')?$smof_data['drop_active_bg']:'#fff'; ?>;
	}

/* Dropdown Active Text Color */
.l-header .w-nav-item.level_2.current-menu-item .w-nav-anchor.level_2,
.l-header .w-nav-item.level_2.current-menu-ancestor .w-nav-anchor.level_2,
.l-header .w-nav-item.level_3.current-menu-item .w-nav-anchor.level_3,
.l-header .w-nav-item.level_3.current-menu-ancestor .w-nav-anchor.level_3 {
	color: <?php echo ($smof_data['drop_active_text'] != '')?$smof_data['drop_active_text']:'#d13a7a'; ?>;
	}

/* Menu Button Background Color */
.btn.w-nav-item .w-nav-anchor.level_1,
.headerpos_fixed .transparent .btn.w-nav-item .w-nav-anchor.level_1 {
	background-color: <?php echo ($smof_data['menu_button_bg'] != '')?$smof_data['menu_button_bg']:'#d13a7a'; ?> !important;
	}

/* Menu Button Text Color */
.btn.w-nav-item .w-nav-anchor.level_1 {
	color: <?php echo ($smof_data['menu_button_text'] != '')?$smof_data['menu_button_text']:'#fff'; ?> !important;
	}

/* Menu Button Hover Background Color */
.no-touch .btn.w-nav-item .w-nav-anchor.level_1:before {
	background-color: <?php echo ($smof_data['menu_button_hover_bg'] != '')?$smof_data['menu_button_hover_bg']:'#6254a8'; ?> !important;
	}

/* Menu Button Hover Text Color */
.no-touch .btn.w-nav-item .w-nav-anchor.level_1:hover {
	color: <?php echo ($smof_data['menu_button_hover_text'] != '')?$smof_data['menu_button_hover_text']:'#fff'; ?> !important;
	}

/*************************** MAIN CONTENT ***************************/

/* Background Color */
.l-canvas,
.w-blog.type_masonry .w-blog-entry-preview:before,
.w-cart-dropdown,
.w-filters-item.active,
.no-touch .w-filters-item.active:hover,
.w-portfolio-item-anchor,
.w-tabs-item.active,
.no-touch .w-tabs-item.active:hover,
.w-timeline-item,
.w-timeline-section-title,
.w-timeline.type_vertical .w-timeline-section-content,
#lang_sel ul ul,
.woocommerce div.product .woocommerce-tabs .tabs li.active,
.no-touch .woocommerce div.product .woocommerce-tabs .tabs li.active:hover,
.woocommerce .stars span:after,
.woocommerce .stars span a:after,
#bbp-user-navigation li.current {
	background-color: <?php echo ($smof_data['main_bg'] != '')?$smof_data['main_bg']:'#fff'; ?>;
	}
.g-btn.color_contrast,
.no-touch .g-btn.color_contrast:hover,
.no-touch .g-btn.color_contrast.outlined:hover,
.w-icon.color_border.with_circle .w-icon-link {
	color: <?php echo ($smof_data['main_bg'] != '')?$smof_data['main_bg']:'#fff'; ?>;
	}

/* Alternate Background Color */
input[type="text"],
input[type="password"],
input[type="email"],
input[type="url"],
input[type="tel"],
input[type="number"],
input[type="date"],
textarea,
select,
.w-actionbox.color_alternate,
.w-blog.imgpos_atleft .w-blog-entry-preview-icon,
.w-filters,
.w-icon.color_text.with_circle .w-icon-link,
.w-icon.color_fade.with_circle .w-icon-link,
.w-pricing-item-title,
.w-pricing-item-price,
.w-progbar-bar,
.w-tabs-list,
.no-touch .widget_nav_menu .menu-item a:hover,
.woocommerce .quantity .plus,
.woocommerce .quantity .minus,
.woocommerce div.product .woocommerce-tabs .tabs,
.woocommerce table.shop_table .actions .coupon .input-text,
.woocommerce #payment .payment_box,
#bbp-user-navigation,
#subscription-toggle,
#favorite-toggle,
.bbp-row-actions #favorite-toggle a,
.bbp-row-actions #subscription-toggle a {
	background-color: <?php echo ($smof_data['main_bg_alternative'] != '')?$smof_data['main_bg_alternative']:'#f2f2f2'; ?>;
	}
.woocommerce #payment .payment_box:after {
	border-color: <?php echo ($smof_data['main_bg_alternative'] != '')?$smof_data['main_bg_alternative']:'#f2f2f2'; ?>;
	}

/* Border Color */
.w-blog-entry,
.w-bloglist,
.w-comments,
.w-comments-item,
.w-pricing-item-h,
.w-sharing.type_simple .w-sharing-item,
.w-tabs.layout_accordion,
.w-tabs.layout_accordion .w-tabs-section,
.w-timeline.type_vertical .w-timeline-section-content,
#wp-calendar thead th,
#wp-calendar tbody td,
#wp-calendar tfoot td,
.widget_nav_menu .menu-item a,
#lang_sel a,
#lang_sel a:visited,
.woocommerce table th,
.woocommerce table td,
.woocommerce .login,
.woocommerce .checkout_coupon,
.woocommerce .register,
.woocommerce .cart.variations_form,
.woocommerce .commentlist,
.woocommerce .commentlist li,
.woocommerce .comment-respond,
.woocommerce .related,
.woocommerce .upsells,
.woocommerce .cross-sells,
.woocommerce .checkout #order_review,
.woocommerce ul.order_details li,
.woocommerce .shop_table.my_account_orders,
.widget_price_filter .ui-slider-handle,
.widget_layered_nav ul,
.widget_layered_nav ul li,
#bbpress-forums .bbp-body ul.forum,
#bbpress-forums .bbp-forums li.bbp-header,
#bbpress-forums .bbp-body ul.topic,
#bbpress-forums .bbp-topics li.bbp-header,
.bbp-replies .bbp-body,
div.bbp-forum-header,
div.bbp-topic-header,
div.bbp-reply-header,
.bbp-pagination-links a,
.bbp-pagination-links span.current,
span.bbp-topic-pagination a.page-numbers,
.bbp-logged-in,
fieldset {
	border-color: <?php echo ($smof_data['main_border'] != '')?$smof_data['main_border']:'#e8e8e8'; ?>;
	}
.g-hr-h i,
.page-404 i,
.w-icon.color_border .w-icon-link {
	color: <?php echo ($smof_data['main_border'] != '')?$smof_data['main_border']:'#e8e8e8'; ?>;
	}
.g-hr-h:before,
.g-hr-h:after,
.g-btn.color_default,
.g-btn.color_default.outlined:before,
.w-icon.color_border.with_circle .w-icon-link,
.w-timeline-list:before,
.woocommerce .button,
.no-touch .woocommerce .quantity .plus:hover,
.no-touch .woocommerce .quantity .minus:hover,
.widget_price_filter .ui-slider {
	background-color: <?php echo ($smof_data['main_border'] != '')?$smof_data['main_border']:'#e8e8e8'; ?>;
	}
.g-btn.color_default.outlined,
.g-pagination-item,
.w-socials-item-link,
.w-tags-item-link,
.w-team-links-item,
.w-testimonial,
.woocommerce-pagination a,
.woocommerce-pagination span {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['main_border'] != '')?$smof_data['main_border']:'#e8e8e8'; ?> inset;
	}

/* Heading Color */
h1, h2, h3, h4, h5, h6,
input[type="text"],
input[type="password"],
input[type="email"],
input[type="url"],
input[type="tel"],
input[type="number"],
input[type="date"],
textarea,
select,
.w-form-field > i,
.no-touch .g-btn.color_default:hover,
.no-touch .g-btn.color_default.outlined:hover,
.g-btn.color_contrast.outlined,
.w-blog-entry-title,
.w-counter-number,
.w-portfolio-item-anchor,
.no-touch a.w-portfolio-item-anchor:hover,
.l-submain.color_primary a.w-portfolio-item-anchor,
.l-submain.color_secondary a.w-portfolio-item-anchor,
.w-pricing-item-title,
.w-pricing-item-price,
.woocommerce .product .price {
	color: <?php echo ($smof_data['main_heading'] != '')?$smof_data['main_heading']:'#444'; ?>;
	}
.g-btn.color_contrast,
.g-btn.color_contrast.outlined:before {
	background-color: <?php echo ($smof_data['main_heading'] != '')?$smof_data['main_heading']:'#444'; ?>;
	}
.g-btn.color_contrast.outlined {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['main_heading'] != '')?$smof_data['main_heading']:'#444'; ?> inset;
	}

/* Text Color */
.l-canvas,
.g-btn.color_default,
.g-btn.color_default.outlined,
.w-cart-dropdown,
.w-icon.color_text .w-icon-link,
.color_primary .w-icon.color_text.with_circle .w-icon-link,
.woocommerce .button,
.l-subfooter.at_top .woocommerce .button {
	color: <?php echo ($smof_data['main_text'] != '')?$smof_data['main_text']:'#666'; ?>;
	}

/* Primary Color */
a,
.g-html .highlight,
.g-btn.color_primary.outlined,
.no-touch .w-blog-entry-link:hover .w-blog-entry-title-h,
.no-touch .w-blog-entry-link:hover,
.l-main .w-contacts-item i,
.w-counter.color_primary .w-counter-number,
.w-filters-item.active,
.no-touch .w-filters-item.active:hover,
.w-form-field > input:focus + i,
.w-form-field > textarea:focus + i,
.w-icon.color_primary .w-icon-link,
.w-iconbox-icon,
.no-touch .w-iconbox-link:hover .w-iconbox-title,
.no-touch .w-pagehead-nav-item:hover,
.w-tabs-item.active,
.no-touch .w-tabs-item.active:hover,
.w-tabs.layout_accordion .w-tabs-section.active .w-tabs-section-header,
.no-touch .w-tags-item-link:hover,
.w-team-link .w-team-name,
.no-touch .slick-prev:hover,
.no-touch .slick-next:hover,
.woocommerce .products .product .button,
.no-touch .woocommerce .products .product .button.loading:hover,
.woocommerce .star-rating span:before,
.woocommerce-breadcrumb a,
.woocommerce div.product .woocommerce-tabs .tabs li.active,
.no-touch .woocommerce div.product .woocommerce-tabs .tabs li.active:hover,
.woocommerce .stars span a:after,
.woocommerce .cart_totals .order-total,
.woocommerce .checkout .shop_table .order-total,
#subscription-toggle span.is-subscribed:before,
#favorite-toggle span.is-favorite:before {
	color: <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#d13a7a'; ?>;
	}
.l-submain.color_primary,
.w-actionbox.color_primary,
.g-btn.color_primary,
.g-btn.color_primary.outlined:before,
button,
input[type="submit"],
.g-pagination-item.active,
.no-touch .g-pagination-item:before,
.no-touch .w-iconbox.with_circle .w-iconbox-icon:before,
.no-touch .w-filters-item:hover,
.w-icon.color_primary.with_circle .w-icon-link,
.w-pricing-item.type_featured .w-pricing-item-title,
.w-pricing-item.type_featured .w-pricing-item-price,
.w-progbar.color_primary .w-progbar-bar-h,
.no-touch .w-team-links,
.w-timeline-item:before,
.w-timeline.type_vertical .w-timeline-section:before,
.w-timeline-section-title:before,
.w-timeline-section.active .w-timeline-section-title:before,
.no-touch .w-toplink.active:hover,
.no-touch .tp-leftarrow.custom:before,
.no-touch .tp-rightarrow.custom:before,
.widget_nav_menu .menu-item.current-menu-item > a,
.no-touch .widget_nav_menu .menu-item.current-menu-item > a:hover,
p.demo_store,
.gform_wrapper .gf_progressbar_percentage,
.woocommerce .button.alt,
.woocommerce .button.checkout,
.no-touch .woocommerce .products .product .button:hover,
.no-touch .woocommerce-pagination a:hover,
.woocommerce-pagination span.current,
.woocommerce .onsale,
.widget_price_filter .ui-slider-range,
.widget_layered_nav ul li.chosen,
.widget_layered_nav_filters ul li a,
.no-touch .bbp-pagination-links a:hover,
.bbp-pagination-links span.current,
.no-touch span.bbp-topic-pagination a.page-numbers:hover {
	background-color: <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#d13a7a'; ?>;
	}
.g-html blockquote,
.w-blog-entry.sticky,
.no-touch .w-clients-item-h:hover,
.w-filters-item.active,
.w-tabs-item.active,
.no-touch .w-tabs-item.active:hover,
.widget_nav_menu .menu-item.current-menu-item > a,
.fotorama__thumb-border,
.woocommerce div.product .woocommerce-tabs .tabs li.active,
.widget_layered_nav ul li.chosen,
.no-touch .bbp-pagination-links a:hover,
.bbp-pagination-links span.current,
.no-touch span.bbp-topic-pagination a.page-numbers:hover,
#bbp-user-navigation li.current {
	border-color: <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#d13a7a'; ?>;
	}
input[type="text"]:focus,
input[type="password"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="tel"]:focus,
input[type="number"]:focus,
input[type="date"]:focus,
textarea:focus,
select:focus,
#bbpress-forums div.bbp-the-content-wrapper textarea:focus {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#d13a7a'; ?>;
	}
.g-btn.color_primary.outlined,
.l-main .w-contacts-item i,
.w-iconbox.with_circle .w-iconbox-icon,
.no-touch .w-pagehead-nav-item:hover,
.no-touch .w-tags-item-link:hover,
.no-touch .w-testimonial:hover,
.w-timeline-item,
.w-timeline-section-title,
.no-touch .slick-prev:hover,
.no-touch .slick-next:hover,
.woocommerce .products .product .button,
.no-touch .woocommerce .products .product .button.loading:hover {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#d13a7a'; ?> inset;
	}

/* Secondary Color */
.no-touch a:hover,
.no-touch a:active,
.g-btn.color_secondary.outlined,
.no-touch .w-blog.type_masonry .w-blog-meta a:hover,
.w-counter.color_secondary .w-counter-number,
.w-icon.color_secondary .w-icon-link,
.no-touch .w-team-link:hover .w-team-name,
.no-touch .widget_archive ul li a:hover,
.no-touch .widget_categories ul li a:hover,
.no-touch .widget_tag_cloud .tagcloud a:hover,
.no-touch .woocommerce-breadcrumb a:hover,
.no-touch .widget_product_tag_cloud .tagcloud a:hover,
.no-touch .bbp_widget_login a.button.logout-link:hover {
	color: <?php echo ($smof_data['main_secondary'] != '')?$smof_data['main_secondary']:'#6254a8'; ?>;
	}
.l-submain.color_secondary,
.w-actionbox.color_secondary,
.g-btn.color_secondary,
.g-btn.color_secondary.outlined:before,
.w-icon.color_secondary.with_circle .w-icon-link,
.w-progbar.color_secondary .w-progbar-bar-h,
.no-touch .button:hover,
.no-touch input[type="submit"]:hover,
.no-touch .woocommerce .button:hover,
.no-touch .woocommerce .button.alt:hover,
.no-touch .woocommerce .button.checkout:hover,
.no-touch .woocommerce .shop_table.cart .product-remove a:hover,
.no-touch .widget_layered_nav_filters ul li a:hover,
.no-touch .bbp-row-actions #favorite-toggle a:hover,
.no-touch .bbp-row-actions #subscription-toggle a:hover {
	background-color: <?php echo ($smof_data['main_secondary'] != '')?$smof_data['main_secondary']:'#6254a8'; ?>;
	}
.g-btn.color_secondary.outlined {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['main_secondary'] != '')?$smof_data['main_secondary']:'#6254a8'; ?> inset;
	}

/* Fade Elements Color */
.w-blog-meta,
.w-blog-meta a,
.w-icon.color_fade .w-icon-link,
.no-touch .w-icon.color_fade.with_circle .w-icon-link:hover,
.widget_tag_cloud .tagcloud a,
.woocommerce-breadcrumb,
.woocommerce .star-rating:before,
.woocommerce .stars span:after,
.woocommerce table.shop_table .product-remove a.remove,
.widget_product_tag_cloud .tagcloud a,
p.bbp-topic-meta,
.bbp_widget_login a.button.logout-link {
	color: <?php echo ($smof_data['main_fade'] != '')?$smof_data['main_fade']:'#999'; ?>;
	}
.w-shortblog-entry-meta-date {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['main_fade'] != '')?$smof_data['main_fade']:'#999'; ?> inset;
	}

/*************************** ALTERNATE CONTENT ***************************/

/* Background Color */
.l-submain.color_alternate,
.color_alternate .w-blog.type_masonry .w-blog-entry-preview:before,
.color_alternate .w-filters-item.active,
.no-touch .color_alternate .w-filters-item.active:hover,
.color_alternate .w-tabs-item.active,
.no-touch .color_alternate .w-tabs-item.active:hover,
.color_alternate .w-timeline-item,
.color_alternate .w-timeline-section-title,
.color_alternate .w-timeline.type_vertical .w-timeline-section-content {
	background-color: <?php echo ($smof_data['alt_bg'] != '')?$smof_data['alt_bg']:'#f2f2f2'; ?>;
	}
.color_alternate .g-btn.color_contrast,
.no-touch .color_alternate .g-btn.color_contrast:hover,
.no-touch .color_alternate .g-btn.color_contrast.outlined:hover,
.color_alternate .w-icon.color_border.with_circle .w-icon-link {
	color: <?php echo ($smof_data['alt_bg'] != '')?$smof_data['alt_bg']:'#f2f2f2'; ?>;
	}

/* Alternate Background Color */
.color_alternate input[type="text"],
.color_alternate input[type="password"],
.color_alternate input[type="email"],
.color_alternate input[type="url"],
.color_alternate input[type="tel"],
.color_alternate input[type="number"],
.color_alternate input[type="date"],
.color_alternate textarea,
.color_alternate select,
.color_alternate .w-blog.imgpos_atleft .w-blog-entry-preview-icon,
.color_alternate .w-filters,
.color_alternate .w-icon.color_text.with_circle .w-icon-link,
.color_alternate .w-icon.color_fade.with_circle .w-icon-link,
.color_alternate .w-pricing-item-title,
.color_alternate .w-pricing-item-price,
.color_alternate .w-tabs-list {
	background-color: <?php echo ($smof_data['alt_bg_alternative'] != '')?$smof_data['alt_bg_alternative']:'#fff'; ?>;
	}

/* Border Color */
.color_alternate .w-blog-entry,
.color_alternate .w-bloglist,
.color_alternate .w-comments-item,
.color_alternate .w-pricing-item-h,
.color_alternate .w-tabs.layout_accordion,
.color_alternate .w-tabs.layout_accordion .w-tabs-section,
.color_alternate .w-timeline.type_vertical .w-timeline-section-content {
	border-color: <?php echo ($smof_data['alt_border'] != '')?$smof_data['alt_border']:'#ddd'; ?>;
	}
.color_alternate .g-hr-h i,
.color_alternate .page-404 i,
.color_alternate .w-icon.color_border .w-icon-link {
	color: <?php echo ($smof_data['alt_border'] != '')?$smof_data['alt_border']:'#ddd'; ?>;
	}
.color_alternate .g-hr-h:before,
.color_alternate .g-hr-h:after,
.color_alternate .g-btn.color_default,
.color_alternate .g-btn.color_default.outlined:before,
.color_alternate .w-icon.color_border.with_circle .w-icon-link,
.color_alternate .w-timeline-list:before {
	background-color: <?php echo ($smof_data['alt_border'] != '')?$smof_data['alt_border']:'#ddd'; ?>;
	}
.color_alternate .g-btn.color_default.outlined,
.color_alternate .g-pagination-item,
.color_alternate .w-socials-item-link,
.color_alternate .w-tags-item-link,
.color_alternate .w-team-links-item,
.color_alternate .w-testimonial {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['alt_border'] != '')?$smof_data['alt_border']:'#ddd'; ?> inset;
	}

/* Heading Color */
.color_alternate h1,
.color_alternate h2,
.color_alternate h3,
.color_alternate h4,
.color_alternate h5,
.color_alternate h6,
.color_alternate input[type="text"],
.color_alternate input[type="password"],
.color_alternate input[type="email"],
.color_alternate input[type="url"],
.color_alternate input[type="tel"],
.color_alternate input[type="number"],
.color_alternate input[type="date"],
.color_alternate textarea,
.color_alternate select,
.color_alternate .w-form-field > i,
.no-touch .color_alternate .g-btn.color_default:hover,
.no-touch .color_alternate .g-btn.color_default.outlined:hover,
.color_alternate .g-btn.color_contrast.outlined,
.color_alternate .w-blog-entry-title,
.color_alternate .w-counter-number,
.color_alternate .w-pricing-item-title,
.color_alternate .w-pricing-item-price {
	color: <?php echo ($smof_data['alt_heading'] != '')?$smof_data['alt_heading']:'#333'; ?>;
	}
.color_alternate .g-btn.color_contrast,
.color_alternate .g-btn.color_contrast.outlined:before {
	background-color: <?php echo ($smof_data['alt_heading'] != '')?$smof_data['alt_heading']:'#333'; ?>;
	}
.color_alternate .g-btn.color_contrast.outlined {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['alt_heading'] != '')?$smof_data['alt_heading']:'#333'; ?> inset;
	}

/* Text Color */
.l-submain.color_alternate,
.color_alternate .g-btn.color_default,
.color_alternate .g-btn.color_default.outlined,
.color_alternate .w-icon.color_text .w-icon-link {
	color: <?php echo ($smof_data['alt_text'] != '')?$smof_data['alt_text']:'#555'; ?>;
	}

/* Primary Color */
.color_alternate a,
.color_alternate .g-btn.color_primary.outlined,
.no-touch .color_alternate .w-blog-entry-link:hover .w-blog-entry-title-h,
.no-touch .color_alternate .w-blog-entry-link:hover,
.color_alternate .l-main .w-contacts-item i,
.color_alternate .w-counter.color_primary .w-counter-number,
.color_alternate .w-filters-item.active,
.no-touch .color_alternate .w-filters-item.active:hover,
.color_alternate .w-icon.color_primary .w-icon-link,
.color_alternate .w-iconbox-icon,
.no-touch .color_alternate .w-iconbox-link:hover .w-iconbox-title,
.no-touch .color_alternate .w-pagehead-nav-item:hover,
.color_alternate .w-tabs-item.active,
.no-touch .color_alternate .w-tabs-item.active:hover,
.color_alternate .w-tabs.layout_accordion .w-tabs-section.active .w-tabs-section-header,
.no-touch .color_alternate .w-tags-item-link:hover,
.color_alternate .w-team-link .w-team-name {
	color: <?php echo ($smof_data['alt_primary'] != '')?$smof_data['alt_primary']:'#d13a7a'; ?>;
	}
.color_alternate .g-btn.color_primary,
.color_alternate .g-btn.color_primary.outlined:before,
.color_alternate input[type="submit"],
.color_alternate .g-pagination-item.active,
.no-touch .color_alternate .g-pagination-item:before,
.no-touch .color_alternate .w-iconbox.with_circle .w-iconbox-icon:before,
.no-touch .color_alternate .w-filters-item:hover,
.color_alternate .w-icon.color_primary.with_circle .w-icon-link,
.color_alternate .w-pricing-item.type_featured .w-pricing-item-title,
.color_alternate .w-pricing-item.type_featured .w-pricing-item-price,
.no-touch .color_alternate .w-team-links,
.color_alternate .w-timeline-item:before,
.color_alternate .w-timeline.type_vertical .w-timeline-section:before,
.color_alternate .w-timeline-section-title:before,
.color_alternate .w-timeline-section.active .w-timeline-section-title:before {
	background-color: <?php echo ($smof_data['alt_primary'] != '')?$smof_data['alt_primary']:'#d13a7a'; ?>;
	}
.color_alternate .g-html blockquote,
.color_alternate .w-blog-entry.sticky,
.color_alternate .w-filters-item.active,
.color_alternate .w-tabs-item.active,
.no-touch .color_alternate .w-tabs-item.active:hover {
	border-color: <?php echo ($smof_data['alt_primary'] != '')?$smof_data['alt_primary']:'#d13a7a'; ?>;
	}
.color_alternate input[type="text"]:focus,
.color_alternate input[type="password"]:focus,
.color_alternate input[type="email"]:focus,
.color_alternate input[type="url"]:focus,
.color_alternate input[type="tel"]:focus,
.color_alternate input[type="number"]:focus,
.color_alternate input[type="date"]:focus,
.color_alternate textarea:focus,
.color_alternate select:focus {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['alt_primary'] != '')?$smof_data['alt_primary']:'#d13a7a'; ?>;
	}
.color_alternate .g-btn.color_primary.outlined,
.color_alternate .l-main .w-contacts-item i,
.color_alternate .w-iconbox.with_circle .w-iconbox-icon,
.no-touch .color_alternate .w-pagehead-nav-item:hover,
.no-touch .color_alternate .w-tags-item-link:hover,
.no-touch .color_alternate .w-testimonial:hover,
.color_alternate .w-timeline-item:before,
.color_alternate .w-timeline-section-title:before {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['alt_primary'] != '')?$smof_data['alt_primary']:'#d13a7a'; ?> inset;
	}

/* Secondary Color */
.no-touch .color_alternate a:hover,
.no-touch .color_alternate a:active,
.color_alternate .g-btn.color_secondary.outlined,
.no-touch .color_alternate .w-blog.type_masonry .w-blog-meta a:hover,
.color_alternate .w-counter.color_secondary .w-counter-number,
.color_alternate .w-icon.color_secondary .w-icon-link,
.no-touch .color_alternate .w-team-link:hover .w-team-name {
	color: <?php echo ($smof_data['alt_secondary'] != '')?$smof_data['alt_secondary']:'#6254a8'; ?>;
	}
.color_alternate .g-btn.color_secondary,
.color_alternate .g-btn.color_secondary.outlined:before,
.color_alternate .w-icon.color_secondary.with_circle .w-icon-link {
	background-color: <?php echo ($smof_data['alt_secondary'] != '')?$smof_data['alt_secondary']:'#6254a8'; ?>;
	}
.color_alternate .g-btn.color_secondary.outlined {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['alt_secondary'] != '')?$smof_data['alt_secondary']:'#6254a8'; ?> inset;
	}

/* Fade Elements Color */
.color_alternate .w-blog-meta,
.color_alternate .w-blog-meta a,
.color_alternate .w-bloglist-entry-date,
.color_alternate .w-bloglist-entry-author,
.color_alternate .w-icon.color_fade .w-icon-link {
	color: <?php echo ($smof_data['alt_fade'] != '')?$smof_data['alt_fade']:'#999'; ?>;
	}
.color_alternate .w-shortblog-entry-meta-date {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['alt_fade'] != '')?$smof_data['alt_fade']:'#999'; ?> inset;
	}

/*************************** SUBFOOTER ***************************/

/* Background Color */
.l-subfooter.at_top,
.l-subfooter.at_top #lang_sel ul ul {
	background-color: <?php echo ($smof_data['subfooter_bg'] != '')?$smof_data['subfooter_bg']:'#1a1a1a'; ?>;
	}

/* Border Color */
.l-subfooter.at_top,
.l-subfooter.at_top #wp-calendar thead th,
.l-subfooter.at_top #wp-calendar tbody td,
.l-subfooter.at_top #wp-calendar tfoot td,
.l-subfooter.at_top #lang_sel a,
.l-subfooter.at_top #lang_sel a:visited,
.l-subfooter.at_top .widget_nav_menu .menu-item a {
	border-color: <?php echo ($smof_data['subfooter_border'] != '')?$smof_data['subfooter_border']:'#222'; ?>;
	}
.l-subfooter.at_top .w-socials-item-link {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['subfooter_border'] != '')?$smof_data['subfooter_border']:'#222'; ?> inset;
	}

/* Text Color */
.l-subfooter.at_top,
.l-subfooter.at_top .w-socials-item-link {
	color: <?php echo ($smof_data['subfooter_text'] != '')?$smof_data['subfooter_text']:'#808080'; ?>;
	}

/* Heading Color */
.l-subfooter.at_top h1,
.l-subfooter.at_top h2,
.l-subfooter.at_top h3,
.l-subfooter.at_top h4,
.l-subfooter.at_top h5,
.l-subfooter.at_top h6 {
	color: <?php echo ($smof_data['subfooter_heading'] != '')?$smof_data['subfooter_heading']:'#ccc'; ?>;
	}

/* Link Color */
.l-subfooter.at_top a,
.l-subfooter.at_top .widget_tag_cloud .tagcloud a,
.l-subfooter.at_top .widget_product_tag_cloud .tagcloud a {
	color: <?php echo ($smof_data['subfooter_link'] != '')?$smof_data['subfooter_link']:'#ccc'; ?>;
	}

/* Link Hover Color */
.no-touch .l-subfooter.at_top a:hover,
.no-touch .l-subfooter.at_top .widget_tag_cloud .tagcloud a:hover,
.no-touch .l-subfooter.at_top .widget_product_tag_cloud .tagcloud a:hover {
	color: <?php echo ($smof_data['subfooter_link_hover'] != '')?$smof_data['subfooter_link_hover']:'#fff'; ?>;
	}

/*************************** FOOTER ***************************/

/* Background Color */
.l-subfooter.at_bottom {
	background-color: <?php echo ($smof_data['footer_bg'] != '')?$smof_data['footer_bg']:'#222'; ?>;
	}

/* Text Color */
.l-subfooter.at_bottom {
	color: <?php echo ($smof_data['footer_text'] != '')?$smof_data['footer_text']:'#666'; ?>;
	}

/* Link Color */
.l-subfooter.at_bottom a {
	color: <?php echo ($smof_data['footer_link'] != '')?$smof_data['footer_link']:'#999'; ?>;
	}

/* Link Hover Color */
.no-touch .l-subfooter.at_bottom a:hover {
	color: <?php echo ($smof_data['footer_link_hover'] != '')?$smof_data['footer_link_hover']:'#fff'; ?>;
	}
<?php
if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE) {
?>
</style>
<?php
}
?>
<?php if ($smof_data['custom_css'] != '') { ?>
<?php
if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE) {
?>
<style>
<?php
}
?>
<?php echo $smof_data['custom_css'] ?>
<?php
if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE) {
?>
</style>
<?php
}
?>
<?php } ?>
