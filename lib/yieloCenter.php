<?php
// la classe yielo center sert à manager le code du thème

class yieloCenter
{
	protected static $firstInstance = false;
	
	protected $hooks = array();
	
	public static function getInstance(){
		// permet un comportement de singleton
		if(self::$firstInstance) return self::$firstInstance;
		else return new yieloCenter();
	}
	
	public static function includeClassFile($class){
		$libDir = get_template_directory().'/lib/';
		if(file_exists($libDir.$class.'.php')) {
			include_once($libDir.$class.'.php');
			return true;
		}
		else return false;		
	}
	public function __construct(){
		if(! self::$firstInstance) self::$firstInstance = $this;
	}

	
	public function __call($nom, $args){
		// le principe ici c'est que j'utilise yieloCenter pour includer les fichiers contenant les classes ylo
		// j'aurais pu utiliser un spl_autoload_register à la place mais bon j'ai fais sans ce qui apporte cette
		// petite complication
		if(isset($this->hooks[$nom])){
			$hook = $this->hooks[$nom];
			$objet = $this->make( $hook['objet'] );
			$methode = $hook['methode'];
			if ( $objet && $methode ){				
				return call_user_func_array(array($objet, $methode), $args);
			}else if ( $objet && !$methode){ // $methode == false signifie qu'il faut retourner une instance de l'objet
				return $objet;
			}else{
				return false;
			}
		}
	}
	
	public function make($class){
		$sucess = self::includeClassFile($class);
		if($sucess) return new $class();
		else return false;
	}
	
	
	public function add_action($hook, $objet, $methode = false, $priority = 10, $accepted_args = 1 ){
		$callback = 'yloAction_'.$hook.'_'.$objet.'_'.$methode;
		$this->hooks[$callback] = array(
				'objet'	=>	$objet,
				'methode'	=>	$methode,
			);
		add_action($hook, array($this, $callback), $priority, $accepted_args);
	}
	
	public function add_filter($hook, $objet, $methode = false, $priority = 10, $accepted_args = 1 ){
		$callback = 'yloFilter_'.$objet.'_'.$methode;
		$this->hooks[$callback] = array(
				'objet'	=>	$objet,
				'methode'	=>	$methode,
		);
		add_filter($hook, array($this, $callback), $priority, $accepted_args);
	}
	

	
}
