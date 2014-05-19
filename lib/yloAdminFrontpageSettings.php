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
				<input type="text" name="yielo_front_textes[front3_lien]" value="<?php $this->front3_lien(); ?>" /><br />
				
				<hr>
				<input type="submit" value="<?php echo esc_attr_e('Update Options'); ?>" class="button-primary" />
				
			</form>
		</div>
			<?php 		
	}
	

}