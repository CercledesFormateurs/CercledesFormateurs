<?php

/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
?>
<!--pre-->
	<?php
	
		$user_fields = user_load($uid);
		//print_r($user_fields);
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
		 $link=preg_replace("/[^0-9a-zA-Z]+/", "", $user_fields->name);
	?>
<!--/pre-->
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>> 
	<?php
		$term = taxonomy_term_load($node->forum_tid);
		$forum_name = strtolower($term->name);
	?>
	<div class="subject-topic">
		<div class="node-picture-author">
			<img src="/sites/default/files/<?php print $avatar; ?>" alt="formateur" title="formateur"/>
		</div>
		<div class="present-topic">
		  <?php print render($title_prefix); ?>
			<h2<?php print $title_attributes; ?>>"<?php print trim($title); ?>"</h2>
		  <?php print render($title_suffix); ?>

		  <?php if ($display_submitted): ?>
			<div class="submitted">
			  <?php /*print $submitted;*/ print '<span>Soumis par <a href="/user/'.$uid.'/'.$link.'">'.$prenom.'</a> le '.date('d/m/Y H:i', $node->created).'</span>';?>
			</div>
		  <?php endif; ?>
		  <!-- Contenu du sujet -->
		  <?php print render($content['body']); ?>
		  <?php if(user_is_logged_in()) :?>
			<?php if(array_key_exists(3, $user->roles) || array_key_exists(5, $user->roles) 
			|| (array_key_exists(6, $user->roles) && $user->uid == $uid) 
			|| (array_key_exists(2, $user->roles) && $user->uid == $uid)) : ?>
			  <div class="action-link">
				  <a class="active" href="<?php echo url("node/{$node->nid}/edit", array('absolute'=>false)); ?>">
					modifier</a>
				  <a class="active" href="<?php echo url("node/{$node->nid}/delete", array('absolute'=>false)); ?>">
					supprimer
				  </a>
				</a>
			 </div>
			<?php endif; ?>
		<?php endif; ?>
		</div>
	</div>

	<!-- Ajout d'un bouton retour -->
	<div class="forum-back">
		<hr><form action="<?php echo "/forum/".$forum_name; ?>"><input type="submit" value="Retour"></form>
	</div>
	
  <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      //print render($content);
    ?>
  </div>

  <?php
    // Only display the wrapper div if there are links.
    $links = render($content['links']);
  ?>
	<?php if(user_is_logged_in()) : ?>
		<div class="link-wrapper">
			<a class="active" href="<?php echo url("node/{$node->nid}", array('absolute'=>false))."#".$content['comments']['comment_form']['#id']; ?>">
				Ajouter un commentaire
			</a>
		</div>
	<?php else: ?>
		<div class="link-wrapper">
			<?php print $links; ?>
		</div>
	<?php endif; ?>
  <?php print render($content['comments']); ?>

</div>