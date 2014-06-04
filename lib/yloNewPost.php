<?php
class yloNewPost
{

	protected $erreurs = array();
	
	public function lien_nouvel_article($url = ''){
		$request = $url ? $url : $_SERVER['REQUEST_URI'] ;
		if(strpos( $request, '?') === false ) return $request.'?ylo_editor=nouveau';
		else return $request.'&ylo_editor=nouveau';
	}
	
	public function lien_editer_supprimer(){
		global $post;
		$edit_tag = 'ylo_editor=edit';
		$delete_tag = 'ylo_delete=current_post';
		$str = '';
		$user_ID = get_current_user_id();
		if($post->post_author == $user_ID || current_user_can('edit_others_posts')){
			if(current_user_can('edit_posts') || current_user_can('edit_others_posts')){
				$url = $_SERVER['REQUEST_URI'];
				$url = (strpos( $url, '?') === FALSE) ? $url . '?'.$edit_tag : $url . '&'.$edit_tag;
				$str .= '<span class="ylo-link-edit-post">
						<a href="'.$url.'" >&Eacute;diter</a>
					</span>';
			}
			if(current_user_can('delete_posts')|| current_user_can('delete_others_posts')){
				$url = $_SERVER['REQUEST_URI'];
				$url = (strpos( $url, '?') === FALSE) ? $url . '?'.$delete_tag : $url . '&'.$delete_tag;
				$str .= '<span class="ylo-link-delete-post">
						<a href="'.$url.'" >Supprimer</a>
					</span>';
			}
			
		}
		echo $str;
	}
	
	public function nouveau($category = false){
		if(current_user_can('publish_posts')){
			$posted = $this->process_form($category);
			if($posted){
				$post = get_post($posted);
				?><p>Votre article a bien &eacute;t&eacute; publi&eacute;</p>
				<p><a href="<?php echo $post->guid;?>">Cliquer ici pour acc&eacute;der &agrave; l'article</a></p>
				<?php 
			}else{
				echo '<h2 class="ylo-titre-editor ylo-post-article"><span>Nouvel article :</span></h2>';
				$this->editor( '', '', 'ylo_new_post_nonce');
			}			
		}
	}
	
	public function edit_post(){
		global $post;
		if((current_user_can('edit_posts') && $post->post_author == get_current_user_id())
				|| current_user_can('edit_others_posts')){
			$edited = $this->process_edit_form($post->ID);
			if($edited){
				?><p>Votre article a bien &eacute;t&eacute; mis &agrave; jour.</p>
					<p><a href="<?php echo $post->guid;?>">Cliquer ici pour acc&eacute;der &agrave; l'article</a></p>
				<?php 			
			}else{
				echo '<h2 class="ylo-titre-editor ylo-post-article"><span>Editer l&#39;article :</span></h2>';
				$this->editor( $post->post_title, $post->post_content, 'ylo_edit_post_nonce'); 			
			}
		}
	}
	
	public function delete_post(){
		global $post;
		if((current_user_can('delete_posts') && $post->post_author == get_current_user_id())
				|| current_user_can('delete_others_posts')){
			$deleted = false;
			$cat = get_the_category($post->ID);
			$cat_link = get_category_link( $cat[0]->cat_ID);
			if(isset($_POST['ylo_delete_post_nonce']) && wp_verify_nonce($_POST['ylo_delete_post_nonce'], 'ylo_delete_post_nonce')){
				if(isset($_POST['ylo_delete_post_confirmation']) && $_POST[ylo_delete_post_confirmation] == 'Confirmer'){
					wp_delete_post($post->ID);
					$deleted = true;
				}
			}
			if($deleted){
				echo '<p>Votre article &agrave; bien &eacute;t&eacute; supprim&eacute;</p>';
				echo '<p><a href="'.$cat_link.'">Retourner &agrave; la page '.$cat[0]->name.'</a></p>';
			}else{
				?>
				<form method="post">
					<?php wp_nonce_field('ylo_delete_post_nonce', 'ylo_delete_post_nonce');?>
					<h4>Vous demandez la suppression de l&#39;article : <br /><?php echo $post->post_title; ?></h4>
					Confirmez-vous vouloir supprimer cet article ?<br />
					<input type="submit" value="Confirmer" name="ylo_delete_post_confirmation"/>
					<a href="<?php echo get_permalink( $post->ID );?>">Annuler</a>
				</form>
				<?php 
			}
		}
	}
	
