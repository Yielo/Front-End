<?php
class yloSidebars
{
	static protected $firstInstance = false;
	
	public function __construct(){
		if(self::$firstInstance == false ){
			self::$firstInstance = $this;
			$this->set_actions();
		}
	}
	
	public function set_actions(){
		add_action('widgets_init', array($this, 'registers'));
		add_action('ylo_default_sidebar', array( $this, 'ylo_default_sidebar'));
		
	}
	
	public function registers(){
		register_sidebar( array(
				'name'          => __( 'Sidebar par d&eacute;faut;' ),
				'id'            => 'ylo-default-sidebar',
				'description'   => __('La sidebar par d&eacute;faut'),
			    'class'         => '',
				'before_widget' => '<li id="%1$s" class="ylo-sidebar-item %2$s">',
				'after_widget'  => '</li>',
				'before_title'  => '<h2 class="widgettitle">',
				'after_title'   => '<span> :</span></h2>',
		) );
	}
	
	public function ylo_default_sidebar(){
		echo '<ul class="ylo-sidebar">';
		dynamic_sidebar('ylo-default-sidebar');
		echo '</ul>';
	}
	
}