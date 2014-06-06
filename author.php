<?php get_header(); ?>
<?php $membre = apply_filters('ylo-fiche-membre', false);?>

	<div id="ylo-page" class="ylo-member-page">
		<?php get_template_part('template_parts/top', 'actionbox'); ?>
		
		<div id="ylo-content" class="ylo-content">		
			<div id="ylo-main">
				<div class="ylo-col1">
				
				<h2 class="ylo-titre-membre"><?php $membre->first_name(); ?> <?php $membre->last_name(); ?> <span><?php $membre->displayTitre(); ?></span></h2>
				
				<div class="ylo-fiche-image"><?php $membre->get_avatar(); ?></div>

				<?php $membre->displayInfo('Pr&eacute;nom', 'simple', 'first_name');?>
				<?php $membre->displayInfo('M&eacute;tier ou qualit&eacute;', 'simple', 'ylo_metier');?>
				<?php $membre->displayInfo('Site web', 'url', 'user_url');?>
				<?php $membre->displayInfo('Ville', 'ville');?>
				<?php $membre->displayInfo('Eglise', 'simple', 'ylo_eglise');?>
				<?php $membre->displayInfo('Comp&eacute;tences', 'simple', 'ylo_competences');?>
				<?php $membre->displayInfo('Formation', 'simple', 'ylo_formation');?>
				<?php $membre->displayInfo('Experience professionnelle', 'large', 'ylo_experiences_pro');?>
				<?php $membre->displayInfo('Projets r&eacute;alis&eacute; <em>(seul ou en groupe)</em>', 'large', 'ylo_projet_realises');?>
				<?php $membre->displayInfo('T&eacute;moignage', 'large', 'ylo_temoignage');?>
				<?php $membre->displayInfo('Coordonn&eacute;es et autres infos', 'large', 'description');?>
				
				
				
				
				<div class="ylo-send-message">
					<?php if($membre->is_envoi_reussi()) : ?>
						<hr>
						<h4>Votre message a bien &eacute;t&eacute; envoy&eacute; : </h4>
						<hr>
						<p><em>Votre message à <?php $membre->first_name(); ?> <?php $membre->last_name(); ?>: </em>
							<hr />
							<?php $membre->le_message(true);?>
							
						</p>
					<?php else : ?>
						<form method="post">
						<?php wp_nonce_field('ylo-envoi-message-membre', 'ylo_envoi_message_nonce');?>
						<?php if(count($erreurs = $membre->erreurs_envoi()) > 0 ):?>
							<hr />
							<h4 class="ylo-form-error">Votre message n'a pas pu &ecirc;tre envoy&eacute; en raison des erreurs suivantes</h4>
							<ul class="ylo-form-error">
								<?php foreach($erreurs as $erreur) echo '<li>'.$erreur.'</li>';?>
							</ul>
							<hr />
						<?php endif; ?>
						 <fieldset>
							<label for="ylo-envoi-message-membree">Envoyer un message</label>
							<textarea rows="10" cols="10" name="ylo-envoi-message-membre" id="ylo-envoi-message-membre"></textarea>
							
							<input type="submit" class="submit ylo-bouton-1" value="Envoyer" />
						 </fieldset>
						</form>
					<?php endif; ?>
				</div>

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
