<?php
class yloLoginForm
{
	protected $errors = array();
	
	public function checkLoginLogout(){
		if(!is_user_logged_in()){
			if(isset($_POST['ylo_custom_login_nonce']) && wp_verify_nonce($_POST['ylo_custom_login_nonce'], 'ylo_custom_login_nonce' )){
				$user = wp_signon();
				if(is_wp_error($user)){
					add_action('ylo_custom_login_error', array($this, 'display_errors'));
					if(empty($_POST['log'])) $this->errors[] = __('Vous devez saisir un nom d&#39;utilisateur pour vous identifier.');
					else $this->errors[] = $user->get_error_message();
				}else{
					$redirect = empty($_POST['ylo_custom_login_redirect']) ? $_SERVER['REQUEST_URI'] : esc_url($_POST['ylo_custom_login_redirect']);
					wp_redirect($redirect);
					exit;
				}
			}
		}elseif(isset($_GET['ylo_deconnexion']) && $_GET['ylo_deconnexion'] == 'deconnecter'){
			wp_logout();
			wp_redirect(home_url());
			exit;
		}
	}
	
	public function display_errors($class = ''){
		if(count($this->errors) > 0){
			echo '<ul class="ylo-login-error '.$class.'">';
			foreach($this->errors as $error){
				echo '<li>'.$error.'</li>';
			}
			echo '</ul>';
		}
	}
	
}
