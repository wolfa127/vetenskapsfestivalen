<?php
?>

<!DOCTYPE html>
<html>
<body>
<?php
//phpinfo();
echo "START";
global $wpdb;
print_r($wpdb);
$allrowsQurey = "SELECT wp_vetfastevent.* FROM wp_vetfastevent";
$results =  $wpdb->get_results( $allrowsQurey, 'ARRAY_A' );

foreach ( $results as $key => $myEvents )
{
    echo($results[$key]);
}

?>
</body>
</html>

<?php
?>