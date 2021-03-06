<?php
class yloFrontpageSettings
{
	public $FrontTextes = array(
								'slogan'	=>	'',
								'redirect_url'	=>	'',
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
	public function redirect_url(){		return $this->getUrl('redirect_url');		}
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

	// les fonctions suivantes servient à récupérer les valeurs directemet, avec un echo au passage mais sans le fix (sans le &nbsp; si vide)
	public function admin_slogan(){			return $this->getTexte('slogan', true, false); }
	public function admin_redirect_url(){	return $this->getUrl('redirect_url', true); }
	public function admin_front2_titre1(){	return $this->getTexte('front2_titre1', true, false); }
	public function admin_front2_texte1(){	return $this->getTexte('front2_texte1', true, false); }
	public function admin_front2_titre2(){	return $this->getTexte('front2_titre2', true, false); }
	public function admin_front2_texte2(){	return $this->getTexte('front2_texte2', true, false); }
	public function admin_front2_titre3(){	return $this->getTexte('front2_titre3', true, false); }
	public function admin_front2_texte3(){	return $this->getTexte('front2_texte3', true, false); }
	public function admin_front3_titre1(){	return $this->getTexte('front3_titre1', true, false); }
	public function admin_front3_texte1(){	return $this->getTexte('front3_texte1', true, false); }
	public function admin_front3_titre2(){	return $this->getTexte('front3_titre2', true, false); }
	public function admin_front3_texte2(){	return $this->getTexte('front3_texte2', true, false); }
	public function admin_front3_titre3(){	return $this->getTexte('front3_titre3', true, false); }
	public function admin_front3_texte3(){	return $this->getTexte('front3_texte3', true, false); }
	public function admin_front3_titre4(){	return $this->getTexte('front3_titre4', true, false); }
	public function admin_front3_texte4(){	return $this->getTexte('front3_texte4', true, false); }
	public function admin_front3_lien(){ 	return $this->getUrl('front3_lien', true); }
	
	public function getTexte($champ, $echo = true, $fix = true){
		if(isset($this->FrontTextes[$champ])) {
			if($echo ) echo esc_html($this->FrontTextes[$champ]);
			if(empty($this->FrontTextes[$champ]) && $fix){ // un petit fix pour résoudre les bugs d'affichage lorsque le contenu est vide
				if($echo) echo '&nbsp;';
				return '&nbsp;';
			}
			return esc_html($this->FrontTextes[$champ]);
		}
		else return false;
	}
	
	public function getUrl($champ, $echo = true){
		if(isset($this->FrontTextes[$champ])) {
			$url = $this->FrontTextes[$champ];
			if($url == '' && $champ == 'redirect_url') $url = get_category_link(get_option('default_category'));
			if($echo ) echo esc_url($url);
			return esc_url($url);
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
