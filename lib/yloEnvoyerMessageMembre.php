<?php
class yloEnvoyerMessageMembre
{
	protected $fieldName = 'ylo-envoi-message-membre';
	protected $is_enovoi = false;
	protected $erreurs = array();
	protected $message = 'test';
	
	public function filterHook($initial){
		if(isset($_POST[$this->fieldName])){
			$this->is_enovoi = true;
			$this->message = sanitize_text_field($_POST[$this->fieldName]);
			if(empty($this->message)) $this->erreurs[] = __('Votre message est vide, il n&#39; donc pas pu &ecirc;tre envoy&eacute; ');
			else	$this->envoyer_le_message();
		}
		return $this;
	}
	
	public function is_envoi_reussi(){
		return ($this->is_enovoi && (count($this->erreurs) == 0));
	}
	
	public function le_message(){
		echo $this->message;
	}
	
	protected function envoyer_le_message(){
		
		$headers = array('From: Me Myself <me@example.net>');
	}
	
}