<?php
/**
 * @link       #
 * @since      2.0.0
 * @author     Marcin Madejski
 * @package    EVMP
 * @subpackage EVMP/admin/partials
 */

  global $wpdb;
  $formData = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "easy_vote_forms");  
?>

<div class="evmp-settings">
  <?php
    define('EVMP_Admin', TRUE);
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
</div>
