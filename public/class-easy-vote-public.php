<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    EVMP
 * @subpackage EVMP/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    EVMP
 * @subpackage EVMP/public
 * @author     Marcin Madejski
 */
class EVMP_Public {

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
	 * The form ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $formId
	 */
	private $formId;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $url ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->url = $url;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-vote.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-map', plugin_dir_url( __FILE__ ) . 'css/easy-vote.css.map', array(), $this->version, 'all' );

	}

	/**
	 * Registers shortcodes at once
	 *
	 * @since    1.0.0
	 */

	public function register_shortcodes() {
		add_shortcode( 'easy_vote', array( $this, 'evmp_shortocde' ) );
	}

	/**
	 * Registers shortcode
	 *
	 * @since    1.0.0
	 */
	public function evmp_shortocde( $atts = array() ) {
		define('evmp_shortcode', TRUE);
		$voteId = abs(crc32(uniqid()));
		$atts = shortcode_atts( array(
			'form_name' => $this->plugin_name . '-' . $voteId,
		), $atts );

		ob_start();

		include( 'easy-vote.php' );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}
}
