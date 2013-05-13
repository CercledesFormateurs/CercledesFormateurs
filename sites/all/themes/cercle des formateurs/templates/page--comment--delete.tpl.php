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
	</header>
	<!--FIN HEADER-->
<div class="clr"></div>
<?php print $messages; ?>

<!--Affichage du contenu-->
<?php if ($tabs): ?><div id="tabs-wrapper" class="clearfix"><?php endif; ?>
    <?php print render($title_prefix); ?>
<?php if ($title): ?>
    <h1<?php print $tabs ? ' class="with-tabs"' : '' ?>><?php print $title ?></h1>
<?php endif; ?>
<?php print render($title_suffix); ?>

<?php $page['content']['system_main']['description']['#markup'] = "Cette action ne peut être annulée."; ?>
<?php print render($page['content']); ?>


<div id="clr_footer" class="clr"></div>
</div>
<?php print render($page['footer']); ?>