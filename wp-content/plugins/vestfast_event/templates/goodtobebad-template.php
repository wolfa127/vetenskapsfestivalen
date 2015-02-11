<?php

global $smof_data;
get_header(); ?>
<?php if (have_posts()) { while(have_posts()) { the_post(); ?>
    <?php get_template_part( 'templates/pagehead' ); ?>
    <?php if (us_is_vc_fe()) { ?>
        <div class="l-submain eventContent">
            <div class="l-submain-h g-html i-cf">
                <?php the_content(); ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="eventContent">
        <?php the_content(); ?>
        </div>
    <?php } ?>
    <div class="l-submain">
        <div class="l-submain-h g-html i-cf">
            <div class="g-cols offset_default">
                <div class="full-width">
                    <div ng-app="ngAppEvent" ><div ui-view autoscroll="true" ></div>


                    </div>
                </div>
            </div>
        </div>
        <?php
        /*
            s = Subject

        */
        if(isset($_GET['s'])){
            echo $_GET['s'];
        }


        ?>

    </div>


<?php }  } else { ?>
    <?php _e('No posts were found.', 'us'); ?>
<?php } ?>
<?php get_footer(); ?>