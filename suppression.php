<?php 
//TODO: Le script permettant d'installer/désinstaller ce fichier dans le 
//répertoire wp-admin
require_once('../wp-load.php');
$id = htmlspecialchars($_GET['id']);

global $wpdb;
$wpdb->delete('wp_slider', array('ID' => $id));

wp_redirect( admin_url( )."/themes.php?page=my-plugin" );
exit;
?>  
