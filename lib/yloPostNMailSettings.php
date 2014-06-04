<?php
class yloPostNMailSettings
{
	protected $db_option = array();

	
	public function __construct(){
		$this->db_option = get_option('yielo_postnmail');
		if(!is_array($this->db_option)) $this->db_option = array();
	}
	
	
	public function errors($cat_ID){
		if(isset($this->db_option[$cat_ID])
				&& isset($this->db_option[$cat_ID]['errors']) 
				&& is_array($this->db_option[$cat_ID]['errors']))
				return $this->db_option[$cat_ID]['errors'];
		else return array();
	}
	
	public function is_setup($cat_ID){
		if(isset($this->db_option[$cat_ID])
				&& isset($this->db_option[$cat_ID]['is_setup'])
				&& $this->db_option[$cat_ID]['is_setup'] == 'on')		
				return true;
		else return false;
	}
	
	public function checked($cat_ID){
		if($this->is_setup($cat_ID)) return 'checked="checked"';
		else return '';
	}
	
	public function from($cat_ID){
		if(isset($this->db_option[$cat_ID])
				&& isset($this->db_option[$cat_ID]['from']))
			return $this->db_option[$cat_ID]['from'];
		else return '';		
	}

	public function fromname($cat_ID){
		if(isset($this->db_option[$cat_ID])
				&& isset($this->db_option[$cat_ID]['fromname']))
			return $this->db_option[$cat_ID]['fromname'];
		else return '';
	}
	
	public function to($cat_ID){
		if(isset($this->db_option[$cat_ID])
				&& isset($this->db_option[$cat_ID]['to']))
			return $this->db_option[$cat_ID]['to'];
		else return '';
	}
	
	public function check_on_transition($new_status, $old_status, $post){
		if($new_status == 'publish' && $old_status != 'publish'){
			$post_cats = get_the_category( $post->ID);
			foreach($post_cats as $post_cat) if(isset($this->db_option[$post_cat->cat_ID])){
				$opt = $this->db_option[$post_cat->cat_ID];
				if(isset($opt['is_setup']) && $opt['is_setup'] == 'on'){
					$to = $opt['to'];
					$headers = array('From: '.$opt['fromname'].' <'.$opt['from'].'>', 'Content-Type: text/plain; charset='.get_option('blog_charset'));
					$subject = $post->post_title;
					$author = get_user_by('id', $post->post_author);
					$content = $post->post_title."\n".__('Ecrit par ').$author->display_name."\n\n";
					$content .= $post->post_content;
					wp_mail($to, $subject, $content, $headers);
				}
			}
		}
	}
	
	public function on_comment_insert($comment_id, $comment){
		$message = get_post($comment->comment_post_ID);
		$post_cats = get_the_category( $message->ID);
		foreach($post_cats as $post_cat) if(isset($this->db_option[$post_cat->cat_ID])){
			$opt = $this->db_option[$post_cat->cat_ID];
			if(isset($opt['is_setup']) && $opt['is_setup'] == 'on'){
				$to = $opt['to'];
				$headers = array('From: '.$opt['fromname'].' <'.$opt['from'].'>', 'Content-Type: text/plain; charset='.get_option('blog_charset'));
				if($comment->user_id){
					$author = get_user_by('id', $comment->user_id);
					$author_name = $author->display_name;
				}else{
					$author_name = $comment->comment_author . ' ('.$comment->comment_author_email.')';
				}				
				$subject = __('Réponse au message : ').$message->post_title.__(' par ').$author_name;
				$content = __('Réponse au message : ').$message->post_title."\n".__('Ecrit par ').$author_name."\n\n";
				$content .= $comment->comment_content;
				$curr_comment = $comment;
				$k = 3;
				while($k && $curr_comment->comment_parent){
					$curr_comment = get_comment($curr_comment->comment_parent);
					if($curr_comment->user_id){
						$curr_author = get_user_by('id', $curr_comment->user_id);
						$curr_author = $curr_author->display_name;
					}else{
						$curr_author = $curr_comment->comment_author . ' ('.$curr_comment->comment_author_email.')';
					}
					$content .= "\n\n\n---En réponse au message de ".$curr_author.": --\n\n";
					$content .= $this->format_ancien_message($curr_comment->comment_content);
					$k--;
				}
				$content .= "\n\n ---Message d'origine--- \n\n";
				$content .= $this->format_ancien_message($message->post_content);
				wp_mail($to, $subject, $content, $headers);

			}
		}
	}
	
	protected function format_ancien_message($texte){
		$les_lignes = explode("\n", $texte);
		$new_texte = '';
		foreach($les_lignes as $ligne){
			$new_texte .= '> '.$ligne."\n";
		}
		return $new_texte;
	}
	
	public function intercept_setup(){
		// sert a empécher la publication des messages reçus par email ayant été préalablement envoyés par le site
		add_filter( 'is_email', array($this, 'intercept_check'), 10, 3 );
	}
	
	public function intercept_check($is_email, $email, $issue){
		$found = false;
		foreach($this->db_option as $opt){
			if($email == $opt['from'] || strpos($email, $opt['from'])) $found = true;
		}
		if($found) add_filter('wp_insert_post_empty_content', array($this, 'intercept'), 10, 2);
	}
	
	public function intercept($maybe_empty, $postarr){
		remove_filter('wp_insert_post_empty_content', array($this, 'intercept'), 10);
		// intecepte la création d'un post, et l'empêche
		return true;
	}
	
	
}
