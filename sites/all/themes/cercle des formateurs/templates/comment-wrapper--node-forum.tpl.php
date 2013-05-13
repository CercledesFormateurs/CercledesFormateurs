<?php

/**
 * @file
 * Default theme implementation to provide an HTML container for comments.
 *
 * Available variables:
 * - $content: The array of content-related elements for the node. Use
 *   render($content) to print them all, or
 *   print a subset such as render($content['comment_form']).
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default value has the following:
 *   - comment-wrapper: The current template type, i.e., "theming hook".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * The following variables are provided for contextual information.
 * - $node: Node object the comments are attached to.
 * The constants below the variables show the possible values and should be
 * used for comparison.
 * - $display_mode
 *   - COMMENT_MODE_FLAT
 *   - COMMENT_MODE_THREADED
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess_comment_wrapper()
 * @see theme_comment_wrapper()
 */
?>
<?php
		$user_fields = user_load($user->uid);
		$photo = "";
		$avatar = "default_images/defaultUser_0.png";
		if(isset($user_fields->field_photo['und']['0']['uri']) && !empty($user_fields->field_photo['und']['0']['uri'])){
			$photo = explode("/",$user_fields->field_photo['und']['0']['uri']);
			//print_r($photo);
			if(isset($photo[2]) && ($photo[2]=="")){
				$avatar = 'default_images/defaultUser_0.png';
			}
			elseif(isset($photo[3]) && ($photo[3]!="")){
				$avatar = 'pictures/'.$photo[3];
			}
			else{
				$avatar = 'pictures/'.$photo[2];
			}
		}
  if(isset($user_fields->field_pr_nom['und']['0']['value']) && !empty($user_fields->field_pr_nom['und']['0']['value'])){
      $prenom = $user_fields->field_pr_nom['und']['0']['value'];
    }
?>
<div id="comments" class="<?php print $classes; ?>"<?php print $attributes; ?>>
	<div class="bloc-comment">
	  <?php if ($content['comment_form']): ?>
		<!-- Image de l'auteur -->
		<div class="picture-author">
			<?php
				/*if(user_is_logged_in()) {
				  $user = user_load($user->uid);
				  print theme('image_style', array('style_name' => 'thumbnail', 'path' => $user->picture->uri));
				}*/
			?>
			<img src="/sites/default/files/<?php print $avatar; ?>" alt="formateur" title="formateur"/>
		</div>
		<div class="bloc-infos-author-textarea">
			<!-- Nom de l'auteur -->
			<p><?php if(user_is_logged_in()) { print $prenom; } ?></p>
			<!--- Affichage de mon formulaire personnalisé pour la soumission de commentaires -->
			<form id="<?php echo $content['comment_form']['#id']; ?>" class="<?php $content['comment_form']['#attributes']['class'] ?>" accept-charset="UTF-8" method="post" action="<?php echo $content['comment_form']['#action']; ?>">
					<div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
						<textarea id="edit-comment-body-und-0-value" class="text-full ckeditor-mod form-textarea required ckeditor-processed" rows="5" cols="60" name="comment_body[und][0][value]" style=""></textarea>
					</div>
					<input type="hidden" value="<?php echo $content['comment_form']['form_build_id']['#value']; ?>" name="<?php echo $content['comment_form']['form_build_id']['#name']; ?>">
					<input type="hidden" value="<?php echo $content['comment_form']['form_token']['#value']; ?>" name="<?php echo $content['comment_form']['form_token']['#name']; ?>">
					<input type="hidden" value="<?php echo $content['comment_form']['form_id']['#value']; ?>" name="<?php echo $content['comment_form']['form_id']['#name']; ?>">
					<div id="edit-actions" class="form-actions form-wrapper">
						<input id="edit-submit" class="form-submit" type="submit" value="Enregistrer" name="op">
					</div>
			</form>
			<!-- Fin formulaire -->
		</div>
	  <?php endif; ?>
  </div>

  <?php if ($content['comments'] && $node->type != 'forum'): ?>
    <?php print render($title_prefix); ?>
    <h2 class="title"><?php print t('Comments'); ?></h2>
    <?php print render($title_suffix); ?>
  <?php endif; ?>

  <?php print render($content['comments']); ?>
  
</div>
