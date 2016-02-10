<?php
if(!class_exists('WP_Plugin_Template_Settings'))
{
	class WP_Plugin_Template_Settings
	{
		/**
		 * Construct the plugin object
		 */
        private $insertCount = 0;
        private $nodeCount = 0;

        public function __construct()
        {
            $this->initStart();
        }

		public function initStart()
		{
			// register actions
        	add_action('admin_menu', array(&$this, 'add_menu_database'));
            add_action('admin_init', array(&$this, 'admin_init_hook'));
		} // END public function __construct

        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init_hook()
        {

            if( false == get_option( 'vetfast_event' ) ) {
                add_option( 'vetfast_event', apply_filters( 'vetfest_default_options', $this->vetfest_default_options() ) );
            } // end if

            add_settings_section(
                'vetfest_general_settings_section',			// ID used to identify this section and with which to register options
                'Options for plugin',		// Title to be displayed on the administration page
                array($this, 'vetfest_options_callback'),	// Callback used to render the description of the section
                'vetfast_event'		// Page on which to add this section of options
            );

            add_settings_field(
                'vetfest_url',						// ID used to identify the field throughout the theme
                'Url (Without http://)',							// The label to the left of the option interface element
                array($this, 'vetfest_url_callback'),	// The name of the function responsible for rendering the option interface
                'vetfast_event',	// The page on which this option will be displayed
                'vetfest_general_settings_section'			// The name of the section to which this field belongs
            );

            add_settings_field(
                'database_username',						// ID used to identify the field throughout the theme
                'Username',							// The label to the left of the option interface element
                array($this, 'vetfest_username_callback'),	// The name of the function responsible for rendering the option interface
                'vetfast_event',	// The page on which this option will be displayed
                'vetfest_general_settings_section'			// The name of the section to which this field belongs

            );

            add_settings_field(
                'daatbase_pwd',						// ID used to identify the field throughout the theme
                'Password',							// The label to the left of the option interface element
                array($this, 'vetfest_pwd_callback'),	// The name of the function responsible for rendering the option interface
                'vetfast_event',	// The page on which this option will be displayed
                'vetfest_general_settings_section'			// The name of the section to which this field belongs
            );

            register_setting(
                'vetfast_event',
                'vetfast_event'
            );


        }

        /**
        * Provides default values for the plugin Options.
        */
        function vetfest_default_options() {

            $defaults = array(
                'vetfest_url'		=>	'http://hebe.premium.se/aktiviteter/ws.php',
                'vetfest_username'		=>	'vetfest',
                'vetfest_pwd'		=>	'boka75klasser',
            );

            return apply_filters( 'vetfest_default_options', $defaults );

        } // end sandbox_theme_default_display_options

        public function settings_section_wp_plugin_template()
        {
            // Think of this as help text for the section.
            echo 'These settings do things for the WP Plugin Template.';
        }
        /* ------------------------------------------------------------------------ *
         * Section Callbacks
         * ------------------------------------------------------------------------ */

        /**
         * This function provides a simple description for the General Options page.
         *
         * It is called from the 'sandbox_initialize_theme_options' function by being passed as a parameter
         * in the add_settings_section function.
         */
        function vetfest_options_callback() {
            echo '<p>Set Database options</p>';
        }

        function vetfest_url_callback(){
            $options = get_option('vetfast_event');
            $field = $options['vetfest_url'];

            echo sprintf('<input type="text" name="vetfast_event[vetfest_url]" id="vetfest_url" value="%s" />', $field);
        }

        function vetfest_username_callback(){
            $options = get_option('vetfast_event');
            $field = $options['vetfest_username'];
            echo sprintf('<input type="text" name="vetfast_event[vetfest_username]" id="vetfest_username" value="%s" />', $field);
        }

        function vetfest_pwd_callback(){
            $options = get_option('vetfast_event');
            $field = $options['vetfest_pwd'];
            echo sprintf('<input type="text" name="vetfast_event[vetfest_pwd]" id="vetfest_pwd" value="%s" />', $field);
        }



        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
        } // END public function settings_field_input_text($args)
        
        /**
         * add a menu
         */
        public function add_menu_database()
        {
            add_menu_page(
                'Event database',
                'Event database',
                'manage_options',
                'vetfast_event',
                array($this, 'my_custom_menu_page'),
                'dashicons-sos',
                '9');
        } // END public function add_menu()
    
        /**
         * Menu Callback
         */

        function my_custom_menu_page(){
            if ( !current_user_can( 'manage_options' ) )  {
                wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
            }
            $this->checkForPost();
            ?>

            <div class="wrap">
                <?php if( isset($_GET['settings-updated']) ) { ?>
                    <div id="message" class="updated">
                        <p><strong><?php _e('Settings saved.') ?></strong></p>
                    </div>
                <?php } ?>
                <?php if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
                    if(isset($_POST['update'])){?>
                        <div id="message" class="updated">
                            <p><strong><?php _e('Databas Uppdaterad med ' .  $this->insertCount . "/" . $this->nodeCount .  " poster") ?></strong></p>
                        </div>
                    <?php }
                    if(isset($_POST['delete'])){?>
                        <div id="message" class="updated">
                            <p><strong><?php _e('Databas tömd') ?></strong></p>
                        </div>
                    <?php }
                } ?>
                <h2>Event Database</h2>
                <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    Antal sparade poster:
                    <?php
                    echo $this->getEventCount();
                    // This prints out all hidden setting fields
                    submit_button('Updatera databas', 'primary', 'update' );
                    submit_button('Töm databas', 'primary', 'delete' );
                    ?>
                </form>

                <form method="post" action="options.php">
                    <?php

                    settings_fields( 'vetfast_event' );
                    do_settings_sections( 'vetfast_event' );

                    ?>

                    <?php submit_button(); ?>
                </form>
            </div>
            <?php

        }


        function getEventCount()
        {
            global $wpdb;
            $countQuery = "SELECT COUNT(*) FROM wp_vetfastevent";
            $resultCount=  $wpdb->get_var($countQuery);
            return $resultCount;
            exit;
        }


        function checkForPost(){

            if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
                if(isset($_POST['update'])){
                    $this->getEventDatabase();
                }
                if(isset($_POST['delete'])){
                    $this->deleteEventDatabase();
                }

                //$this->getEventDatabase();
            }
        }
        function deleteEventDatabase(){
            global $wpdb;
            $wpdb->query("DELETE FROM wp_vetfastevent",'');
            $wpdb->query("DELETE FROM wp_vetfastevent_links",'');
            $wpdb->query("DELETE FROM wp_vetfastevent_subjectlist",'');
            $wpdb->query("DELETE FROM wp_vetfastevent_subjectTags",'');
            $wpdb->query("DELETE FROM wp_vetfastevent_accessibilityTags",'');
            $wpdb->query("DELETE FROM wp_vetfastevent_accessibilitylist",'');

            $wpdb->query("ALTER TABLE wp_vetfastevent AUTO_INCREMENT = 1");
            $wpdb->query("ALTER TABLE wp_vetfastevent_links AUTO_INCREMENT = 1");
            $wpdb->query("ALTER TABLE wp_vetfastevent_subjectlist AUTO_INCREMENT = 1");
            $wpdb->query("ALTER TABLE wp_vetfastevent_subjectTags AUTO_INCREMENT = 1");
            $wpdb->query("ALTER TABLE wp_vetfastevent_accessibilityTags AUTO_INCREMENT = 1");
            $wpdb->query("ALTER TABLE wp_vetfastevent_accessibilitylist AUTO_INCREMENT = 1");

        }

        function getEventDatabase(){
            $this  -> deleteEventDatabase();
            $vetenskaps_options = get_option('vetfast_event');
            $buildUrl = "http://" . $vetenskaps_options['vetfest_username'] . ":" . $vetenskaps_options['vetfest_pwd'] . "@" . $vetenskaps_options['vetfest_url'];
            $url = $buildUrl;
            $xml = file_get_contents($url);
            $data = new SimpleXMLElement($xml);
            $this->nodeCount = $data->count();
            global $wpdb;
            //$wpdb->show_errors = true;
            $subjects_arr = array();
            $utility_arr = array();
            $this -> insertCount = 0;
            foreach ($data->activity as $activity) {

                try{

                    $insertarr = array(
                        'created' => (string) $activity['created'],
                        'updated' => (string) $activity['updated'],
                        'title' =>  trim((string) $activity -> title),
                        'description' =>  trim((string) $activity -> description),
                        'description_short' =>  trim((string) $activity -> description_short),
                        'eventId' => (int) $activity['id'],
                        'event_type' => (string) $activity -> type,
                        'overhead_title' =>  trim((string) $activity -> overhead_title),
                        'overhead_description' => trim((string) $activity -> overhead_description),
                        'event_start' => (string) $activity -> start,
                        'event_end' => (string) $activity -> end,
                        'event_language' => (string) $activity -> language,
                        'venue' =>  trim((string) $activity -> venue),
                        'venue_number' => (string) $activity -> venue_number,
                        'venue_adress' =>  trim((string) $activity -> venue_adress),
                        'image_url' => (string) $activity -> image,
                        'crew' =>  trim((string) $activity -> crew),
                        'closest_public_transport' => (string) $activity -> closest_public_transport,
                        'geo_position' => (string) $activity -> position,
                        'highlight' => filter_var(strtolower((int) $activity -> highlight), FILTER_VALIDATE_BOOLEAN),
                        'family_activity' => filter_var(strtolower((int) $activity -> family_activity), FILTER_VALIDATE_BOOLEAN)
                    );

                    $insertResult =  $wpdb->query( $wpdb->prepare(
                        "INSERT INTO wp_vetfastevent
                    ( created, updated, title, description, description_short, eventId, event_type,overhead_title, overhead_description, event_start, event_end,event_language, venue,venue_number,venue_adress,image_url,crew,closest_public_transport, geo_position,highlight,family_activity)
                    VALUES  ('%s', '%s', '%s', '%s','%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d')",
                        $insertarr
                    ) );


                    if($insertResult != false){
                        $this -> insertCount++;
                    }

                }catch (Exception $e){


                }


                if($activity -> subjects -> children() -> count() > 0){
                    foreach ($activity -> subjects -> subject as $_subject) {
                        $_subject = trim((string) $_subject);
                        $key = array_search((string) $_subject, $subjects_arr);
                        if ($key == false) {
                             $wpdb->insert('wp_vetfastevent_subjectTags', array('subject' => (string) $_subject), array('%s'));
                            $subjects_arr[$wpdb -> insert_id] =  $_subject;
                            $this -> insertSubject($wpdb -> insert_id, $activity['id']);
                        }
                        else{
                            $this -> insertSubject($key, $activity['id']);
                        }
                    }
                }

                if($activity -> accessibility -> children() -> count() > 0){
                    foreach ($activity -> accessibility -> utility as $utility) {
                        $key = array_search((string) $utility, $utility_arr);
                        if ($key == false) {
                            $wpdb->insert('wp_vetfastevent_accessibilityTags', array('accessibility' => (string) $utility), array('%s'));
                            $utility_arr[$wpdb -> insert_id] = (string) $utility;
                            $this -> insertAccessibility($wpdb -> insert_id, $activity['id']);
                        }
                        else{
                            $this -> insertAccessibility($key, $activity['id']);
                        }
                    }

                }

                if (((int) $activity->links -> count()) > 0) {

                    foreach ($activity->links->link as $link) {
                        $wpdb->insert(
                            'wp_vetfastevent_links',
                            array(
                                'eventId' => $activity['id'],
                                'url' => $link['href'],
                                'title' => (string) $link
                            ),
                            array(
                                '%d',
                                '%s',
                                '%s'
                            )
                        );
                    }

                }

            }

        }

        function insertSubject($_subjectId, $_eventId){
            global $wpdb;
            $wpdb->insert(
                'wp_vetfastevent_subjectlist',
                array(
                    'subjectId' => (int) $_subjectId,
                    'eventId' => (int) $_eventId
                ),
                array(
                    '%d',
                    '%d'
                )
            );
        }

        function insertAccessibility($_accessId, $_eventId){
            global $wpdb;
            $wpdb->insert(
                'wp_vetfastevent_accessibilitylist',
                array(
                    'accessibilityId' => (int) $_accessId,
                    'eventId' => (int) $_eventId
                ),
                array(
                    '%d',
                    '%d'
                )
            );
        }




    } // END class WP_Plugin_Template_Settings
} // END

//if(!class_exists('WP_Plugin_Template_Settings'));
