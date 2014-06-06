<?php get_header() ;?>
<?php $ylo_front = apply_filters('ylo_setupFrontPage', false);?>

<!--HOME-->
<div id="intro" >
		<div class="logo"></div>
		<div class="tablette"></div>
		<div class="presentation">
				<div class="float-left">
						<h2><?php $ylo_front->slogan(); ?></h2>
						<a class="rollover" href="#third" title="Next Section">&nbsp;</a> 
	
						<div id="ylo-front-connexion">
						<?php if(is_user_logged_in()) : ?>
							<div >
								<p>Bonjour <?php echo wp_get_current_user()->display_name ;?>, 
								<br />Bienvenue de retour !
								</p>
								<div class="ylo-login-form"><a href="<?php echo wp_logout_url(home_url()); ?>" title="Se d&eacute;connecter" >
									<button class="ylo-submit">Se déconnecter</button>
								</a></div>			
							</div>
						<?php else : ?>
							<p>Déjà membre? Connecte-toi :</p>
							<div class="ylo-login-form">
								<?php do_action('ylo_custom_login_error'); ?>	
								<form method="post" action="">
									<?php wp_nonce_field('ylo_custom_login_nonce', 'ylo_custom_login_nonce');?>
									
									<input class="ylo-textfield" type="text" name="log" placeholder="Login" /> 
									<input class="ylo-textfield" type="password" name="pwd" placeholder="Mot de passe" />
									<input type="hidden" name="ylo_custom_login_redirect" value="<?php $ylo_front->admin_redirect_url();?>" />
									<div class="ylo-checkbox">
										<input type="checkbox" name="rememberme" value="forever"/>
										<label for="rememberme" >Se souvenir <br />de moi</label>
									</div>
									<div class="ylo-width-fix">
										<input class="ylo-submit" type="submit" value="Se connecter" />
									</div>
									
								</form>	
								
							</div>		
						<?php endif;?>
					</div><!-- #ylo-front-connexion -->
				</div>
		</div>
</div>
<!--PRESENTATION-->
<div id="second">
		<div class="presentation">
			<div id="para1" class="float-right">
					<h2><?php $ylo_front->front2_titre1(); ?></h2>
					<p><?php $ylo_front->front2_texte1(); ?></p>
			</div>
			<div id="para2" class="float-right">
					<h2><?php $ylo_front->front2_titre2(); ?></h2>
					<p><?php $ylo_front->front2_texte2(); ?></p>
			</div>
			<div id="para3" class="float-right">
					<h2><?php $ylo_front->front2_titre3(); ?></h2>
					<p><?php $ylo_front->front2_texte3(); ?></p>
			</div>		
		</div>

</div>
</div>
<!--CHARTE-->
<div id="third">
		<div class="presentation">
				<div id="char1" class="float-left">
						<h2><?php $ylo_front->front3_titre1(); ?></h2>
						<p><?php $ylo_front->front3_texte1(); ?></p>
						<h2><?php $ylo_front->front3_titre3(); ?></h2>
						<p><?php $ylo_front->front3_texte3(); ?></p>
				</div>
				<div id="char2" class="float-left">
						<h2><?php $ylo_front->front3_titre2(); ?></h2>
						<p><?php $ylo_front->front3_texte2(); ?></p>
						<h2><?php $ylo_front->front3_titre4(); ?></h2>
						<p><?php $ylo_front->front3_texte4(); ?></p>
						<a class="rollover2" href="<?php $ylo_front->front3_lien(); ?>"></a> </div>
		</div>
</div>

<?php get_footer() ;?>
