<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Easy_Vote
 * @subpackage Easy_Vote/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy_Vote
 * @subpackage Easy_Vote/admin
 * @author     Marcin Madejski
 */
class Easy_Vote_Admin {

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
			$table = $wpdb->prefix . 'easy_vote';
			$where = [ 'id' => 1 ];
			$data = array(
				'id' => 1,
				'create_date' => date("Y-m-d"),
				'last_mod_date' => date("Y-m-d"),
				'show_count' => sanitize_key($_POST['easy-vote-count']),
				'class_name' => sanitize_text_field($_POST['easy-vote-class'])
			);

			$wpdb->update($table, $data, $where);
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
