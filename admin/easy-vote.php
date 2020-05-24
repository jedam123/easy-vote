<?php

/**
 * @link       #
 * @since      1.0.0
 * @author     Marcin Madejski
 * @package    Easy_Vote
 * @subpackage Easy_Vote/admin/partials
 */
global $wpdb;

$rankingData = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "easy_vote_ranking");
$formData= $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "easy_vote_froms");

?>

<div class="easy-vote-options">
    <?php
      define('Easy_Vote_Admin', TRUE);
    ?>

    <h1>How it works?</h1>
    <ol>
      <li>Set fields</li>
      <li>Paste [easy_vote] shortcode on page or post</li>
    </ol>
    and... use it.
    <br><br>
    <h1>Settings</h1>
    <form>
      <div>
      Show counter:<br>
      <input type="checkbox">
      </div>

      <div>
        Custom class name:<br>
        <input type="text">
      </div>

      <div>
        <input type="submit" value="Save">
      </div>
    </form>
</div>
