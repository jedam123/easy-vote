<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    EVMP
 * @subpackage EVMP/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    EVMP
 * @subpackage EVMP/admin
 * @author     Marcin Madejski
 */
class EVMP_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The url of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $url
	 */
	private $url;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $url ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->url = $url;

	}

	/**
	 * Save and update fields
	 *
	 * @since    1.0.0
	 */
	public function options_update() {
		if(isset($_POST['easy-vote-submit']) && current_user_can('manage_options')) {
			global $wpdb;
			ob_start();

			$table = $wpdb->prefix . 'easy_vote_forms';
			$where = [ 'id' => 1 ];
			$data = array(
				'id' => 1,
				'show_count' => sanitize_key($_POST['easy-vote-show_count']),
				'class_name' => sanitize_text_field($_POST['easy-vote-class_name']),
				'snippet_1' => sanitize_text_field($_POST['easy-vote-snippet_1']),
				'snippet_2' => sanitize_text_field($_POST['easy-vote-snippet_2']),
				'snippet_3' => sanitize_text_field($_POST['easy-vote-snippet_3']),
				'snippet_4' => sanitize_text_field($_POST['easy-vote-snippet_4']),
				'snippet_5' => sanitize_text_field($_POST['easy-vote-snippet_5']),
				'last_mod_date' => date("Y-m-d")
			);

			$wpdb->update($table, $data, $where);

			$output = ob_get_contents();
			ob_end_clean();
		}
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {
		add_menu_page( 'Easy Vote', 'Easy Vote', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), 'dashicons-yes', 81 );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
		include_once( 'easy-vote.php' );
	}
}
