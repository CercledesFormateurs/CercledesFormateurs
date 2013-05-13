<div id="user-register">
	<?php
		print render ($form['field_pr_nom']);
		print render ($form['field_nom']);
		print render ($form['field_photo']);
		print render ($form['account']);
		print render ($form['field_cle_premium']);
		print render ($form['field_ads']);
		print render ($form['field_cgu']);
		print drupal_render($form['actions']);
		print drupal_render($form['form_build_id']); // needed for the form mechanism to work
       	print drupal_render($form['form_id']);  // needed for the form mechanism to work
	?>
</div>