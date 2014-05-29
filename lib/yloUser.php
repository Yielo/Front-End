<?php

yieloCenter::includeClassFile('yloUserFields');

class yloUser
{
	protected $wp_user	=	false; // objet WP_User
	protected $user_id = false;
	
	protected $user_info = array(
			'ylo_user_login'	=>	'',
			'ylo_user_email'	=>	'',
			'ylo_user_pass'		=>	'',
			'ylo_first_name'	=>	'',
			'ylo_last_name'		=>	'',
			'ylo_eglise' 		=> '',
			'ylo_ville' 		=> '',
			'ylo_pays' 			=> '',
			'ylo_competences' 	=> '',
			'ylo_formation' 	=> '',
			'ylo_experiences_pro' => '',
			'ylo_temoignage'	=> '',
			'ylo_avatar_upload' => '',
		);
	
	protected $errors = array();
	
	protected $yloUserFields;
	
	protected $edit_password = true;
	
	public function __construct(){
		$this->yloUserFields = new yloUserFields();
	}
	
	public function setUsername($ylo_user_login){
		$sanitized_user = sanitize_user(wp_slash($ylo_user_login));
		if( ($sanitized_user != $ylo_user_login) || !validate_username($ylo_user_login) ){
			// le format est invalide
			$this->errors['ylo_user_login'][] = __('Ce nom d&#39;utilisateur comporte des carract&egrave;res non autoris&eacute; ou un format incorrect !');
			return false;
		}else if($ylo_user_login == '' ){
			$this->errors['ylo_user_login'][] = __('Le nom d&#39;utilisisateur doit &ecirc;tre renseign&eacute; !');
			return false;
		}else if(username_exists($ylo_user_login)){
			$this->errors['ylo_user_login'][]	= __('Le nom d&#39;utilisateur "'.esc_html($ylo_user_login).'"existe d&eacute;j&agrave; !');
			return false;
		}else{
			$this->user_info['ylo_user_login']	= $ylo_user_login;
			return true;
		}
	}
	
	public function setEmail($post_email, $post_email_verif){
		$email = sanitize_text_field( $post_email );
		$email_verif = sanitize_text_field( $post_email_verif );
		$is_valide_email = true;
		if(empty($email)){
			$is_valide_email = false;
			$this->errors['ylo_user_email'][] = __('L&#39;adresse email est requise !');
		}
		if(empty($email_verif)){
			$is_valide_email = false;
			$this->errors['ylo_user_email'][] = __('Vous devez confirmer votre adresse email !');
		}
		if(!is_email($email) || ($email != $post_email)){
			$is_valide_email = false;
			$this->errors['ylo_user_email'][] = __('Ceci n&#39;pas une adresse email valide !');
		}
		if(email_exists($email)){
			$is_valide_email = false;
			$this->errors['ylo_user_email'][] = __('Cette adresse email est d&eacute;j&agrave; utilis&eacute;e, veuillez choisir une autre adresse email');
		}
		if( $email != $email_verif ){
			$is_valide_email = false;
			$this->errors['ylo_user_email'][] = __('Les deux adresses emails ne correspondondent pas !');
		}
		$this->user_info['ylo_user_email'] = $email;
		$this->user_info['ylo_user_email_verif'] = $email_verif;
		return $is_valide_email;
	}
	
	public function updateEmail($email, $verif){
		if($email == $this->user_info['ylo_user_email']){
			return true; // le mot de passe est inchangé
		}else {
			return $this->setEmail($email, $verif);
		}
	}
	
	public function setPassword($pass, $pass_verif){
		$pass_valide = true;
		if(empty($pass)){
			$this->errors['ylo_user_pass'][] = __('Vous devez choisir un mot de passe !');
			$pass_valide = false;
		}else{
			if($pass != $pass_verif){
				$this->errors['ylo_user_pass'][] = __('Les mots de passe que vous avez saisi ne correspondent pas !');
				$pass_valide = false;
			}
			if((strlen($pass)<4) || (strlen($pass) > 64)){
				$this->errors['ylo_user_pass'][] = __('Votre mot de passe n&#39; pas valide, il doit contenir entre 4 et 20 carract&egrave;res');
				$pass_valide = false;
			}
			if(false !== strpos( wp_unslash( $pass ), "\\" )){
				$this->errors['ylo_user_pass'][] = __('Votre mot de passe ne doit pas contenir de backslash "\\", veuillez choisir un autre mot de passe');
				$pass_valide = false;
			}
		}
		if($pass_valide){
			$this->user_info['ylo_user_pass'] = $pass;
		}
		return $pass_valide;
	}
	
	public function updatePassword($old, $new, $verif){
		if(empty($old) && empty($new) && empty($verif)){
			$this->edit_password = false;
			return true;
		}elseif(empty($old)){
			$this->edit_password = false;
			$this->errors['ylo_user_pass'][] = __('Vous devez saisir votre mot de passe actuel pour pouvoir le changer !');
			return false;
		}elseif(!wp_check_password($old, $this->user_info['ylo_user_pass'], $this->user_id)){
			$this->edit_password = false;
			$this->errors['ylo_user_pass'][] = __('Votre mot de passe actuel ne correspond pas &agrave; celui que vous avez saisi');
			return false;
		}else{
			return $this->setPassword($new, $verif);
		}
	}
	
	public function setFirstName($prenom){
		return $this->setRequiredTextField('ylo_first_name', 'Le pr&eacute;nom', $prenom);
	}
	