	protected function editor( $title, $content, $nonce){
		$edit_args = array(
				'media_buttons' => false
		);
		?>
				<form method="post">
					<div class="ylo-editor-content">
						<?php wp_nonce_field($nonce , $nonce);?>
						<?php if(count($this->erreurs) > 0) {
								echo '<ul class="ylo_erreurs">';
								foreach($this->erreurs as $err) echo '<li>'.$err.'</li>';
								echo '</ul>';
							  }
						?>
						<div>
							<div class="ylo-edito-field">
								<h3 class="ylo-titre-editor">Le titre de l'article : </h3>
								<input type="text" name="ylo_editor_post_title" value="<?php echo $title; ?>" />
							</div>
							<div class="ylo-edito-field">
								<h3 class="ylo-titre-editor">Le contenu de l'article : </h3>
							</div>
							<?php wp_editor($content, 'ylo_editor_article', $edit_args);?>
						</div>
						<div class="ylo-nouvel-article">
							<input type="submit" value="valider" />
						</div>
					</div><!-- .ylo-editor-content -->
				</form>
				<?php 		
	}
	
	protected function process_form($category = false){
		if(isset($_POST['ylo_new_post_nonce']) && wp_verify_nonce($_POST['ylo_new_post_nonce'] , 'ylo_new_post_nonce'))	{
			if(empty($_POST['ylo_editor_post_title']) || trim($_POST['ylo_editor_post_title']) == '') 
				$this->erreurs[] = __('Il faut saisir un titre pour votre article !');
			if(empty($_POST['ylo_editor_article']) || trim($_POST['ylo_editor_article']) == '')
				$this->erreurs[] = __('Il faut saisir un contenu pour votre article !');
			if(count($this->erreurs) > 0 ) return false;
			else{
				$postdata = array(
					  'post_content'   => sanitize_text_field($_POST['ylo_editor_article']),
					  'post_title'     => sanitize_text_field($_POST['ylo_editor_post_title']),
					  'post_status'    => 'publish' ,
					  'post_type'      =>  'post' ,
					  'post_author'    =>  get_current_user_id(),
					  'comment_status' => 'open' ,
					);	
				if($category) $postdata['post_category' ]	= array($category);	
				$post = wp_insert_post($postdata);
				if(is_wp_error($post)) return false;
				else return $post; 
			}
		}else return false;
	}
	
	protected function process_edit_form($ID){
		if(isset($_POST['ylo_edit_post_nonce']) && wp_verify_nonce($_POST['ylo_edit_post_nonce'] , 'ylo_edit_post_nonce'))	{
			if(empty($_POST['ylo_editor_post_title']) || trim($_POST['ylo_editor_post_title']) == '')
				$this->erreurs[] = __('Il faut saisir un titre pour votre article !');
			if(empty($_POST['ylo_editor_article']) || trim($_POST['ylo_editor_article']) == '')
				$this->erreurs[] = __('Il faut saisir un contenu pour votre article !');
			if(count($this->erreurs) > 0 ) return false;
			else{
				$postdata = array(
						'ID'			=> $ID,
						'post_content'   => sanitize_text_field($_POST['ylo_editor_article']),
						'post_title'     => sanitize_text_field($_POST['ylo_editor_post_title']),
				);
				
				$edited = wp_update_post($postdata);
				if(is_wp_error($edited)) return false;
				else return $edited;
				
			}
		}else return false;
	}
}
