<div id="ylo-top-action-box">

	<?php if(is_user_logged_in()) : ?>

		<div class="ylo-logout-link">
			Bonjour <?php echo wp_get_current_user()->display_name ;?>
			<br />
			<a href="<?php echo wp_logout_url(home_url()); ?>" title="Se d&eacute;connecter" >
				Se déconnecter
			</a>			
		</div>
		<?php  get_search_form(); ?>

	<?php else : ?>
		<div class="ylo-login-form">
			
			<form method="post" action="">
				<?php wp_nonce_field('ylo_custom_login_nonce', 'ylo_custom_login_nonce');?>
				<div class="ylo-checkbox">
					<input type="checkbox" name="rememberme" value="forever" />
					<label for="rememberme" >Se souvenir <br />de moi</label>
				</div>
				<input class="ylo-textfield" type="text" name="log" placeholder="Login" /> 
				<input class="ylo-textfield" type="password" name="pwd" placeholder="Mot de passe" />
				<input class="ylo-submit" type="submit" value="Se connecter" />
			</form>	
			<?php do_action('ylo_custom_login_error'); ?>	
		</div>

		
	<?php endif;?>
</div><!-- #ylo-action-box -->
