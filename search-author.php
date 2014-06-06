<?php
/*
 Template Name: Chercher Membre
 Description: Une page de recherche pour chercher des membres
 * 
 */

do_action('ylo_search_hooks');
?><?php get_header(); ?>

	<div id="ylo-page">
		<div id="ylo-content" class="ylo-content">		
			<?php get_template_part('template_parts/recherche');?>
			<div class="clearfix"></div>
		</div><!-- #ylo-content -->
	</div><!-- #ylo-page -->		


<div style="padding: 10px;" >
<?php get_footer(); ?>
