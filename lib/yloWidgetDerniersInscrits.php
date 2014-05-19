<?php
class yloWidgetDerniersInscrits extends WP_Widget
{

	function __construct() {
		parent::__construct(
				'ylo_derniers_inscrits', // Base ID
				__('Derniers inscrits'), // Name
				array( 'description' => __( 'Affiche les derniers membres inscrits' ), ) // Args
		);
	}
	
	public function actionRegisterWidget(){
		register_widget( 'yloWidgetDerniersInscrits' );
	}
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
	
		echo $args['before_widget'];
		if ( ! empty( $title ) )  echo $args['before_title'] . $title . $args['after_title'];
		$nb = (absint($instance['nombre']) < 11 && absint($instance['nombre']) > 0 ) ? absint($instance['nombre']) : 3;
		$users = $this->getDerniersUsers($nb);
		$this->displayDerniersInscrits($users , is_user_logged_in());
		echo $args['after_widget'];
	}
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Derniers inscrits');
		}
		if(isset( $instance['nombre'])) $nb = absint($instance['nombre']);
		else $nb = 3;
		?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Titre:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			<label for="<?php echo $this->get_field_id( 'nombre' ); ?>"><?php _e( 'Nombre de nouveaux &agrave; afficher:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'nombre' ); ?>" name="<?php echo $this->get_field_name( 'nombre' ); ?>" type="text" value="<?php echo esc_attr( $nb ); ?>">
			</p>
			<?php 
		}
	
		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$nb = ( ! empty( $new_instance['nombre'] ) ) ? absint( $new_instance['nombre'] ) : 3 ;
			if($nb < 1) $nb = 1;
			if($nb > 10 ) $nb = 10;
			$instance['nombre'] = $nb;
			return $instance;
		}
		
		protected function getDerniersUsers($nb){
			$args = array(
					'orderby'      => 'ID',
					'order'        => 'DESC',
					'number'       => $nb,
					'fields'       => 'all_with_meta',
			);
			$users = get_users($args);
			// un peu d'optimisation est possible ici en ne renvoyer que les infos dont on a besoin
			return $users;
		}
		
		protected function displayDerniersInscrits($membres , $avec_liens = false){
			echo '<div class="last-subscription"><ul>';	
			
			foreach($membres as $membre){
				echo '<li>';
				echo $avec_liens ? '<a href="'.get_author_posts_url( $membre->ID, $membre->user_nicename ).'" title="'.esc_attr($membre->display_name).'">' : '';
			?>
							<div class="subscription-img"><?php echo get_avatar($membre->ID, 50); ?></div>
							<h4><?php echo esc_html(substr($membre->display_name, 0, 20));?></h4>
							<h5><?php echo esc_html(substr($membre->ylo_competences, 0, 20));?></h5>
							<p><?php echo esc_html(substr($membre->ylo_ville, 0, 20));?> <?php echo empty($membre->ylo_pays) ? '' : '('.esc_html(substr($membre->ylo_pays, 0, 20)).')';?></p>
		
			<?php 
				echo $avec_liens ? '</a>' : '';
				echo '</li>';
			}
			echo '</ul></div>';

		}
		
		
}