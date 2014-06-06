							<h3>Identifiez-vous : </h3>
							<?php do_action('ylo_custom_login_error'); ?>
							<?php $ylo_front = apply_filters('ylo_setupFrontPage', false);?>
							<form name="loginform" id="loginform" a method="post">
								<?php wp_nonce_field('ylo_custom_login_nonce', 'ylo_custom_login_nonce');?>
								<input type="hidden" name="ylo_custom_login_redirect" value="<?php $ylo_front->redirect_url();?>" />
								<p class="login-username">
									<label for="user_login">Identifiant</label>
									<input name="log" id="user_login" class="input" value="" size="20" type="text">
								</p>
								<p class="login-password">
									<label for="user_pass">Mot de passe</label>
									<input name="pwd" id="user_pass" class="input" value="" size="20" type="password">
								</p>
								
								<p class="login-remember"><label><input name="rememberme" id="rememberme" value="forever" type="checkbox"> Se souvenir de moi</label></p>
								<p class="login-submit">
									<input name="wp-submit" id="wp-submit" class="button-primary" value="Se connecter" type="submit">
								</p>
								
							</form>
