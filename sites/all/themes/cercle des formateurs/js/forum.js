// jQuery for Drupal 7 [BEGIN]
//var rechercheEnCours = false;
//var bibliSearchOpen=false;
(function ($) {
// [jQuery BEGIN] début des fonctions
$(document).ready(function() {
	console.log('toto');
	//Hover catégories
	$("#forum_4 a img, #forum_2 a img, #forum_8 a img, #forum_9 a img").hover(function () {
		$(this).attr('src', $(this).attr('src').replace('.jpg', '_hover.jpg'));
	  },function () {
		$(this).attr('src', $(this).attr('src').replace('_hover.jpg', '.jpg'));
	});

	//Récupération de l'url pour passer le pushPédago en active selon la page
	var url2 = location.pathname;
	var name_page_bis=url2.split('/');
	if (name_page_bis[2]=="g%C3%A9n%C3%A9ral"){
		name_page_bis[2]="général";
	}
	//console.log((name_page_bis[2]));
	$("#block-block-14 #"+name_page_bis[2]).addClass('active');	
	/*$('.approuvedZone a').click(function(){
		//alert('truc');
		$(this).addClass('approuvedDesabled');
		return false;
	});
	
	$('#ajouterCommentaire').click(function(){
		$('#writeMessage').css({display:'block'}).animate({opacity:1});
		return false;
	});*/
	
	// Script Cufon à éxécuter
	Cufon.replace('.page-node .region-content .node-forum div.present-topic h2');
	Cufon.replace('.page-node-add-forum .node--forum--add--title h1');
	Cufon.replace('.page-comment-edit .comment--edit--title h1');
	Cufon.replace('.page-node .region-content .node-forum div.present-topic span a');
	//Cufon.replace('.page-node .region-content .node-forum .link-wrapper a');
	//Cufon.replace('.page-node .region-content .node-document-affiche .link-wrapper');
	//Cufon.replace('.page-node .region-content .node-article .link-wrapper a');
	//Cufon.replace('.logged-in.page-node .region-content .node-forum .link-wrapper a');
	//Cufon.replace('.not-logged-in.page-node .region-content .node-forum .link-wrapper ul li.comment_forbidden span');
	//Cufon.replace('.not-logged-in.page-node .region-content .node-article .link-wrapper ul li.comment_forbidden span')
	// fin cufon

	/* Click sur ajouter un commentaire dans le forum */
	$(".page-node .region-content .node-forum .bloc-comment,.page-node .region-content .node-article .bloc-comment, "
	+".page-node .region-content .node-forum .bloc-comment,.page-node.node-type-document-affiche .region-content .node-document-affiche .bloc-comment").css({'display':'none'});
	$('.logged-in.page-node .region-content .node-forum .link-wrapper a, .logged-in.page-node .region-content .node-article .link-wrapper a,'
	+'.logged-in.page-node .region-content .node-forum .link-wrapper a, .logged-in.page-node.node-type-document-affiche .region-content .node-document-affiche .link-wrapper a').click(function(){
		$('.logged-in.page-node .region-content .node-forum .bloc-comment, .page-node .region-content .node-article .bloc-comment').css({display:'block'}).animate({opacity:1});
		$('.logged-in.page-node .region-content .node-forum .bloc-comment, .logged-in.page-node.node-type-document-affiche .region-content .node-document-affiche .bloc-comment').css({display:'block'}).animate({opacity:1});
		return false;
	});
	/*$('.page-node-add-forum').load(function(){
		alert ('toto');
		$('field-type-taxonomy-term-reference select option[@value=conception]').attr("selected", "selected");

	});*/
	
	
// [jQuery END] fin des fonctions
});
// jQuery for Drupal 7 [END]
}(jQuery));