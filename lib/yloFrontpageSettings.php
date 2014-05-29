<?php
class yloFrontpageSettings
{
	protected $FrontTextes = array(
								'slogan'	=>	'',
								'front2_titre1'	=>	'',
								'front2_texte1'	=>	'',
								'front2_titre2'	=>	'',
								'front2_texte2'	=>	'',
								'front2_titre3'	=>	'',
								'front2_texte3'	=>	'',
								'front3_titre1'	=>	'',
								'front3_texte1'	=>	'',
								'front3_titre2'	=>	'',
								'front3_texte2'	=>	'',
								'front3_titre3'	=>	'',
								'front3_texte3'	=>	'',
								'front3_titre4'	=>	'',
								'front3_texte4'	=>	'',
								'front3_lien'	=>	'',
							);
	
	public function __construct(){
		$this->setupFrontTextes();
	}

	// les fonctions suivantes servient à récupérer les valeurs directemet, avec un echo au passage
	public function slogan(){			return $this->getTexte('slogan'); 	}
	public function front2_titre1(){	return $this->getTexte('front2_titre1');	}
	public function front2_texte1(){	return $this->getTexte('front2_texte1');	}	
	public function front2_titre2(){	return $this->getTexte('front2_titre2');	}
	public function front2_texte2(){	return $this->getTexte('front2_texte2');	}
	public function front2_titre3(){	return $this->getTexte('front2_titre3');	}
	public function front2_texte3(){	return $this->getTexte('front2_texte3');	}
	public function front3_titre1(){	return $this->getTexte('front3_titre1');	}
	public function front3_texte1(){	return $this->getTexte('front3_texte1');	}
	public function front3_titre2(){	return $this->getTexte('front3_titre2');	}
	public function front3_texte2(){	return $this->getTexte('front3_texte2');	}
	public function front3_titre3(){	return $this->getTexte('front3_titre3');	}
	public function front3_texte3(){	return $this->getTexte('front3_texte3');	}
	public function front3_titre4(){	return $this->getTexte('front3_titre4');	}
	public function front3_texte4(){	return $this->getTexte('front3_texte4');	}
	public function front3_lien(){		return $this->getUrl('front3_lien');	}
	
	
	public function getTexte($champ, $echo = true){
		if(isset($this->FrontTextes[$champ])) {
			if($echo ) echo esc_html($this->FrontTextes[$champ]);
			if(empty($this->FrontTextes[$champ])){ // un petit fix pour résoudre les bugs d'affichage lorsque le contenu est vide
				if($echo) echo '&nbsp;';
				return '&nbsp;';
			}
			return esc_html($this->FrontTextes[$champ]);
		}
		else return false;
	}
	
	public function getUrl($champ, $echo = true){
		if(isset($this->FrontTextes[$champ])) {
			if($echo ) echo esc_url($this->FrontTextes[$champ]);
			return esc_url($this->FrontTextes[$champ]);
		}
		else return false;
	}
	
	protected function setupFrontTextes(){
		$front_textes = get_option( 'yielo_front_textes' );
		foreach($this->FrontTextes as $key => $value){
			if(isset($front_textes[$key])) $this->FrontTextes[$key] = $front_textes[$key];
		}
	}
}
