<?php
/**
 * @link       #
 * @since      2.0.0
 * @author     Marcin Madejski
 * @package    EVMP
 * @subpackage EVMP/admin/partials
 */
  
  global $wpdb;
  $rankingData = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "easy_vote_ranking");
?>

<div class="evmp-votes">
  <?php
    define('EVMP_Admin', TRUE);

    if (empty($rankingData)) :
      echo '<div class="evmp-empty-state">
              NO RESULTS :(
            </div>';
    else:
  ?>

  <div class="evmp-votes__row evmp-votes__row--header" style="font-weight: bold;">
    <div style="width: 80px;">ID</div>
    <div style="width: 120px;">Vote</div>
    <div style="width: 120px;">Post ID</div>
    <div style="width: 300px;">IP Address</div>
    <div style="width: 300px;">Time</div>
  </div>
    
  <?php 
    $i = 1;
    foreach ($rankingData as $row) {
      $vote = $row->vote;
      $voteResult =  $vote == 1 ? 'yes' : 'no' ;

      echo '<div class="evmp-votes__row">
              <div style="width: 80px;">' . $i . '</div>
              <div style="width: 120px;">' . $voteResult . '</div>
              <div style="width: 120px;">' . $row->post_id . '</div>
              <div style="width: 300px;">' . $row->ip_address . '</div>
              <div style="width: 300px;">' . $row->timestamp . '</div>
            </div>';
      $i++;
    }
  ?>
  <?php endif; ?>
</div>
