<?php
/**
 * Plugin Name: Poney Slider with Flexslider
 * Description: Slider qui utilise pour le front-end le code de flexslider et pour le back-end un code perso.
 * Author: Philippe-Arnaud de MANGOU
 */

//TODO: Faire une validation sur le formulaire. 
//TODO: Limiter le nombre de slides actifs à 5

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
// 2.1 HOOK DES FONCTIONS //

// A l'initialisation du menu, on charge la fonction pa_slider_menu
add_action(
	'admin_menu',
 	'pa_slider_menu');

// A l'initialisation de l'admin, on charge la fonction pa_slider_init
add_action(
	'admin_init',
	'pa_slider_init');

// Lorsque les scripts js d'admin sont chargés, on lit la fonction my_admin_scripts aussi
 add_action(
	'admin_enqueue_scripts',
	'my_admin_scripts'); 

//lorsque les css sont chargés, in lit la fonction my_admin_css
/*add_action(
    'wp_enqueue_scripts',
    'my_admin_css');*/


//2.2 FONCTIONS D'AFFICHAGES//
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
				'Ajout Slide',
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

			// PHP va chercher le script js du plugin poneyslider et charge-le dans le navigateur!
			function my_admin_scripts() {
				if (isset($_GET['page']) && $_GET['page'] == 'my-plugin') {
					wp_enqueue_media();
					wp_register_script('my-admin-js', WP_PLUGIN_URL.'/poneyslider/my-admin.js', array('jquery'));
					wp_enqueue_script('my-admin-js');
				}
		}
                       

            //PHP va chercher le css du plugin poneyslider et le charge dans le 
            //navigateur
          /*  function my_admin_css() {
                    wp_register_style('my-plugin', plugins_url('poneyslider/css/plugin.css'));
                    wp_enqueue_style('my-plugin');
          }*/


			// Fonction appelée en callback dans add_settings_section
			function instructions_callback() {
				echo "Veuillez entrer le titre, la description et la photo du slide.";
			}

			// Fonction permettant de mettre un champ titre à chaque slide appelé en callback dans add_settings
			function titre_callback() {
				$setting = esc_attr( get_option( 'my-setting'));
				echo "<input type='text' name='titre' />";
			}

			function description_callback() {
				$setting = esc_attr( get_option( 'my-setting'));
				echo "<textarea name='description' row='50' cols='50'>";
				echo "Entrez votre description";
				echo "</textarea>";
			}

			function image_callback() {
				echo "<label for='upload_image'>";
        echo 			"<input id='upload_image'	type='text' size='36' name='upload_image'>";
				echo 			"<input id='upload_image_button' type='button' value='Upload Image'>";
				echo 			"<br/> Entrez une Url or téléchargez une image";
				echo "</label>";
			}
	}

	function my_options_page() {
        global $wpdb;
        $slides = $wpdb->get_results(
            "
            SELECT id, titre, description, image_url
            FROM wp_slider
            "
        );

		echo "<div class='wrap'>";
		echo 		"<h2> Poney Slider feat. Flexslider </h2>";
		echo		"<form id='poney_form' action='ajout.php' method='POST'>";
								settings_fields('my-settings-group');
								do_settings_sections('my-plugin');
								submit_button();
        echo		"</form>";
				echo "</div>";
        echo "<div class='admin_slide'>";
				echo "<ul style='display:flex;'>";
        foreach ( $slides as $slide) {
        $nonce = wp_create_nonce("suppression_slide_nonce");
        $link = admin_url('admin-ajax.php?action=suppression_slide&slide_id='.$slide->id.'&nonce='.$nonce);
				echo "<li style='width: 220px;padding: 20px;'>";
        echo "<a class='suppression_slide' style='padding: 20px;'  href='".$link."' data-nonce='".$nonce."' data-slide_id='".$slide->id."'>Suppression slide</a>";
        echo "<img width='250' class='image_slide' src='".$slide->image_url."'>";
				echo "<h4 class='titre_slide'>".$slide->titre."</h4>";
        echo "<p class='description_slide'>".$slide->description."</p>";

				echo "</li>";
        }
				echo "</ul>";
        echo "</div>";
	}
    // AJAX STYLE AVEC DISGRACEFUL DEGRADATION
    add_action("wp_ajax_suppression_slide", "suppression_slide");

    function suppression_slide() {
        if (!wp_verify_nonce($_REQUEST['nonce'], "suppression_slide_nonce")) {
            exit("Pas de méchants please !");
        }

        global $wpdb;
        $id = $_REQUEST['slide_id'];
        $delete_query = $wpdb->delete('wp_slider', array('ID' => $id));

				if ($delete_query == 0) {
					$result['type'] = 'error';
					$result['log'] = 'Ca marche pas';
				}
				else {
					$result['type'] = 'success';
					$result['log'] = 'Ca marche';
				}

				$result = json_encode($result);
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode($result);
            echo $result;
        }

        else {
          header("Location: ".$_SERVER['HTTP_REFERER']);
        }
        die();
    }

    add_action('init', 'my_script_enqueuer');

    function my_script_enqueuer() {
        wp_register_script(
            "suppression_script",
            WP_PLUGIN_URL.'/poneyslider/js/suppression_script.js',
            array('jquery'));

        wp_localize_script(
            'suppression_script',
            'myAjax',
            array('ajax_url' => admin_url('admin-ajax.php')));

        wp_enqueue_script('jquery');
        wp_enqueue_script('suppression_script');
    }
