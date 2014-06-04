<?php get_header(); ?>

	<div id="ylo-page">
		<?php get_template_part('template_parts/top', 'actionbox'); ?>
		
		<div id="ylo-content" class="ylo-content">		
			<h1 class="ylo-main-title"><?php the_title(); ?></h1>
			<div id="ylo-main">
				<div class="ylo-col1">
					<?php if(isset($_GET['ylo_editor']) && $_GET['ylo_editor'] == 'edit' && current_user_can('edit_posts')) : ?>
						<div id="ylo-post-editor" class="ylo-category-style">
							<?php do_action('ylo_edit_post_editor');?>
						</div><!-- #ylo-post-editor -->
						
					<?php elseif(isset($_GET['ylo_delete']) && $_GET['ylo_delete'] == 'current_post') :?>
						<?php do_action('ylo_delete_current_post');?>
					<?php else : ?>
						<div id="ylo-single-loop" class="ylo-category-style">
							<?php while(have_posts()) : the_post();?>
								<div <?php post_class('ylo-post-article'); ?>>
									<h2 class="ylo-titre-cat"><?php the_title() ;?></h2>
									<p class="ylo-article-publie">
										<em>Publi&eacute; le <?php echo get_the_date();?>, par <?php the_author(); ?></em>
										<span><?php do_action('ylo_lien_editer_supprimer');?></span>
									</p>
									<div class="ylo-article-content">
										<?php the_content(); ?>
									</div>
										
								</div>
								
								<nav class="ylo-single-page-nav">
									<?php posts_nav_link(); ?>
								</nav>
								<div class="ylo-post-article ylo-post-comments">
									<?php comments_template();?>
								</div>
								
							<?php endwhile;?>
							&nbsp;
						</div><!-- #ylo-single-loop -->
						<?php if(current_user_can('edit_posts')) :?>
							<p class="ylo-publier-nouveau">
								<?php $cat = get_the_category(); ?> 
								Publier un nouvel article dans la cat&eacute;gorie <?php  echo $cat[0]->cat_name; ?> 
								<a class="ylo-nouvel-article" href="<?php echo apply_filters('ylo_new_post_link', get_category_link($cat[0]->cat_ID)); ?>" >
									<button>Nouvel Article</button>
								</a>
							</p>
							<br>
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
