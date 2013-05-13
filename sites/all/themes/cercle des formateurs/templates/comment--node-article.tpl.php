<?php

/**
 * @file
 * Default theme implementation for comments.
 *
 * Available variables:
 * - $author: Comment author. Can be link or plain text.
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $created: Formatted date and time for when the comment was created.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->created variable.
 * - $changed: Formatted date and time for when the comment was last changed.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->changed variable.
 * - $new: New comment marker.
 * - $permalink: Comment permalink.
 * - $submitted: Submission information created from $author and $created during
 *   template_preprocess_comment().
 * - $picture: Authors picture.
 * - $signature: Authors signature.
 * - $status: Comment status. Possible values are:
 *   comment-unpublished, comment-published or comment-preview.
 * - $title: Linked title.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - comment: The current template type, i.e., "theming hook".
 *   - comment-by-anonymous: Comment by an unregistered user.
 *   - comment-by-node-author: Comment by the author of the parent node.
 *   - comment-preview: When previewing a new or edited comment.
 *   The following applies only to viewers who are registered users:
 *   - comment-unpublished: An unpublished comment visible only to administrators.
 *   - comment-by-viewer: Comment by the user currently viewing the page.
 *   - comment-new: New comment since last the visit.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * These two variables are provided for context:
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_comment()
 * @see template_process()
 * @see theme_comment()
 */
?>
<pre>
	<?php
		$user_fields = user_load($comment->uid);
		$photo = "";
		$avatar = "default_images/defaultUser_0.png";
		//print_r($user_fields);
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
</pre>
<div class="comment-by-all <?php print $zebra; ?><?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php //if(isset($picture)&& !empty($picture)): ?>
	<?php //print $picture;?>
  <?php //else: ?>
	<div class="user-picture">
		<img src="/sites/default/files/<?php print $avatar; ?>" alt="formateur" title="formateur"/>
	</div>
  <?php //endif; ?>
  <?php if ($new): ?>
    <!--<span class="new"><?php //print $new ?></span>-->
  <?php endif; ?>
  <div class="bloc-comment-publish">
  
	<div class="block-like">
		<!-- Aimer un commentaire -->
		<?php print flag_create_link('like_comments', $comment->cid); ?>

		<!-- Si l'utilsateur n'est pas connecté on affiche quand même le nombre de like s'un commentaire et lien grisé -->
		<?php if(!user_is_logged_in()): ?>
			<?php $flag = flag_get_flag('like_comments'); ?>
			<p class="not_loggin_number_likes"><?php print $flag->get_count($comment->cid); ?></p>
			<a href="/User" class="not-loggin-flag-desactive" title="Vous devez vous inscrire ou vous connectez pour indiquer que vous approuvez ce commentaire">
				Approuver
			</a>
		<?php endif; ?>
	</div>
	
	<div class="the-comment-publish">
	  <div class="date"> 
		<?php  print 'le&nbsp;'.format_date($comment->created, 'custom', 'd/m/Y').'&nbsp;à&nbsp;'.format_date($comment->created, 'custom', 'H:i'); ?>
	  </div>

	  <div class="content"<?php print $content_attributes; ?>>
		<h3><?php print $prenom ?></h3>
		<?php
		  // We hide the comments and links now so that we can render them later.
		  hide($content['links']);
		  print render($content);
		?>
		<?php if ($signature): ?>
		<div class="user-signature clearfix">
		  <?php print $signature ?>
		</div>
		<?php endif; ?>
	  </div>

	  <div class="comment-links">
		  <!-- Supression des liens que je ne veux pas afficher ici -->
		  <?php //unset($content['links']['comment']['#links']['comment-edit']); ?>
		  <?php //unset($content['links']['comment']['#links']['comment-reply']); ?>
		  <?php print render($content['links']['comment']); ?>
		  <!-- Signaler un abus -->
		  <?php print flag_create_link('abuse_link', $comment->cid); ?>
	  </div>
	</div>
	
  </div>
  
</div>