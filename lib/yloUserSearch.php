<?php
yieloCenter::includeClassFile('yloUserFields');

class yloUserSearch
{
	
	// la méthode suivante est conçue pour être appelée en réponse à un formulaire don $champ et le nom de la variable de recherche
	public function templatePartResultat($champ = 's'){

		if(isset($_POST[$champ]))  $search = sanitize_text_field($_POST[$champ]);
		elseif(isset($_GET[$champ])) $search = sanitize_text_field;
		else return false;
		$resultat = $this->queryUsers($search);
		$this->displayResultat($resultat);
	}
	
	protected function queryUsers($search){
		// TODO cette méthode est mega naze, à revoir !!
		
		// WP_User_Query arguments
		$champs = array( 'first_name', 'last_name', 'ylo_competences');
		$query_array = array('relation' => 'OR');
		$k = 0;
		$fields = array('id');
		foreach($champs as $champ ){
			$query_array[$k] = array(
						'key'     => $champ,
						'value'   => $search,
						'compare' => 'LIKE',
					);
			$k++;
		}
		$args = array (
				'meta_query' => $query_array,
				'fields'         => array( 
						'ID', 
						'user_login', 
						'user_nicename', 
						'user_email', 
						'user_url', 
						'display_name',

					),
		);
		
		// The User Query
		 return new WP_User_Query( $args );
		

		
	}
	
	protected function displayResultat($user_query){
		// The User Loop
		if ( ! empty( $user_query->results ) ) {
			echo '<ul class="ylo-search-user-results">';
			foreach ( $user_query->results as $user ) {
				$membre = get_user_by('id', $user->ID);
				echo '<li><a href="'.get_author_posts_url( $membre->ID, $membre->user_nicename ).'" title="'.esc_attr($membre->display_name).'">' ;
				?>
						<?php echo get_avatar($membre->ID, 50); ?>
						<div class="ylo-membre-summary" >
							<h4><?php echo esc_html(substr($membre->display_name, 0, 20));?></h4>
							<h5><?php echo esc_html(substr($membre->ylo_competences, 0, 20));?></h5>
							<p><?php echo esc_html(substr($membre->ylo_ville, 0, 20));?> <?php echo empty($membre->ylo_pays) ? '' : '('.esc_html(substr($membre->ylo_pays, 0, 20)).')';?></p>
						</div>
				<?php 
				unset($membre);
				echo  '</a></li>';
			}
			echo '</ul>';
		} else {
			echo '<p>Pas de membre trouv&eacute;';
		}		
	}
	
}