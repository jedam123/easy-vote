<?php

/**
 * @link       #
 * @since      1.0.0
 * @author     Marcin Madejski
 * @package    EVMP
 * @subpackage EVMP/admin/partials
 */

  global $wpdb;
  $tab = $_GET['tab'];
?>

<div class="evmp-admin">
  <?php
    define('EVMP_Admin', TRUE);
  ?>
  <div class="evmp-admin__header">
    <div class="evmp-admin__logo"></div>
    <div class="evmp-admin__tabs">
      <a href="?page=easy-vote"><?php _e('Settings', $this->plugin_name); ?></a>
      <a href="?page=easy-vote&tab=votes"><?php _e('Votes', $this->plugin_name); ?></a>
      <a href="?page=easy-vote&tab=help"><?php _e('Help', $this->plugin_name); ?></a>
    </div>
  </div>
  <div class="evmp-admin__content">
  <?php
    switch ($tab) {
      case 'votes':
        include_once 'partials/votes.php';
        break;

      case 'help':
        include_once 'partials/help.php';
        break;
          
      default:
        include_once 'partials/settings.php';
        break;
    }
  ?>
  </div>
</div>
