<?php
class yloDeleteUser
{
	
	public function delete_request(){
		if(isset($_POST['ylo_confimation_de_supression_nonce']) && wp_verify_nonce($_POST['ylo_confimation_de_supression_nonce'], 'ylo_confimation_de_supression_nonce')){
			if(isset($_POST['ylo_confirmation_de_suppression']) && $_POST['ylo_confirmation_de_suppression'] == 'confirmer' ){
				require_once(ABSPATH.'wp-admin/includes/user.php' );
				wp_delete_user(get_current_user_id());
				$this->delete_confirmed();
			}else{
				message_non_confirmation();
			}
		}else{
			$this->confirmation_form();
		}	
	}
	
	protected function delete_confirmed(){
		?>
			<div class="ylo-delete-user">
				<h3>Votre compte a bien &eacute;t&eacute; supprim&eacute;</h3>
				<p><a href="<?php echo home_url(); ?>">
					Retourner &agrave; l'accueil
				</a></p>
			</div>
		<?php 
	}

	
	protected function confirmation_form(){
		$user = wp_get_current_user();
		?>
		<div class="ylo-delete-user">
			<h3>Confirmez-vous la suppression de l'utilisateur suivant : </h3>
			<p>
				<h4><?php esc_html($user->display_name);?></h4>
				<ul>
					<li>Nom : <?php echo esc_html($user->last_name); ?></li>
					<li>Pr&eacute;nom : <?php echo esc_html($user->first_name); ?></li>
					<li>Login : <?php echo esc_html($user->user_login); ?></li>
					<li>Email : <?php echo esc_html($user->user_email); ?></li>
				</ul>
			</p>

				<form method="post">
					<?php wp_nonce_field('ylo_confimation_de_supression_nonce', 'ylo_confimation_de_supression_nonce');?>
					<p>
						La suppression d'un utilisateur est une action irr&eacute;versible.
						<br />  Si vous &ecirc;tes s&ucirc;r de vouloir supprimer votre compte 
						cochez la case ci-dessous et cliquez sur "Confirmer la Suppression"
					</p>
					<p>
						<input type="checkbox" name="ylo_confirmation_de_suppression" value="confirmer" />
						Je confirme demander la suppression de mon compte.
						<br />
						<input type="submit" value="Confirmer la Suppression" />
						<span><a href="<?php echo home_url('');?>">Annuler</a></span>
					</p>
				</form>
		</div>
		<?php 
	}
	
	protected function message_non_confirmation(){
		?>
		<div class="ylo-delete-user">
			<h3>Vous n'avez pas confirm&eacute; la suppression de votre compte</h3>
			<p>Vous n'avez pas s&eacute;lection&eacute; la case de confirmation de votre compte, 
			et votre n'a donc pas &eacute;t&eacute; supprim&eacute;.
			</p>
			<p><a href="<?php echo home_url(); ?>">
				Cliquez ici pour retourner &agrave; l'accueil
			</a></p>
		</div>
		<?php 	
	}
}
