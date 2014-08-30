<?php
/**
 * Plugin Name: Poney Slider with Flexslider
 * Description: Slider qui utilise pour le front-end le code de flexslider et pour le back-end un code perso.
 * Author: Philippe-Arnaud de MANGOU
 */

defined('ABSPATH') or die("No script kiddies please!");

define('PA_URL', plugin_dir_url(__FILE__) );
define('PA_DIR', plugin_dir_path(__FILE__));
define('PA_VERSION', '1.0');
define('PA_OPTION', 'pa_ext');


// 1 -- INSTALL - UNINSTALL WP_SLIDER TABLE //
//
// Les fonctions d'ajout/activation et suppression/désactivation de table
function create_slider_table() {
	global $wpdb;
	$sql = "CREATE TABLE `wp_slider` (
	  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
    `titre` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `image_url` text NOT NULL,
      PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
	//dbDelta vérifie si la table existe déjà, à défaut elle exécute $sql
	dbDelta( $sql );
}

function destroy_slider_table() {
	global $wpdb;
	$sql = "DROP TABLE `wp_slider`;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
	$wpdb->query( $sql );
}

// On bind les fonctions d'ajout et de suppression aux hooks correspondants
register_activation_hook(__FILE__, 'create_slider_table');
register_deactivation_hook(__FILE__, 'destroy_slider_table');


// 2 -- AFFICHAGE DU MENU DANS L'ADMIN //
add_action(
	'admin_menu',
 	'pa_slider_menu');

add_action(
	'admin_init',
	'pa_slider_init');

	function pa_slider_menu() {
		//add_theme_page($page_title, $menu_title, $capability, $menu_slug, $function)
		add_theme_page(
			'Poney Slider',
			'Poney Slider',
			'manage_options',
			'my-plugin',
		 	'my_options_page');
	}

	function pa_slider_init() {

			// register_setting($option_group, $option_name, $sanitize_callback)
		register_setting(
			'my-settings-group',
		 	'my-setting');

			//add_settings_section($id, $title, $callback, $page)
			//Slide 1
			add_settings_section(
				'slide-un',
				'Premier slide',
				'instructions_callback',
			 	'my-plugin');

			//Slide 2
			add_settings_section(
				'slide-deux',
				'Deuxième Slide',
				'instructions_callback',
				'my-plugin');

			//Slide 3
			add_settings_section(
				'slide-trois',
				'Troisième slide',
				'instructions_callback',
			 	'my-plugin');

			//Slide 4
			add_settings_section(
				'slide-quatre',
				'Quatrième Slide',
				'instructions_callback',
				'my-plugin');


			//add_settings_field($id, $title, $callback, $page, $section, $args)
			//Champs de la section 1
			add_settings_field(
				'slide-un-titre',
				'Titre',
				'titre_callback',
				'my-plugin',
			 	'slide-un');

			add_settings_field(
				'slide-un-description',
				'Description',
				'description_callback',
				'my-plugin',
				'slide-un');

			add_settings_field(
				'slide-un-image',
				'Image',
				'image_callback',
				'my-plugin',
				'slide-un');

			//Champs de la section2
			add_settings_field(
				'slide-deux-titre',
				'Titre',
				'titre_callback',
				'my-plugin',
			 	'slide-deux');

			add_settings_field(
				'slide-deux-description',
				'Description',
				'description_callback',
				'my-plugin',
				'slide-deux');

			add_settings_field(
				'slide-deux-image',
				'Image',
				'image_callback',
				'my-plugin',
				'slide-deux');

			// Champs du slide 3
			add_settings_field(
			 	'slide-trois-titre',
				'Titre',
				'titre_callback',
				'my-plugin',
			 	'slide-trois');

			add_settings_field(
				'slide-trois-description',
				'Description',
				'description_callback',
				'my-plugin',
				'slide-trois');

			add_settings_field(
				'slide-trois-image',
				'Image',
				'image_callback',
				'my-plugin',
				'slide-trois');

			//Champs de la section4
			add_settings_field(
				'slide-quatre-titre',
				'Titre',
				'titre_callback',
				'my-plugin',
			 	'slide-quatre');

			add_settings_field(
				'slide-quatre-description',
				'Description',
				'description_callback',
				'my-plugin',
				'slide-quatre');

			add_settings_field(
				'slide-quatre-image',
				'Image',
				'image_callback',
				'my-plugin',
				'slide-quatre');


			// Fonction appelée en callback dans add_settings_section
			function instructions_callback() {
				echo "Veuillez entrer le titre, la description et la photo du slide.";
			}

			// Fonction permettant de mettre un champ titre à chaque slide appelé en callback dans add_settings
			function titre_callback() {
				$setting = esc_attr( get_option( 'my-setting'));
				echo "<input type='text' name='my-setting' value='$setting' />";
			}

			function description_callback() {
				$setting = esc_attr( get_option( 'my-setting'));
				echo "<textarea name='my-settings' row='50' cols='50'>";
				echo "Entrez votre description";
				echo "</textarea>";
			}

			function image_callback() {
				echo "<a href='#' id='retrieve-media-url' class='button'/>";
				echo "Récupérer l'URL du média";
				echo "</a>";
			}
	}

	function my_options_page() {
		echo "<div class='wrap'>";
		echo 		"<h2> Poney Slider feat. Flexslider </h2>";
		echo		"<form action='options.php' method='POST'>";
								settings_fields('my-settings-group');
								do_settings_sections('my-plugin');
								submit_button();
	  echo		"</form>";
		echo "</div>";
	}

