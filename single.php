<?php get_header(); ?>

	<div id="ylo-page">
		<?php get_template_part('template_parts/top', 'actionbox'); ?>
		
		<div id="ylo-content">		
			<h1 class="ylo-main-title"><?php the_title(); ?></h1>
			<div id="ylo-main">
				<div class="ylo-col1">
					<?php if(isset($_GET['ylo_editor']) && $_GET['ylo_editor'] == 'edit' && current_user_can('edit_posts')) : ?>
						<?php do_action('ylo_edit_post_editor');?>
					<?php elseif(isset($_GET['ylo_delete']) && $_GET['ylo_delete'] == 'current_post') :?>
						<?php do_action('ylo_delete_current_post');?>
					<?php else : ?>
						<?php while(have_posts()) : the_post();?>
							<div <?php post_class('ylo-post-article'); ?>>
								<h2 class="ylo-titre-triangle">Publi&eacute; le <?php echo get_the_date();?>, par <?php the_author(); ?><span>&nbsp;</span></h2>
								<p><?php the_content(); ?></p>		
							</div>
							<span><?php do_action('ylo_lien_editer_supprimer');?></span>
							<nav class="ylo-single-page-nav">
								<?php posts_nav_link(); ?>
							</nav>
							<?php comments_template();?>
						<?php endwhile;?>
						&nbsp;
						
						<?php if(current_user_can('edit_posts')) :?>
							<hr />
							<?php $cat = get_the_category(); ?> 
							Publier un nouvel article dans cette la cat&eacute;gorie <?php  echo $cat[0]->cat_name; ?> 
							<a href="<?php echo apply_filters('ylo_new_post_link', get_category_link($cat[0]->cat_ID)); ?>" >
								<button>Nouvel Article</button>
							</a>
							<hr><br>
						<?php endif;?>
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
