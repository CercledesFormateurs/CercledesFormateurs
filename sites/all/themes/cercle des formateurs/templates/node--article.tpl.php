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
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>  
		  <!-- Contenu du sujet -->
 <div class="content">
 <?php
		$term = field_get_items('node', $node, 'field_cat_gorie', $node->language);
		$tid = $term[0]['tid'];
		$term = taxonomy_term_load($tid);
		$actualite_name = strtolower($term->name);
		$actualite_name = ($actualite_name == 'général') ? 'générales' : $actualite_name;
 ?>
	
<!- --------------------------------------------------- GAUCHE --------------------------------------------------- ->
<?php if(isset($content['body']['#object']) && !empty($content['body']['#object'])): ?>
		<div id="leftColumn">
			<div class="article">
				<?php
					if($actualite_name=="pédagogie"){
						$actualite_name="pedagogie";
					}
				?>
				<a class="backBtn btn" href="/actualites/actualites-<?php echo $actualite_name; ?>"><span></span></a>

				<h2> <?php print render($content['body']['#object']->title); ?></h2>

				<?php if(isset($content['body']['#object']->created) && !empty($content['body']['#object']->created)): ?>
					<div id="date">Publié le <?php print date("d/m/y",$content['body']['#object']->created)?></div>
				<?php endif; ?>
				<?php if(isset($content['body']['#object']->field_art_accroche['und'][0]['value']) && !empty($content['body']['#object']->field_art_accroche['und'][0]['value'])): ?>
					<p id="accroche"><?php print render($content['body']['#object']->field_art_accroche['und'][0]['value']); ?></p>
				<?php endif; ?>
				<?php if(isset($content['body']['#object']->field_image['und'][0]['filename']) && !empty($content['body']['#object']->field_image['und'][0]['filename'])): ?>
					<img src="/sites/default/files/field/image/<?php print $content['body']['#object']->field_image['und'][0]['filename']; ?>" alt="article"/>
				<?php endif; ?>
				<div class="article-content">
					<?php if(isset($content['body']['#object']->body['und'][0]['value']) && !empty($content['body']['#object']->body['und'][0]['value'])): ?>
						<p><?php print render($content['body']['#object']->body['und'][0]['value']); ?></p>
					<?php endif; ?>
				</div>
			</div>
		
		</div>
<?php endif; ?>
		<!- --------------------------------------------------- DROITE --------------------------------------------------- ->
		<?php
		$avatar = 'default_images/defaultUser_0.png';
		$photo = "";
		if(isset($content['body']['#object']->uid) && !empty($content['body']['#object']->uid)){
			$user_fields = user_load($content['body']['#object']->uid);
		}
		//print_r($user_fields);
		if(isset($user_fields) && isset($user_fields->field_photo['und']['0']['uri']) && !empty($user_fields->field_photo['und']['0']['uri'])){
			$photo = explode("/",$user_fields->field_photo['und']['0']['uri']);
			//print_r($photo);
			if($photo[2]==""){
				$avatar = 'default_images/defaultUser_0.png';
			}
			elseif($photo[3]!=""){
				$avatar = 'pictures/'.$photo[3];
			}
			else{
				$avatar = 'pictures/'.$photo[2];
			}
		}
		 $link=$uid.'/'.preg_replace("/[^0-9a-zA-Z]+/", "", $user_fields->name);
	?>
		<div id="rightColumn">
			<div class="article">
				<h3>A propos de l'auteur</h3>
				<div class="formateurs">
					<table>
						<tr>
							<td class="vignette">
								<a href="/user/<?php print $link?>">
									<img src="/sites/default/files/<?php print $avatar; ?>" alt="formateur" title="formateur" width="55" height="55"/>
								</a>
							</td>
							<td class="infos_auteur">
								<h4><a href="/user/<?php print $link?>"><?php print $user_fields->field_nom['und']['0']['value']; ?></a></h4>
								<h5><?php print $user_fields->field_pr_nom['und']['0']['value']; ?></h5>
							</td>
						</tr>
					
					</table>
					
					<ul>
						<?php if($user_fields->field_societe['und']['0']['value']!="") { ?>
							<li>- Formateur à “<?php print $user_fields->field_societe['und']['0']['value']; ?>”</li>
						<?php } ?>
						<?php
							$uid= $content['body']['#object']->uid;
							$response = db_query('SELECT cp.title as title, t.name as name, n.vid as vid FROM {commerce_product} cp, {node} n, {field_data_field_type_contenu} fc, {taxonomy_term_data} t WHERE cp.product_id = fc.entity_id AND fc.field_type_contenu_tid = t.tid AND cp.title = n.title AND cp.uid = :uid LIMIT 2',array(':uid' => $uid));
							foreach ($response as $record) {
								$vid='node/'.$record->vid;
								$response1 = db_query('SELECT alias FROM {url_alias} WHERE source=:vid',array(':vid' => $vid));
								foreach ($response1 as $record1) {
									print '<li>- '.$record->name.' <a href="/'.$record1->alias.'">'.$record->title.'</a></li>';
								}
							}
						?>
						<!--?php

						/*Objectif : Le faire en 2 requêtes au max!!!!! I DID IT !!!*/
							/*Première requete : Je récupère le titre du document*/
							$uid= $content['body']['#object']->uid;
							$response = db_query('SELECT product_id,title FROM {commerce_product} WHERE uid=:uid LIMIT 10',array(':uid' => $uid));
							foreach ($response as $record) {
								/*Seconde requête : Je recupère le numéro du type de document*/
								$prod_id=$record->product_id;
								$response2 = db_query('SELECT field_type_contenu_tid FROM {field_data_field_type_contenu} WHERE entity_id=:idp',array(':idp' => $prod_id));
								foreach ($response2 as $record1) {
									/*Troisième requête : Je récupère le type de document*/
									$tid=$record1->field_type_contenu_tid;
									$response3 = db_query('SELECT name FROM {taxonomy_term_data} WHERE tid=:tid',array(':tid' => $tid));
									foreach ($response3 as $record2) {
										/*Quatrième requête : On récupère le numéro du node du produit*/
										$titlep = $record->title;
										$response4 = db_query('SELECT vid FROM {node} WHERE title=:title',array(':title' => $titlep));
										foreach ($response4 as $record3) {
											/*Cinquième requête : On récupère l'url du node*/
											$vid='node/'.$record3->vid;
											$response5 = db_query('SELECT alias FROM {url_alias} WHERE source=:vid',array(':vid' => $vid));
											foreach ($response5 as $record4) {
												print '<li>- '.$record2->name.' <a href="/'.$record4->alias.'">'.$record->title.'</a></li>';
											}
										}
									}
								}
							}
						?-->
					</ul>
				</div>	
			</div>
		</div>
  
  <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
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
</div>