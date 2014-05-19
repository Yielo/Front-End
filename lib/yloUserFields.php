<?php
class yloUserFields
{
	protected static $yloChamps = array(
			'ylo_eglise' => 'Ton &eacute;glise',
			'ylo_ville' => 'Ville de r&eacute;sidence',
			'ylo_pays' => 'Pays de r&eacute;sidence',
			'ylo_competences' => 'Tes domaines de comp&eacute;tences',
			'ylo_formation' => 'Ta formation',
			'ylo_experiences_pro' => 'Tes exp&eacute;riences professionnelles',
			'ylo_temoignage'	=> 'Ton t&eacute;moignage',
			'ylo_avatar_upload' => 'Ton avatar',
		);
	
	protected static $champsNatifs = array(
			'user_login'    =>  'Ton Login',
			'user_email'	=>	'Ton Email',
			// 'user_pass'		=>	'', le mot de passe ne doit être utilisié qu'intentionnellement, d'ou l'intérêt de le supprimer de cette liste
			'first_name'	=>	'Ton Pr&eacute;nom',
			'last_name'		=>	'Ton nom',
			'nickname'		=>	'Ton pseudo',
		);
	
	public static function fieldList(){
		$liste = array_merge( self::$yloChamps, self::$champsNatifs);
		$champs = array();
		foreach($liste as $champ => $label ){
			$champs[] = $champ;
		}
		return $champs;
	}
	
	public function editList($champs){
		// ici on rajoute les champs qu'on veut
		foreach(self::$yloChamps as $label => $valeur){
			$champs[$label] = $valeur;
		}
		return $champs;
	}
	
	public function is_yielo_champ($champ){
		if(isset(self::$yloChamps[$champ])) return true;
		else return false;
	}
	
	
	
}