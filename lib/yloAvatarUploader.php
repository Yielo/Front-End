<?php

class yloAvatarUploader
{
	
	protected $errors = array();
	
	protected static $targetDir = 'wp-content/uploads/yielo_avatars'; // attention sans "/" final !!!
	protected $maxUploadFileSize = 10000000; // taille en octets
	
	protected $finalPath = ''; // le chemin complet de l'image après capture
	protected $filename = ''; // nom du fichier final
	
	protected $maxHeight	= '190';
	protected $maxWidth		= '190';
	protected $crop			= true;
	
	public static function is_upload($file){
		if(isset($_FILES[$file])) return !empty($_FILES[$file]['name']);
		else return false;
	}
	
	public static function check_url($url){
		$base = home_url().'/'.self::$targetDir.'/';
		if(substr($url, 0, strlen($base)) == $base ){
			$url = str_replace($base, '', $url);
			if(file_exists(ABSPATH.self::$targetDir.'/'.$url)){
				return true;
			}else return false;
		}else return false;
	}
	
	public function __construct($inputFileName){
		if(! $this->captureUpload($inputFileName)){ // si la capture n'a pas marché on reset les champs
			$this->resetValues();
		}
	}
	
	public function is_valid(){
		if(empty($this->filename))  return false;
		elseif(! file_exists( $this->finalPath)) return false;
		elseif(count($this->errors) > 0)  return false;
		else return true;
	}
	
	public function the_url(){
		if($this->is_valid()) return home_url().'/'.self::$targetDir.'/'.$this->filename;
		else return false;
	}
	
	public function the_errors(){
		return $this->errors;
	}
	
	
	protected function captureUpload($file){
		// $file est le nom dans name="xxx" du champs du formulaire qui envoie l'image
		// renvoie true si réssit et false s'il y a une erreur
		if(isset($_FILES[$file])){
			$path = ABSPATH . self::$targetDir;
			if(!is_file($path) && !is_dir($path)){ // on va tenter de crer le répertoire
				if(!@mkdir($path, 0755, true)) { // impossible de créer, on renvoie une erreur
					$this->errors[] = __('Impossible de cr&eacute;er le r&eacute;pertoire '. $this->targetDir );
					return false;
				}else{ // le répertoire vient dêtre créer, on lui rajoute un index.php par sécuite
					touch($path.'/index.html');
				}
			}elseif(is_file($path)  && !is_dir($path)){
				$this->errors[] = __(self::$targetDir.' n&#39;est pas un r&eacute;pertoire, aucun fichier ne peut &ecirc;tre uploader dedans');
				return false;
			}elseif( is_dir($path) && !is_writable($path)){
				$this->errors[] = __( 'Le serveur n&#39;a pas les droits n&eacute;cessaires pour &eacute;crire dans le r&eacute;pertoire '.self::$targetDir);
				return false;
			}
			
			// arrivé ici c'est que le fichier existe bien
			if(((integer) $_FILES[$file]['size']) > $this->maxUploadFileSize ){
				$taille = (intval($this->maxUploadFileSize))." octets";
				if(intval( $this->maxUploadFileSize > 1024)) $taille = intval( intval( $this->maxUploadFileSize) / 1024)."Ko";
				if(intval( $this->maxUploadFileSize > (1024*1024))) $taille = intval( intval( $this->maxUploadFileSize) / (1024*1024))."Mo";
				$this->errors[] = __('Votre fichier est trop gros pour être charg&eacute;, veuillez choisir un fichier qui fait moins de '.$taille.'.');
				return false;
			}
			
			$formats_autorises = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif',);
			$ext_autorises	= array( 'jpg', 'jpeg', 'png', 'gif');
			$extension = strtolower(array_pop(explode('.', $_FILES[$file]['name'])));
			if(!in_array($_FILES[$file]['type'], $formats_autorises) || !in_array($extension, $ext_autorises)){
				$this->errors[] = __('Le format du fichier uploader n&#39;est pas autoris&eacute;, seuls sont autoris&eacute;s les formats .jpg, .png et .gif');
				return false; 
			}
			$this->filename = 'avatar'.time().md5(mt_rand(1, 9999999).$_FILES[$file]['tmp_name'].time().$FILE[$file]['size']).'.'.$extension; // un nom au hasard, on omet de verifier les doubons
			$this->finalPath =  ABSPATH.self::$targetDir.'/'.$this->filename;

			if(!copy($_FILES[$file]['tmp_name'], $this->finalPath)){
				$this->errors[] = __('Impossible de copier votre image, veuillez alter l&#39;administrateur du site.');
				return false;
			}
			if(is_wp_error($image = wp_get_image_editor( $this->finalPath ))){
				$this->errors[] = __('Votre image est un fichier corrompu, veuillez choisir un autre fichier' );
				return false;
			}else{
				$image->resize(  $this->maxWidth,$this->maxHeight, $this->crop );
			    $image_data = $image->save(  $this->finalPath );
			    unset($image);
			}
			return true;	
		}else{
			$this->errors[] = __('Auncun fichier joint !');
			return false;
		}
	}
	
	protected function resetValues(){
		if(file_exists($this->finalPath)) unlink($this->finalPath);
		$this->filename = '';
		$this->finalPath = '';
	}
}