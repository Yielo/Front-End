<?php

yieloCenter::includeClassFile('yloUser');
yieloCenter::includeClassFile('yloAvatarUploader');

class yloSignup
{
	protected $submitted = false;
	
	protected $user = false;
	
	protected $form_valide = false;
	
	protected $is_update = false;
	
	protected $new_user_id = false;
	
	public function __construct(){
		if(isset($_POST['_wpnonce_ylo_signup']) && wp_verify_nonce( $_POST['_wpnonce_ylo_signup'], 'ylo_inscription' )){
			$this->submitted = true;
			$this->new_user_id = $this->processForm();
		}
	}
	
	public function displayError($champ){
		if($this->submitted){
			$erreurs = $this->user->getErrors($champ);
			if($erreurs){
				echo '<ul class="ylo-form-error">';
				foreach($erreurs as $erreur){
					echo '<li>'.esc_html($erreur).'</li>';
				}
				echo '</ul>';
			}
		}
	}
	
	public function displayErrorStyle($champ){
		if($this->submitted){
			$erreurs = $this->user->getErrors($champ);
			if($erreurs){	echo '<ul class="ylo-form-error"></ul>';	}
		}
	}
	
	public function value($champ, $echo = true){
		if($this->submitted || $this->is_update){
			$value = stripslashes($this->user->getValue($champ));
			if($value && $echo) echo esc_attr($value);
			return $value;
		}else{
			return false;
		}
	}
	
	public function avatarValue($champAvatar, $champHidden, $champSuppression){
		if($this->submitted || $this->is_update){
			$url = $this->user->getValue($champAvatar);
			if(!empty($url)){
				echo '<p style="clear: both;"><img src="'.esc_url($url).'"/>';
				echo '<input type="hidden" name="'.$champHidden.'" value="'.esc_url($url).'" /><br />';
				echo '<input type="checkbox" name="'.$champSuppression.'" value="'.$champSuppression.'" class="ylo-checkbox"> Supprimer cet avatar <br /><br />';
				echo __('Choisir un autre fichier : ');
				echo '</p>';
			}
		}
	}
	
	public function conditionsGenerales(){
		$ylo_divers = get_option('yielo_divers');
		$cg = empty($ylo_divers['cg_label']) ? '' : $ylo_divers['cg_label'].'<br />';
		$lien = empty($ylo_divers['cg_lien']) ? '': $ylo_divers['cg_lien'];
		$url = empty($ylo_divers['cg_url']) ? '#': esc_url($ylo_divers['cg_url']);
		if(empty($cg) && empty($lien)) $cg = __('Accepter les conditions g&eacute;n&eacute;rales du site');
		echo $cg.'<a href="'.$url.'" target="_blank">'.$lien.'</a>';
	}
	
	public function is_successfull_signup(){
		if($this->new_user_id) return true;
		else return false;
	}
	
	protected function processForm(){
		$this->user = new yloUser();
		$this->form_valide = true;
		
		$ylo_user_login = (isset($_POST['ylo_user_login'])) ? $_POST['ylo_user_login'] : '';
		if(!$this->user->setUsername($ylo_user_login)) $this->form_valide = false;
		
		$ylo_user_email = (isset($_POST['ylo_user_email'])) ? $_POST['ylo_user_email'] : '';
		$ylo_user_email_verif = (isset($_POST['ylo_user_email_verif'])) ? $_POST['ylo_user_email_verif'] : '';
		if(!$this->user->setEmail($ylo_user_email, $ylo_user_email_verif)) $this->form_valide = false;
		
		$ylo_user_pass = (isset($_POST['ylo_user_pass'])) ? $_POST['ylo_user_pass'] : '';
		$ylo_user_pass_verif = (isset($_POST['ylo_user_pass_verif'])) ? $_POST['ylo_user_pass_verif'] : '';
		if(!$this->user->setPassword($ylo_user_pass, $ylo_user_pass_verif)) $this->form_valide = false;
		
		$ylo_first_name = (isset($_POST['ylo_first_name'])) ? $_POST['ylo_first_name'] : '';
		if(!$this->user->setFirstName($ylo_first_name)) $this->form_valide = false;
		
		$ylo_last_name = (isset($_POST['ylo_last_name'])) ? $_POST['ylo_last_name'] : '';
		if(!$this->user->setLastName($ylo_last_name)) $this->form_valide = false;

		// les champs optionnels
		$this->user->setMetier(isset($_POST['ylo_metier']) ? $_POST['ylo_metier'] : '');
		$this->user->setUserUrl(isset($_POST['user_url']) ? $_POST['user_url'] : '');
		$this->user->setVille(isset($_POST['ylo_ville']) ? $_POST['ylo_ville'] : '');
		$this->user->setPays(isset($_POST['ylo_pays']) ? $_POST['ylo_pays'] : '');
		$this->user->setEglise(isset($_POST['ylo_eglise']) ? $_POST['ylo_eglise'] : '');
		$this->user->setCompetences(isset($_POST['ylo_competences']) ? $_POST['ylo_competences'] : '');
		$this->user->setFormations(isset($_POST['ylo_formation']) ? $_POST['ylo_formation'] : '');
		$this->user->setExperiencesPro(isset($_POST['ylo_experiences_pro']) ? $_POST['ylo_experiences_pro'] : '');
		$this->user->setProjetsRealises(isset($_POST['ylo_projet_realises']) ? $_POST['ylo_projet_realises'] : '');
		$this->user->setTemoignage(isset($_POST['ylo_temoignage']) ? $_POST['ylo_temoignage'] : '');
		$this->user->setDescription(isset($_POST['description']) ? $_POST['description'] : '');
		
			// l'avatar est optionnel mais il peut y avoir une erreur de chargement
		if(yloAvatarUploader::is_upload('ylo_avatar_upload')){
			$avatar = new yloAvatarUploader('ylo_avatar_upload');
			if(!$this->user->setAvatar($avatar->the_url(), $avatar->the_errors())) $this->form_valide = false;
		}elseif(!empty($_POST['ylo_supprimer_avatar']) && ($_POST['ylo_supprimer_avatar'] == 'ylo_supprimer_avatar')){
			$this->user->setAvatar('');
		}elseif(!empty($_POST['ylo_avatar_existant'])){
			$this->user->setAvatar((yloAvatarUploader::check_url($_POST['ylo_avatar_existant'])) ? $_POST['ylo_avatar_existant'] : '' );
		}

		// on vérifie les condtions générales
		if(!isset($_POST['ylo_conditions_generales']) || $_POST['ylo_conditions_generales'] != 'accepted'){
			$this->user->setCgError();
			return false;
		}
	
		if($this->form_valide) return $this->user->insertUser();
		else return false;
	}
	
	
	
}
