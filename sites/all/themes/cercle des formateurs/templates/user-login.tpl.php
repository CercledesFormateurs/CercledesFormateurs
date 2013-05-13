<h2>Connexion</h2>
<div id="user-login-page">
	<?php 
		//print_r($form);
		print render ($form['name']);
		print render ($form['pass']);
		print drupal_render($form['actions']);
	?>
		<p class="btn">
			<a class="btn" href="/user/register?destination"> Inscription </a>
		</p>
	<?php
		print drupal_render($form['form_build_id']); // needed for the form mechanism to work
       	print drupal_render($form['form_id']);  // needed for the form mechanism to work
	?>
</div>