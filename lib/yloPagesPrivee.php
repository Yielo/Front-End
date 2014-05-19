<?php
class yloPagesPrivee
{
	
	
	public function check(){
		global $post;
		if( is_home() || is_front_page() ){
			return;
		}elseif('public' == get_post_meta($post->ID, '_ylo_statut_vip', true)){
			return;
		}elseif(is_user_logged_in()){
			return;
		}else{
			get_template_part('template_parts/acces', 'restreint');
			get_footer();
			die();
		}
	}
}