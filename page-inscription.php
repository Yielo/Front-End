<?php
/*
Template Name: Page Inscription
Description: La page pour s'inscritre 
 
 */
$yloForm = apply_filters('ylo_signup_form', false );

?>
<?php get_header(); ?>
	<div id="ylo-page">
		<?php get_template_part('template_parts/top', 'actionbox'); ?>
		
		<div id="ylo-content">		
			<h1 class="ylo-main-title">Inscription</h1>
			<div id="ylo-main">
				<div class="ylo-col1">
					<div id="ylo-loop">
						<?php while(have_posts()) : the_post();?>
							<div <?php post_class(); ?>>
								<h2 class="ylo-titre-ligne"><span><?php the_title() ;?></span></h2>
								<p><?php the_content(); ?></p>		
							</div>
						<?php endwhile;?>					
					</div>
					<div class="ylo-inscription">
					<?php if(is_user_logged_in()) :?>
						<?php $membre = wp_get_current_user(); ?>
						<div class="ylo-form-dialogue">
							<p>
								<em>Tu es d&eacute;j&agrave; connect&eacute; en tant que <?php echo esc_html($membre->display_name); ?>,
								tu es donc d&eacute;j&agrave; inscrit.</em>					
							</p>
							<p> Si tu n'es pas <?php echo esc_html($membre->display_name); ?>, ou que tu veux inscrire quelqu'un d'autre, 
								tu dois d'abord te <a href="<?php wp_logout(); ?>">d&eacute;connecter (en cliquant ici par exemple)</a>
							</p>						
						</div>

					<?php elseif($yloForm->is_successfull_signup()): ?>
						<div class="ylo-form-dialogue">
							<h3>Inscrition r&eacute;ussie</h3>
							<p>Bienvenue dans la communaut&eacute; Yielo
								<br /> Tu peux d&eacute;sorm&eacute; te connecter ci-dessous
							</p>
							<div id="ylo-login-box">
								<h3>Identifiez-vous : </h3>
								<?php wp_login_form(array( 'value_username' => $yloForm->value('ylo_user_login', false))); ?>
							</div>
						</div>
					<?php else :?>
						<form id="ylo-form-inscription" method="post" action="#" enctype="multipart/form-data">
							<input type="hidden" name="ylo-formulaire" value="inscription" />
							 <?php wp_nonce_field('ylo_inscription','_wpnonce_ylo_signup'); ?>
							<fieldset>
								
								<div class="ylo-form-div">
									<?php $yloForm->displayError('ylo_user_login'); ?>
									<label for="ylo_user_login">Ton pseudo *</label> 
									<input type="text" name="ylo_user_login" id="ylo_user_login" value="<?php $yloForm->value('ylo_user_login'); ?>" placeholder="Pseudo" />
								</div>
								
							</fieldset>
							<fieldset>
								
								<div class="ylo-form-div">
									<?php $yloForm->displayError('ylo_user_email'); ?>
									<label for="ylo_user_email">Ton email *</label> 
									<input type="text" name="ylo_user_email" id="ylo_user_email" value="<?php $yloForm->value('ylo_user_email'); ?>" placeholder="Email" />
								</div>
								
								<div class="ylo-form-div">
									<?php $yloForm->displayErrorStyle('ylo_user_email'); ?>
									<label for="ylo_user_email_verif">V&eacute;rif email *</label> 
									<input type="text" name="ylo_user_email_verif" id="ylo_user_email_verif" value="<?php $yloForm->value('ylo_user_email_verif'); ?>" placeholder="V&eacute;rification email" />
								</div>
								
							</fieldset>
							<fieldset>
								
								<div class="ylo-form-div">
									<?php $yloForm->displayError('ylo_user_pass'); ?>
									<label for="ylo_user_pass">Mot de passe *</label> 
									<input type="password" name="ylo_user_pass" id="ylo_user_pass" value="" placeholder="Mot de passe" />
								</div>
								
								<div class="ylo-form-div">
									<?php $yloForm->displayErrorStyle('ylo_user_pass'); ?>
									<label for="ylo_user_pass_verif">Re mot de passe *</label> 
									<input type="password" name="ylo_user_pass_verif" id="ylo_user_pass_verif" value="" placeholder="Confirmation mot de passe" />
								</div>
								
							</fieldset>
							<fieldset>
								
								<div class="ylo-form-div">
									<?php $yloForm->displayError('ylo_last_name'); ?>
									<label for="ylo_last_name">Nom *</label> 
									<input type="text" name="ylo_last_name" id="ylo_last_name" value="<?php $yloForm->value('ylo_last_name'); ?>" placeholder="Nom" />
								</div>
								
								<div class="ylo-form-div">
									<?php $yloForm->displayError('ylo_first_name'); ?>
									<label for="ylo_first_name">Prénom *</label> 
									<input type="text" name="ylo_first_name" id="ylo_first_name" value="<?php $yloForm->value('ylo_first_name'); ?>" placeholder="Pr&eacute;nom" />
								</div>
								
								<div class="ylo-form-div">
									<label for="ylo_ville">Ville de r&eacute;sidence</label> 
									<input type="text" name="ylo_ville" id="ylo_ville" value="<?php $yloForm->value('ylo_ville'); ?>" placeholder="Ta ville de r&eacute;sidence" />
								</div>
								
								<div class="ylo-form-div">
									<label for="ylo_pays">Pays de r&eacute;sidence</label> 
									<input type="text" name="ylo_pays" id="ylo_pays" value="<?php $yloForm->value('ylo_pays'); ?>" placeholder="Ton pays de r&eacute;sidence" />
								</div>
								
								<div class="ylo-form-div">
									<label for="ylo_eglise">Ton église</label> 
									<input type="text" name="ylo_eglise" id="ylo_eglise" value="<?php $yloForm->value('ylo_eglise'); ?>" placeholder="Ton &eacute;glise"/>
								</div>
								
							</fieldset>
							<fieldset>
								
								<div class="ylo-form-div">
									<label class="ylo-textarea-label" for="ylo_competences">Tes domaines de comp&eacute;tence ou qualit&eacute;s</label>
									<textarea rows="5" cols="15" name="ylo_competences" id="ylo_competences" placeholder="D&eacute;velloppeur, D&eacute;signer, Sys Amin, Community manager, Client ..."><?php $yloForm->value('ylo_competences'); ?></textarea>
								</div>
								
								<div class="ylo-form-div">
									<label class="ylo-textarea-label" for="ylo_formation">Ta Formation</label>
									<textarea rows="5" cols="15" name="ylo_formation" id="ylo_formation" placeholder="Formations qualifiantes, ..."><?php $yloForm->value('ylo_formation'); ?></textarea>
								</div>
								
								<div class="ylo-form-div">
									<label class="ylo-textarea-label" for="ylo_experiences_pro">Experience professionnelle</label>
									<textarea rows="5" cols="15" name="ylo_experiences_pro" id="ylo_experiences_pro"><?php $yloForm->value('ylo_experiences_pro'); ?></textarea>
								</div>
								
								<div class="ylo-form-div">
									<label class="ylo-textarea-label" for="ylo_temoignage">Témoignage</label>
									<textarea rows="5" cols="15" name="ylo_temoignage" id="ylo_temoignage" placeholder="Un court résumé..."><?php $yloForm->value('ylo_temoignage'); ?></textarea>
								</div>
								
								<div class="ylo-form-div">
									<?php $yloForm->displayError('ylo_avatar_upload'); ?>
									<label for="ylo_avatar_upload">Ton avatar</label>
									<?php $yloForm->avatarValue('ylo_avatar_upload', 'ylo_avatar_existant', 'ylo_supprimer_avatar'); ?>
									
									<input type="file" name="ylo_avatar_upload" id="ylo_avatar_upload" />
								</div>
								
								<div class="ylo-form-div form-submit ">
									<input class="ylo-bouton-1" type="submit" value="Envoyer" />
								</div>
								
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
