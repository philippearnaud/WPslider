<?php 

require_once('../wp-load.php');
$titre = htmlspecialchars($_POST['titre']);
$description = htmlspecialchars($_POST['description']);
$image = htmlspecialchars($_POST['upload_image']);
var_dump($titre, $description, $image);
var_dump($titre, $description, $image);

function add_entries($titre, $description, $image) {

 global $wpdb;
 $wpdb->insert('wp_slider', array(
	 'titre' => $titre,
	 'description' => $description,
	 'image_url' => $image
 ), array(
		'%s',
		'%s',
		'%s'));
}

add_entries($titre, $description, $image);
wp_redirect( admin_url( )."/themes.php?page=my-plugin" );
exit;


; ?>
