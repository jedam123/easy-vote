<?php

/**
 * @link       #
 * @since      2.0.0
 * @author     Marcin Madejski
 * @package    EVMP
 * @subpackage EVMP/admin/partials
 */
?>

<div class="evmp-help">
  <?php
    define('EVMP_Admin', TRUE);
  ?>
  <ol>
    <li><?php _e('Set fields', $this->plugin_name); ?></li>
    <li><?php _e('Paste [easy_vote] shortcode to page or post', $this->plugin_name); ?></li>
  </ol>
  <?php _e('and... wait for votes =)', $this->plugin_name); ?>
</div>
