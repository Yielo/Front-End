<?php
yieloCenter::includeClassFile('yloPagesPrivee');

class yloAdminPagesPrivee extends yloPagesPrivee
{
	
	
	public function adminInitHook(){
		add_action('add_meta_boxes', array($this, 'addingMetaBoxes'));
		add_action('save_post', array($this, 'saveVipOption'));
		
	}
	
	public function addingMetaBoxes(){
		$post_types = array('post', 'page');
		foreach($post_types as $post_type){
			add_meta_box(
					'ylo-is-vip-metabox',
					__('Option VIP'),
					array($this, 'vipMetaBox'),
					$post_type,
					'side',
					'high'
				);
		}
	}
	
	public function vipMetaBox($post){
		$check = get_post_meta($post->ID, '_ylo_statut_vip', true);
		if(!check || !in_array($check, array('public', 'vip'))) $check = 'vip';
		wp_nonce_field('ylo-is-vip-meta-nonce', 'ylo_is_vip_nonce');
		echo '<fieldset><legend>Securiser cette page/ce post :</legend>';
		echo '<input type="checkbox" name="ylo_option_vip" id="ylo_option_vip" '.checked($check, 'vip', false).' value="page_vip" /><label for="ylo_option_vip"><em>';
		echo __('Cochez cette case pour que cette page/ce post ne soit visible que pour les membre, ( d&eacute;cochez la case pour que la page soit publique )');
		echo '</em></label></fieldset>';
	}
	
	public function saveVipOption($post_id){

		if(empty($_POST['ylo_is_vip_nonce']) || !wp_verify_nonce($_POST['ylo_is_vip_nonce'], 'ylo-is-vip-meta-nonce')){
			return;
		}elseif(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
			return;
		}else{
			if('page_vip' == sanitize_text_field($_POST['ylo_option_vip'])) {
				$vip_option = 'vip';
			}else{
				$vip_option = 'public' ;
			}
			update_post_meta($post_id, '_ylo_statut_vip', $vip_option );
		}
		
	}
}