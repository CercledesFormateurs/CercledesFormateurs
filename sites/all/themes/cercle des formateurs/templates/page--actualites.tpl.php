<?php drupal_set_title('Actualités | Cercle des formateurs'); ?>
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
							print "</li></ul>";
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
								print l(t("Inscription"), 'user/register', array(
									'query' => array(
										'destination' => $destination,
									)
								)
							);
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
<div class="clr"></div>

<!--Affichage du contenu-->

<div class="content">
	<div id="fullWidth">

		<div class="edito">
			<h1>Actualités</h1>
			<p>Retrouvez toutes les actualitées liées au monde de la formation !</p>
		</div>
		
		<?php print render($page['content']); ?>

		<!--<div class="categorieActusContent">			
			<h2>Pédagogie</h2>
			<div class="categorieActus">
				<img src="img/img/visuelProduit.png" height="134" width="181" />
				<h3>Titre de l'actu</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean purus arcu, dictum at rhoncus et, faucibus quis sapien. Curabitur imperdiet adipiscing porttitor.</p>
				<a href="#" class="more">Lire la suite...</a>
				<a href="actualites-pedagogie" class="btnGreen"><span>Voir toutes les actus</span></a>
				<hr>
			</div>
			
			<h2>Psychologie</h2>
			<div class="categorieActus">
				<img src="img/img/visuelProduit.png" height="134" width="181" />
				<h3>Titre de l'actu</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean purus arcu, dictum at rhoncus et, faucibus quis sapien. Curabitur imperdiet adipiscing porttitor.</p>
				<a href="#" class="more">Lire la suite...</a>
				<a href="actualites-psychologie" class="btnGreen"><span>Voir toutes les actus</span></a>
				<hr>
			</div>
			
			<h2>Juridique</h2>
			<div class="categorieActus">
				<img src="img/img/visuelProduit.png" height="134" width="181" />
				<h3>Titre de l'actu</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean purus arcu, dictum at rhoncus et, faucibus quis sapien. Curabitur imperdiet adipiscing porttitor.</p>
				<a href="#" class="more">Lire la suite...</a>
				<a href="actualites-juridique" class="btnGreen"><span>Voir toutes les actus</span></a>
				<hr>
			</div>
			
			<h2>Généralité</h2>
			<div class="categorieActus">
				<img src="img/img/visuelProduit.png" height="134" width="181" />
				<h3>Titre de l'actu</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean purus arcu, dictum at rhoncus et, faucibus quis sapien. Curabitur imperdiet adipiscing porttitor.</p>
				<a href="#" class="more">Lire la suite...</a>
				<a href="actualites-generales" class="btnGreen"><span>Voir toutes les actus</span></a>
				<hr>
			</div>
		</div>-->
	</div>
</div>
	
<?php
	$url = $_SERVER['REQUEST_URI'];
	$pageUrl = explode("/", $url);
	//SI l'on se trouve dans ces pages alors on affiche les liens de bas de page
	if((isset($pageUrl[2])) &&($pageUrl[2]=='pedagogie' || $pageUrl[2]=='psychologie' || $pageUrl[2]=='juridique' || $pageUrl[2]=='')){
		print '<div class="clr">&nbsp;</div>';
	}
?>
<div id="clr_footer" class="clr"></div>
</div>
<?php print render($page['footer']); ?>