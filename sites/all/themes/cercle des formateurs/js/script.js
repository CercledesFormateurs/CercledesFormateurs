// jQuery for Drupal 7 [BEGIN]
//var rechercheEnCours = false;
//var bibliSearchOpen=false;
(function ($) {
// [jQuery BEGIN] début des fonctions
$(document).ready(function() {

	// Script Cufon à éxécuter
	Cufon.replace('.page-node .region-content .node-forum div.present-topic h2');
	Cufon.replace('.page-node .region-content .node-forum div.present-topic span a');
	Cufon.replace('#baseline');
	Cufon.replace('h1');
	Cufon.replace('h3:not(article h3, .page-search-node .title)');
	Cufon.replace('h2:not(.node-document-affiche h2)');
	// fin cufon
	
	
	if ($('.cart-notif').html()==0) {
    	$('.cart-notif').hide();
	}
	
	//if (window.location.pathname.split('/')[1] == 'bibliotheque')
	if (window.location.pathname=='/node/add/article') {
        $('#edit-field-cat-gorie-und').find('option[value=5], option[value=6], option[value=7]').remove()
	}
	if (window.location.pathname=='/node/add/forum/0') {
        //$('#edit-field-cat-gorie-und').find('option[value=5], option[value=6], option[value=7]').remove()
	}
		

	if ($('.role_user_premium').html()=='PREMIUM') {
	    //console.log(window.location.pathname.split('/')[1]);
    	$('#block-views-push-pr-mium-block, .view-push-pr-mium').hide();
    	if (window.location.pathname.split('/')[1]=='User') {
        	$('td.vignette').append('<div class="user-premium-label"></div>');
    	}
	}
	
	/*
if (window.location.pathname.split('/')[1]=='cart') {
        console.log('premium cart');
        if ($('.role_user_premium').html()=='PREMIUM') {
            $('.views-field-commerce-total').html('Prix Premium');
        }
    }
*/
	
	$('#block-views-push-pr-mium-block input[type=submit], .view-push-pr-mium input[type=submit]').attr('value','Devenir Premium pour 10€ seulement !');
	
	if (window.location.pathname.split('/')[1] == 'bibliotheque') {
        $('.view--docs-page-bibliotheque .view-filters').css({height:'0px', opacity:0, 'margin-bottom':'0px'}).hide();
        bibliSearchOpen=false;
        var clickAddCart = false,
            listCart = [],
            thisCart = parseInt($('.commerce-add-to-cart input[name=product_id]').attr('value'));
        
        console.log($('.commerce-add-to-cart input[name=product_id]').attr('value'));
        //console.log($('#list-cart').html());
        
        $('#list-cart li').each(function(i){
            listCart[i] = parseInt($('#list-cart li').eq(i).html());
        })
        //console.log(listCart);
        console.log(jQuery.inArray(thisCart, listCart));
        
        $('.commerce-add-to-cart #edit-submit').live('click',function() {
            var imgURL = $('.field-name-field-image-illustration').find('img').attr('src'),
                countCart = parseInt($('.cart-notif').html());
                
            
            if (clickAddCart==false && jQuery.inArray(thisCart, listCart)<0) {
                $('.field-name-field-image-illustration img').clone()
                    .addClass('img-add-to-card')
                    .css({position:'absolute', top:'21px', left:'1px'})
                    .appendTo('.node-document-affiche');
                    
                $('.img-add-to-card').stop(true,false).animate({left:'881px', width:'47px', height:'33px', top:'-121px', opacity:'0'}, 700, function(){
                    $('.img-add-to-card').remove();
                });

                $('.cart-notif').show().html(countCart+1);
                clickAddCart = true;
            
                submitForm($('.commerce-add-to-cart'));
            }
            return false;
            //$('.commerce-add-to-cart').submit();
        });
	}
	
	
	function submitForm(form){
    	// create an object (not an array) to store name->value
    	// use an object so $.ajax() can handle it
    	var vals = {};	
    	var name = "";
     
    	//grab the value of each form INPUT (not selects, checkboxes or radios)
    	form.find("input").each(function(){
    		// skip submit button values
    		// optionally add or statements for submits that should pass values
    		// in this example, the drupal edit-submit passes a value
    		if($(this).attr("type")!="submit" || $(this).attr("id")=="edit-submit"){
    			name = $(this).attr("name");		
    			vals[name] =  $(this).val();
    		}
    	});
     
    	$.ajax({
    		url: form.attr("action"),
    		type: "POST",
    		global: false,
    		data: vals,
    		success: function(msg){
    			//do something to tell the user everything is ok
    			},
     
    		error: function(msg){
    			//do something to make your user feel better about the fact that ajax just failed
    			}
    	});
    }
	
	if ($('.component-title').length!=0) {
        $('.component-title').html('Total :');
	}

	

	$('.page-user-password #edit-actions #edit-submit').attr('value', 'Valider');
	
	if (window.location.pathname.split('/')[1] == 'User' && $('.greyBloc').eq(0).find('> p').length==2) {
	    $('.greyBloc').eq(0).find('> p').eq(0).css({marginTop:'28px'})
	}
	
	
	if (window.location.pathname == '/contact' || window.location.pathname == '/contactbloclogge' || window.location.pathname == '/contactbloclogge') {
		//console.log(
			//$('body').attr('class')
		//);
		if ($('body').hasClass('not-logged-in')){
			if ($('webform-component-rejoignez-laventure').is(":visible")) {
			}
		}
	}
	
	if ($('body').hasClass('node-type-document-affiche')) {
		$('body.node-type-document-affiche .field-name-field-lien-fichier a').html('Téléchargement');
	}
	
	if ($('.field-name-field-fichier-payant').length == 0) {
        $('.commerce-add-to-cart input[type=submit]#edit-submit').hide();
        $('.field-name-commerce-price .field-item').html('Gratuit');
	}
	
	//console.log(window.location);

	//Rognage des entrées
	/*reduce($('#block-views-docs-accueil-block .views-row h2 a'));
	reduce($('#block-views-docs-pedagogique-block .views-row h2 a'));
	reduce($('#block-views-docs-concevoir-block .views-row h2 a'));
	reduce($('#block-views-docs-animer-block .views-row h2 a'));
	reduce($('#block-views-docs-evaluer-block .views-row h2 a'));
	reduce($('#block-views-docs-psychologique-block .views-row h2 a'));
	reduce($('#block-views-docs-juridique-block .views-row h2 a'));
	reduce($('.view--docs-page-bibliotheque .views-row h2 a'));*/
	reduce($('#forum_c article p a'), true);
	
	function reduce(objects, nomaxheight) {
		objects.each(function(index) {
			if($(this).html().length>24) {
				$(this).html($(this).html().substring(0, 20)+"...");
				if(!nomaxheight) {
					$(this).css("max-height", "15px");
				}
				$(this).css("overflow", "hidden");
			}
		});
	}

	//Initialisation des input de login avec placeholder
	$('header #topBar #center #block-user-login form input#edit-name').attr('value','Adresse e-mail');
	$('header #topBar #center #block-user-login form input#edit-pass').attr('value','Mot de passe');
	
	$('header #topBar #center #block-user-login form input').focus(function(){
		$(this).attr('value','');
	});
	$('header #topBar #center #block-user-login form input').blur(function(){	
		if($(this).attr('value')==''){
			if($(this).attr('id')=='edit-name'){
				$(this).attr('value', 'Adresse e-mail');
			}
			else if($(this).attr('id')=='edit-pass'){
				$(this).attr('value', 'Mot de passe');
			}
		}
	});
	
	//Initialisation de l'input de recherche avec placeholder
	$('header #block-search-form #search-block-form input#edit-search-block-form--2').attr('value','Rechercher...');
	$('header #block-search-form #search-block-form input#edit-search-block-form--2').focus(function(){
		$(this).attr('value','');
	});
	$('header #block-search-form #search-block-form input#edit-search-block-form--2').blur(function(){
		if($(this).attr('value')==''){
			$(this).attr('value','Rechercher...');
		}	
	});
	
	//Class actif du menu principal
	var url = location.pathname;
	var name_page=url.split('/');
	if(name_page[1]=="forum"){
		$("header #block-system-main-menu ul li:nth-child(3) a").addClass('active');
	}
	if(name_page[1]=="actualites"){
		$("header #block-system-main-menu ul li:nth-child(2) a").addClass('active');
	}
	if(name_page[3]=="6"){
		$("header #block-system-main-menu ul li:nth-child(8) a").addClass('active');
	}
	if(name_page[2]=="pedagogie"){
		$("header #block-system-main-menu ul li:nth-child(4) a").addClass('active');
	}
	if(name_page[2]=="bibliotheque"){
		$("header #block-system-main-menu ul li:nth-child(7) a").addClass('active');
	}
	//Récupération de l'url pour passer le pushPédago en active selon la page
	if(name_page[2]=="animation"){
		$('#pushPedago.pedaIn #pushConcevoir a').removeClass("active");
		$('#pushPedago.pedaIn #pushAnimer a').addClass("active");
	}
	else if(name_page[2]=="evaluation"){
		$('#pushPedago.pedaIn #pushConcevoir a').removeClass("active");
		$('#pushPedago.pedaIn #pushEvaluer a').addClass("active");
	}
	
	$text="<p class='error-connect'>Erreur d'identifiant et/ou de mot de passe. Veuillez les ressaisir ou <a href='/user/password'> cliquez-ici pour ressaissir votre mot de passe</a>.</p>";
	if($('#user-login #edit-name').attr('class')=='form-text required error' || $('#user-login #edit-pass').attr('class')=='form-text required error'){
		$('#user-login').before($text);
	}
	
	/*Modification lien pushForum*/
	$('.page-node-15 #pushForum p a').attr('href', '/forum/evaluation');
	$('.page-node-14 #pushForum p a').attr('href', '/forum/animation');
	$('.page-node-13 #pushForum p a').attr('href', '/forum/conception');
	$('.page-node-10 #pushForum p a').attr('href', '/forum/juridique');
	$('.page-node-9 #pushForum p a').attr('href', '/forum/psychologie');
	
	$('#block-views-push-formateur-block .views-field-name a').wrap('<h4></h4>');
	//Equilibrage des boutons du slider
	var largeurSlider=672;
	var nbArticle = $('.view-slideshow-accueil .views_slideshow_slide').size();
	$('.view-slideshow-accueil #views_slideshow_cycle_main_slideshow_accueil-block').css({width:(100*nbArticle)+'%'});
	$('.view-slideshow-accueil #widget_pager_bottom_slideshow_accueil-block .views_slideshow_pager_field_item').css({width:(largeurSlider/nbArticle)-1+'px'});
	
	//Remplacement des noms de bouton
	$('.view-slideshow-accueil .views_slideshow_slide .views-field-field-lien-vers-page a').html('En savoir plus');
	$('#block-system-user-menu ul .leaf a').addClass('btn');

function switchImage($this){
	if($.trim($this.html())=='PDF')
	{
		$this.html('<p class="nomProduct"><span id="nomTP">PDF</span><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/picto_PDF.png" alt="PDF" width="18" height="23"/></p>');

	}
	if($.trim($this.html())=='Audio')
	{
		$this.html('<p class="nomProduct"><span id="nomTP">Audio</span><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/picto_audio.png" alt="Audio" width="14%" /></p>');

	}
	if($.trim($this.html())=='Vidéo')
	{
		$this.html('<p class="nomProduct"><span id="nomTP">Vidéo</span><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/picto_video.png" alt="Vidéo" width="14%" /></p>');

	}
	if($.trim($this.html())=='PPT')
	{
		$this.html('<p class="nomProduct"><span id="nomTP">PPT</span><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/picto_ppt.png" alt="PPT" width="13%"/></p>');

	}
	if($.trim($this.html())=='Liens')
	{
		$this.html('<p class="nomProduct"><span id="nomTP">Liens</span><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/picto_PDF.png" alt="Liens" width="18" height="23"/></p>');

	}
	if($.trim($this.html())=='Autre')
	{
		$this.html('<p class="nomProduct"><span id="nomTP">Autre</span><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/picto_PDF.png" alt="Autre" width="18" height="23"/></p>');

	}
	if($.trim($this.html())=='DOC')
	{
		$this.html('<p class="nomProduct"><span id="nomTP">DOC</span><img src="/sites/all/themes/cercle%20des%20formateurs/img/assets/picto_PDF.png" alt="DOC" width="18" height="23"/></p>');

	}
}	
/*Affichage du type de document sur les vues des pages*/
$('.view-display-id-block .views-row .field-name-field-type-contenu .field-items .field-item').each(function(){
	switchImage($(this));
});

/*Affichage du type de document sur les pages articles*/
$('body > .node-type-document-affiche .field-name-field-type-contenu .field-items .field-item').each(function(){
	switchImage($(this));
});	

/*Affichage du type de document dans la bibliotheque*/
$('.view--docs-page-bibliotheque .view-content .field-name-field-type-contenu .field-items .field-item').each(function(){
	switchImage($(this));
});	

/*Affichage du type de document sur la page user*/
$('.view-histo-dl .views-field-field-type-contenu .field-content').each(function(){
	switchImage($(this));
});	

/*Affichage du type de document sur la page user*/
$('.view-doc-formateur .views-field-field-type-contenu .field-content').each(function(){
	switchImage($(this));
});

	$('.view--docs-page-bibliotheque .view-filters').load(function() {
		if(bibliSearchOpen){
			$('.view--docs-page-bibliotheque .view-filters').addClass("panel_deplie");
		}
	});

	var bibliSearchOpen=false;
	/*$('.view--docs-page-bibliotheque .view-filters').css({display:'none',opacity:0,'margin-bottom':'0px',height:'0px'});*/
	$('#bibliTop ul li#searchButton').click(function(){
		
		if (!bibliSearchOpen) {
			$('.view--docs-page-bibliotheque .view-filters').css({display:'block'}).animate({height:'396px', opacity:1, 'margin-bottom':'20px'});
			bibliSearchOpen=true;
		} else {
			$('.view--docs-page-bibliotheque .view-filters').animate({height:'0px', opacity:0, 'margin-bottom':'0px'},function(){
				$('.view--docs-page-bibliotheque .view-filters').css({display:'none'});
			});
			bibliSearchOpen=false;
		}
	});
	
	/*$('#glob_chk').click(function(){
		if($('#glob_chk').checked==true){
			$('.form-checkboxes:checkbox').checked = true ;
		}else{
			$('.form-checkboxes:checkbox').checked = false ;
		}
	});*/
		
	
	$('.view--docs-page-bibliotheque .view-filters #edit-field-type-contenu-tid-wrapper > label').html('<input type="checkbox" class="globalCheck" name="Check_ctr" value="yes" id="glob_chk"><label for="Check_ctr">Documents</label>');
	$('.view--docs-page-bibliotheque .view-filters #edit-field-theme-document-tid-wrapper > label').html(' <input type="checkbox" name="Check_ctr2" value="yes" class="globalCheck" onClick="checkThe(document.myform2.check_list2)"><label for="Check_ctr2">Thèmes</label>');
	$('body > div').removeClass('node-unpublished');
	$('body > .node-document-affiche .field-name-field-lien-fichier a').addClass('btn').html('Téléchargement');
	
	
	$('#reinit').click(function(){
		$('input').removeAttr('checked');
	});

	function decheckDoc(){
		if(document.myform.Check_ctr.checked==true){
			document.myform.Check_ctr.checked=false;
		}
	}

	function checkThe(chk) {
		if(document.myform2.Check_ctr2.checked==true){
			for (i = 0; i < chk.length; i++)
			chk[i].checked = true ;
		}else{
		for (i = 0; i < chk.length; i++)
		chk[i].checked = false ;
		}
	}
	function decheckThe(){
		if(document.myform2.Check_ctr2.checked==true){
			document.myform2.Check_ctr2.checked=false;
		}
	}
	
	//ACTUALITES
	jQuery("body.page-actualites .view-derniere-actu .views-field-body div").each(function() {
		$(this).html(strip_tags($(this).html()));
	});
		jQuery(".view-liste-articles .views-field-body div").each(function() {
		$(this).html(strip_tags($(this).html()));
	});
	
	function strip_tags(html)
	{
		//PROCESS STRING
		if(arguments.length < 3) {
		 html=html.replace(/<\/?(?!\!)[^>]*>/gi, '');
		} else {
		 var allowed = arguments[1];
		 var specified = eval("["+arguments[2]+"]" );
		 if(allowed){
			var regex='</?(?!(' + specified.join('|') + '))\b[^>]*>';
			html=html.replace(new RegExp(regex, 'gi'), '');
		 } else{
			var regex='</?(' + specified.join('|') + ')\b[^>]*>';
			html=html.replace(new RegExp(regex, 'gi'), '');
		 }
		}
		//CHANGE NAME TO CLEAN JUST BECAUSE  
		var clean_string = html;
		//RETURN THE CLEAN STRING
		return clean_string;
	}
	
	/*
	if ($('body').attr('class').indexOf('page-admin-commerce-products-add') >= 0 ) {
    	$('#edit-status-1').attr('checked', 'checked');
	}
	*/
	
	/*Réparation du lien vers la fiche formateur*/
	$("#block-views-equipe-formateur-block li").each(function() {
		//console.log($(this).find('.views-field-name a').attr('href'));
		$(this).find('.views-field-name a').attr('href', $(this).find('.views-field-field-photo a').eq(1).attr('href'));
	});
	$("#block-views-push-formateur-block .views-field-field-pr-nom a").attr('href', $('#block-views-push-formateur-block .views-field-field-photo a').attr('href'));
	$("#block-views-push-formateur-block .views-field-field-nom a").attr('href', $('#block-views-push-formateur-block .views-field-field-photo a').attr('href'));
	$(".view-liste-des-topics .view-content div").each(function() {
		$(this).find('h4 a').attr('href', $(this).find('.vignette a').attr('href'));
	});
	$(".view-liste-des-topics-general .view-content div").each(function() {
		$(this).find('h4 a').attr('href', $(this).find('.vignette a').attr('href'));
	});
	$(".view-liste-des-topics-psychologie .view-content div").each(function() {
		$(this).find('h4 a').attr('href', $(this).find('.vignette a').attr('href'));
	});
	$(".view-liste-des-topics-animation .view-content div").each(function() {
		$(this).find('h4 a').attr('href', $(this).find('.vignette a').attr('href'));
	});
	$(".view-liste-des-topics-evalution .view-content div").each(function() {
		$(this).find('h4 a').attr('href', $(this).find('.vignette a').attr('href'));
	});
	$(".view-liste-des-topics-juridique .view-content div").each(function() {
		$(this).find('h4 a').attr('href', $(this).find('.vignette a').attr('href'));
	});


	


	/*Réparation texte lien telechargment doc user*/
	$('.view-histo-dl .views-field-commerce-file-license-file .field-content a').each(function(){
		$(this).text('Télécharger');
	});

	displayRejoignezValidation();
	//Pas de captcha ou de bouton de validation sur Rejoindre l'équipe en non connecté
	$("#edit-submitted-demande-nl").live("change", function() {
		displayRejoignezValidation();
		$("#edit-submitted-demande-nl").val();
	});

	//Référence du produit automatique (front)
	jQuery("#commerce-product-ui-product-form #edit-title").change(function() {
		title = jQuery("#commerce-product-ui-product-form #edit-title").val();
		jQuery("#commerce-product-ui-product-form #edit-sku").val(slugify(title)+parseInt(Math.random()*10000));
	})

	//Apparition notation
	jQuery('.logged-in.page-node .region-content .node-document-affiche .add-com .link-wrapper a').click(function(){
		jQuery(".field-name-field-note-user").show();
	});

	//Pas de commentaire vide
	jQuery('#comment-form #edit-submit').click(function(e) {
		if(jQuery('#comment-form textarea').val()=="") {
			e.preventDefault();
			jQuery('#comment-form textarea').css("border", "1px solid red");
		}
	});

	//Pas de rejoindre l'équipe en non connecté
	console.log(($('body.not-logged-in #webform-component-rejoignez-laventure')).css('display'));

	$(".more-art a").click(function(){
		$this=$(this);
		if(!$this.hasClass("art-minifie")){
			$(".view-article-forma .view-content .views-row").each(function() {
				$(this).css('display','block');
			});
			$(this).text("Voir moins");
			$(this).addClass("art-minifie");
		}
		else{
			$nbart2=0;
			$(".view-article-forma .view-content .views-row").each(function() {
				$nbart2++;
				if($nbart2>3){
					$(this).css('display','none');
				}
			});
			$(this).text("Voir tout");
			$(this).removeClass("art-minifie");

		}		
		return false;
	});

	$(".more-doc a").click(function(){
		$this=$(this);
		if(!$this.hasClass("doc-minifie")){
			$(".view-doc-forma .view-content .views-row").each(function() {
				$(this).css('display','block');
			});
			$(this).text("Voir moins");
			$(this).addClass("doc-minifie");
		}
		else{
			$nbdocu2=0;
			$(".view-doc-forma .view-content .views-row").each(function() {
				$nbdocu2++;
				if($nbdocu2>3){
					$(this).css('display','none');
				}
			});
			$(this).text("Voir tout");
			$(this).removeClass("doc-minifie");

		}		
		return false;
	});

	$nbarti=0;
	$(".view-article-forma .view-content .views-row").each(function() {
		$nbarti++;
		if($nbarti>3){
			$(this).css('display','none');
			$('.more-art').css('display', 'block');
		}
	});

	$nbdocu=0;
	$(".view-doc-forma .view-content .views-row").each(function() {
		$nbdocu++;
		if($nbdocu>3){
			$(this).css('display','none');
			$('.more-doc').css('display', 'block');
		}
	});

	
	

	/*Modification lien reset password*/
	if ($("body").attr("class")=="page-user-reset"){
		$attraction=($(".page-user-reset #user-pass-reset").attr('action')).split('/');
	$attraction[1]='User';
	$urlreset = $attraction.join('/');
	$(".page-user-reset form").attr('action', $urlreset);
	}

	/*Fichier gratuit > Ficher*/
	jQuery("#commerce-product-ui-product-form .form-item-field-lien-fichier-und-0 label").text("Fichier");
	
	

	
// [jQuery END] fin des fonctions
});
// jQuery for Drupal 7 [END]
}(jQuery));

/**
 * Transform text into a URL slug: spaces turned into dashes, remove non alnum
 * @param string text
 */
function slugify(text) {
	text = text.replace(/[^-a-zA-Z0-9,&\s]+/ig, '');
	text = text.replace(/-/gi, "_");
	text = text.replace(/\s/gi, "-");
	text = text.toLowerCase();
	return text;
}

function displayRejoignezValidation() {
	if(jQuery('body.not-logged-in #webform-component-rejoignez-laventure').css('display')=='block') {
		jQuery('.captcha').hide();
		jQuery('.champs_obligatoire').hide();
		jQuery('#edit-submit--3').hide();
	} else {
		jQuery('.captcha').show();
		jQuery('.champs_obligatoire').show();
		jQuery('#edit-submit--3').show();
	}
}