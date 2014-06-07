<?php
yieloCenter::includeClassFile('yloFrontpageSettings');
yieloCenter::includeClassFile('yloPostNMailSettings');

class yloAdminPageOptions
{

	public function setup(){
		$page = add_theme_page( __('Option du th&egrave;me Yielo'), __('Option du th&egrave;me Yielo'), 'manage_options', 'yielo_theme_options', array($this, 'display_de_la_page'));
		add_action( 'admin_print_styles-' . $page, array($this, 'enqueue_admin_style') );
		register_setting( 'yielo_theme_options', 'yielo_front_textes', array($this, 'front_textes_callback'));
		register_setting( 'yielo_theme_options', 'yielo_postnmail', array($this, 'postnmail_callback'));
		register_setting( 'yielo_theme_options', 'yielo_divers', array($this, 'divers_callback'));
		
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
					var pagesId = new Array('ylo-front-page-settings', 'ylo-autre-settings', 'ylo-post2mail-settings');
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
								<li id="ylo-post2mail-settings-tab"><a href="#rroo" onClick="yloActiveTab('ylo-post2mail-settings');">Emails</a></li>
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
							<div class="ylo-admin-box1">
								<h3>Redirection apr&egrave;s login</h3>
								<h4>Page ou Cat&eacute;gorie de redirection :</h4> 
								<?php $this->display_cible_de_redirection($front, true);?>
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
						
						<div id="ylo-post2mail-settings" class="ylo-setting-page ylo-hidden-setting-page">
							<h1 class="ylo-main-titre" >La gestion des Emails</h1>
							<p class="ylo-admin-box1">
								C'est ici qu'on d&eacute;fini comment sont g&eacute;r&eacute;s les envois d'emails
							</p>
							<hr />
							<h2>Configuration de l'envoi des emails lors de la publication d'articles</h2>
							<div class="ylo-admin-box1">
								<ul class="ylo-postnmail-setting">
									<?php echo $this->display_category_email_settings();?>
								</ul>
							</div>
							
						</div><!-- #ylo-post2mail-settings -->
						
						<div id="ylo-autre-settings" class="ylo-setting-page ylo-hidden-setting-page">
							<?php $ylo_divers = get_option('yielo_divers');?>
							<h1 class="ylo-main-titre" >Options diverses</h1>
							<p class="ylo-admin-box1">
								C'est ici qu'on trouve les options qui ne rentrent pas dans une autre cat&eacute;gorie.
							</p>
							<hr />
							<h2>Configuration de la page de Conditions G&eacute;nerales</h2>
						
							<div class="ylo-admin-box1">
								<p>
									<label for="ylo_cg_label"><h4>Phrase du champs "Conditions G&eacute;n&eacute;rales" : </h4></label>
									<input type="text" id="ylo_cg_label" name="yielo_divers[cg_label]" class="ylo-text-field"  placeholder="Label des conditions g&eacute;n&eacute;rales" value="<?php esc_attr_e($ylo_divers['cg_label']);?>" />
								</p>
								<p>
									<label for="ylo_cg_lien"><h4>Intitul&eacute; du lien des "Conditions G&eacute;n&eacute;rales" : </h4></label>
									<input type="text" id="ylo_cg_lien" name="yielo_divers[cg_lien]" class="ylo-text-field"  placeholder="Intitul&eacute; du lien" value="<?php esc_attr_e($ylo_divers['cg_lien']);?>" />
								</p>
								<p>
									<label for="ylo_cg_url"><h4>Page ou Cat&eacute;gorie de redirection :</h4> </label>
									<select name="yielo_divers[cg_url]" id="ylo_cg_url">
										<?php echo $this->display_options_pages(esc_url($ylo_divers['cg_url']));?>
									</select>
								</p>

								
							</div>
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
		$old_url = $front->FrontTextes['front3_lien'];
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
	
	protected function display_category_email_settings(){
		$str = '';
		$settings = new yloPostNMailSettings();
		$cats = get_categories( array(
				'type'                     => 'post',
				'orderby'                  => 'count',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'taxonomy'                 => 'category',		
			) );
		foreach($cats as $cat){
			$cat_ID = $cat->cat_ID;
			$str .= '<li><h3>Cat&eacute;gorie : '.$cat->cat_name.'</h3><fieldset>';
			if(count($settings->errors($cat_ID)) > 0){
				$str .= '<ul class="ylo_errors">';
				foreach($settings->errors($cat_ID) as $err) $str .= '<li>'.$err.'</li>';
				$str .= '</ul>';
			}
			$str .= '<p><input type="checkbox" id="ylo_is_setup_'.$cat_ID.'"  name="yielo_postnmail['.$cat_ID.'][is_setup]" value="on" '.$settings->checked($cat_ID).' />';
			$str .= '<label for="ylo_is_setup_'.$cat_ID.'" class="ylo-checkbox-label">'
						.__('Activer l&#39;envoi par email des nouveaux articles de la cat&eacute;gorie : '.$cat->cat_name)
						.'</label></p>';
			$str .= '<p><label for="ylo_from_name'.$cat_ID.'">Nom du From <em>(Un nom court)</em> : </label>'
						.'<input type="text" id="ylo_from_name'.$cat_ID.'" name="yielo_postnmail['.$cat_ID.'][fromname]" class="ylo-text-field"  placeholder="Nom du champs From du mail " value="'.$settings->fromname($cat_ID).'" maxlength="16" /></p>';
			$str .= '<p><label for="ylo_from_'.$cat_ID.'">From <em>(adresse email valide)</em> : </label>'
						.'<input type="text" id="ylo_from_'.$cat_ID.'" name="yielo_postnmail['.$cat_ID.'][from]" class="ylo-text-field"  placeholder="Champs From du mail envoy&eacute;" value="'.$settings->from($cat_ID).'" /></p>';
			$str .= '<p><label for="ylo_to_'.$cat_ID.'">To <em>(adresse email valide)</em> : </label>'
						.'<input type="text" id="ylo_to_'.$cat_ID.'" name="yielo_postnmail['.$cat_ID.'][to]" class="ylo-text-field" placeholder="Champs To du mail envoy&eacute;" value="'.$settings->to($cat_ID).'" /></p>';
			$str .= '</fieldset></li>';
		}
		return $str;
	}
	
	public function postnmail_callback($yielo_postnmail){
		$sanitized = array();
		foreach($yielo_postnmail as $cat_ID => $values){
			if(isset($values['is_setup']) && $values['is_setup'] == 'on' ){
				$sanitized[$cat_ID]['cat_ID'] = $cat_ID;
				$sanitized[$cat_ID]['errors'] = array();
				if(!empty($values['fromname'])) $sanitized[$cat_ID]['fromname'] = substr($values['fromname'], 0, 16);
				else 	$sanitized[$cat_ID]['fromname'] = substr(get_bloginfo('name'),0, 16);
				if(isset($values['from']) && is_email($values['from']) ){
					$sanitized[$cat_ID]['from'] = $values['from'];
				}
				else {
					$sanitized[$cat_ID]['errors'][] = __('Vous n&#39;avez pas fourni une adresse email &#39;FROM&#39; valide ! ');
					$sanitized[$cat_ID]['from'] = '';
				}
				if(isset($values['to']) && is_email($values['to']) ) $sanitized[$cat_ID]['to'] = $values['to'];
				else {
					$sanitized[$cat_ID]['errors'][] = __('Vous n&#39;avez pas fourni une adresse email &#39;TO&#39; valide ! ');
					$sanitized[$cat_ID]['to'] = '';
				}
				if(count($sanitized[$cat_ID]['errors']) == 0) $sanitized[$cat_ID]['is_setup'] = 'on';
			}
		}
		return $sanitized;
	}
	
	public function front_textes_callback($front_textes){
		$retour = array();
		foreach($front_textes as $key => $value){
			$retour[$key] = esc_textarea(nl2br($value));
		}
		return $retour;
	}
	
	public function divers_callback($front_textes){
		$retour = array();
		foreach($front_textes as $key => $value){
			$retour[$key] = sanitize_text_field($value);
		}
		return $retour;
	}
	
	protected function display_cible_de_redirection($front, $echo = false){
		$initial = $front->FrontTextes['redirect_url'];
		$first_opt = '';
		$cat_opts = '';
		$cat_defaut = get_option('default_category');
		$cats = get_categories( array(
				'type'                     => 'post',
				'orderby'                  => 'count',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'taxonomy'                 => 'category',
		) );
		foreach($cats as $cat){
			$cat_url = get_category_link( $cat->cat_ID );
			if($cat->cat_ID == $cat_defaut){
				$first_opt = '<option value="'.$cat_url.'" '.selected($initial, $cat_url, false)." >Cat&eacute;gorie par d&eacute;faut : ".$cat->cat_name.'</option>';
			}else{
				$cat_opts .= '<option value="'.$cat_url.'" '.selected($initial, $cat_url, false)." >Cat&eacute;gorie : ".$cat->cat_name.'</option>';
			}
		}
		unset($cats);
		$page_opts = $this->display_options_pages($initial);
		$str = '<select name="yielo_front_textes[redirect_url]">';
		$str .= $first_opt;
		$str .= '<option disabled>----------------------------</option>';
		$str .= $cat_opts;
		$str .= '<option disabled>----------------------------</option>';
		$str .= $page_opts;
		$str .= '</select>';
		if($echo) echo $str;
		return $str;		
	}
	
	protected function display_options_pages($initial = ''){
		$page_opts = '';
		$pages = get_pages(array(
				'sort_order' => 'ASC',
				'sort_column' => 'ID',
				'post_type' => 'page',
		));
		foreach($pages as $page){
			$page_url = $page->guid;
			$page_opts .=	'<option value="'.$page_url.'" '.selected($initial, $page_url, false)." >Page : ".$page->post_title.'</option>';
		}
		return $page_opts;
	}
}









































