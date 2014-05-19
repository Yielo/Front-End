<?php
yieloCenter::includeClassFile('yloUserFields');

class yloFicheMembre 
{
	protected $membre = false;
	protected $user_fields = array();
	protected $champ_message = 'ylo-envoi-message-membre';
	protected $is_envoi = false;
	protected $erreurs_envoi = array();
	protected $message = 'test';
	protected $sujet = '[yielo message personnel] vous avez recu un message via le site yielo';
	
	public function __construct(){
		global $author;
		$this->membre = get_userdata(intval($author));
		$this->user_fields = yloUserFields::fieldList();
	}
	
	public function __get($name){
		if($this->membre && in_array($name, $this->user_fields)){
			return $this->membre->$name;
		}else return '';
	}
	
	public function __call($name, $args){
		echo $this->__get($name);
	}
	
	public function instance(){
		if(isset($_POST[$this->champ_message])){
			$this->is_envoi = true;
			$this->message = sanitize_text_field($_POST[$this->champ_message]);
			if(empty($this->message)) $this->erreurs_envoi[] = __('Votre message est vide, il n&#39;a donc pas pu &ecirc;tre envoy&eacute; ');
			elseif($this->check_nonce()) $this->envoyer_le_message();
		}
		return $this;
	}
	
	public function get_avatar(){
		$id = intval($this->membre->ID);
		if($id > 0 ){
			echo get_avatar($id, 190);
		}
	}
	
	public function is_envoi_reussi(){
		return ($this->is_envoi && (count($this->erreurs_envoi) == 0));
	}
	
	public function le_message(){
		echo $this->message;
	}
	
	public function erreurs_envoi(){
		return $this->erreurs_envoi;
	}
	
	protected function check_nonce(){
		if(empty($_POST['ylo_envoi_message_nonce'])){
			$this->erreurs_envoi[] = __('Votre message est du spam ! Nous n&#39;acceptions pas le spam !');
			return false;
		}elseif(!wp_verify_nonce($_POST['ylo_envoi_message_nonce'], 'ylo-envoi-message-membre')){
			$this->erreurs_envoi[] = __('Votre session &agrave; expir&eacute; !');
			return false;
		}else{
			return true;
		}
	}
	
	protected function envoyer_le_message(){
		$to_prenom = $this->first_name;
		$to_nom = $this->last_name;
		$to_email = $this->user_email;
		$to = $to_prenom.' '.$to_nom. ' <'.$to_email.'>' ;
		$sender = get_userdata(intval(get_current_user_id())) ;
		$from_prenom = $sender->first_name;
		$from_nom = $sender->last_name;
		$from_email = $sender->user_email;
		$headers[] = 'From: '.$from_prenom.' '.$from_nom.' <'.$from_email.'>';
		if(wp_mail($to, $this->sujet, $this->message, $headers)){
			return true;
		}else{
			$this->erreurs_envoi[] = __('L&#39;envoi a &eacute;chou&eacute; &agrave; cause d&#39;une erreur interne, veuiller informer l&#39;administrateur du site.');
			return false;
		}
	}
	
}