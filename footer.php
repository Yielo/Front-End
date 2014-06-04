		<footer id="ylo-page-footer">
			<span class="ylo-copyright">&copy; Copyright <?php bloginfo('name'); ?> <?php echo date('Y');?></span>
			<div id="ylo-footer-menu"><?php wp_nav_menu(array('theme_location' => 'ylo-footer', 'depth' => 1,'fallback_cb' => false ));?></div>
		</footer>

	</div><!-- #page-wrapper -->
	<?php wp_footer();?>
</body>
</html>
