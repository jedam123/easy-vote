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
      echo '<div>NO RESULTS :(</div>';
    else:
  ?>
  <table class="evmp-table" style="margin-top: 40px;">
    <tr class="evmp-table__row evmp-table__row--header" style="font-weight: bold;">
      <td style="width: 80px;">ID</td>
      <td style="width: 120px;">Vote</td>
      <td style="width: 120px;">Post ID</td>
      <td style="width: 300px;">IP Address</td>
      <td style="width: 300px;">Time</td>
    </tr>
    
    <?php 
      $i = 1;
      foreach ($rankingData as $row) {
        $vote = $row->vote;
        $voteResult =  $vote == 1 ? 'yes' : 'no' ;

        echo '<tr class="evmp-table__row">
                <td style="width: 80px;">' . $i . '</td>
                <td style="width: 120px;">' . $voteResult . '</td>
                <td style="width: 120px;">' . $row->post_id . '</td>
                <td style="width: 300px;">' . $row->ip_address . '</td>
                <td style="width: 300px;">' . $row->timestamp . '</td>
              </tr>';
        $i++;
      }
    ?>
  </table>
  <?php endif; ?>
</div>
