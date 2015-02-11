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

function custom_us_breadcrumbs() {

    /* === OPTIONS === */
    $text['home']     = 'För alla' ; // text for the 'Home' link
    $text['category'] = __('Archive by Category "%s"', 'us'); // text for a category page
    $text['search']   = __('Search Results for "%s" Query', 'us'); // text for a search results page
    $text['tag']      = __('Posts Tagged "%s"', 'us'); // text for a tag page
    $text['author']   = __('Articles Posted by %s', 'us'); // text for an author page
    $text['404']      = __('Error 404', 'us'); // text for the 404 page
    $text['forums']   = __('Forums', 'us'); // text for the 404 page

    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter   = ' <span class="g-breadcrumbs-separator"><i class="fa fa-angle-right"></i></span> '; // delimiter between crumbs
    $before      = '<span class="g-breadcrumbs-item">'; // tag before the current crumb
    $after       = '</span>'; // tag after the current crumb
    /* === END OF OPTIONS === */

    global $post;
    $homeLink = home_url() . '/';
    $linkBefore = '<span typeof="v:Breadcrumb">';
    $linkAfter = '</span>';
    $linkAttr = ' rel="v:url" property="v:title"';
    $link = $linkBefore . '<a class="g-breadcrumbs-item"' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

    if (is_home() || is_front_page()) {

        if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

    } else {

        echo '<div class="g-breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';

        if ( is_category() ) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
            }
            echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

        } elseif ( is_search() ) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;

        } elseif ( is_day() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), __(get_the_time('F'), 'us')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif ( is_month() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . __(get_the_time('F'), 'us') . $after;

        } elseif ( is_year() ) {
            echo $before . get_the_time('Y') . $after;

        } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() == 'topic' OR get_post_type() == 'forum' ) {
                $forums_page = bbp_get_page_by_path( bbp_get_root_slug() );
                if ( !empty( $forums_page ) ) {
                    $forums_page_url = get_permalink( $forums_page->ID );
                    echo sprintf($link, $forums_page_url, $text['forums']) ;
                }
                $parent_id  = $post->post_parent;
                if ($parent_id) {
                    $breadcrumbs = array();
                    while ($parent_id) {
                        $page = get_page($parent_id);
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                        $parent_id  = $page->post_parent;
                    }
                    $breadcrumbs = array_reverse($breadcrumbs);
                    for ($i = 0; $i < count($breadcrumbs); $i++) {
                        echo $delimiter.$breadcrumbs[$i];
//                        if ($i != count($breadcrumbs)-1) echo $delimiter;
                    }

//                    if ( get_post_type() == 'forum' ) {
//                        echo $delimiter;
//                    }
                }

//                if ( get_post_type() == 'forum' ) {
//                    if ($showCurrent == 1) echo $before . get_the_title() . $after;
//                }

            } elseif ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
                if ($showCurrent == 1) echo $before . get_the_title() . $after;
            }

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());

            echo $before . $post_type->labels->name . $after;

        } elseif ( is_attachment() ) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, null);
            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
            echo $cats;
            printf($link, get_permalink($parent), $parent->post_title);
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_page() && !$post->post_parent ) {
            if ($showCurrent == 1) echo $before . get_the_title() . $after;

        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs)-1) echo $delimiter;
            }
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_tag() ) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;

        } elseif ( is_404() ) {
            echo $before . $text['404'] . $after;
        }

        if ( get_query_var('paged') AND ! (get_post_type() == 'topic' OR get_post_type() == 'forum') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }

        echo '</div>';

    }
} // end dimox_breadcrumbs()

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

add_image_size( 'vetenskap_logosize', 150, 150, false);
add_image_size( 'vetenskap_large', 1200, 1200, false);
add_image_size( 'vetenskap_medium', 800, 1024, false);
add_image_size( 'vetenskap_front_thumbnail', 600, 400, true);

add_action( 'vc_after_init', 'add_optimized_image_size' ); /* Note: here we are using vc_after_init because WPBMap::GetParam and mutateParame are available only when default content elements are "mapped" into the system */

function add_optimized_image_size() {
    $param = WPBMap::getParam( 'vc_single_image', 'img_size' );
    //Append new value to the 'value' array
    $param['value'][__("Vetenskap large", "js_composer")] = 'vetenskap_large';
    $param['value'][__("Vetenskap medium", "js_composer")] = 'vetenskap_medium';
    $param['value'][__("Vetenskap front thumbnail", "js_composer")] = 'vetenskap_front_thumbnail';
    //Finally "mutate" param with new values
    vc_update_shortcode_param( 'vc_single_image', $param );
}

function ms_image_editor_default_to_gd( $editors ) {
    $gd_editor = 'WP_Image_Editor_GD';

    $editors = array_diff( $editors, array( $gd_editor ) );
    array_unshift( $editors, $gd_editor );

    return $editors;
}
add_filter( 'wp_image_editors', 'ms_image_editor_default_to_gd' );

// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpfull


add_action( 'admin_init', 'us_register_meta_boxes2' );

add_action('wp_footer', 'add_googleanalytics');

function add_googleanalytics() { ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-23149368-1', 'auto');
        ga('send', 'pageview');

    </script>
<?php }



