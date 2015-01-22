<?php
/*
Plugin Name: Extend Visual Composer Plugin Example
Plugin URI: http://wpbakery.com/vc
Description: Extend Visual Composer with your own set of shortcodes.
Version: 0.1.1
Author: WPBakery
Author URI: http://wpbakery.com
License: GPLv2 or later
*/

/*
This example/starter plugin can be used to speed up Visual Composer plugins creation process.
More information can be found here: http://kb.wpbakery.com/index.php?title=Category:Visual_Composer
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

class VCExtendAddonClass {
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );

        // Use this when creating a shortcode addon
        //add_shortcode( 'bartag', array( $this, 'renderMyBartag' ) );

        // Register CSS and JS
        add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
    }

    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }

        /*
        Add your Visual Composer logic here.
        Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

        More info: http://kb.wpbakery.com/index.php?title=Vc_map
        */
        vc_map( array(
            "name" => __("My Bar Shortcode", 'vc_extend'),
            "description" => __("Bar tag description text", 'vc_extend'),
            "base" => "bartag",
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/asterisk_yellow.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Content', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Text", 'vc_extend'),
                    "param_name" => "foo",
                    "value" => __("Default params value", 'vc_extend'),
                    "description" => __("Description for foo param.", 'vc_extend')
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Text color", 'vc_extend'),
                    "param_name" => "color",
                    "value" => '#FF0000', //Default Red color
                    "description" => __("Choose text color", 'vc_extend')
                ),
                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Content", 'vc_extend'),
                    "param_name" => "content",
                    "value" => __("<p>I am test text block. Click edit button to change this text.</p>", 'vc_extend'),
                    "description" => __("Enter your content.", 'vc_extend')
                ),
            )
        ) );
    }

    /*
    Shortcode logic how it should be rendered
    */
    public function renderMyBartag( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'foo' => 'something',
            'color' => '#FF0000'
        ), $atts ) );
        $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

        $output = "<div style='color:{$color};' data-foo='${foo}'>{$content}</div>";
        return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
        //temporary comment
        //wp_register_style( 'vc_extend_style', 'assets/vc_extend.css');
        wp_enqueue_style( 'vc_extend_style' );

        // If you need any javascript files on front end, here is how you can load them.
        //wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
        </div>';
    }
}
