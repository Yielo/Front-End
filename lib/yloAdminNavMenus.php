<?php
class yloAdminNavMenus
{
	
	public function register_nav_menus(){
		add_meta_box('ylo-nav-menus', __('Divers Yielo'), array($this, 'nav_menus_display'),'nav-menus', 'side', 'default');
	}
	
	public function nav_menus_display(){
		global $_nav_menu_placeholder, $nav_menu_selected_id;
		// cette fonction n'est pas élégante en ce sens qu'elle ne respecte pas le principe des id unique
		// j'utilise donc les mêmes ids que pour le customLinkdiv en raison du fait que je jquery qui est derriere ne fonctionne qu'avec cet id
		// pour ce que je fais ici. 
		?>
		<div class="customlinkdiv" id="customlinkdiv">
		<input type="hidden" value="custom" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" />
		<p id="menu-item-url-wrap">
			<label class="howto" for="custom-menu-item-url">
				<span><?php _e('URL'); ?></span><br />
				<select style="width:98%;" id="custom-menu-item-url" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-url]" type="text" class="code menu-item-textbox"  >
					<option value="<?php echo home_url('');?>">Accueil - Premi&egrave;re section</option>
					<option value="<?php echo home_url('/#second');?>">Accueil-Deuxi&egrave;me section</option>
					<option value="<?php echo home_url('/#second');?>">Accueil-Troisi&egrave;me section</option>
					<option disabled>---------</option>
					<?php echo $this->get_liens_nouveaux_posts();?>
					<option disabled>---------</option>
					<option value="<?php echo add_query_arg('ylo_deconnexion', 'deconnecter', home_url(''));?>">Lien de d&eacute;connexion</option>
				</select>
			</label>
		</p>

		<p id="menu-item-name-wrap">
			<label class="howto" for="custom-menu-item-name">
				<span><?php _e( 'Link Text' ); ?></span><br />
				<input style="width:98%;" id="custom-menu-item-name" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" type="text" class="regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e('Menu Item'); ?>" />
			</label>
		</p>

		<p class="button-controls">
			<span class="add-to-menu">
				<input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-custom-menu-item" id="submit-customlinkdiv" />
				<span class="spinner"></span>
			</span>
		</p>

	</div><!-- /.customlinkdiv -->
		
	<?php 
	}
	
	protected function get_liens_nouveaux_posts(){
		$args = array(
				'type'                     => 'post',
				'orderby'                  => 'count',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'taxonomy'                 => 'category',
		);
		$categories = get_categories( $args );
		$retour = "";
		$ylo_nouveau = 'ylo_editor=nouveau';
		foreach($categories as $cat){
			echo $link = get_category_link( $cat->cat_ID );
			$url = (strpos($link, '?') === false )? $link.'?'.$ylo_nouveau : $link.'&'.$ylo_nouveau;
			$retour .= '<option value="'.$url.'">'.'Nouvel article: '.$cat->cat_name."</option>\n";
		}
		return $retour;
	}
	
}
