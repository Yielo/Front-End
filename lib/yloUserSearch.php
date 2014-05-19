<?php
yieloCenter::includeClassFile('yloUserFields');

class yloUserSearch
{
	
	// la méthode suivante est conçue pour être appelée en réponse à un formulaire don $champ et le nom de la variable de recherche
	public function templatePartResultat($champ = 's'){

		if(isset($_POST[$champ]))  $search = sanitize_text_field($_POST[$champ]);
		elseif(isset($_GET[$champ])) $search = sanitize_text_field;
		else return false;
		$resultat = $this->queryUsers($search, -1);
		$this->displayResultat($resultat);
	}
	
	protected function queryUsers($search, $nb = 20, $offset = 0){
		$liste = $this->queryUsersIds($search, $nb, $offest);
		return new WP_User_Query( array( 'include' => $liste ) );
	}
	

	
	protected function queryUsersIds($search, $nb = 20, $offest = 0){
		global $wpdb;
		
		$rows = $wpdb->get_results($wpdb->prepare(
				"SELECT * FROM $wpdb->usermeta WHERE
				(
					meta_key = 'first_name'
					OR meta_key = 'last_name'
					OR meta_key = 'nickname'
					OR meta_key = 'user_email'
					OR meta_key = 'user_login'
					OR meta_key = 'ylo_ville'
					OR meta_key = 'ylo_pays'
					OR meta_key = 'ylo_competences'
					OR meta_key = 'ylo_formation'
					OR meta_key = 'ylo_experiences_pro'
					OR meta_key = 'ylo_temoignage'
					OR meta_key = 'ylo_ville'
					OR meta_key = 'ylo_eglise'
				)
				AND meta_value LIKE %s", 
				'%'.$search.'%'
			));

		// on fait une recherche dans la table user
		$user_rows = $wpdb->get_results($wpdb->prepare(
				"SELECT * FROM $wpdb->users WHERE
					user_login LIKE %s 
					OR user_nicename LIKE %s
					OR user_email LIKE %s
					OR user_url LIKE %s
					OR display_name LIKE %s 
				",
				'%'.$search.'%',
				'%'.$search.'%',
				'%'.$search.'%',
				'%'.$search.'%',
				'%'.$search.'%'
			));		
		// on va trier les résultats par occurence du terme trouvé
		// en cosidérant un coefficficient 5 pour les résultat de la table user
		$les_membres = array();
		foreach($user_rows as $user_row){
			$les_membres[$user_row->ID] = 5;
		}
		foreach($rows as $row){
			if(isset($les_membres[$row->user_id])) $les_membres[$row->user_id]++;
			else $les_membres[$row->user_id] = 1;
		}
		asort($les_membres);
		$k = 0;
		$indexes = array();
		foreach($les_membres as $id => $occurence){
			$indexes[$k] = $id;
			$k++;
		}
	
		if(intval($nb) == -1 ) return $indexes;
		else {
			$resultat = array();
			for($k = 0 ; $k < $nb ; $k++ ){
				$resultat[] = $indexes[$k + $offest];
			}
			return $resultat;
		} 
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
