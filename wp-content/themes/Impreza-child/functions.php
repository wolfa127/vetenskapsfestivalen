<?php

add_action( 'admin_menu', 'remove_menus');
function theme_slug_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Main Sidebar 2', 'theme-slug' ),
        'id' => 'sidebar-2',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
        'before_title' => '<h1>',
        'after_title' => '</h1>',

    )

    );



}
add_action( 'widgets_init', 'theme_slug_widgets_init' );

function remove_menus(){
    remove_menu_page('edit.php?post_type=us_portfolio');
    remove_menu_page('edit.php?post_type=us_client');
}



function my_google_fonts_filter($data) {
   return json_decode( file_get_contents(get_stylesheet_directory() . '/params/google_fonts.json'));
}
add_filter("vc_google_fonts_get_fonts_filter", "my_google_fonts_filter");

require_once('vc_templates/vc_newsitem.php');


function custom_posts_on_homepage( $query ) {

    if ( is_page_template( 'page-big_blog.php' ) ) {
        echo "Returns true when 'about.php' is being used.";
     //  $category = get_category_by_slug('nyheter');
     //   $query->set( 'cat', '-'.$category->cat_ID );
    }
    if ( $query->is_home() && $query->is_main_query() ) {
       // $category = get_category_by_slug('nyheter');
       // echo "--------------------------------------------------------". $category->cat_ID;
       // $query->set( 'cat', '-'.$category->cat_ID );
    }
}
//add_action( 'pre_get_posts', 'custom_posts_on_homepage' );

add_filter( 'theme_page_templates', 'my_remove_page_template' );
function my_remove_page_template( $pages_templates ) {
    unset( $pages_templates['page-grid_blog_paginated.php'] );
    unset( $pages_templates['page-grid_blog.php'] );
    return $pages_templates;
}


// custom taxonomy permalinks
add_filter('post_link', 'state_permalink', 10, 3);
add_filter('post_type_link', 'state_permalink', 10, 3);

function state_permalink($permalink, $post_id, $leavename) {
    if (strpos($permalink, '%nyhetskategori%') === FALSE) return $permalink;

    //log_me($permalink);
    // Get post
    $post = get_post($post_id);
    if (!$post) return $permalink;

    // Get taxonomy terms
    $terms = wp_get_object_terms($post->ID, 'nyhetskategori');
    if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) $taxonomy_slug = $terms[0]->slug;
    else $taxonomy_slug = 'other';

    return str_replace('%nyhetskategori%', $taxonomy_slug, $permalink);
}


function log_me($message) {
    if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }

    }
}


/*
 *
 *  REGISTER MODIFIED SCRIPT SOLVING BUG CAUSING HASH ERROR IN URL DUE TO ANGULAR STATES
 *
 * */

$template_directory_url = get_template_directory_uri();
$theme = wp_get_theme();
$theme_version = $theme->get('Version');


function us_jscripts_child()
{
    $template_directory_url = get_stylesheet_directory_uri();
    $theme = wp_get_theme();
    $theme_version = $theme->get('Version');

    wp_deregister_script('us-plugins');
    wp_register_script('us-plugins', $template_directory_url.'/js/plugins.js', array('jquery'), $theme_version, TRUE);

}
add_action('wp_enqueue_scripts', 'us_jscripts_child');
require_once('widgets/partnerwidget.php');



/*
 *
 * Solves problem with Breadcrumb Home text
 *
 * */
add_filter('gettext', 'textChangeFilter',10,3);
function textChangeFilter( $translated_text, $text, $domain ) {
    if ( is_singular() ) {

        switch ( $translated_text ) {

            case 'Home' :

                $translated_text = __( 'Hem', 'us' );
                break;

        }

    }
    return $translated_text;
}




function us_register_meta_boxes2()
{
    global $meta_boxes;
    $prefix = 'us_';

    $header_titlebar_fields = array (
        array(
            'name'		=> 'Title Bar Content',
            'id'		=> $prefix . "titlebar",
            'type'		=> 'select',
            'options'	=> array(
                '' => 'Captions and Breadcrumbs',
                'caption_only' => 'Captions only',
                "startpage_header" => "Startpage Header",
                'hide' => 'Hide',
            ),
        ),
        array(
            'name'		=> 'Title Bar Size',
            'id'		=> $prefix . "header_layout_type",
            'type'		=> 'select',
            'options'	=> array(
                '' => 'Default (set at Theme Options)',
                'Ultra Compact' => 'Ultra Compact',
                'Compact' => 'Compact',
                'Large' => 'Large',
                'Huge' => 'Huge',
            ),
        ),
        array(
            'name'		=> 'Big caption (shown next to Page Title)',
            'id'		=> $prefix . 'bigtitle',
            'clone'		=> false,
            'type'		=> 'text',
            'std'		=> ''
        ),
        array(
            'name'		=> 'Small caption (shown next to Page Title)',
            'id'		=> $prefix . 'subtitle',
            'clone'		=> false,
            'type'		=> 'text',
            'std'		=> '',
        ),
        array(
            'name'		=> 'Title Bar Color Style',
            'id'		=> $prefix . "titlebar_color",
            'type'		=> 'select',
            'options'	=> array(
                '' => 'Default bg | Default text',
                'alternate' => 'Alternate bg | Default text',
                'primary' => 'Primary bg | White text',
                'secondary' => 'Secondary bg | White text',
            ),
        ),
        array(
            'name'		=> 'Title Bar Background Image',
            'id'		=> $prefix . "titlebar_image",
            'type'		=> 'image_advanced',
            'max_file_uploads'	=> 1,

        ),
        array(
            'name'		=> 'Parallax Effect',
            'id'		=> $prefix . "titlebar_parallax",
            'type'		=> 'select',
            'options'	=> array(
                '' => 'None',
                'vertical' => 'Vertical Parallax',
                'vertical_reversed' => 'Vertical Reversed Parallax',
                'horizontal' => 'Horizontal Parallax',
                'still' => 'Still (Image not moves)',
            ),
        ),
        array(
            'name'		=> 'Overlay Color',
            'id'		=> $prefix . "titlebar_overlay_color",
            'type'		=> 'color',
        ),
        array(
            'name'		=> 'Overlay Opacity',
            'id'		=> $prefix . "titlebar_overlay_opacity",
            'type'		 => 'slider',
            'js_options' => array(
                'min' => 1,
                'max' => 99,
            )
        )
    );
    $meta_boxes[] = array(
        'id' => 'impeza_page_portfolio_header_settings',
        'title' => 'Title Bar Settings',
        'pages' => array('page', 'us_portfolio'),
        'context' => 'side',
        'priority' => 'default',

        // List of meta fields
        'fields' => $header_titlebar_fields,
    );


    // Make sure there's no errors when the plugin is deactivated or during upgrade
    if ( class_exists( 'RW_Meta_Box' ) )
    {

        foreach ( $meta_boxes as $meta_box )
        {
            new RW_Meta_Box( $meta_box );
        }
    }
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'us_register_meta_boxes2' );
