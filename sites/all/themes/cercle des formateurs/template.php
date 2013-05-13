<?php

function cdf_theme($existing, $type, $theme, $path){
 $hooks['user_register_form']=array(
  'render element'=>'form',
  'template' =>'templates/user--register',
 );
  $hooks['user_profile_form']=array(
    // Forms always take the form argument.
    'arguments' => array('form' => NULL),
    'render element' => 'form',
    'template' => 'templates/user-profile-edit',
  );
  $hooks['user_login']=array(
  'render element'=>'form',
  'template' =>'templates/user-login',
 );
 return $hooks;
}

function cdf_preprocess_user_register(&$variables) {
 $variables['form'] = drupal_build_form('user_register_form', user_register_form(array()));
}

function taille_fichier($fichier)
{
  $taille_fichier = $fichier;

  if ($taille_fichier >= 1073741824) 
  {
    $taille_fichier = round($taille_fichier / 1073741824 * 10) / 10 . " Go";
  }
  elseif ($taille_fichier >= 1048576) 
  {
    $taille_fichier = round($taille_fichier / 1048576 * 10) / 10 . " Mo";
  }
  elseif ($taille_fichier >= 1024) 
  {
    $taille_fichier = round($taille_fichier / 1024 * 10) / 10 . " Ko";
  }
  else 
  {
    $taille_fichier = $taille_fichier . " o";
  } 
  return $taille_fichier;
}


function cdf_preprocess_field( &$variables ){
//print'<pre>';
  //print_r($variables);
  if(isset($variables['element']['#object']->field_lien_fichier['und'][0]['filesize']) && !empty($variables['element']['#object']->field_lien_fichier['und'][0]['filesize'])){
    if($variables['element']['#object']->field_lien_fichier['und'][0]['filesize']){
       $variables['file_size_a'] = taille_fichier($variables['element']['#object']->field_lien_fichier['und'][0]['filesize']);
    }
  }
  if(isset($variables['element']['#object']->field_fichier_payant['und'][0]['filesize']) && !empty($variables['element']['#object']->field_fichier_payant['und'][0]['filesize'])){
    if($variables['element']['#object']->field_fichier_payant['und'][0]['filesize']){
       $variables['file_size_a'] = taille_fichier($variables['element']['#object']->field_fichier_payant['und'][0]['filesize']);
    }
  }
}

function cdf_preprocess_node(&$variables) {
  //print('<pre>');
 //print_r(theme('username', array('account' => $node)));
  //print_r($variables);
  $variables['view_mode'] = $variables['elements']['#view_mode'];
  // Provide a distinct $teaser boolean.
  $variables['teaser'] = $variables['view_mode'] == 'teaser';
  $variables['node'] = $variables['elements']['#node'];
  $node = $variables['node'];

  $variables['date']      = format_date($node->created, 'custom', 'd/m/Y - H:i');
  $variables['name']      = theme('username', array('account' => $node));

  $uri = entity_uri('node', $node);
  $variables['node_url']  = url($uri['path'], $uri['options']);
  $variables['title']     = check_plain($node->title);
  $variables['page']      = $variables['view_mode'] == 'full' && node_is_page($node);

  // Flatten the node object's member fields.
  $variables = array_merge((array) $node, $variables);

  // Helpful $content variable for templates.
  $variables += array('content' => array());
  foreach (element_children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }

  // Make the field variables available with the appropriate language.
  field_attach_preprocess('node', $node, $variables['content'], $variables);

  // Display post information only on certain node types.
  if (variable_get('node_submitted_' . $node->type, TRUE)) {
    $variables['display_submitted'] = TRUE;
    $variables['submitted'] = t('Submitted by !username on !datetime', array('!username' => $variables['name'], '!datetime' => $variables['date']));
    $variables['user_picture'] = theme_get_setting('toggle_node_user_picture') ? theme('user_picture', array('account' => $node)) : '';
  }
  else {
    $variables['display_submitted'] = FALSE;
    $variables['submitted'] = '';
    $variables['user_picture'] = '';
  }

  // Gather node classes.
  $variables['classes_array'][] = drupal_html_class('node-' . $node->type);
  if ($variables['promote']) {
    $variables['classes_array'][] = 'node-promoted';
  }
  if ($variables['sticky']) {
    $variables['classes_array'][] = 'node-sticky';
  }
  if (!$variables['status']) {
    $variables['classes_array'][] = 'node-unpublished';
  }
  if ($variables['teaser']) {
    $variables['classes_array'][] = 'node-teaser';
  }
  if (isset($variables['preview'])) {
    $variables['classes_array'][] = 'node-preview';
  }

  // Clean up name so there are no underscores.
  $variables['theme_hook_suggestions'][] = 'node__' . $node->type;
  $variables['theme_hook_suggestions'][] = 'node__' . $node->nid;
}

//------------------------------------------------mon code


function cdf_preprocess_page(&$variables) {
  global $user;
  if ( $user->uid ) {
    $variables['utilisateur_connecte'] = $variables['user']->name;
  }
}


function cdf_textfield($variables) {
  global $user;
  $element = $variables['element'];
  $element['#attributes']['type'] = 'text';
  element_set_attributes($element, array('id', 'name', 'value', 'size', 'maxlength'));
  _form_set_class($element, array('form-text'));

  $extra = '';
  if ($element['#autocomplete_path'] && drupal_valid_path($element['#autocomplete_path'])) {
    drupal_add_library('system', 'drupal.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = array();
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#attributes']['id'] . '-autocomplete';
    $attributes['value'] = url($element['#autocomplete_path'], array('absolute' => TRUE));
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $extra = '<input' . drupal_attributes($attributes) . ' />';
  }

  if($element['#attributes']['id']=="edit-field-auteur-und-0-uid"){
    $element['#attributes']['value']=$user->name; 
  }

  if($element['#attributes']['id']=="edit-commerce-price-und-0-amount"){
    $element['#attributes']['value']=00; 
  }

  

  $output = '<input' . drupal_attributes($element['#attributes']) . ' />';




  return $output . $extra;
}




?>