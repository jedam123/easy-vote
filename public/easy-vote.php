<?php

/**
 * @link       #
 * @since      1.0.0
 */

if (!defined('evmp_shortcode')) {
    die('Direct access not permitted');
}
global $wpdb;

$dataForm = $wpdb->get_row( "SELECT show_count, class_name, snippet_1, snippet_2, snippet_3, snippet_4, snippet_5 FROM " . $wpdb->prefix . "easy_vote_forms WHERE id = 1");
$dataRanking = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "easy_vote_ranking WHERE post_id = " . get_the_ID() ."");

$showCounter = $dataForm->show_count;
$customClass = $dataForm->class_name;
$snippet_1 = $dataForm->snippet_1;
$snippet_2 = $dataForm->snippet_2;
$snippet_3 = $dataForm->snippet_3;
$snippet_4 = $dataForm->snippet_4;
$snippet_5 = $dataForm->snippet_5;

$ipIsOk = true;
$positiveVote = 0;
$negativeVote = 0;
$activeOnUp = false;
$activeOnDown = false;

if (!empty($dataRanking)) {
  for ($i = 0; $i < count($dataRanking); $i++) {
      if ($dataRanking[$i]->vote == 1 && $showCounter == 1) {
        $positiveVote++;
      } else if ($dataRanking[$i]->vote == 0 && $showCounter == 1) {
        $negativeVote++;
      }

      if ($dataRanking[$i]->ip_address == evmp_getIpAddress()) {
        $ipIsOk = false;

        if ($dataRanking[$i]->vote == 1) {
          $activeOnUp = true;
        } else if ($dataRanking[$i]->vote == 0) {
          $activeOnDown = true;
        }
      }
  }
}

$formId = 'easy-vote-form-' . uniqid();

?>


<form name="<?php echo $formId; ?>" class="easy-vote <?php echo $ipIsOk ? '' : 'disable '; echo $customClass; ?> ">
    <div class="easy-vote__up">
      <span class="thumb <?php echo $activeOnUp ? 'active' : ''; ?>"></span>
      <?php if ($showCounter == 1) : ?>
        <span class="easy-vote__count"><?php echo $positiveVote; ?></span>
      <?php endif;?>
    </div>
    <div class="easy-vote__down">
      <span class="thumb <?php echo $activeOnDown ? 'active' : ''; ?>"></span>
      <?php if ($showCounter == 1) : ?>
        <span class="easy-vote__count"><?php echo $negativeVote; ?></span>
      <?php endif;?>
    </div>
    <input type="hidden" name="easy-vote" value="">
</form>

  <script>
  <?php if ($ipIsOk) : ?>

  jQuery('form[name="<?php echo $formId ?>"]').find(".easy-vote__up").find('.thumb').on('click touch', function (e) {
    if (!jQuery('form[name="<?php echo $formId ?>"]').hasClass('disable') && window.localStorage.getItem('voteData-<?php echo get_the_ID(); ?>') == null) {
      var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

      jQuery.ajax({
      	type: 'post',
        url: ajaxurl,
        data: {
        	action : 'evmp_addVote',
          'vote': true,
          'postId': <?php echo get_the_ID(); ?>,
          <?php echo trim($snippet_1) != '' ? '\'snippet_1\': jQuery("' . $snippet_1 . '").text(),' : ''; ?>
          <?php echo trim($snippet_2) != '' ? '\'snippet_2\': jQuery("' . $snippet_2 . '").text(),' : ''; ?>
          <?php echo trim($snippet_3) != '' ? '\'snippet_3\': jQuery("' . $snippet_3 . '").text(),' : ''; ?>
          <?php echo trim($snippet_4) != '' ? '\'snippet_4\': jQuery("' . $snippet_4 . '").text(),' : ''; ?>
          <?php echo trim($snippet_5) != '' ? '\'snippet_5\': jQuery("' . $snippet_5 . '").text(),' : ''; ?>
          'easy-vote': jQuery('form[name="<?php echo $formId ?>"]').find('input[name="easy-vote"]').val()
        },

        success: function() {
          jQuery('form[name="<?php echo $formId ?>"]').addClass('disable');

          <?php if ($showCounter == 1) : ?>
            var counterElement = jQuery('form[name="<?php echo $formId ?>"]').find(".easy-vote__up").find('.easy-vote__count');
            var value = +jQuery(counterElement).html();
            jQuery(counterElement).text(value + 1);
          <?php endif; ?>

          jQuery('form[name="<?php echo $formId ?>"]').find(".easy-vote__up").find('.thumb').addClass('active');
          window.localStorage.setItem('voteData-<?php echo get_the_ID(); ?>' , true);
        }
      });
    }
  });

  jQuery('form[name="<?php echo $formId ?>"]').find(".easy-vote__down").find('.thumb').on('click touch', function (e) {
    if (!jQuery('form[name="<?php echo $formId ?>"]').hasClass('disable') && window.localStorage.getItem('voteData-<?php echo get_the_ID(); ?>') == null) {
    	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

      jQuery.ajax({
      	type: 'post',
        url: ajaxurl,
        data: {
        	action : 'evmp_addVote',
          'vote': false,
          'postId': <?php echo get_the_ID(); ?>,
          <?php echo trim($snippet_1) != '' ? '\'snippet_1\': jQuery("' . $snippet_1 . '").text(),' : ''; ?>
          <?php echo trim($snippet_2) != '' ? '\'snippet_2\': jQuery("' . $snippet_2 . '").text(),' : ''; ?>
          <?php echo trim($snippet_3) != '' ? '\'snippet_3\': jQuery("' . $snippet_3 . '").text(),' : ''; ?>
          <?php echo trim($snippet_4) != '' ? '\'snippet_4\': jQuery("' . $snippet_4 . '").text(),' : ''; ?>
          <?php echo trim($snippet_5) != '' ? '\'snippet_5\': jQuery("' . $snippet_5 . '").text(),' : ''; ?>
          'easy-vote': jQuery('form[name="<?php echo $formId ?>"]').find('input[name="easy-vote"]').val()
        },

    		success: function () {
          jQuery('form[name="<?php echo $formId ?>"]').addClass('disable');

          <?php if ($showCounter == 1) : ?>
            var counterElement = jQuery('form[name="<?php echo $formId ?>"]').find(".easy-vote__down").find('.easy-vote__count');
            var value = +jQuery(counterElement).html();
            jQuery(counterElement).text(value + 1);
          <?php endif; ?>

          jQuery('form[name="<?php echo $formId ?>"]').find(".easy-vote__down").find('.thumb').addClass('active');
          window.localStorage.setItem('voteData-<?php echo get_the_ID(); ?>' , false);
        }
      });
    }
  });
  <?php endif; ?>

  var localData = window.localStorage.getItem('voteData-<?php echo get_the_ID(); ?>');
  if (localData != null) {
    var thumbUp = jQuery('form[name="<?php echo $formId ?>"]').find(".easy-vote__up").find('.thumb');
    var thumbDown = jQuery('form[name="<?php echo $formId ?>"]').find(".easy-vote__down").find('.thumb');
    jQuery('form[name="<?php echo $formId ?>"]').addClass('disable');

    if (localData == "true" && !jQuery(thumbDown).hasClass('active')) {
      jQuery(thumbUp).addClass('active');
    } else {
      jQuery(thumbDown).addClass('active');
    }
  }
  </script>
