<?php drupal_set_title('Forum | Cercle des formateurs'); ?>

<!--Texte de la page de forum-->
<div class="edito">
	<h1>
		Forum</h1>
	<p>Plaque tournante du Cercle des Formateurs, le forum vous permet après inscription gratuite d’échanger avec toute notre communauté de pédagogues. N’hésitez pas à consulter les différents topics, à utiliser le moteur de recherche ou à poster votre contribution si vous n’avez pas trouvé votre bonheur !</p>
</div>

<?php
	$nb_topic_tot=0;
	$nb_comm_count=0;
?>

  	<?php foreach ($forums as $child_id => $forum): //On parcourt tous les forums?>
  		
  		<!--Si ce ne sont pas les forums conception, animation, evaluation-->
  		<?php if ( ($child_id!="5") && ($child_id!="6") && ($child_id!="7")):?>
  		
		  	<article id="forum_<?php print $child_id;?>" class="fofo">
		  		
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
		    						if($topic->comment_count > $nb_comm_count){
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
					<!--a href=""-->Pédagogie
						<span class="nbreSujet"> (<?php print $nb_topic_tot; ?> sujets)</span>
					<!--/a-->
				</h2>
				<div class="detailsCategorie" id="fofoPeda">
					<ul class="categories">
						<li>
							<a href="forum/conception"><img src="sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoConcevoir.jpg" alt="" /></a>
						</li>
						<li>
							<a href="forum/animation"><img src="sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoAnimer.jpg" alt="" /></a>
						</li>
						<li>
							<a href="forum/evaluation"><img src="sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoEvaluer.jpg" alt="" /></a>
						</li>
					</ul>
					<div class="view-content">
						<ul class="top-forum">
							<li class="views-row views-row-1 views-row-odd views-row-first">
								<div class="views-field views-field-title">
									<span class="field-content">
										<?php print $titre; ?>
									</span>
								</div>
								<div class="views-field views-field-comment-count">
									<span class="field-content">
										(<?php print $nb_comm_count ?> commentaires)
									</span>
								</div>
							</li>
						</ul>
					</div>
					<!--<div class="btnGreen">
						<div class="nbrDebats"><span>1</span></div>
						<p><?php print $titre; ?><br/><span>(<?php print $nb_comm_count ?> commentaires)</span></p>
					</div>-->
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
								        $img='sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoGeneral.jpg';
								        break;
								    case 2:
								        $img='sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoPsycho.jpg';
								        break;
								    case 8:
								        $img='sites/all/themes/cercle%20des%20formateurs/img/assets/forum/pictoJuridique.jpg';
								        break;
								}
							?>
							<img src="<?php print $img; ?>" alt="" />
						</a>
						<p><?php print $forum->description; ?></p>
						
						<div class="view-content">
							<ul class="top-forum">
								<li class="views-row views-row-1 views-row-odd views-row-first">
									<div class="views-field views-field-title">
										<span class="field-content">
											<?php print $titre; ?>
										</span>
									</div>
									<div class="views-field views-field-comment-count">
										<span class="field-content">
											(<?php print $nb_comm_count ?> commentaires)
										</span>
									</div>
								</li>
							</ul>
						</div>
						
					</div>
				<?php endif; ?>
			</article>
		<?php endif; ?>
	<?php endforeach; ?>