<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	<title><?php wp_title('|', true, 'left'); ?></title>
	<link href='http://fonts.googleapis.com/css?family=Josefin+Slab:400,700|Audiowide' rel='stylesheet' type='text/css'/>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script> 
	<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/jquery.parallax-1.1.3.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/jquery.localscroll-1.2.7-min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/jquery.scrollTo-1.4.2-min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/bjqs-1.3.min.js"></script>
	
	<?php //TODO le script suivant n'est valable que pour la front page, il est a inclure conditionnellement?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#ylo-top-menu').localScroll(1900);
			$('#intro').localScroll(800);

			$('#intro').parallax("50%", 0.1);
			$('.logo').parallax("50%", 0.2);
			$('.tablette').parallax("50%", 4);
			$('#second').parallax("50%", 0.2);
			$('.bg').parallax("50%", 0.4);
			$('#third').parallax("50%", 0.3);
		})
	</script>

	<?php // TODO le script suivant n'est utilisé que pour la page de recherche de membres, il faut l'inclure conditionnellement?>
	<script type="text/javascript">
		$(document).ready(function(){
			 $('#members-slide').bjqs({
		        animtype      : 'slide',
		        height        : 280,
		        width         : 600,
		        randomstart   : false,
		        showmarkers  : false,
		        automatic	 : false
		      });
		})
	</script>

<!--[if lte IE 8]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]--> 

	<?php wp_head();?>
</head>
<body <?php body_class();?> >
	<div id="ylo-page-wrapper">
		<nav id="ylo-top-menu">
			<?php wp_nav_menu(apply_filters('ylo_top_menu', array())) ;?>
		</nav>
		
		<?php do_action('ylo_check_private_page'); ?>
