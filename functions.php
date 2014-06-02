<?php

include_once(get_template_directory().'/lib/yieloCenter.php');

$yloC = new yieloCenter();


// gère la page d'options du thème dans l'admin
$yloC->add_action('admin_menu', 'yloAdminPageOptions', 'setup');

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
$yloC->add_action('ylo_lien_editer_supprimer', 'yloNewPost', 'lien_editer_supprimer');
$yloC->add_action('ylo_edit_post_editor', 'yloNewPost', 'edit_post');
$yloC->add_action('ylo_delete_current_post', 'yloNewPost', 'delete_post');

// gère les éléments de menu pour les menus dynamiques dans l'admin
$yloC->add_action('admin_init', 'yloAdminNavMenus', 'register_nav_menus');

// gère l'envoi des email lors de la publication des articles
$yloC->add_action('transition_post_status', 'yloPostNMailSettings', 'check_on_transition', 10, 3);
$yloC->add_action('wp_insert_comment', 'yloPostNMailSettings', 'on_comment_insert', 10, 2 );
$yloC->add_action('wp-mail.php', 'yloPostNMailSettings', 'intercept_setup');

