<?php 
/*
Template Name: login
 */

get_header(); ?>

	<div id="ylo-page">
		<div id="ylo-action-box">
		</div><!-- #ylo-action-box -->
		<div id="ylo-content" class="ylo-content">
			<h1 class="ylo-main-title"><?php the_title(); ?></h1>
			
			<div id="ylo-main">
				<div class="ylo-full-width">
					<?php while(have_posts()) : the_post();?>
						<div <?php post_class(); ?>>
							<h2 class="ylo-titre-ligne"><span><?php the_title() ;?></span></h2>
							<p><?php the_content(); ?></p>		
						</div>
					
					<?php endwhile;?>
					<div id="ylo-login-box">
						<?php if(is_user_logged_in()) :?>
							<h3>Bienvenue <?php echo esc_html(wp_get_current_user()->display_name );?></h3>
							<h5 style="text-align: center;">Choisis ta prochaine destination : </h4>
							<p>
								<ul>
									<?php wp_nav_menu(apply_filters('ylo_top_menu', array()));?>
								</ul>
							</p>
						<?php else : ?>
							<?php get_template_part('template_parts/loginform');?>
							
						<?php endif; ?>
					</div>
				</div><!-- .ylo-full-width -->
			</div><!-- #ylo-main -->
			
			<div class="clearfix"></div>
		</div><!-- #ylo-content -->
	</div><!-- #ylo-page -->		





<div style="padding: 10px;" >

</div>
<?php //// get_sidebar(); ?>
<?php get_footer(); ?>
