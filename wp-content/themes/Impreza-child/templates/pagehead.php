<?php
global $smof_data;

if (in_array(rwmb_meta('us_titlebar'), array('', '  caption_only', 'startpage_header'))) {
    $color_class = $background_styles = '';
    if (in_array(rwmb_meta('us_titlebar_color'), array('primary', 'alternate', 'secondary'))) {
        $color_class = ' color_'.rwmb_meta('us_titlebar_color');
    }
    $titlebar_image = '';
    if (rwmb_meta('us_titlebar_image') != '')
    {
        $titlebar_img_id = preg_replace('/[^\d]/', '', rwmb_meta('us_titlebar_image'));
        $titlebar_img = wpb_getImageBySize(array('attach_id' => $titlebar_img_id, 'thumb_size' => 'full' ));

        if ( $titlebar_img != NULL )
        {
            $titlebar_img = wp_get_attachment_image_src($titlebar_img_id, 'full');
            $titlebar_image = $titlebar_img[0];
        }
    }

    $background_tag = '';
    $parallax_class = '';
    $section_id = $section_id_string ='';
    $js_output = '';

    if ($titlebar_image != ''){
        $background_tag = '<div class="l-submain-img" style="background-image: url('.$titlebar_image.');"></div>';

        $titlebar_parallax = rwmb_meta('us_titlebar_parallax');

        static $section_id = 0;
        $section_id++;

        if ($titlebar_parallax == 'vertical' || $titlebar_parallax == 'vertical_reversed' || $titlebar_parallax == 'still'){
            $section_id_string = ' id="section_'.$section_id.'"';

            $parallax_class = ' parallax_ver';

            $ratio = 0; // still
            if ($titlebar_parallax == 'vertical'){
                $ratio = 0.61;
            }
            elseif ($titlebar_parallax == 'vertical_reversed'){
                $ratio = -0.1;
            }
            // We need vertical parallax script for this, but only once per page
            if ( ! wp_script_is('us-parallax', 'enqueued')){
                wp_enqueue_script('us-parallax');
            }
            $js_output = "<script type='text/javascript'>jQuery(document).ready(function(){ jQuery('#section_".$section_id." .l-submain-img').parallax('50%', '".$ratio."'); });</script>";
        }
        elseif ($titlebar_parallax == 'horizontal') {
            $section_id_string = ' id="section_'.$section_id.'"';

            $parallax_class = ' parallax_hor';
            // We need horizontal parallax script for this, but only once per page
            if ( ! wp_script_is('us-hor-parallax', 'enqueued')){
                wp_enqueue_script('us-hor-parallax');
            }
            $js_output = "<script type='text/javascript'>jQuery(document).ready(function(){ jQuery('#section_".$section_id."').horparallax(); });</script>";
        }
    }

    $overlay_tag = '';

    if (rwmb_meta('us_titlebar_overlay_color') != '') {
        $opacity = rwmb_meta('us_titlebar_overlay_opacity');
        if ($opacity < 10) {
            $opacity = '0'.$opacity;
        }
        $overlay_tag = '<div class="l-submain-overlay" style="background-color: '.rwmb_meta('us_titlebar_overlay_color').'; opacity: 0.'.$opacity.';"></div>';
    }

    $header_container_layout_type = ' size_large';
    if (isset($smof_data['header_layout_type']) AND $smof_data['header_layout_type'] == 'Ultra Compact'){
        $header_container_layout_type = ' size_small';
    }
    elseif (isset($smof_data['header_layout_type']) AND $smof_data['header_layout_type'] == 'Compact'){
        $header_container_layout_type = ' size_medium';
    }
    elseif (isset($smof_data['header_layout_type']) AND $smof_data['header_layout_type'] == 'Huge'){
        $header_container_layout_type = ' size_huge';
    }

    if (rwmb_meta('us_header_layout_type') == 'Ultra Compact'){
        $header_container_layout_type = ' size_small';
    }
    elseif (rwmb_meta('us_header_layout_type') == 'Compact'){
        $header_container_layout_type = ' size_medium';
    }
    elseif (rwmb_meta('us_header_layout_type') == 'Large'){
        $header_container_layout_type = ' size_large';
    }
    elseif (rwmb_meta('us_header_layout_type') == 'Huge'){
        $header_container_layout_type = ' size_huge';
    }
    ?>
    <div class="l-submain  _pagehead<?php echo $color_class.$header_container_layout_type.$parallax_class; ?>"<?php echo $section_id_string; ?>>
        <?php echo $background_tag.$overlay_tag; ?>
        <div class="l-submain-h g-html i-cf">
            <div class="w-pagehead">

                <?php if (rwmb_meta('us_titlebar') == 'startpage_header') { ?>
                  <!--  <h1>VETENSKAPSFESTIVALEN</h1>
                    <h2>13-24 APRIL 2015. ÅRETS TEMA: LIV OCH DÖD</h2>-->
                <?php }
                else{
                ?>
                    <h1><?php //the_title(); ?></h1>
                    <?php rwmb_meta('us_titlebar');

                        if (rwmb_meta('us_bigtitle') != '') { echo '<h1>'.rwmb_meta('us_bigtitle').'</h1>'; }
                        if (rwmb_meta('us_subtitle') != '') { echo '<h2>'.rwmb_meta('us_subtitle').'</h2>'; } ?>
                    <?php if (rwmb_meta('us_titlebar') == '') { ?>
                        <!-- breadcrums -->
                        <?php us_breadcrumbs(); ?>
                    <?php } ?>
                <?php } ?>

            </div>
        </div>
    </div>
    <?php
    echo $js_output;
}
