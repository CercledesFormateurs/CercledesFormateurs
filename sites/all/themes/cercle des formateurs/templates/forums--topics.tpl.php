<?php

/**
 * @file
 * Default theme implementation to display a forum which may contain forum
 * containers as well as forum topics.
 *
 * Variables available:
 * - $forums: The forums to display (as processed by forum-list.tpl.php)
 * - $topics: The topics to display (as processed by forum-topic-list.tpl.php)
 * - $forums_defined: A flag to indicate that the forums are configured.
 *
 * @see template_preprocess_forums()
 * @see theme_forums()
 */
?>
<?php 
	$title='Forum '.drupal_get_title().' | Cercle des formateurs';
	drupal_set_title($title); 
?>
<?php //if ($forums_defined): ?>
<!--<div id="forum_c">-->
  <?php //print $forums; ?>
  <?php //print $topics; ?>
<!--</div>-->
<?php //endif; ?>