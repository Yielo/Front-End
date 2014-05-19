<?php get_header(); ?>

	<div id="ylo-page">
		<?php get_template_part('template_parts/top', 'actionbox'); ?>
		
		<div id="ylo-content">		
			<h1 class="ylo-main-title"><?php the_title(); ?></h1>
			<div id="ylo-main">
				<div class="ylo-col1">
					<?php while(have_posts()) : the_post();?>
						<div <?php post_class('ylo-post-article'); ?>>
							<h2 class="ylo-titre-triangle">Publi&eacute; le <?php echo get_the_date();?>, par <?php the_author(); ?><span>&nbsp;</span></h2>
							<p><?php the_content(); ?></p>		
						</div>
						<nav class="ylo-single-page-nav">
							<?php posts_nav_link(); ?>
						</nav>
						<?php comments_template();?>
					<?php endwhile;?>
					&nbsp;
					<?php if(current_user_can('edit_posts')) :?>
						<hr />
						Publier un nouvel article dans cette la cat&eacute;gorie  
						<a href="<?php echo (home_url('/wp-admin/post-new.php')); ?>" >
							<button>Nouvel Article</button>
						</a>
						<hr><br>
					<?php endif;?>
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
