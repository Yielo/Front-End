<?php
/*
 Template Name: Chercher Membre
 Description: Une page de recherche pour chercher des membres
 * 
 */
?><?php get_header(); ?>

	<div id="ylo-page">

		
		<div id="ylo-content">		
			<div id ="ylo-search-member">
				<form id="ylo-search-member-form" name="ylo-search-member-form" method="post">
					<fieldset>
						<input type="text" name="ylo_cherche_membre" class="ylo-search-text-field" value="" placeholder="Un membre, un métier , un lieu,..." />
						<input type="submit" value="Rechercher" class="ylo-search-button"  />
					</fieldset>
				</form>
			</div>
			<div id="ylo-main">
				<div class="ylo-col1">
					<?php while(have_posts()) : the_post();?>
						<div <?php post_class(); ?>>
							<h2 class="ylo-titre-ligne"><span><?php the_title() ;?></span></h2>
							<p><?php the_content(); ?></p>		
						</div>
					<?php endwhile;?>
					
					<?php if(!empty($_POST['ylo_cherche_membre']) || !empty($_GET['ylo_cherche_membre'])) : do_action('ylo_search_member', 'ylo_cherche_membre', 12); ?>
					<?php else : ?>
						<p>Veuillez remplir le formulaire ci-dessus pour effectuer une recherche</p>
					<?php endif ;?>

					
				</div><!-- .ylo-col1 -->
				<div class="ylo-col2">
					<?php do_action('ylo_default_sidebar');  ?>
				</div><!-- .ylo-col2 -->
				<div class="clearfix"></div>
			</div><!-- #ylo-main -->
			
			<div class="clearfix"></div>
		</div><!-- #ylo-content -->
	</div><!-- #ylo-page -->		





<div style="padding: 10px;" >

</div>
<?php //// get_sidebar(); ?>
<?php get_footer(); ?>
