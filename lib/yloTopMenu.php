<?php
class yloTopMenu
{
	protected static $firstInstance = false;
	
	public function __construct(){
		if(self::$firstInstance == false){
			self::$firstInstance = $this;
			$this->setupMenu();
		}
	}
		
	public function setupMenu(){
		register_nav_menus(array(
				'top-menu-visiteur'	=> 	__('Menu principal - Visiteurs non identifi&eacute;s', 'yielo'),
				'top-menu-membre'	=>	__('Menu principal - Membres identifi&eacute;s', 'yielo'),	
			));
		add_filter('ylo_top_menu', array($this, 'selectMenu'));
		add_filter('wp_nav_menu_objects', array( $this, 'first_last_item_classes') );
	}
	
	public function selectMenu(){
		$menu = array(
				'theme_location'	=>	'top-menu-visiteur',
				'container'			=>	false,
				
				/*
				$defaults = array(
						'theme_location'  => '',
						'menu'            => '',
						'container'       => 'div',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => 'menu',
						'menu_id'         => '',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => ''
				);
				*/
			);
		if(is_user_logged_in()){
			$menu['theme_location']	=	'top-menu-membre';
		}
		return $menu;
	}
	
	public function first_last_item_classes($menu){
		// cette méthode sert à rajouter les classes 'first-item' et 'last-item' au premier et dernier élément du menu de base
		$firstSet = false;
		$lastItem = false;
		foreach($menu as $item){
			if(!$firstSet){
				$item->classes[] = 'first-item';
				$firstSet = true;
				$lastItem = $item;
			}
			if($item->menu_item_parent == '0' ) $lastItem = $item;
		}
		$lastItem->classes[] = 'last-item';
		return $menu;
	}
}