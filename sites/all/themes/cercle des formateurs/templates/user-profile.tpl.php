<pre>
	<?php 
		$tit = $elements['#account']->field_pr_nom['und']['0']['value'].' '.$elements['#account']->field_nom['und']['0']['value'].' | Cercle des formateurs';
		drupal_set_title($tit); 
		$uid = $elements['#account']->uid;
		if(isset($elements['#account']->field_photo['und']['0']['uri']) && !empty($elements['#account']->field_photo['und']['0']['uri'])){
			$photo = explode("/",$elements['#account']->field_photo['und']['0']['uri']);
		}
		if($photo[2]=="default_images"){
			$avatar = $photo[2].'/'.$photo[3];
		}
		elseif($photo[3]!=""){
			$avatar = 'pictures/'.$photo[3];
		}
		else{
			$avatar = 'pictures/'.$photo[2];
		}
		
	?>
</pre>
<div class="edito">
				<h1>Fiche Profil</h1>
			</div>
			
			<h2 class="titleSubGrey">Ses informations actuelles</h2>
			<div class="greyBloc">
				<?php

					$role= db_query('SELECT count(*) as has_role FROM {users_roles} WHERE uid = :uid',array(':uid' => $uid));
					foreach ($role as $rol) {
						if($rol->has_role > 0){
							$authen=true;
						}
						else{
							$authen=false;
						}
					}

					if($authen){
						$types="document_affiche";
						$doc= db_query('SELECT count(*) as count_doc FROM {node} WHERE type = :type AND uid = :uid',array(':type' => $types, ':uid' => $uid));
						//print '<pre>';
						foreach ($doc as $docu) {
							print '<p><span>'.$docu->count_doc.'</span>Document(s) posté(s)</p>';
						}

						$type="article";
						$art= db_query('SELECT count(*) as count_art FROM {node} WHERE type = :type AND uid = :uid',array(':type' => $type, ':uid' => $uid));
						//print '<pre>';
						foreach ($art as $article) {
							print '<p><span>'.$article->count_art.'</span>Article(s) posté(s)</p>';
						}
						
						$response = db_query('SELECT count(*) as count_comm FROM {comment} WHERE uid=:uid',array(':uid' => $uid));
						//print '<pre>';
						foreach ($response as $record) {
							print '<p><span>'.$record->count_comm.'</span>Commentaire(s) posté(s)</p>';
						}
					}
					else{
						$response = db_query('SELECT count(*) as count_comm FROM {comment} WHERE uid=:uid',array(':uid' => $uid));
						foreach ($response as $record) {
							if($record->count_comm < 5){
								$textmb='Nouveau Membre';
							}
							elseif ($record->count_comm < 50) {
								$textmb='Membre régulier';
							}
							elseif ($record->count_comm < 200) {
								$textmb='Membre aguerri';
							}
							else{
								$textmb='Membre vétéran';
							}
							print '<p><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/iconMember.png" />'.$textmb.'</p>';
							print '<p><span>'.$record->count_comm.'</span>Commentaire(s) posté(s)</p>';
						}
					}
				?>

				<table>
					<tr>
						<td class="vignette">
							<img src="/sites/default/files/<?php print $avatar; ?>" alt="contributeur" title="Contributeur" />
						</td>
						<td>
							<div id="name-contributor">
								<h4><?php  
									if(isset($elements['#account']->field_pr_nom['und']['0']['value']) && !empty($elements['#account']->field_pr_nom['und']['0']['value'])){
										print_r($elements['#account']->field_pr_nom['und']['0']['value']);
									}
									?>
								</h4>
								<h5><?php 
									if(isset($elements['#account']->field_nom['und']['0']['value']) && !empty($elements['#account']->field_nom['und']['0']['value'])){
										print_r($elements['#account']->field_nom['und']['0']['value']); 
									}
									?>
								</h5>
							</div>
							
							<?php 
							if($authen){
								print '<p id="date-contribution">Contributeur depuis ';
								setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
								print ucfirst(strftime('%B %Y',$elements['#account']->created));
								print '</p>';
								print '<p id="contributor-mail">';
								print_r ($elements['#account']->mail); 
								print'</p>';
							}
								
							?>
							
						</td>
					</tr>

				</table>
				
			</div>
			<?php 
				$block = module_invoke('views', 'block_view', 'doc_forma-block');
				if ($block['content']) {
					print '<h2 class="titleSubGrey">Ses derniers documents</h2>';
					print render($block);
					print '<div class="more-doc">';
					print '<hr>';
					print '<a class="btn" href="#">Voir tout</a>';
					print '</div>';
				}
			  	
			?>
			<!--h2 class="titleSubGrey">Ses expériences</h2-->

			<?php 
				$block2 = module_invoke('views', 'block_view', 'article_forma-block');
				if ($block2['content']) {
					print '<h2 class="titleSubGrey">Ses articles</h2>';
			  		print render($block2);
			  		print '<div class="more-art">
							<hr>
							<a class="btn" href="#">Voir tout</a>
						</div>';
			  	}
			?>

</div>


