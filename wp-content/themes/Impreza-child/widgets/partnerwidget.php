<?php
global $smof_data;

class Partners_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'Partners_Widget', 'description' => 'Displays an My widget!' );
        $this->WP_Widget('Partners_Widget', 'Partner widget', $widget_ops);
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
                <span class="partnerheader">HEJ PARTNERS</span>
                <?php
                $args = array( 'post_type' => 'partners', 'posts_per_page' => 1000 );
                $loop = new WP_Query( $args );
                $postCount = 0;
                while ( $loop->have_posts() ) : $loop->the_post();
                    the_content();
                    $pname = types_render_field( "partnername", array());

                    if (++$postCount == 1) {
                        echo "<span class='partnername'></i> " . $pname . "</span>";
                    } else {
                        echo "<span class='partnername'><i class='fa fa-circle'></i> " . $pname . "</span>";
                    }
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

add_action( 'widgets_init', create_function('', 'return register_widget("Partners_Widget");') );
?>