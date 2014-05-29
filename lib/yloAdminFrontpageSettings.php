<?php
yieloCenter::includeClassFile('yloFrontpageSettings');

class yloAdminFrontpageSettings extends yloFrontpageSettings
{

	public function init(){

		// cette méthode est l'endroit où placer les crochets relatif à l'objet

		add_action( 'admin_menu', array($this, 'addSettingPage'));
		
	}

	
	public function addSettingPage(){
		add_theme_page( __('Textes de la Front Page'), __('Textes de la Front Page'), 'manage_options', 'yielo_front_textes', array($this, 'settingPageContent'));
		register_setting( 'yielo_front_textes', 'yielo_front_textes');
	}
	
	public function settingPageContent(){
		?>
		<div class="wrap">
			<form method="post" id="yielo_front_textes" action="options.php">
				<?php 
				settings_fields('yielo_front_textes');
				//$options = get_option( 'yielo_front_textes' );
				?>
				<h2><?php _e('Textes de la Front Page'); ?></h2>
				<input type="submit" value="<?php echo esc_attr_e('Update Options'); ?>" class="button-primary" />
				<hr>
				<h3>Page d'Accueil</h3>
				slogan : 
				<textarea name="yielo_front_textes[slogan]" ><?php $this->slogan(); ?></textarea>
				
				<hr>
				<h3>Seconde section : Pr&eacute;sentation</h3>

				<h4>Premier Paragraphe</h4>
				titre : 
				<input type="text" name="yielo_front_textes[front2_titre1]" value="<?php $this->front2_titre1(); ?>" /><br />
				texte : 
				<textarea name="yielo_front_textes[front2_texte1]" ><?php $this->front2_titre1(); ?></textarea>
				
				<h4>Deuxi&egrave;me Paragraphe</h4>
				titre : 
				<input type="text" name="yielo_front_textes[front2_titre2]" value="<?php $this->front2_titre2(); ?>" /><br />
				texte : 
				<textarea name="yielo_front_textes[front2_texte2]" ><?php $this->front2_titre2(); ?></textarea>
				
				<h4>Troisi&egrave;me Paragraphe</h4>
				titre : 
				<input type="text" name="yielo_front_textes[front2_titre3]" value="<?php $this->front2_titre3(); ?>" /><br />
				texte : 
				<textarea name="yielo_front_textes[front2_texte3]" ><?php $this->front2_texte3(); ?></textarea>
				
				<hr>
				<h3>Troisi&egrave;me section : Yielo </h3>

				<h4>Premier Paragraphe</h4>
				titre : 
				<input type="text" name="yielo_front_textes[front3_titre1]" value="<?php $this->front3_titre1(); ?>" /><br />
				texte : 
				<textarea name="yielo_front_textes[front3_texte1]" ><?php $this->front3_texte1(); ?></textarea>
				
				<h4>Deuxi&egrave;me Paragraphe</h4>
				titre : 
				<input type="text" name="yielo_front_textes[front3_titre2]" value="<?php $this->front3_titre2(); ?>" /><br />
				texte : 
				<textarea name="yielo_front_textes[front3_texte2]" ><?php $this->front3_texte2(); ?></textarea>
				
				<h4>Troisi&egrave;me Paragraphe</h4>
				titre : 
				<input type="text" name="yielo_front_textes[front3_titre3]" value="<?php $this->front3_titre3(); ?>" /><br />
				texte : 
				<textarea name="yielo_front_textes[front3_texte3]" ><?php $this->front3_texte3(); ?></textarea>
				
				<h4>Quatri&egrave;me Paragraphe</h4>
				titre : 
				<input type="text" name="yielo_front_textes[front3_titre4]" value="<?php $this->front3_titre4(); ?>" /><br />
				texte : 
				<textarea name="yielo_front_textes[front3_texte4]" ><?php $this->front3_texte4(); ?></textarea>
				
				<h3>Le lien final</h3>
				Lien : 
				<?php $this->display_page_select(true);?>
				<br />
				
				<hr>
				<input type="submit" value="<?php echo esc_attr_e('Update Options'); ?>" class="button-primary" />
				
			</form>
		</div>
			<?php 		
	}
	
	protected function get_les_pages(){
		// renvoie la liste des pages existates en séparant les pages d'inscription des autres pages
		$pages_d_inscription = array();
		$autres_pages_publiee = array();
		$autres_pages_non_publiee = array();
		$id_url = array();
		$args = array(
				'sort_order' => 'ASC',
				'sort_column' => 'ID',
				'post_type' => 'page',
				'meta_key'     => '_wp_page_template',
		);
		$pages = get_pages($args);
		foreach($pages as $page){
			$item = new stdClass();
			$item->ID 	= $page->ID;
			$item->post_title 	= $page->post_title;
			$item->post_name	=	$page->post_name;
			$item->post_status	=	$page->post_status;
			$item->guid			=	$page->guid;
			$item->template		=	$page->meta_value;
			$id_url[$page->ID]	=	$page->guid;
			if($item->template == 'page-inscription.php' && $item->post_status = 'publish'){
				$pages_d_inscription[] = $item;
			}elseif($item->template == 'page-inscription.php' && !($item->post_status = 'publish')){
				array_unshift($autres_pages_non_publiee, $item);
			}elseif($item->post_status = 'publish'){
				$autres_pages_publiee[] = $item;
			}else{
				$autres_pages_non_publiee[] = $item;
			}
		}
		$retour = new stdClass();
		$retour->inscription = $pages_d_inscription;
		$retour->autre	= $autres_pages_publiee;
		$retour->non_publiee = $autres_pages_non_publiee;
		$retour->liste = $id_url;
		return $retour;
	}
	
	protected function display_page_select($echo = true){
		$pages = $this->get_les_pages();
		$old_url = $this->FrontTextes['front3_lien'];
		$str = '<select name="yielo_front_textes[front3_lien]">';
		foreach($pages->inscription as $page)
			$str .= '<option value="'.esc_attr($page->guid).'" '.selected($old_url, $page->guid, false).'>'.esc_attr($page->post_title).' (page d&#39;inscription)</option>';
		$str .= '<option disabled>--------------</option>';
		foreach($pages->autre as $page)
			$str .= '<option value="'.esc_attr($page->guid).'" '.selected($old_url, $page->guid, false).'>'.esc_attr($page->post_title).' (autre page)</option>';
		$str .= '<option disabled>--------------</option>';
		foreach($pages->non_publiee as $page)
			$str .= '<option value="'.esc_attr($page->guid).'" disabled>'.esc_attr($page->post_title).' (non publi&eacute;e)</option>';
		$str .= '</select>';
		if($echo) echo $str;
		return $str;
	}
}
