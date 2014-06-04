<?php
yieloCenter::includeClassFile('yloUserFields');

class yloUserSearch
{
	protected $nb = 20;
	protected $page = 0;
	protected $search = '';
	protected $champs = 'ylo_search';
	protected $nb_resultats = 0;
	
	// la méthode suivante est conçue pour être appelée en réponse à un formulaire don $champ et le nom de la variable de recherche
	public function templatePartResultat($champs = null, $nb_par_page = 20){
		if(is_null($champs)) $champs = $this->$champs;
		else $this->champs = (string) $champs;
		if(isset($_POST[$champs]))  $search = sanitize_text_field($_POST[$champs]);
		elseif(isset($_GET[$champs])) $search = sanitize_text_field(urldecode($_GET[$champs]));
		else return false;
		$this->search = $search;
		$this->nb = absint($nb_par_page);
		if($this->nb == 0 ) return false;
		if(isset($_GET[$champs.'_p']) && !isset($_POST[$champs])) $this->page = absint($_GET[$champs.'_p']); // l'extention _p désigne la page de la recherche
		else $this->page = 0;
		$offset = intval($this->nb) * intval($this->page);
		$resultat = $this->queryUsers($search, $this->nb, $offset);
		$this->displayResultat($resultat);
		echo '<div class="ylo-cat-page-nav">'.$this->displayLiens().'</div>';
	}
	
