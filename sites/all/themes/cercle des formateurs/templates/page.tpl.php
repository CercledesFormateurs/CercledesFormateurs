<!--BLOC GENERAL-->
<div id="wraper_content" class="template_front">
	
	<!--HEADER-->
	<header>
		<!--ENTETE LOGO + CONNEXION/INSCRIPTION-->
		<div id="topBar">
			<div id="center">
				<?php if ($logo): ?>
				<a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
					<img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
				</a>
				<?php endif; ?>
				<!-- LOGIN -->
				<div id="login">
						<?php
						global $user;
						global $node;
						$role_id=false;
						$role2= db_query('SELECT rid FROM {users_roles} WHERE uid = :uid',array(':uid' => $user->uid));
						foreach ($role2 as $roller) {
							if($roller->rid == 8){
								print '<span class="role_user_premium">PREMIUM</span>';
								$role_id=true;
							}
						}
						if(!$role_id){
							print '<span class="role_user_premium">PAS PREMIUM</span>';
						}
						
						if ($user->uid) {
							print ('<ul class="menu" id="menu-login">');
							print t('<li>Bienvenue ');
							$user_fields = user_load($user->uid);
							print_r($user_fields->field_pr_nom['und']['0']['value']);
							print ', </li><li class="btn">';
							print l('Mon compte', 'User/' . $user->uid . '/edit');
							print ' </li><li class="btn">';
							print l(t('Se déconnecter'), 'user/logout');
							print ' </li><li class="btn cart">';
							print l(t('Panier'), 'cart');
							$order = commerce_cart_order_load($user->uid);
							print '<span class="cart-notif">';
							print_r(sizeof($order->commerce_line_items['und']));
							print "</span></li></ul>";
							print '<ul id="list-cart">';
							for ($i= 0; $i<sizeof($order->commerce_line_items['und']); $i++){
								$line=commerce_line_item_load($order->commerce_line_items['und'][$i]['line_item_id']);
								print '<li>'.$line->data['context']['product_ids'][0].'</li>';

							}
							print '</ul>';
						} 
						if(!$user->uid):
							?>
							<form action="/User?<?php print drupal_get_destination() ?>" method="post" id="user-login-form">
								<input type="text" maxlength="60" name="name" id="edit-name" size="20" value="Email" tabindex="1" class="form-text required" onblur="if (this.value == '') {this.value = 'Email';}" onFocus="if(this.value=='Email')this.value=''"/>
								<br/>
								<input type="password" value="Mot de passe" name="pass" id="edit-pass" size="20" tabindex="2" class="form-text required" onblur="if (this.value == '') {this.value = 'Mot de passe';}" onFocus="if(this.value=='Mot de passe')this.value=''"/>
								<br/>
								<span>
									<input type="submit" name="op" id="edit-submit" value="Se connecter" tabindex="3" class="form-submit" />
								</span>
								<br/>
								<span class="utabs3">
									<a href="/user/password" title="Forgot your password?">Mot de passe oublié?</a>
								</span>
								<input type="hidden" name="form_id" id="edit-user-login" value="user_login" />
							</form>
							<?php
							
							if (variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL)) {
								print ('<p class="btn">');
								print l(t("Inscription"), 'user/register');
								/*print l(t("Inscription"), 'user/register', array(
									'query' => array(
										'destination' => $destination,
									)
								)*/
								print ('</p>');
							}
						endif;
					?>
				</div>
				<?php print render($page['header']['system_main-menu']); ?>
				<?php print render($page['header']['search_form']); ?>
			</div>
		</div>
	</header>
	<!--FIN HEADER-->
<div class="clr"></div>

<!--Affichage des messages d'erreurs-->
<?php// print $messages; ?>

<!--Affichage du contenu-->

<?php 

	if (drupal_is_front_page()) {
		?>
			<div id="baseline">Votre espace de partage pour formateurs</div>
			
		<?php

	}
	print render($page['content']);
	$url = $_SERVER['REQUEST_URI'];
	$pageUrl = explode("/", $url);
	//SI l'on se trouve dans ces pages alors on affiche le sliens de bas de page
	if($pageUrl[1]=='pedagogie' || $pageUrl[1]=='psychologie' || $pageUrl[1]=='juridique' || $pageUrl[1]=='' || $pageUrl[1]=='actualites'):
?>
<div class="clr">&nbsp;</div>
<p class="bibliotheque-links">
	<a class="btn" href="/nous-contacter?demande=devis">Demander un devis</a> 
	<a class="btn" href="/admin/commerce/products/add/document">Proposer un document</a> 
	<?php
		//Selon la page où l'on se trouve, on adapte le lien de la bibliothèque
		$lienbibli="bibliotheque";
		if($pageUrl[1]=='pedagogie'){
			switch ($pageUrl[2]) {
   		 		case "conception":
   		 			$lienbibli="/bibliotheque?theme%5B%5D=5";
       				break;
			    case "animation":
			      	$lienbibli="/bibliotheque?theme%5B%5D=6";
			        break;
			    case "evaluation":
			        $lienbibli="/bibliotheque?theme%5B%5D=7";
			        break;
			    default:
			      	$lienbibli="/bibliotheque?theme%5B%5D=4";
			        break;
			}
		}
		elseif ($pageUrl[1]=='psychologie') {
			$lienbibli="/bibliotheque?theme%5B%5D=2";
		}
		elseif ($pageUrl[1]=='juridique') {
			$lienbibli="/bibliotheque?theme%5B%5D=8";
		}
	
	?>
	<a class="btn" href=<?php print $lienbibli;?>>Acc&eacute;der &agrave; la biblioth&egrave;que</a>
</p>
<?php
	endif;
?>
<div id="clr_footer" class="clr"></div>
</div>
<?php print render($page['footer']); ?>

