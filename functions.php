<?php

include_once(get_template_directory().'/lib/yieloCenter.php');

$yloC = new yieloCenter();

if(is_admin()) $yloC->setupAdmin();

// gère le contenu de la balise <title>
$ylo_title 	=	$yloC->make('yloTitle');

// gère le menu princimal du site, en  fonction de si on est identifié ou pas
$ylo_topMenu = $yloC->make('yloTopMenu');

// gère les sidebars
$ylo_sidebars = $yloC->make('yloSidebars');

// gère les textes de la front page
$yloC->add_filter('ylo_setupFrontPage', 'yloFrontpageSettings');

// gère les champs user
$yloC->add_filter('user_contactmethods', 'yloUserFields', 'editList', 10, 1);
//gère les avatar uploader 
$yloC->add_filter('get_avatar', 'yloAvatar', 'getAvatar',  20, 5);
// gère le formulaire d'inscription
$yloC->add_filter('ylo_signup_form', 'yloSignup');

//gère le formulaire de update de profil 
$yloC->add_filter('ylo_update_form', 'yloProfile');

//gère les recherches de membres sur la page 'Recherche Memebre'
$yloC->add_action('ylo_search_member', 'yloUserSearch', 'templatePartResultat', 10, 2 );

// gère les champs dynamiques de la page author.php  et l'envoi des messages via la page membre
$yloC->add_filter('ylo-fiche-membre', 'yloFicheMembre', 'instance');


// gère le widget qui affiche les derniers inscrits 
$yloC->add_action('widgets_init', 'yloWidgetDerniersInscrits', 'actionRegisterWidget');

// gère la restriction des pages réservées aux membres
$yloC->add_action('ylo_check_private_page', 'yloPagesPrivee', 'check' );
$yloC->add_action('admin_init', 'yloAdminPagesPrivee', 'adminInitHook');

//gère les formulaires de login
$yloC->add_action('after_setup_theme', 'yloLoginForm', 'checkLogin');

//gère l'éditeur pour écriture et d'édition de nouveaux posts
$yloC->add_filter('ylo_new_post_link', 'yloNewPost', 'lien_nouvel_article');
$yloC->add_action('ylo_new_post_editor', 'yloNewPost', 'nouveau', 10, 1);
