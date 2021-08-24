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

<div class="easy-vote">
    <?php
      define('EVMP_Admin', TRUE);
    ?>
    <div class="wrap">
      <h1>Easy Vote</h1>
      <ol>
        <li><?php _e('Set fields', $this->plugin_name); ?></li>
        <li><?php _e('Paste [easy_vote] shortcode to page or post', $this->plugin_name); ?></li>
      </ol>
      <?php _e('and... wait for votes =)', $this->plugin_name); ?>
      <br><br>
      <nav class="nav-tab-wrapper">
        <a href="?page=easy-vote" class="nav-tab <?php if($tab === null): ?>nav-tab-active<?php endif; ?>">Settings</a>
        <a href="?page=easy-vote&tab=votes" class="nav-tab <?php if($tab === 'votes'):?>nav-tab-active<?php endif; ?>">Votes</a>
      </nav>
      <?php 
        if($tab === null):
          $formData = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "easy_vote_forms");  
      ?>
      
        <form method="post" name="easy-vote-options" enctype="multipart/form-data">
          <table class="form-table" role="presentation">
            <tbody>
              <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-show_count"><?php _e('Show counters', $this->plugin_name); ?></label></th>
                <td>
                  <fieldset><legend class="screen-reader-text"><span><?php _e('Show counters', $this->plugin_name); ?></span></legend>
                    <input name="<?php echo $this->plugin_name; ?>-show_count" id="<?php echo $this->plugin_name; ?>-show_count" type="checkbox" id="users_can_register" value="1" <?php echo $formData->show_count ? 'checked' : ''; ?>>
                  </fieldset>
                </td>
              </tr>
              <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-class_name"><?php _e('Custom class name', $this->plugin_name); ?></label></th>
                <td><input name="<?php echo $this->plugin_name; ?>-class_name" id="<?php echo $this->plugin_name; ?>-class_name" type="text" value="<?php echo $formData->class_name; ?>" class="regular-text"></td>
              </tr>
              <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-snippet_1"><?php _e('Snippet 1', $this->plugin_name); ?></label></th>
                <td><input name="<?php echo $this->plugin_name; ?>-snippet_1" id="<?php echo $this->plugin_name; ?>-snippet_1" type="text" value="<?php echo $formData->snippet_1; ?>" class="regular-text"></td>
              </tr>
              <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-snippet_2"><?php _e('Snippet 2', $this->plugin_name); ?></label></th>
                <td><input name="<?php echo $this->plugin_name; ?>-snippet_2" id="<?php echo $this->plugin_name; ?>-snippet_2" type="text" value="<?php echo $formData->snippet_2; ?>" class="regular-text"></td>
              </tr>
              <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-snippet_3"><?php _e('Snippet 3', $this->plugin_name); ?></label></th>
                <td><input name="<?php echo $this->plugin_name; ?>-snippet_3" id="<?php echo $this->plugin_name; ?>-snippet_3" type="text" value="<?php echo $formData->snippet_3; ?>" class="regular-text"></td>
              </tr>
              <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-snippet_4"><?php _e('Snippet 4', $this->plugin_name); ?></label></th>
                <td><input name="<?php echo $this->plugin_name; ?>-snippet_4" id="<?php echo $this->plugin_name; ?>-snippet_5" type="text" value="<?php echo $formData->snippet_4; ?>" class="regular-text"></td>
              </tr>
              <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-snippet_5"><?php _e('Snippet 5', $this->plugin_name); ?></label></th>
                <td><input name="<?php echo $this->plugin_name; ?>-snippet_5" id="<?php echo $this->plugin_name; ?>-snippet_5" type="text" value="<?php echo $formData->snippet_5; ?>" class="regular-text"></td>
              </tr>
            </tbody>
          </table>
          <p class="submit"><input type="submit" name="easy-vote-submit" id="easy-vote-submit" class="button button-primary" value="<?php _e('Save'); ?>"></p>
        </form>
      <?php
        else: 
          $rankingData = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "easy_vote_ranking");

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
      <?php endif; ?>
    </div>
</div>
