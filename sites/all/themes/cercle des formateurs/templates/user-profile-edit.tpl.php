<?php 
	$tit = $form['#user']->field_pr_nom[und][0][value].' '.$form['#user']->field_nom[und][0][value].' | Cercle des formateurs';
	drupal_set_title($tit); 
?>

<pre>
	<?php 
		//print_r ($form['#user']);
		$uid = $user->uid;
		$photo = explode("/",$form['#user']->field_photo[und][0][uri]);
		if($photo[2]==""){
			$avatar = 'default_images/defaultUser_0.png';
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
			
<h2 class="titleSubGrey">Vos informations actuelles</h2>
<div class="greyBloc">
	<?php
		$role_id=false;
		$role= db_query('SELECT count(*) as has_role, rid FROM {users_roles} WHERE uid = :uid',array(':uid' => $uid));
		foreach ($role as $rol) {
			if($rol->has_role > 0){
				$authen=true;
			}
			else{
				$authen=false;
			}
			
			
		}
		$role2= db_query('SELECT rid FROM {users_roles} WHERE uid = :uid',array(':uid' => $uid));
		foreach ($role2 as $roller) {
			if($roller->rid == 8){
				$role_id=true;
			}
		}

		if(!$authen){
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
		else{
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
		
	?>

	<table>
		<tr>
			<td class="vignette">
				<img src="/sites/default/files/<?php print $avatar; ?>" alt="contributeur" title="Contributeur"/>
			</td>
			<td>
				<div id="name-contributor">
					<h4><?php print_r($form['#user']->field_nom[und][0][value]);?></h4>
					<h5><?php print_r($form['#user']->field_pr_nom[und][0][value]);?></h5>
				</div>
				<p><?php print_r ($form['#user']->mail); ?></p>
			</td>
		</tr>
	</table>
	
</div>

<!--Affiche les documents acheté (block histo_dl-block)-->
<?php 
	$block = module_invoke('views', 'block_view', 'push_pr_mium-block');
	if ($role_id==false) {
	//	print '<h2 class="titleSubGrey">Mes documents</h2>';
	  	print render($block);
  }
?>

<h2 class="titleSubGrey">Modifications</h2>
<div class="greyBloc">
    <div id="user-register">
    	<?php 
    		print render($form['form_id']);
    		print render($form['form_build_id']);
    		print render($form['form_token']);
    
    		
    		print render($form['field_nom']);
    		print render($form['field_pr_nom']);
    		print render($form['field_photo']);
    		print render($form['account'][current_pass]);
    		print render($form['account']['pass']);
    		if ($role_id==false) {
    			print render($form['field_cle_premium']);
    		}
    		print render($form['field_ads']);
    		print render($form['field_cgu']);
    
    		print render($form['actions']['submit']);
    	?>
    </div>
</div>

<!--Affiche les documents acheté (block histo_dl-block)-->
<?php 
	$block = module_invoke('views', 'block_view', 'histo_dl-block');
	if ($block['content']) {
		print '<h2 class="titleSubGrey">Mes documents</h2>';
	  	print render($block);
  }
?>























