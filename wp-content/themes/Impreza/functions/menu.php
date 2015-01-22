<?php

class Walker_Nav_Menu_us extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$level = ( $depth + 2); // because it counts the first submenu as 0
		$classes = array(
			'w-nav-list',
			'level_'.$level,
		);
//		if ($level == 1)
//		{
//			$classes[] = 'layout_hor';
//			$classes[] = 'width_stretch';
//		}
//		elseif ($level == 2)
//		{
//			$classes[] = 'place_down';
//			$classes[] = 'show_onhover';
//		}
//		elseif ($level == 3)
//		{
//			$classes[] = 'place_aside';
//			$classes[] = 'show_onhover';
//		}
		$class_names = implode( ' ', $classes );

		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$output .= "$indent</ul>\n";
	}

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		if( ! empty( $children_elements[$element->$id_field] ) )
			array_push($element->classes,'has_sublevel');

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$level = ( $depth + 1); // because it counts the first submenu as 0

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'w-nav-item';
		$classes[] = 'level_'.$level;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a class="w-nav-anchor level_'.$level.'" '. $attributes .'>';
		$item_output .= $args->link_before.'<span class="w-nav-title">'. apply_filters( 'the_title', $item->title, $item->ID ) .'</span><span class="w-nav-arrow"></span>'. $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$output .= "$indent</li>\n";
	}

}

// Add Top Menu
function register_us_menu(){
	register_nav_menus(
		array(
			'impeza_main_menu' => __('Main Menu', 'us'),
			'impeza_footer_menu' => __('Footer Menu', 'us'),
		)
	);
}
add_action('init', 'register_us_menu');