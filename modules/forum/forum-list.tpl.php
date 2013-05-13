<?php
	$nb_topic_tot=0;
	$nb_comm_count=0;

/**
 * @file
 * Default theme implementation to display a list of forums and containers.
 *
 * Available variables:
 * - $forums: An array of forums and containers to display. It is keyed to the
 *   numeric id's of all child forums and containers.
 * - $forum_id: Forum id for the current forum. Parent to all items within
 *   the $forums array.
 *
 * Each $forum in $forums contains:
 * - $forum->is_container: Is TRUE if the forum can contain other forums. Is
 *   FALSE if the forum can contain only topics.
 * - $forum->depth: How deep the forum is in the current hierarchy.
 * - $forum->zebra: 'even' or 'odd' string used for row class.
 * - $forum->icon_class: 'default' or 'new' string used for forum icon class.
 * - $forum->icon_title: Text alternative for the forum icon.
 * - $forum->name: The name of the forum.
 * - $forum->link: The URL to link to this forum.
 * - $forum->description: The description of this forum.
 * - $forum->new_topics: True if the forum contains unread posts.
 * - $forum->new_url: A URL to the forum's unread posts.
 * - $forum->new_text: Text for the above URL which tells how many new posts.
 * - $forum->old_topics: A count of posts that have already been read.
 * - $forum->num_posts: The total number of posts in the forum.
 * - $forum->last_reply: Text representing the last time a forum was posted or
 *   commented in.
 *
 * @see template_preprocess_forum_list()
 * @see theme_forum_list()
 */
?>

  	<?php foreach ($forums as $child_id => $forum): //On parcourt tous les forums
  			$nb_comm_count=0;
  	?>
  		
  		<!--Si ce ne sont pas les forums conception, animation, evaluation-->
  		<?php if ( ($child_id!="5") && ($child_id!="6") && ($child_id!="7")):?>
  		
		  	<article id="forum_<?php print $child_id;?>">
		  		
		  		<!--Si c'est le forum pédagogie-->
		  		<?php if($child_id=="4"):?>
		  		<?php
					//Le forum est un container
					if ($forum->is_container) {
					
						//On charge les differents forums du container
						$ssforum=forum_forum_load($child_id)->forums;
						
						//Pour chaque forum du container
						foreach ($ssforum as $child_id => $forum)
						{
							//On récupère ses topics
    						$topics=forum_get_topics($forum->tid, 3,1000);
    						//S'il y a des sujets de discussion
    						if (!empty($topics))
    						{
    							//Pour chaque topic
		    					foreach ($topics as $topic)
		    					{
		    						//On incrémente le nombre total de topic de la partie pédagogique
		    						$nb_topic_tot++;
		    						//Si le nombre de commentaire du topic est supérieur ou égal à 0
		    						if(($topic->comment_count) >= $nb_comm_count){
			    						$nb_comm_count=$topic->comment_count;
			    						$titre= l($topic->title, "node/$topic->nid");
		    						}
			    				}
		    				}	
    					}						
					}
    					
    					
					 ?>
		  		
		  		<!--Affichage de la partie pédagogie-->
				<h2>
					<!--a href="<?php print $forum->link; ?>"-->Pédagogie
						<span class="nbreSujet"> (<?php print $nb_topic_tot; ?> sujets)</span>
					<!--/a-->
				</h2>
				<div class="detailsCategorie" id="fofoPeda">
					<ul>
						<li>
							<a href="/forum/conception"><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoConcevoir.jpg" alt="" /></a>
						</li>
						<li>
							<a href="/forum/animation"><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoAnimer.jpg" alt="" /></a>
						</li>
						<li>
							<a href="/forum/evaluation"><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoEvaluer.jpg" alt="" /></a>
						</li>
					</ul>
					<div class="btnGreen">
						<div class="nbrDebats"><span>1</span></div>
						<p><?php print $titre; ?><br/><span>(<?php print $nb_comm_count ?> commentaires)</span></p>
					</div>
				</div>
				<!--Fin forum pédagogie-->
				
				<!--Pour les autres forums-->
				<?php else :?>
				<?php
						//Le forum n'est pas un container on récupère son topic le + commenté
							if (!$forum->is_container) {
								$topics = forum_get_topics($child_id, 3,1);
	    					}
	    					
	  	    				//Si un topic existe
	    					if (!empty($topics))
	    					{
		    					foreach ($topics as $topic){
			    					$titre= l($topic->title, "node/$topic->nid");
			    					$nb_comm_count= $topic->comment_count;
		    					}	
	    					}
	    				//Sinon on note qu'il n'y a aucun topic crée pour le moment
	    					else{
		    					$titre= "Aucun topic créé";
		    					$nb_comm_count= '0';
	    					}
	    					
	    					
    					 ?>
				<h2>
					<a href="<?php print $forum->link; ?>"><?php print $forum->name;?>
						<span class="nbreSujet"> (<?php print $forum->num_topics ?> sujets)</span>
					</a>
				</h2>

					<div class="detailsCategorie">
						<a href="<?php print $forum->link; ?>" class="largePicto">
							<?php 
								$var = $child_id;
								$img = '';
								switch ($var) {
								    case 9:
								        $img='/sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoGeneral.jpg';
								        break;
								    case 2:
								        $img='/sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoPsycho.jpg';
								        break;
								    case 8:
								        $img='/sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoJuridique.jpg';
								        break;
								}
							?>
							<img src="<?php print $img; ?>" alt="" />
						</a>
						<p><?php print $forum->description; ?></p>
						
						<div class="btnGreen">
							<div class="nbrDebats"><span>1</span></div>
							<p><?php print $titre; ?><br/><span>(<?php print $nb_comm_count; ?> commentaires)</span></p>
						</div>
						
					</div>
				<?php endif; ?>
			</article>
		<?php endif; ?>
	<?php endforeach; ?>
<!--table id="forum-<?php print $forum_id; ?>">
  <thead>
    <tr>
      <th><?php print t('Forum'); ?></th>
      <th><?php print t('Topics');?></th>
      <th><?php print t('Posts'); ?></th>
      <th><?php print t('Last post'); ?></th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach ($forums as $child_id => $forum): ?>
    <tr id="forum-list-<?php print $child_id; ?>" class="<?php print $forum->zebra; ?>">
      <td <?php print $forum->is_container ? 'colspan="4" class="container"' : 'class="forum"'; ?>>
        <?php /* Enclose the contents of this cell with X divs, where X is the
               * depth this forum resides at. This will allow us to use CSS
               * left-margin for indenting.
               */ ?>
        <?php print str_repeat('<div class="indent">', $forum->depth); ?>
          <div class="icon forum-status-<?php print $forum->icon_class; ?>" title="<?php print $forum->icon_title; ?>">
            <span class="element-invisible"><?php print $forum->icon_title; ?></span>
          </div>
          <div class="name"><a href="<?php print $forum->link; ?>"><?php print $forum->name; ?></a></div>
          <?php if ($forum->description): ?>
            <div class="description"><?php print $forum->description; ?></div>
          <?php endif; ?>
        <?php print str_repeat('</div>', $forum->depth); ?>
      </td>
      <?php if (!$forum->is_container): ?>
        <td class="topics">
          <?php print $forum->num_topics ?>
          <?php if ($forum->new_topics): ?>
            <br />
            <a href="<?php print $forum->new_url; ?>"><?php print $forum->new_text; ?></a>
          <?php endif; ?>
        </td>
        <td class="posts"><?php print $forum->num_posts ?></td>
        <td class="last-reply"><?php print $forum->last_reply ?></td>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table-->

