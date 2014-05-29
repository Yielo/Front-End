<?php
yieloCenter::includeClassFile('yloSignup');

class yloProfile extends yloSignup
{
	protected $is_update = true;
	
	public function __construct(){
		$this->user = new yloUser();
		if($id = get_current_user_id()) $this->user->load_user($id);
		if(isset($_POST['_wpnonce_ylo_update_profile']) && wp_verify_nonce( $_POST['_wpnonce_ylo_update_profile'], 'ylo_update_profile' )){
			$this->submitted = true;
			$this->processForm();
		}
	}
	
	protected function processForm(){
		$this->form_valide = true;
	
		$ylo_user_email = (isset($_POST['ylo_user_email'])) ? $_POST['ylo_user_email'] : '';
		$ylo_user_email_verif = (isset($_POST['ylo_user_email_verif'])) ? $_POST['ylo_user_email_verif'] : '';
		if(!$this->user->updateEmail($ylo_user_email, $ylo_user_email_verif)) $this->form_valide = false;

		$ylo_user_old_pass = (isset($_POST['ylo_user_old_pass'])) ? $_POST['ylo_user_old_pass'] : '';
		$ylo_user_pass = (isset($_POST['ylo_user_pass'])) ? $_POST['ylo_user_pass'] : '';
		$ylo_user_pass_verif = (isset($_POST['ylo_user_pass_verif'])) ? $_POST['ylo_user_pass_verif'] : '';
		if(!$this->user->updatePassword($ylo_user_old_pass, $ylo_user_pass, $ylo_user_pass_verif)) $this->form_valide = false;
	
		$ylo_first_name = (isset($_POST['ylo_first_name'])) ? $_POST['ylo_first_name'] : '';
		if(!$this->user->setFirstName($ylo_first_name)) $this->form_valide = false;
	
		$ylo_last_name = (isset($_POST['ylo_last_name'])) ? $_POST['ylo_last_name'] : '';
		if(!$this->user->setLastName($ylo_last_name)) $this->form_valide = false;

		// les champs optionnels
		$this->user->setVille(isset($_POST['ylo_ville']) ? $_POST['ylo_ville'] : '');
		$this->user->setPays(isset($_POST['ylo_pays']) ? $_POST['ylo_pays'] : '');
		$this->user->setEglise(isset($_POST['ylo_eglise']) ? $_POST['ylo_eglise'] : '');
		$this->user->setCompetences(isset($_POST['ylo_competences']) ? $_POST['ylo_competences'] : '');
		$this->user->setFormations(isset($_POST['ylo_formation']) ? $_POST['ylo_formation'] : '');
		$this->user->setExperiencesPro(isset($_POST['ylo_experiences_pro']) ? $_POST['ylo_experiences_pro'] : '');
		$this->user->setTemoignage(isset($_POST['ylo_temoignage']) ? $_POST['ylo_temoignage'] : '');
	
		// l'avatar est optionnel mais il peut y avoir une erreur de chargement
		if(yloAvatarUploader::is_upload('ylo_avatar_upload')){
			$avatar = new yloAvatarUploader('ylo_avatar_upload');
			if(!$this->user->setAvatar($avatar->the_url(), $avatar->the_errors())) $this->form_valide = false;
		}elseif(!empty($_POST['ylo_supprimer_avatar']) && ($_POST['ylo_supprimer_avatar'] == 'ylo_supprimer_avatar')){
			$this->user->setAvatar('');
		}elseif(!empty($_POST['ylo_avatar_existant'])){
			$this->user->setAvatar((yloAvatarUploader::check_url($_POST['ylo_avatar_existant'])) ? $_POST['ylo_avatar_existant'] : '' );
		}
	

		if($this->form_valide) return $this->user->updateUser();
		else return false;
	}
}
