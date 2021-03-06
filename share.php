<?php
/**
 * Created by PhpStorm.
 * User: christian.dompert
 * Date: 30/03/15
 * Time: 10:59
 */

define('WP_USE_THEMES', false);
require_once( 'wp-load.php' );

global $wpdb;
global $smof_data;
$searchId = 0;
if(isset($_GET['id'])) {
    $searchId = $_GET['id'];
}else{
    wp_redirect('/');
    exit;
}



$sq_results = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM wp_vetfastevent WHERE eventId = %d",
        $searchId
    ), 'ARRAY_A'
);
if(!$sq_results){
    wp_redirect('/');
    exit;
}


if($sq_results[0]['image_url'] !=''){
    $imageUrl  = $sq_results[0]['image_url'];
}
else{
    $imageUrl  = $smof_data['custom_logo'];
}
//$imageUrl  = $smof_data['custom_logo'];//$sq_results[0]['image_url'];
?><!DOCTYPE HTML>
<html>
    <head>
        <title><?=$sq_results[0]['title']?></title>
    <meta charset="UTF-8">
    <meta property="og:title" content="<?=$sq_results[0]['title']?>" />
    <meta property="og:image" content="<?=$imageUrl?>" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:description" content="<?=htmlspecialchars($sq_results[0]['description'])?>" />
    <meta property="og:url" content="<?=home_url()?>/for-alla/program/event/<?php echo $searchId ?>" />

    </head>
<body>
<script>
  // window.location = "/vetenskapsfestivalen/program/#/event/<?php echo $searchId ?>";
  window.location = "/for-alla/program/#/event/<?php echo $searchId ?>";
</script>
</body>
</html>

