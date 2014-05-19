<?php

// cette classe sert à définir le titre de la balise <title> des pages
class yloTitle
{
	static protected $firstInstance = false;
	
	public function __construct(){
		if( self::$firstInstance == false ){
			$this->setAction();
			self::$firstInstance = $this;
		}
	}
	
	public function setAction(){
		add_action('wp_title', array( $this, 'wp_title'), 10, 2);
	}
	
	public function wp_title( $title = '', $sep = '|' ){
		$suffix = ($title == '') ? '' : $sep.' '.$title;
		return "Comunaut&eacute; Yielo " . $suffix;
	}
}