<?php
/*
Plugin Name: AA - Vetenskapsfestivalen Event Plugin
Description: Plugin för att ladda ner eventdatabasen lokalt i wordpress
Version: 1.0
Author: Christian Dompert - Stendahls Reklambyrå
Author URI: http://www.stendahls.se
License: GPL2
*/
/*

*/

if (!class_exists('Vetfast_event')) {
    class Vetfast_event
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // Initialize Settings
            require_once(sprintf("%s/settings.php", dirname(__FILE__)));

            $WP_Plugin_Template_Settings = new WP_Plugin_Template_Settings();



            add_action( 'wp_ajax_getEvents',  array($this, 'getEvents_callback'));
            add_action( 'wp_ajax_nopriv_getEvents', array($this, 'getEvents_callback'));

            add_action( 'wp_ajax_getEvent',  array($this, 'getEvent_callback'));
            add_action( 'wp_ajax_nopriv_getEvent', array($this, 'getEvent_callback'));

            add_action( 'wp_ajax_getSubjects',  array($this, 'getSubjects_callback'));
            add_action( 'wp_ajax_nopriv_getSubjects', array($this, 'getSubjects_callback'));


            add_action( 'wp_head', array( $this, 'add_ajax_library' ) );
            add_action( 'wp_head', array( $this, 'add_angular_for_template' ) );


            add_action( 'wp_loaded', array( $this,'taco_kitten_rewrite') );
        } // END public function __construc


        function taco_kitten_rewrite() {
            $url = str_replace( trailingslashit( site_url() ), '', plugins_url( '/taco-kittens.php', __FILE__ ) );
            add_rewrite_rule( 'taco-kittens\\.php$', $url, 'top' );
        }

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
           // $this->jal_install();

            global $wpdb;
            global $jal_db_version;
            $sql_event = "CREATE TABLE IF NOT EXISTS wp_vetfastevent (
                id MEDIUMINT NOT NULL AUTO_INCREMENT,
                eventId INT NULL,
                created DATETIME NULL,
                updated DATETIME NULL,
                title VARCHAR(2000) NULL,
                overhead_title VARCHAR(2000) NULL,
                overhead_description VARCHAR(2000) NULL,
                event_start DATETIME NULL,
                event_end DATETIME NULL,
                event_language VARCHAR(45) NULL,
                venue VARCHAR(300) NULL,
                venue_number INT NULL,
                venue_adress VARCHAR(1000) NULL,
                event_type VARCHAR(245) NULL,
                theme VARCHAR(500) NULL,
                crew VARCHAR(2000) NULL,
                image_url VARCHAR(2000) NULL,
                closest_public_transport VARCHAR(1000) NULL,
                description VARCHAR(2000) NULL,
                geo_position VARCHAR (40) NULL,
                highlight TINYINT(1) NULL,
                family_activity TINYINT(1) NOT NULL,
                PRIMARY KEY  (id));";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql_event);


            $sql_eventlinks = "CREATE TABLE IF NOT EXISTS wp_vetfastevent_links (
                id MEDIUMINT NOT NULL AUTO_INCREMENT,
                eventId INT NOT NULL,
                url VARCHAR(2000) NULL,
                title VARCHAR(2000) NULL,
                PRIMARY KEY  (id));";
            dbDelta($sql_eventlinks);

            $sql_eventsubjectTags = "CREATE TABLE IF NOT EXISTS wp_vetfastevent_subjectTags (
                id MEDIUMINT NOT NULL AUTO_INCREMENT,
                subject VARCHAR(2000) NULL,
                PRIMARY KEY  (id));";
            dbDelta($sql_eventsubjectTags);

            $sql_eventsubjectlist = "CREATE TABLE IF NOT EXISTS wp_vetfastevent_subjectlist (
                eventId MEDIUMINT NOT NULL,
                subjectId MEDIUMINT NOT NULL,
                PRIMARY KEY  (eventId, subjectId));";
            dbDelta($sql_eventsubjectlist);

            $sql_accessibilityTags = "CREATE TABLE IF NOT EXISTS wp_vetfastevent_accessibilityTags (
                id MEDIUMINT NOT NULL AUTO_INCREMENT,
                accessibility VARCHAR(2000) NULL,
                PRIMARY KEY  (id));";
            dbDelta($sql_accessibilityTags);

            $sql_eventaccessibilityList = "CREATE TABLE IF NOT EXISTS wp_vetfastevent_accessibilitylist (
                eventId MEDIUMINT NOT NULL,
                accessibilityId MEDIUMINT NOT NULL,
                PRIMARY KEY  (eventId, accessibilityId));";
            dbDelta($sql_eventaccessibilityList);


            add_option('jal_db_version', $jal_db_version);

        } // END public static function activate

        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            $sql2 = "DROP TABLE wp_vetfastevent, wp_vetfastevent_links, wp_vetfastevent_subjectTags, wp_vetfastevent_subjectlist, wp_vetfastevent_accessibilityTags, wp_vetfastevent_accessibilitylist";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            //dbDelta($sql2);
            global $wpdb;
            $wpdb->query($sql2);
        } // END public static function deactivate

        // Add the settings link to the plugins page
        function plugin_settings_link($links)
        {
            $settings_link = '<a href="options-general.php?page=wp_plugin_template">Settings</a>';
            array_unshift($links, $settings_link);
            return $links;
        }

        function jal_install_data()
        {
            global $wpdb;

            $welcome_name = 'Mr. WordPres';
            $welcome_text = 'Congratulations, you just completed the installation!';

            $table_name = $wpdb->prefix . 'liveshoutbox';

            $wpdb->insert(
                $table_name,
                array(
                    'time' => current_time('mysql'),
                    'name' => $welcome_name,
                    'text' => $welcome_text,
                )
            );
        }

        public function init()
        {


        }

        public function getEvents_callback()
        {
            global $wpdb;

            $allrowsQurey = "SELECT wp_vetfastevent.* FROM wp_vetfastevent";
            $results =  $wpdb->get_results( $allrowsQurey, 'ARRAY_A' );
            $resultObj = array();
            $getIDs = "SELECT wp_vetfastevent.eventId, wp_vetfastevent_subjectTags.subject FROM wp_vetfastevent, wp_vetfastevent_subjectlist, wp_vetfastevent_subjectTags where wp_vetfastevent.eventId = wp_vetfastevent_subjectlist.eventId and wp_vetfastevent_subjectlist.subjectId = wp_vetfastevent_subjectTags.id";
            $results2 =  $wpdb->get_results( $getIDs, 'ARRAY_A' );
            foreach ( $results2 as $key => $resultEvent )
            {
                $resultObj[ $results2[$key]['eventId']][] = $results2[$key]['subject'];
            }

            foreach ( $results as $key => $myEvents )
            {
              //  $results[$key]['subjectList'][] = $resultObj[$myEvents.eventId]['subject'];
                if(array_key_exists($myEvents['eventId'], $resultObj)){
                    $results[$key]['subjectList'] = $resultObj[$myEvents['eventId']];
                }else{
                    $results[$key]['subjectList'] = array();
                }
            }

            header( "Content-Type: application/json" );
            echo json_encode($results);
            // IMPORTANT: don't forget to "exit"
            exit;

        }

        public function getEvent_callback()
        {
            global $wpdb;
            $searchId = $_POST['eventId'];

            //$sq = "SELECT * FROM wp_vetfastevent WHERE wp_vetfastevent.eventId=' . + $searchId + "'";
            $sq_results = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM wp_vetfastevent WHERE eventId = %d",
                            $searchId
                        ), 'ARRAY_A'
                    );
            $getIDs = "SELECT wp_vetfastevent.eventId, wp_vetfastevent_links.url, wp_vetfastevent_links.title FROM wp_vetfastevent, wp_vetfastevent_links where %d = wp_vetfastevent_links.eventId  AND $searchId = wp_vetfastevent.eventId ";
            $results2 =  $wpdb->get_results( $wpdb->prepare($getIDs,$searchId) , 'ARRAY_A' );
            $resultObj = array();
            $resultListObj = array();
            $resultAccessibilityObj = array();
            foreach ( $results2 as $key => $resultEvent )
            {
                $resultObj[] = array("title" => $results2[$key]['title'], "url" => $results2[$key]['url']);
            }

            $getEventSubjects = "SELECT wp_vetfastevent.eventId, wp_vetfastevent_subjectTags.subject, wp_vetfastevent_subjectlist.subjectId FROM wp_vetfastevent, wp_vetfastevent_subjectlist, wp_vetfastevent_subjectTags where wp_vetfastevent.eventId = wp_vetfastevent_subjectlist.eventId and wp_vetfastevent_subjectlist.subjectId = wp_vetfastevent_subjectTags.id AND wp_vetfastevent.eventId = %d";
            $getEventSubjectsResult =  $wpdb->get_results( $wpdb->prepare( $getEventSubjects, $searchId), 'ARRAY_A' );
            foreach ( $getEventSubjectsResult as $key => $resultEventSubject )
            {
                $resultListObj[] = array("subjectId" => $resultEventSubject['subjectId'], "subject" => $resultEventSubject['subject']);
            }

            //$getEventAccessibility = "SELECT wp_vetfastevent_accessibilityTags.accessibility FROM wp_vetfastevent_accessibilityTags, wp_vetfastevent_accessibilitylist where wp_vetfastevent_accessibilityTags.eventId = wp_vetfastevent_subjectlist.eventId and wp_vetfastevent_subjectlist.subjectId = wp_vetfastevent_subjectTags.id AND wp_vetfastevent.eventId = %d";
            $getEventAccessibility = "SELECT * FROM wp_vetfastevent_accessibilityTags, wp_vetfastevent_accessibilitylist WHERE wp_vetfastevent_accessibilityTags.id = wp_vetfastevent_accessibilitylist.accessibilityId AND wp_vetfastevent_accessibilitylist.eventid = %d";
            $getEventAccessibilityResult =  $wpdb->get_results( $wpdb->prepare( $getEventAccessibility, $searchId), 'ARRAY_A' );
            foreach ( $getEventAccessibilityResult as $key => $resultEventAccessibility )
            {
                $resultAccessibilityObj[] = array("accessibilityId" => $resultEventAccessibility['accessibilityId'], "accessibility" => $resultEventAccessibility['accessibility']);
            }

            $sq_results[0]['links'] = $resultObj;
            $sq_results[0]['subjectList'] = $resultListObj;
            $sq_results[0]['accessibilityList'] = $resultAccessibilityObj;
            header( "Content-Type: application/json" );


            echo json_encode($sq_results);

            // IMPORTANT: don't forget to "exit"
            exit;

        }

        public function getSubjects_callback()
        {
            global $wpdb;
            $subjectsQuery = "SELECT * FROM wp_vetfastevent_subjectTags";
            $subjects =  $wpdb->get_results( $subjectsQuery, 'ARRAY_A' );
            header( "Content-Type: application/json" );
            echo json_encode($subjects);
            // IMPORTANT: don't forget to "exit"
            exit;

        }

        public function add_angular_for_template()
        {

            global $wp_query;
            $template_name = "";
            if(isset($wp_query->post->ID)) {
                $template_name = get_post_meta($wp_query->post->ID, '_wp_page_template', true);
            }
            if("$template_name" == 'templates/goodtobebad-template.php'){
                //If page is using slider portfolio template then load our slider script
                //wp_register_script('angularjs', '//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular.js');
                wp_register_script('angularjs', plugin_dir_url( __FILE__ ) . 'js/angular.min.js');
                wp_enqueue_script('angularjs');

               //wp_register_script('angularjs_route','//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-route.js');
                //wp_enqueue_script('angularjs_route');

                wp_register_script('angularjs_loader',  plugin_dir_url( __FILE__ ) . 'js/loading-bar.js');
                wp_enqueue_script('angularjs_loader');

                wp_register_script('angularjs_uiroute',  plugin_dir_url( __FILE__ ) . 'js/angular-ui-router.js');
                wp_enqueue_script('angularjs_uiroute');


                //wp_register_script('lodash', 'http://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js');
                wp_register_script('lodash', plugin_dir_url( __FILE__ ) . 'js/lodash.compat.min.js');
                wp_enqueue_script('lodash');

                //wp_register_script('angular-filter', '//cdnjs.cloudflare.com/ajax/libs/angular-filter/0.5.1/angular-filter.min.js');
                wp_register_script('angular-filter', plugin_dir_url( __FILE__ ) . 'js/angular-filter.min.js');
                wp_enqueue_script('angular-filter');

                wp_register_script('multiselect',  plugin_dir_url( __FILE__ ) . 'js/angularjs-dropdown-multiselect.min.js');
                wp_enqueue_script('multiselect');



                //wp_register_script('google-maps-api', '//maps.googleapis.com/maps/api/js?v=3.exp');
                //wp_enqueue_script('google-maps-api');
                //
                wp_register_script('angular-google-maps-api',  plugin_dir_url( __FILE__ ) . 'js/angular-google-maps.min.js?d=2');
                wp_enqueue_script('angular-google-maps-api');

                wp_register_style('angularjs_loader_style',  plugin_dir_url( __FILE__ ) . 'css/loading-bar.css');
                wp_enqueue_style('angularjs_loader_style');

                wp_register_script('angularjs-app', plugin_dir_url( __FILE__ ) . 'js/angular-app.js');
                wp_enqueue_script('angularjs-app');
            }
        }

        public function add_ajax_library()
        {
            $html = '<script type="text/javascript">';
            $html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";';
            $html .= 'var pluginUrl = "' . plugin_dir_url( __FILE__ ) . '";';
            $html .= '</script>';

            echo $html;
        }

    } // END class WP_Plugin_Template
} // END if(!class_exists('WP_Plugin_Template'))

if (class_exists('Vetfast_event')) {
    // Installation and uninstallation hooks
    require_once( 'pagetemplater.php' );
    add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );
    register_activation_hook(__FILE__, array('Vetfast_event', 'activate'));
    register_deactivation_hook(__FILE__, array('Vetfast_event', 'deactivate'));


    // instantiate the plugin class
    $wp_plugin_template = new Vetfast_event();

}