	public function setLastName($nom){
		return $this->setRequiredTextField('ylo_last_name', 'Le nom de famille', $nom );
	}
	
	public function setVille($ville){
		return $this->setSimpleTextField( 'ylo_ville',  $ville);
	}
	
	public function setPays($pays){
		return $this->setSimpleTextField( 'ylo_pays',  $pays);
	}
	
	public function setEglise($eglise){
		return $this->setSimpleTextField( 'ylo_eglise',  $eglise);
	}
	
	public function setCompetences($competences){
		return $this->setSimpleTextField( 'ylo_competences',  $competences);
	}
	
	public function setFormations($formations){
		return $this->setSimpleTextField( 'ylo_formation',  $formations);
	}
	
	public function setExperiencesPro($experiences){
		return $this->setSimpleTextField( 'ylo_experiences_pro',  $experiences);
	}
	
	public function setTemoignage($temoignage){
		return $this->setSimpleTextField( 'ylo_temoignage',  $temoignage);
	}
	
	public function setAvatar($avatarURL, $errors = array() ){
		// l'url est générée en interne elle n'a donc pas besoin d'être sanitiezée
		// par contre les erreurs sont rensignée à l'extérieur de la donction
		
		foreach($errors as $error){
			$this->errors['ylo_avatar_upload'][] = $error;
		}
		if($avatarURL || $avatarURL === '') {
			$this->user_info['ylo_avatar_upload'] = $avatarURL;
			return true;
		}else return false;
	}

	public function insertUser(){
		return $this->updateUser(true);
	}
	
	public function updateUser($new = false){
		if(count($this->errors) == 0 ){
			$userdata = array(
					'user_login'    =>  $this->user_info['ylo_user_login'],
					'user_email'	=>	$this->user_info['ylo_user_email'],
					'first_name'	=>	$this->user_info['ylo_first_name'],
					'last_name'		=>	$this->user_info['ylo_last_name'],
					'ylo_ville'		=>	$this->user_info['ylo_ville'],
					'ylo_pays'		=>	$this->user_info['ylo_pays'],
					'ylo_eglise'	=>	$this->user_info['ylo_eglise'],
					'ylo_competences'	=>	$this->user_info['ylo_competences'],
					'ylo_formation'		=>	$this->user_info['ylo_formation'],
					'ylo_experiences_pro'	=>	$this->user_info['ylo_experiences_pro'],
					'ylo_temoignage'	=>	$this->user_info['ylo_temoignage'],
					'ylo_avatar_upload'	=>	$this->user_info['ylo_avatar_upload'],
			);
			
			// le mot de passe ne doit pas être changer lorsqu'on update le profil et qu'on ne renseigne pas le mot de passe 
			
			if($new){
				$userdata['user_pass'] = $this->user_info['ylo_user_pass']; 
				$userdata['role'] = 'author' ;
				$user_id =  wp_insert_user( $userdata ) ;
			}else{
				$userdata['ID'] = $this->user_id;
				if($this->edit_password) $userdata['user_pass'] = $this->user_info['ylo_user_pass']; 
				$user_id = wp_update_user( $userdata );
			}
			if($user_id) update_user_meta( $user_id, 'ylo_avatar_upload', $userdata['ylo_avatar_upload']);
			
			return $user_id;
		}else{
			return false;
		}
	}
	
	
	public function load_user($user_id){
		$this->user_id = $user_id;
		$this->wp_user = get_user_by('id', $user_id); // je sais plus si j'utilise cette variable
		$user_data = get_userdata($user_id);
		$this->user_info['ylo_user_login']	= $user_data->user_login ;
		$this->user_info['ylo_user_email']	= $user_data->user_email ;
		$this->user_info['ylo_user_email_verif']	= $user_data->user_email ;
		$this->user_info['ylo_user_pass']	= $user_data->user_pass  ;
		$this->user_info['ylo_first_name']	= $user_data->first_name  ;
		$this->user_info['ylo_last_name']	= $user_data->last_name  ;
		$this->user_info['ylo_ville']		= $user_data->ylo_ville  ;
		$this->user_info['ylo_pays']		= $user_data->ylo_pays  ;
		$this->user_info['ylo_eglise']		= $user_data->ylo_eglise  ;
		$this->user_info['ylo_competences']	= $user_data->ylo_competences  ;
		$this->user_info['ylo_formation']	= $user_data->ylo_formation  ;
		$this->user_info['ylo_experiences_pro']	= $user_data->ylo_experiences_pro  ;
		$this->user_info['ylo_temoignage']	= $user_data->ylo_temoignage  ;
		$this->user_info['ylo_avatar_upload']	= $user_data->ylo_avatar_upload  ;
		
	}
	
	public function getErrors($champ){
		if(isset($this->errors[$champ])) return $this->errors[$champ];
		else return false;
	}
	
	public function getValue($champ){
		
		if(!empty($this->user_info[$champ])) return $this->user_info[$champ];
		else return false;
	}
	
	protected function setRequiredTextField($champ, $label, $valeur){
		$valeur = sanitize_text_field($valeur);
		if(empty($valeur)){
			$this->errors[$champ][] = __( $label.' est requis !' );
			return false;
		}else{
			$this->user_info[$champ] = $valeur;
			return true;
		}
	}
	
	protected function setSimpleTextField($champ, $valeur){
		$valeur = sanitize_text_field($valeur);
		$this->user_info[$champ] = $valeur;
		return true;
	}
	
	
}
