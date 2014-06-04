<?php get_header(); ?>

	<div id="ylo-page">
		<?php get_template_part('template_parts/top', 'actionbox'); ?>
		
		<div id="ylo-content" class="ylo-content">		
			<h1 class="ylo-main-title"><?php single_cat_title(); ?></h1>
			<div id="ylo-main">
				<div class="ylo-col1">
					<?php if($description = category_description()): ?>
						<p class="ylo-category-description"><?php echo $description; ?></p>
						<hr />
					<?php endif; ?>
					<?php if(isset($_GET['ylo_editor']) && $_GET['ylo_editor'] == 'nouveau' && current_user_can('edit_posts')) : ?>
						<div id="ylo-post-editor" class="ylo-category-style">
							<?php do_action('ylo_new_post_editor', get_query_var( 'cat' ));?>
						</div><!-- #ylo-post-editor -->
					<?php else : ?>
					<?php if(current_user_can('edit_posts')) :?>
						<a class="ylo-nouvel-article" href="<?php echo apply_filters('ylo_new_post_link', false); ?>" >
							<button >Nouvel Article</button>
						</a>
					<?php endif;?>
					<div id="ylo-category-loop" class="ylo-category-style">
						<?php while(have_posts()) : the_post();?>
							<article <?php post_class('ylo-post-article'); ?>>
								<header class="ylo-category-item-header">
									<h2 class="ylo-titre-cat">
										<a href="<?php the_permalink(); ?>" rel="bookmark" title="Lien vers : <?php the_title_attribute();?>">
											<span><?php the_title() ;?></span>
										</a>
									</h2>
									<p><em>
									Publi&eacute; par <?php the_author();?>,
										le <?php echo get_the_date();?>
									</em></p>
								</header>
	
								<div class="ylo-article-preview">
									<?php the_content(); ?>
								</div>		
								<p class="ylo-lire-la-suite"><em><a href="<?php the_permalink(); ?>" >Lire la suite ... &rarr;</a></em></p>
							</article>
			
						<?php endwhile;?>
					</div><!-- #ylo-category-loop -->
					<?php if(current_user_can('edit_posts')) :?>
						<a class="ylo-nouvel-article" href="<?php echo apply_filters('ylo_new_post_link', false); ?>" >
							<button >Nouvel Article</button>
						</a>
					<?php endif;?>
					<nav class="ylo-cat-page-nav">
							<?php posts_nav_link(); ?>
					</nav>
					
					<?php endif; ?>
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
