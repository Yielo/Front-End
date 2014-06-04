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
						<h3>Identifiez-vous : </h3>
						<?php wp_login_form(); ?>
					</div>
				</div><!-- .ylo-full-width -->
			</div><!-- #ylo-main -->
			
			<div class="clearfix"></div>
		</div><!-- #ylo-content -->
	</div><!-- #ylo-page -->	
