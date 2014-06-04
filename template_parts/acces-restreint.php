	<div id="ylo-page">
		<div id="ylo-action-box">
		</div><!-- #ylo-action-box -->
		<div id="ylo-content" class="ylo-content">
			<h1 class="ylo-main-title">Acc&egrave;s restreint</h1>
			
			<div id="ylo-main">
				<div class="ylo-full-width">
						<div >
							<h2 class="ylo-titre-ligne"><span>Veuillez vous indentifier</span></h2>
							<p class="align-center"><em>La page que vous avez demand&eacute; est une page dont l'acc&egrave;s est r&eacute;serv&eacute; aux membre de Yielo.<br />
							L'acc&egrave;s &agrave; cette page n&eacute;cessite d&ecirc;tre d'&ecirc;tre connect&eacute;.<br>
							Veillez donc vous identifier pour continuer. </em></p>		
						</div>
					<div id="ylo-login-box">
						<h3>Identifiez-vous : </h3>
						<?php do_action('ylo_custom_login_error'); ?>
						<form name="loginform" id="loginform" a method="post">
							<?php wp_nonce_field('ylo_custom_login_nonce', 'ylo_custom_login_nonce');?>
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
					</div>
				</div><!-- .ylo-full-width -->
			</div><!-- #ylo-main -->
			
			<div class="clearfix"></div>
		</div><!-- #ylo-content -->
	</div><!-- #ylo-page -->	