	protected function queryUsers($search, $nb = 20, $offset = 0){
		$search_str = $termes[0] = trim(substr($search, 0, 150)); // on défini un mot le plus long à 150 carractères
		preg_match_all('/"(.*)"/U', stripslashes($termes[0]), $guillemets); // on récupère les expressions entre guillemets
		foreach($guillemets[1] as $str) $termes[] = addslashes($str);
		foreach($guillemets[0] as $str) $search_str = addslashes(str_replace($str, '', stripslashes($search_str)));
		$mots = str_replace(array('"', '.', ',', "'", '  ' ), ' ', stripslashes($search_str));
		$mots = explode( ' ', $mots);
		foreach($mots as $mot){
			if(strlen(trim($mot)) > 0 ) $termes[] = trim(addslashes($mot));
		}
		$liste = $this->queryUsersIds($termes[0]);
		for($k = 1 ; $k <count($termes) ; $k++){		
			$liste = $this->queryUsersIds($termes[$k], $liste);
		}
		arsort($liste);
		$liste_finale = array();
		$n = 0;
		foreach($liste as $k => $occ){
			$liste_finale[$n] = $k;
			$n++;
		}
		$this->nb_resultats = count($liste);
		$query_list = array_slice($liste_finale, absint($offset), absint($nb), true);
		if(count($query_list) == 0 ) return new WP_User_Query();
		else {
			$db_reponse = new WP_User_Query( array( 'include' =>  $query_list ) );
			// ici je fait un petit hack pour ordonner les résultat dans l'ordre qui me convient
			$flip = array_flip($query_list);
			foreach($flip as $k => $on_sen_fou) $flip[$k] = false;
			foreach($db_reponse->results as $user) $flip[$user->data->ID] = $user;
			$k = 0;
			foreach($flip as $user) if($user){ 
				$db_reponse->results[$k] = $user;
				$k++;
			}
			return $db_reponse ;
		}
	}
	

	
	protected function queryUsersIds($search, $liste_ids = array()){
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
		// on utilise un coefficient pour pondérer les mots plus longs d'une plus grande valeur
		// on prend un coefficficient supplémentaire de 5 pour les résultat de la table user
		$coef = strlen($search)*strlen($search);
		if($nb = count($rows) + count($user_rows)) $coef = intval($coef/($nb));
		if($coef == 0 ) $coef =1;
		foreach($user_rows as $user_row){
			if(isset($liste_ids[$user_row->ID])) $liste_ids[$user_row->ID] += 5*$coef;
			else $liste_ids[$user_row->ID] = 5*$coef;
		}
		foreach($rows as $row){
			if(isset($liste_ids[$row->user_id])) $liste_ids[$row->user_id] += $coef;
			else $liste_ids[$row->user_id] = $coef;
		}
		return $liste_ids;
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
	
	protected function page_url($page = null, $search = null, $champs = null){
		if(is_null($page)) $page = $this->page;
		if(is_null($search)) $search = $this->search;
		if(is_null($champs)) $champs = $this->champs;
		$parametres = explode('&', str_replace('&amp;', '&', $_SERVER['QUERY_STRING']));
		$new_parametres = '';
		foreach($parametres as $k =>$para)
			if(strpos($para, $champs) !== 0) $new_parametres .= (empty($new_parametres))? $para : '&'.$para;
		$recherche = $champs.'='.urlencode($search).'&'.$champs.'_p='.$page;
		$new_parametres .= empty($new_parametres) ? $recherche : '&'.$recherche;
		$req = '?'.$new_parametres;
		return add_query_arg('ylotype', 'membre', $req);
	}
	
	protected function displayLiens($page = null, $prec = null, $suiv = null, $debut = null, $fin = null){
		if(is_null($page)) $page = $this->page;
		if(is_null($prec)) $prec = __('&larr; Page pr&eacute;c&eacute;dente');
		if(is_null($suiv)) $suiv = __('Page suivante &rarr;');
		$nb_pages =	intval(ceil( intval($this->nb_resultats)/intval($this->nb)));
		$page = intval($page);
		if($nb_pages <= 1 ) return '';
		else{
			$k=0;
			$delta = 1;
			$pages_prec = array();
			$pages_suiv = array();
			while($k <10 && $delta < 10){
				if($page - $delta >= 0){
					$pages_prec[] = $page - $delta ;
					$k++;
				}
				if($page + $delta <= $nb_pages - 1){
					$pages_suiv[] = $page + $delta;
					$k++;
				}
				$delta++;
			}
			sort($pages_prec);
			sort($pages_suiv);
			$retour = '';
			if(!is_null($debut) && $page > 0) $retour .= ' <a href="'.$this->page_url(0).'">'.esc_html($debut).'</a> ';
			if($page >0 ) $retour .= ' <a href="'.$this->page_url($page - 1).'">'.esc_html($prec).'</a> ';
			foreach($pages_prec as $page_no) $retour .= ' <a href="'.$this->page_url($page_no).'">'.(intval($page_no+1)).'</a> ';
			$retour .= $page +1 ;
			foreach($pages_suiv as $k=>$page_no) $retour .= ' <a href="'.$this->page_url($page_no).'">'.(intval($page_no+1)).'</a> ';
			if($page < $nb_pages -1 ) $retour .= ' <a href="'.$this->page_url($page + 1).'">'.esc_html($suiv).'</a> ';
			if(!is_null($fin) && ($page < $nb_pages -1 ) ) $retour .= ' <a href="'.$this->page_url($nb_pages-1).'</a> ';
			return $retour;
		}

	}
	
	public function page_hooks(){
		add_filter('get_pagenum_link', array($this, 'pagination_articles'), 10, 1);
		add_action('wp_head', array($this, 'type_script' ));
	}
	
	public function pagination_articles($lien){
		return add_query_arg('ylotype', 'article', $lien);
	}
	
	public function type_script(){
		?>
		<script type="text/javascript">
		function yloSearchType(type){
			var boutonMembre = document.getElementById('ylo-bouton-search-type-membre');
			var boutonArticle = document.getElementById('ylo-bouton-search-type-article');
			var resultatsMembre = document.getElementById('ylo-resultats-type-membre');
			var resultatsArticle = document.getElementById('ylo-resultats-type-article');
			var ylotype = document.getElementById('ylo-type-de-recherche');
			if(type == 'membre'){
				boutonMembre.className = 'ylo-search-type-active';
				boutonArticle.className = 'ylo-search-type-inactive';
				resultatsMembre.style.display = 'block';
				resultatsArticle.style.display = 'none';
				ylotype.value = 'membre';
			}else if(type == 'article'){
				boutonMembre.className = 'ylo-search-type-inactive';
				boutonArticle.className = 'ylo-search-type-active';
				resultatsMembre.style.display = 'none';
				resultatsArticle.style.display = 'block';
				ylotype.value = 'article';
			}
		}

		function checkFormulaireVide(fieldId){
			var field = document.getElementById(fieldId);
			if(field.value == '') return false;
			else return true;
		}
		</script>
		<?php 
	}
}
