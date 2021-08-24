<?php
/**
 * The plugin Easy Vote
 *
 * @link              #
 * @since             1.0.0
 * @package           EVMP
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Vote
 * Plugin URI:        https://github.com/jedam123/easy-vote
 * Description:				Easy Vote allows you to save additional data. The fields snippet 1, snippet 2, snippet 3, snippet 4 or snippet 5 in admin panel reference to the class or ids you want to save. The reference works through jQuery. If we want to save the data that is in the container with the id 'test' in snippet x, just type #test and the data will be saved
 * Version:           1.1
 * Author:            Madejski-Project
 * Author URI:        https://github.com/jedam123
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       easy-vote
 * Domain Path:       /languages
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EVMP_PLUGIN_NAME_VERSION', '1.1' );
define( 'EVMP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// The code that runs during plugin activation
function evmp_activate() {
	global $wpdb;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$installed_version = get_option('evmp_db_version');

	$sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "easy_vote_forms (
					id INT NOT NULL auto_increment,
					show_count BOOLEAN NOT NULL,
					class_name varchar(255),
					snippet_1 varchar(255),
					snippet_2 varchar(255),
					snippet_3 varchar(255),
					snippet_4 varchar(255),
					snippet_5 varchar(255),
					last_mod_date DATE,
					PRIMARY KEY  (id)
				) ". $charset_collate .";";
	dbDelta($sql);

	$sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "easy_vote_ranking (
					id INT NOT NULL auto_increment,
					ip_address varchar(255),
					timestamp DATETIME,
					post_id INT,
					vote BOOLEAN NOT NULL,
					comment varchar(255),
					snippet_1 varchar(255),
					snippet_2 varchar(255),
					snippet_3 varchar(255),
					snippet_4 varchar(255),
					snippet_5 varchar(255),
					PRIMARY KEY  (id)
				) ". $charset_collate .";";

	dbDelta($sql);

	$data = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "easy_vote_forms WHERE id = 1");

	if (empty($data)) {
		$table = $wpdb->prefix . 'easy_vote_forms';
		$data = array(
					'id' => '',
					'show_count' => true,
					'class_name' => '',
					'snippet_1' => '',
					'snippet_2' => '',
					'snippet_3' => '',
					'snippet_4' => '',
					'snippet_5' => '',
					'last_mod_date' => date("Y-m-d")
				);
		$wpdb->insert($table, $data);
	}

	update_option('evmp_db_version', EVMP_PLUGIN_NAME_VERSION);
}


// The code that runs during plugin deactivation
function evmp_deactivate() {

}

register_activation_hook( __FILE__, 'evmp_activate' );
register_deactivation_hook( __FILE__, 'evmp_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-easy-vote.php';

function evmp_getIpAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

function evmp_addVote() {
	global $wpdb;

	$snippet_1 = '';
	$snippet_2 = '';
	$snippet_3 = '';
	$snippet_4 = '';
	$snippet_5 = '';

	if (isset($_POST['snippet_1'])) {
		$snippet_1 = sanitize_html_class($_POST['snippet_1'], ' ');
	}

	if (isset($_POST['snippet_2'])) {
		$snippet_2 = sanitize_html_class($_POST['snippet_2'], ' ');
	}

	if (isset($_POST['snippet_3'])) {
		$snippet_3 = sanitize_html_class($_POST['snippet_3'], ' ');
	}

	if (isset($_POST['snippet_4'])) {
		$snippet_4 = sanitize_html_class($_POST['snippet_4'], ' ');
	}

	if (isset($_POST['snippet_5'])) {
		$snippet_5 = sanitize_html_class($_POST['snippet_5'], ' ');
	}

	$table = $wpdb->prefix . 'easy_vote_ranking';
	$data = array(
				'id' => '',
				'ip_address' => sanitize_text_field(evmp_getIpAddress()),
				'timestamp' => date("Y-m-d H:i:s"),
				'post_id' => intval($_POST['postId']),
				'vote' => rest_sanitize_boolean($_POST['vote']),
				'comment' => '',
				'snippet_1' => $snippet_1,
				'snippet_2' => $snippet_2,
				'snippet_3' => $snippet_3,
				'snippet_4' => $snippet_4,
				'snippet_5' => $snippet_5
	);

	$result = $wpdb->insert($table, $data);
}

add_action('wp_ajax_evmp_addVote', 'evmp_addVote');
add_action('wp_ajax_nopriv_evmp_addVote', 'evmp_addVote');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function evmp_run() {

	$plugin = new EVMP();
	$plugin->run();

}
evmp_run();
