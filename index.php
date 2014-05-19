<?php get_header(); ?>

	<div id="ylo-page">
		<?php get_template_part('template_parts/top', 'actionbox'); ?>
		
		<div id="ylo-content">		
			<h1 class="ylo-main-title"><?php the_title(); ?></h1>
			<div id="ylo-main">
				<div class="ylo-col1">
					<?php while(have_posts()) : the_post();?>
						<div <?php post_class(); ?>>
							<h2 class="ylo-titre-ligne"><span><?php the_title() ;?></span></h2>
							<p><?php the_content(); ?></p>		
						</div>
					<?php endwhile;?>
					&nbsp;
				</div><!-- .ylo-col1 -->
				<div class="ylo-col2">
					<?php do_action('ylo_default_sidebar');  ?>
				</div><!-- .ylo-col2 -->
				<div class="clearfix"></div>
			</div><!-- #ylo-main -->
			
			<div class="clearfix"></div>
		</div><!-- #ylo-content -->
	</div><!-- #ylo-page -->		





<div style="padding: 10px;" >

</div>
<?php //// get_sidebar(); ?>
<?php get_footer(); ?>
