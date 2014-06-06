<?php
/*
 Template Name: Profile Update
 Description: Un template pour mettre à jour les infos personelles des membres
 */

$yloForm = apply_filters('ylo_update_form', false );

?>
<?php get_header(); ?>
	<div id="ylo-page">
		<?php get_template_part('template_parts/top', 'actionbox'); ?>
		
		<div id="ylo-content" class="ylo-content">		
			<h1 class="ylo-main-title">Votre Profil</h1>
			<div id="ylo-main">
				<div class="ylo-col1">
				<?php if(isset($_GET['ylo_delete_user']) && $_GET['ylo_delete_user'] == 'supprimer') :?>
					<?php do_action('ylo_delete_user');?>
				<?php else :?>
					<div id="ylo-loop">
						<?php while(have_posts()) : the_post();?>
							<div <?php post_class(); ?>>
								<h2 class="ylo-titre-ligne"><span><?php the_title() ;?></span></h2>
								<p><?php the_content(); ?></p>		
							</div>
						<?php endwhile;?>					
					</div>
					<div class="ylo-inscription">
						<form id="ylo-form-inscription" method="post"  enctype="multipart/form-data">
							<input type="hidden" name="ylo-formulaire" value="update-profile" />
							 <?php wp_nonce_field('ylo_update_profile','_wpnonce_ylo_update_profile'); ?>
							<fieldset>
								
								<div class="ylo-form-div">
									<?php $yloForm->displayError('ylo_user_login'); ?>
									<label for="ylo_user_login">Ton pseudo *</label> 
									<input type="text" name="ylo_user_login" id="ylo_user_login" value="<?php $yloForm->value('ylo_user_login'); ?>" placeholder="Pseudo" disabled />
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
								<p><em>NB : ne saisir les mot de passe ci-dessous que pour changer le mot de passe
									<br /> Laisser vide pour laisser le mot de passe inchang&eacute;.
								</em></p>
									<?php $yloForm->displayError('ylo_user_pass'); ?>
									<label for="ylo_user_old_pass">Mot de passe actuel *</label> 
									<input type="password" name="ylo_user_old_pass" id="ylo_user_old_pass" value="" placeholder="Mot de passe actuel" />
								</div>
								
								<div class="ylo-form-div">
									<?php $yloForm->displayErrorStyle('ylo_user_pass'); ?>
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
								
							</fieldset>
							<fieldset>
								<div class="ylo-form-div">
									<?php $yloForm->displayError('ylo_metier'); ?>
									<label class="ylo-large-label" for="ylo_metier">Ton m&eacute;tier ou ta qualit&eacute; * 
										<br /><em class="ylo-small">(d&eacute;veloppeur, d&eacute;signer, webmaster, community-manager, sys-admin, porteur de projet, client, ... )</em>
									</label> 
									<input type="text" name="ylo_metier" id="ylo_metier" value="<?php $yloForm->value('ylo_metier'); ?>" placeholder="M&eacute;tier ou qualit&eacute;" />
								</div>
								
								<div class="ylo-form-div">
									<label for="user_url">Ton site web</label> 
									<input type="text" name="user_url" id="user_url" value="<?php $yloForm->value('user_url'); ?>" placeholder="Ton site web"/>
								</div>
								
							</fieldset>
							<fieldset>
								
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
									<textarea rows="5" cols="15" name="ylo_competences" id="ylo_competences" 
										placeholder="Html, css, php, javasript, java, photoshop, graphiste, linux, python, wordpress, synfony, jquery, gestion de projet, visionnaire, enthousiaste ..."
									><?php $yloForm->value('ylo_competences'); ?></textarea>
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
									<label class="ylo-textarea-label" for="ylo_projet_realises">Projets r&eacute;alis&eacute; <em>(Seul ou avec d'autres personnes)</em></label>
									<textarea rows="5" cols="15" name="ylo_projet_realises" id="ylo_projet_realises"><?php $yloForm->value('ylo_projet_realises'); ?></textarea>
								</div>								
								
								<div class="ylo-form-div">
									<label class="ylo-textarea-label" for="ylo_temoignage">Témoignage</label>
									<textarea rows="5" cols="15" name="ylo_temoignage" id="ylo_temoignage" placeholder="Un court résumé..."><?php $yloForm->value('ylo_temoignage'); ?></textarea>
								</div>
																
								<div class="ylo-form-div">
									<label class="ylo-textarea-label" for="description">Coordonn&eacute;es et autres infos</label>
									<textarea rows="5" cols="15" name="description" id="description" placeholder="N° de t&eacute;l&eacute;phone, freelance, soci&eacute;t&eacute;, association, etc ..."><?php $yloForm->value('description'); ?></textarea>
								</div>
								
								
								<div class="ylo-form-div">
									<?php $yloForm->displayError('ylo_avatar_upload'); ?>
									<label for="ylo_avatar_upload">Ton avatar</label>
									<?php $yloForm->avatarValue('ylo_avatar_upload', 'ylo_avatar_existant', 'ylo_supprimer_avatar'); ?>
									<input type="file" name="ylo_avatar_upload" id="ylo_avatar_upload" />
								</div>
							
							</fieldset>
							<fieldset class="ylo-form-top-line">
								<div class="ylo-form-div">
									<?php $yloForm->displayError('ylo_conditions_generales'); ?>
									<input type="checkbox" name="ylo_conditions_generales" class="ylo-checkbox" value="accepted" checked="checked" disabled="disabled"/>
									<label class="ylo-checkbox-label" for="ylo_conditions_generales">
										<?php $yloForm->conditionsGenerales();?>
									</label>
								</div>
								<div class="ylo-form-div form-submit ">
									<input class="ylo-bouton-1" type="submit" value="Envoyer" />
								</div>
								
							</fieldset>
						</form>
						<div class="ylo-lien-suppression-user">
							<p>
								<a href="<?php echo add_query_arg('ylo_delete_user', 'supprimer', $_SERVER['REQUEST_URI']);?>">
									Supprimer votre compte
								</a>
								- Attention : la suppression de votre compte de membre est irr&eacute;versible 
							</p>
						</div>
					</div>
					<?php endif;?>
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
