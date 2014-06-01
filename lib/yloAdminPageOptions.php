<?php
yieloCenter::includeClassFile('yloFrontpageSettings');

class yloAdminPageOptions
{

	public function setup(){
		$page = add_theme_page( __('Option du th&egrave;me Yielo'), __('Option du th&egrave;me Yielo'), 'manage_options', 'yielo_theme_options', array($this, 'display_de_la_page'));
		add_action( 'admin_print_styles-' . $page, array($this, 'enqueue_admin_style') );
		register_setting( 'yielo_theme_options', 'yielo_front_textes');
	}
	
	public function enqueue_admin_style(){
		wp_enqueue_style( 'ylo_admin_theme_option_style',  get_stylesheet_directory_uri().'/style_admin.css' );
		wp_enqueue_style('gle_import_fonts', 'http://fonts.googleapis.com/css?family=Audiowide');
	}
	
	public function display_de_la_page(){
		
		$front = new yloFrontpageSettings();
		?>
			<script type="text/javascript">
				function yloActiveTab(tabId){
					var pagesId = new Array('ylo-front-page-settings', 'ylo-autre-settings');
					for( var id in pagesId){
						var item = document.getElementById(pagesId[id]);
						var itemLi = document.getElementById(pagesId[id]+'-tab');
						if(tabId == pagesId[id]){
							item.style.display = 'block';
							itemLi.className = 'current';
						}else{
							item.style.display = 'none';
							itemLi.className = '';
						}
					}			
				}
			</script>
			<div class="wrap">
				<form method="post" id="yielo_theme_options" action="options.php">
					<?php settings_fields('yielo_theme_options');?>
					<input type="submit" value="Mettre &agrave; jour" class="button button-primary" />
					<div id="ylo-theme-settings-wrapper">
						<h1 class="ylo-main-titre">Page d'options du th&egrave;me Yielo</h1>
						<nav class="ylo-onglets-settings">
							<ul>
								<li id="ylo-front-page-settings-tab" class="current"><a href="#" onClick="yloActiveTab('ylo-front-page-settings');">Front Page</a></li>
								<li id="ylo-autre-settings-tab"><a href="#" onClick="yloActiveTab('ylo-autre-settings');">Autre</a></li>
							</ul>
						</nav>
						<div id="ylo-front-page-settings" class="ylo-setting-page">
							<h1 class="ylo-main-titre" >Les Textes de la Front-Page</h1>
							<p class="ylo-admin-box1">
								C'est ici qu'on d&eacute;fini les textes de la Font Page.
							</p>
							<hr />
							<h2>Premi&egrave;re section :</h2>
							<div class="ylo-admin-box1">
								<h3>Slogan : </h3>
								<textarea name="yielo_front_textes[slogan]" ><?php $front->admin_slogan(); ?></textarea>
							</div>
							
							<hr />
							<h2>Deuxi&egrave;me section <em>(Pr&eacute;sentation)</em> :</h2>
							<div class="ylo-admin-box1 ylo-admin-bi-colones">
								<h3>Premier Paragraphe</h3>
								<h4>Titre :</h4> 
								<input type="text" name="yielo_front_textes[front2_titre1]" value="<?php $front->admin_front2_titre1(); ?>" />
								<h4>Texte :</h4> 
								<textarea name="yielo_front_textes[front2_texte1]" ><?php $front->admin_front2_texte1(); ?></textarea>
							</div>
							<div class="ylo-admin-box1 ylo-admin-bi-colones">
								<h3>Deuxi&egrave;me Paragraphe</h3>
								<h4>Titre :</h4> 
								<input type="text" name="yielo_front_textes[front2_titre2]" value="<?php $front->admin_front2_titre2(); ?>" />
								<h4>Texte :</h4> 
								<textarea name="yielo_front_textes[front2_texte2]" ><?php $front->admin_front2_texte2(); ?></textarea>							
							</div>
							<div class="ylo-admin-box1 ylo-admin-bi-colones">
								<h3>Troisi&egrave;me Paragraphe</h3>
								<h4>Titre :</h4> 
								<input type="text" name="yielo_front_textes[front2_titre3]" value="<?php $front->admin_front2_titre3(); ?>" />
								<h4>Texte :</h4> 
								<textarea name="yielo_front_textes[front2_texte3]" ><?php $front->admin_front2_texte3(); ?></textarea>								
							</div>
							<hr />
							<h2>Troisi&egrave;me section : <em>(Yielo)</em> </h2>
							<div class="ylo-admin-box1 ylo-admin-bi-colones">
								<h3>Premier Paragraphe</h3>
								<h4>Titre :</h4> 
								<input type="text" name="yielo_front_textes[front3_titre1]" value="<?php $front->admin_front3_titre1(); ?>" />
								<h4>Texte :</h4> 
								<textarea name="yielo_front_textes[front3_texte1]" ><?php $front->admin_front3_texte1(); ?></textarea>
							</div>
							<div class="ylo-admin-box1 ylo-admin-bi-colones">
								<h3>Deuxi&egrave;me Paragraphe</h3>
								<h4>Titre :</h4> 
								<input type="text" name="yielo_front_textes[front3_titre2]" value="<?php $front->admin_front3_titre2(); ?>" />
								<h4>Texte :</h4> 
								<textarea name="yielo_front_textes[front3_texte2]" ><?php $front->admin_front3_texte2(); ?></textarea>							
							</div>
							<div class="ylo-admin-box1 ylo-admin-bi-colones">
								<h3>Troisi&egrave;me Paragraphe</h3>
								<h4>Titre :</h4> 
								<input type="text" name="yielo_front_textes[front3_titre3]" value="<?php $front->admin_front3_titre3(); ?>" />
								<h4>Texte :</h4> 
								<textarea name="yielo_front_textes[front3_texte3]" ><?php $front->admin_front3_texte3(); ?></textarea>								
							</div>
							<div class="ylo-admin-box1 ylo-admin-bi-colones">
								<h3>Quatri&egrave;me Paragraphe</h3>
								<h4>Titre :</h4> 
								<input type="text" name="yielo_front_textes[front3_titre4]" value="<?php $front->admin_front3_titre4(); ?>" />
								<h4>Texte :</h4> 
								<textarea name="yielo_front_textes[front3_texte4]" ><?php $front->admin_front3_texte4(); ?></textarea>								
							</div>
							<div class="ylo-admin-box1">
								<h3>Le lien final <em>(S'inscrire)</em></h3>
								<h4>Lien :</h4> 
								<?php $this->display_page_select($front);?>
							</div>
							
							
						</div><!-- #ylo-front-page-settings -->
						<div id="ylo-autre-settings" class="ylo-setting-page ylo-hidden-setting-page">
							Autre
						</div>
							&nbsp;&nbsp; NB : N'oublies pas de cliquer sur "mettre &agrave; jour" 
					</div>
					<input type="submit" value="Mettre &agrave; jour" class="button button-primary" />
				</form>
			
			</div>
			
		<?php 
	}
	
	
	// les deux méthodes suivantes servent à définir la liste des pages disponbles pour le lien final de la front page
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
	
	
	// $front est une instance de la classe yloFrontpageSettings
	protected function display_page_select($front, $echo = true){
		$pages = $this->get_les_pages();
		$old_url = $front->admin_FrontTextes['front3_lien'];
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
