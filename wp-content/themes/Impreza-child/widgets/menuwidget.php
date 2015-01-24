<?php
global $smof_data;

class Menu_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'Menu_Widget', 'description' => 'Displays a Menu widget!' );
        $this->WP_Widget('Menu_Widget', 'Menu widget', $widget_ops);
    }

    function widget($args, $instance) {


       ?> <div class="entry-content">
            <span class="partnerheader">HUVUDMÄN</span>
            <div class="partners-main">
                <?php
                $args = array( 'post_type' => 'mainpartners' );
                $loop = new WP_Query( $args );
                while ( $loop->have_posts() ) : $loop->the_post();
                    the_content();
                    echo types_render_field( "partnerimageslug", array( "title" => "title", "width" => "140", "height" => "80", "proportional" => "true", "class" => "entry-content-mainpartner") );
                endwhile;
                ?>
            </div>

            <div class="partners-secondary">
                <span class="partnerheader">PARTNERS</span>
                <?php
                $args = array( 'post_type' => 'partners' );
                $loop = new WP_Query( $args );
                while ( $loop->have_posts() ) : $loop->the_post();
                    the_content();
                    $pname = types_render_field( "partnername", array());
                    echo "<span class='partnername'>" . $pname;
                    echo " <i class='fa fa-circle'></i> ";
                    echo "</span>";
                endwhile;
                ?>
            </div>
        </div>

        <?php
        // After widget code, if any
        echo (isset($after_widget)?$after_widget:'');
    }

    public function form( $instance ) {


    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        return $instance;
    }

}

add_action( 'widgets_init', create_function('', 'return register_widget("Menu_Widget");') );
?>