<?php global $smof_data; ?>
<?php
if ( ! defined('THEME_TEMPLATE') AND FALSE) { ?>
	</div>
	</div>
<?php } ?>
</div>
<!-- /MAIN -->

</div>
<!-- /CANVAS -->


<a class="w-toplink" href="#"><i class="fa fa-angle-up"></i></a>
<?php
$l_submain_padding = NULL;
if (@$smof_data['header_is_sticky'] == 1 AND @$smof_data['main_header_layout'] == 'standard' AND ( ! empty($smof_data['header_main_height']) AND $smof_data['header_main_height'] >= 50 AND $smof_data['header_main_height'] <= 150)) {
	$l_submain_padding = $smof_data['header_main_height'];
} elseif (@$smof_data['header_is_sticky'] == 1 AND in_array(@$smof_data['main_header_layout'], array('extended', 'advanced', 'centered')) AND ( ! empty($smof_data['header_main_height']) AND $smof_data['header_main_height'] >= 50 AND $smof_data['header_main_height'] <= 150) AND ( ! empty($smof_data['header_extra_height']) AND $smof_data['header_extra_height'] >= 36 AND $smof_data['header_extra_height'] <= 60)) {
	$l_submain_padding = $smof_data['header_main_height'] + $smof_data['header_extra_height'];
}
?>
<script type="text/javascript">
<?php if ( ! empty($smof_data['mobile_nav_width']) AND $smof_data['mobile_nav_width'] < "1024") {?>window.mobileNavWidth = "<?php echo $smof_data['mobile_nav_width']; ?>";<?php } ?>
<?php if ( ! empty($smof_data['logo_height']) AND $smof_data['logo_height'] != "30") {?>window.logoHeight = "<?php echo $smof_data['logo_height']; ?>";<?php } ?>
<?php if ( ! empty($smof_data['logo_height_sticky']) AND $smof_data['logo_height_sticky'] != "30") {?>window.logoHeightSticky = "<?php echo $smof_data['logo_height_sticky']; ?>";<?php } ?>
<?php if ( ! empty($smof_data['mobile_nav_width']) AND $smof_data['mobile_nav_width'] != "1000") {?>window.mobileNavWidth = "<?php echo $smof_data['mobile_nav_width']; ?>";<?php } ?>
<?php if ($l_submain_padding) { ?>window.firstSubmainPadding = <?php echo $l_submain_padding; ?>;<?php } ?>
</script>
<?php if($smof_data['tracking_code'] != "") { echo $smof_data['tracking_code']; } ?>
<?php wp_footer(); ?>
</body>
</html>
