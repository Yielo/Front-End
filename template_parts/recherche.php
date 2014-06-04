<?php 
			$membre = true;
			$article = false;
			if(isset($_GET['ylotype']) && $_GET['ylotype'] == 'article') {
				$membre = false;
				$article = true;
			}
?>		

			<div id="ylo-search-type-select">
				<h2>Rechercher :<span>&nbsp;</span></h2>
				<button id="ylo-bouton-search-type-membre" class="ylo-search-type-<?php echo $membre ? 'active': 'inactive';?>" onClick="yloSearchType('membre');">Un membre</button>
				<button id="ylo-bouton-search-type-article" class="ylo-search-type-<?php echo $article ? 'active': 'inactive';?>" onClick="yloSearchType('article');">Un article</button>
			</div>	
			<div id ="ylo-search-member">
				<form id="ylo-search-member-form" name="ylo-search-member-form" method="get" action="<?php echo home_url('/'); ?>">
					<fieldset>
						<input type="text" id="ylo-search-field" name="s" class="ylo-search-text-field" value="<?php echo isset($_GET['s']) ? htmlspecialchars(stripslashes($_GET['s'])):'';?>" placeholder="Un membre, un métier , un lieu,..." />
						<input type="hidden" name="ylotype" id="ylo-type-de-recherche" value="<?php echo $article ? 'article' : 'membre'; ?>" />
						<input type="submit" value="Rechercher" class="ylo-search-button"  onClick="return checkFormulaireVide('ylo-search-field');"/>
					</fieldset>
				</form>
			</div>
			<div id="ylo-main">
				<div class="ylo-col1">
					<?php if(isset($_GET['s'])) : ?>
						<div id="ylo-resultats-type-article" <?php echo $article ? '': 'class="ylo-hidden"';?>>
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
											<?php the_excerpt(); ?>
										</div>		
										<p class="ylo-lire-la-suite"><em><a href="<?php the_permalink(); ?>" >Lire la suite ... &rarr;</a></em></p>
									</article>
					
								<?php endwhile;?>
							</div><!-- #ylo-category-loop -->
							<nav class="ylo-cat-page-nav">
								<?php posts_nav_link(); ?>
							</nav>
							
							&nbsp;				
						</div><!-- #ylo-resultat-type-membre -->
						
						<div id="ylo-resultats-type-membre" <?php echo $membre ? '': 'class="ylo-hidden"';?>>
							<?php if(!empty($_POST['s']) || !empty($_GET['s'])) : do_action('ylo_search_member', 's', 12); ?>
						
							<?php else : ?>
								<p>Veuillez remplir le formulaire ci-dessus pour effectuer une recherche</p>
							<?php endif ;?>		
							&nbsp;			
						</div>
					<?php else : ?>
						<div >
							<?php while(have_posts()) : the_post();?>
								<div <?php post_class(); ?>>
									<h2 class="ylo-titre-ligne"><span><?php the_title() ;?></span></h2>
									<p><?php the_content(); ?></p>	
									
								</div>
							<?php endwhile;?>	
							&nbsp;					
						</div>
						
					<?php endif;?>

				</div><!-- .ylo-col1 -->
				<div class="ylo-col2">
					<?php do_action('ylo_default_sidebar');  ?>
				</div><!-- .ylo-col2 -->
				<div class="clearfix"></div>
			</div><!-- #ylo-main -->
